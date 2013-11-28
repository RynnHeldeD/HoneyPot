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

		public static function validateObjectiveAction($objectiveId) {

		}

		public static function removeObjectiveAction($objectiveId) {
			
		}
	}
?>