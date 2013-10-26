<?php
	class DepositDAL
	{
		public static function create(&$deposit) {
			DataAccessLayer::insertInto(
				'deposit', 
				array($deposit->accountId, $deposit->amount, date('Y-m-d')), 
				array('accountId', 'amount', 'date')
			);
			$deposit->id = DataAccessLayer::getValue('SELECT MAX(id) FROM deposit WHERE accountId = '.$deposit->accountId.'');
		}

		public static function delete($deposit) {
			DataAccessLayer::query(
				'DELETE FROM deposit WHERE id = ?',
				array($deposit->id),
				false
			);
		}

		public static function getAllAccountDeposits($accountId) {
			$deposits = array();
			$result = DataAccessLayer::query(
				'SELECT * FROM Deposit WHERE accountId = ?',
				array($accountId)
			);

			foreach($result as $deposit) {
				$aDeposit = new Deposit(
					$deposit->accountId,
					$deposit->amount,
					$deposit->date
				);
				$aDeposit->id = $deposit->id;

				$deposits[] = $aDeposit;
			}
			return $deposits;
		}
	}
?>