<?php
	class ObjectiveController
	{
		public static function defaultAction() {
		}

		public static function createNewObjectiveAction() {
            global $user;
            $label = $_POST['label'];
            $goal = $_POST['goal'];
            
            $objective = new Objective($user->id, $label, $goal);
            ObjectiveDAL::createObjective($objective);
		}

		public static function updateObjectiveAction() {
            $allocations = $_POST['allocations'];
            $accountId = $_POST['accountId'];
            
            foreach($allocations as $allocation){
                $objectiveId = $allocation[0];   
                $amount = intval($allocation[1]);
                
                ObjectiveDAL::updateObjective($accountId, $objectiveId, $amount);
            }
        }
		public static function validateObjectiveAction($objectiveId) {

		}

		public static function removeObjectiveAction($objectiveId) {
			
		}
	}
?>