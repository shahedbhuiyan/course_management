<?php
include_once("utils/utils.php");
class DBMgr {  
  
    protected $objDatabase; 
    private static $instance;

    private $_host = HOST;
	private $_username = USER;
	private $_password = PASSWORD;
	private $_database = DB;   
    
    private function __construct() { 
        try { 
            $this->objDatabase = new PDO("mysql:host=localhost;dbname=".$this->_database, $this->_username, $this->_password); 
            $this->objDatabase->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch( PDOException $e ) { die( $e->getMessage() ); } 
    } 
   
    public static function getInstance() { 
      if (!isset(self::$instance)) { self::$instance = new DBMgr(); } 
      return self::$instance; 
    }

    public function getConnection() {
		return $this->objDatabase;
	}
} 


//$obj = DBMgr::getInstance()->getConnection();
//print_r($obj);