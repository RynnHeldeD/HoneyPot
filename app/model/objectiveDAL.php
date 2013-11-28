<?php
	class ObjectiveDAL
	{
		public static function createObjective(&$objective) {
			global $user;

			DataAccessLayer::insertInto(
				'objective',
				array($user->id, $objective->label, $objective->goal),
				array('userId', 'label', 'goal')
			);
			$objective->id = DataAccessLayer::getValue('SELECT  MAX(id) FROM objective');
		}
        
        public static function updateObjective($accountId, $objectiveId, $amount) {
            $currentAmount = DataAccessLayer::getValue(
                'SELECT amount FROM allocate WHERE accountId = ? AND objectiveId = ?',
                array($accountId, $objectiveId)
            );
            
            if(!empty($currentAmount)) {   
			     DataAccessLayer::query(
                    'UPDATE allocate SET amount = ? WHERE accountId = ? AND objectiveId = ?', 
                    array($amount, $accountId, $objectiveId), 
                    false
                 );
            }
            else {
                DataAccessLayer::insertInto(
                    'allocate', 
                    array($accountId, $objectiveId, $amount),
                    array('accountId', 'objectiveId', 'amount')
                );
            }
        }
        
        public static function validateObjective($objectiveId)
        {
            DataAccessLayer::query(
                    'UPDATE objective SET validationDate = ? WHERE id = ?', 
                    array(date('Y-m-d'), $objectiveId), 
                    false
                 );
        }
		
		public static function getAllObjectives() {
			global $user;
			
			$objects = DataAccessLayer::query("SELECT * FROM objective WHERE userId = ?", array($user->id));
			$objectives = array();
			
			foreach($objects as $objective){
				$anObjective = new Objective(
					$objective->userId,
					$objective->label,
					$objective->goal,
					$objective->validationDate
				);
				$anObjective->id = (int)$objective->id;
				$anObjective->allocations = self::getAllAllocations($anObjective->id);

				$objectives[] = $anObjective;
			}
			
			return $objectives;
		}
		
		public static function getNonCompletedObjectives() {
			global $user;
			
			$objects = DataAccessLayer::query("SELECT * FROM objective WHERE userId = ? AND validationDate = '0000-00-00'", array($user->id));
			$objectives = array();
			
			foreach($objects as $objective){
				$anObjective = new Objective(
					$objective->userId,
					$objective->label,
					$objective->goal,
					$objective->validationDate
				);
				$anObjective->id = (int)$objective->id;
				$anObjective->allocations = self::getAllAllocationsForObjective($anObjective->id);

				$objectives[] = $anObjective;
			}
			
			return $objectives;
		}
		
		public static function getCompletedObjectives() {
			global $user;
			
			$objects = DataAccessLayer::query("SELECT * FROM objective WHERE userId = ? AND validationDate != '0000-00-00'", array($user->id));
			$objectives = array();
			
			foreach($objects as $objective){
				$anObjective = new Objective(
					$objective->userId,
					$objective->label,
					$objective->goal,
					$objective->validationDate
				);
				$anObjective->id = (int)$objective->id;
				$anObjective->allocations = self::getAllAllocationsForObjective($anObjective->id);

				$objectives[] = $anObjective;
			}
			
			return $objectives;
		}

		private static function getAllAllocationsForObjective($objectiveId) {
			$allocations = array();
			$result = DataAccessLayer::query("SELECT accountId, amount from allocate where objectiveId = ?", array($objectiveId));
			
			foreach($result as $allocation)
			{
				$allocations[$allocation->accountId] = $allocation->amount;
			}

			return $allocations;
		}
	}
?>