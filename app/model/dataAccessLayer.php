<?php
	class DataAccessLayer
	{
		private static $hostname = 'localhost';
		private static $database = 'HoneyPot';
		private static $username = 'root';
		private static $password = '';
		private static $pdo = null;

		public static function init() {
			self::createPDO();
		}
		
		private static function createPDO() {
			if
			(
				!empty(self::$hostname) &&
				!empty(self::$database) &&
				!empty(self::$username)
			) {
				self::$pdo = new PDO
				(
					'mysql:host=' . self::$hostname . ';dbname=' . self::$database,
					self::$username,
					self::$password
				);
				self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}
		}
		
		public static function query($query, $args = array(), $isReturningResults = true) {
			if(!empty($query)) {
				$query = self::$pdo->prepare($query);
				$query->execute($args);
				
				if($isReturningResults)
				{
					return $query->fetchAll(PDO::FETCH_OBJ);
				}
			}
		}
		
		public static function getValue($query, $args = array()) {
			if(!empty($query)) {
				$query = self::query($query, $args);
				$queryResult = $query[0];
				$field = get_object_vars($queryResult);

				foreach($field as $result) {
					return $result;
				}
			}
		}
		
		public static function insertInto($table, $values = array(), $fields = array()) {
			if(!empty($table) && !empty($values)) {
				if(is_string($table) && is_array($fields) && is_array($values)) {
					$fieldsString = '';
					if(!empty($fields)) {
						$fieldsString .= ' (';

						foreach($fields as $field) {
							$fieldsString .= $field . ', ';
						}

						$fieldsString = substr($fieldsString, 0, -2);
						$fieldsString .= ') ';
					}
				
					$valuesString = '';
					foreach($values as $value) {
						$valuesString .= '?, ';
					}
					$valuesString = substr($values, 0, -2);
				
					self::query('INSERT INTO ' . $table . $fieldsString . ' VALUES ( ' . $valuesString . ');', $values, false);
				}
			}
		}
	}
?>