<?php 

/*
 * 
 */
class Database {
	function open_db_connection() {
		$config = array(
			'host'		=> '173.254.28.123',
			'username'	=> 'lvtranco_michael',
			'password'	=> 'sqlman',
			'dbname' 	=> 'lvtranco_lotDev'
		);
		
		#connecting to the database by supplying required parameters
		$db = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'], $config['username'], $config['password']);
		
		#Setting the error mode of our db object, which is very important for debugging.
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		return $db;
	}
}

?>