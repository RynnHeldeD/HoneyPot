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
		
		public static function getAllObjectives()
		{
			$objects = DataAccessLayer::query("SELECT * from objective");
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

		private static function getAllAllocations($objectiveId) {
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