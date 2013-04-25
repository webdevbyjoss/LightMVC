<?php

namespace Quick;

/**
 * Wrapper class to load ADOdb
 *
 * As Adodb doesn't supports PSR-0 autoloading standard we should load & instantiate it manually
 * Don't want to create proxy-class to save my time and avoid re-implemating ADOdb interface
 *
 * So we will be using ADOdb directly in our app
 */
class Db {
	/**
	 * Factory method the returns ADODB_mysqli instance
	 *
	 * @param string $libDir
	 * @param array $conf
	 * @return object \ADODB_mysqli
	 */
	public static function initDb($libDir, $conf) {
		require_once $libDir . '/Adodb/adodb5/adodb.inc.php';
		require_once $libDir . '/Adodb/adodb5/adodb-active-record.inc.php';
		require_once $libDir . '/Adodb/adodb5/adodb-exceptions.inc.php';
		$db = ADONewConnection('mysqli');
		$db->debug = empty($conf['debug']) ? false : $conf['debug'];
		$db->Connect($conf['host'], $conf['user'], $conf['pass'], $conf['dbname']);
		// set this connection as default for all active records instances
		\ADOdb_Active_Record::SetDatabaseAdapter($db);
		return $db;
	}

}