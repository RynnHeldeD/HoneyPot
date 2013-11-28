<?php
	class AccountController
	{
		public static function defaultAction() {
		}
        
        public static function createAccountAction() {
            global $user;
            $libelle = $_POST['libelle'];
            $solde = $_POST['solde'];

            $account = new Account($user->id, $libelle);
            AccountDAL::createAccount($account, $solde);   
        }
            
	}
?>