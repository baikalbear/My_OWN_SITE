<?php
class BaseController {
	protected $db_link;	
	protected $mvc;
	public $auth;
	
	function __construct(){
		$this->db_link = mysqli_connect($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_pass'], $GLOBALS['db_base']);
		mysqli_query($this->db_link, "set names " . $GLOBALS['db_encoding']);		
		$this->mvc = $GLOBALS['mvc'];	
		$this->auth = new Auth();
		$this->view = new View();
		$this->view->setAuth($this->auth);
		$this->view->setDbLink($this->db_link);
	}

}