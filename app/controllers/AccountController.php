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
        
        public static function newDepositAction(){
            $depositAmount = $_POST['depositAmount'];   
            $accountId = $_POST['accountId'];
            
            $newDeposit = new Deposit($accountId, $depositAmount, date('Y-m-d'));
            DepositDAL::createDeposit($newDeposit);
        }
            
	}
?>