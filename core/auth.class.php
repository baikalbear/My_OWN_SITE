<?php
class Auth {
    function __construct(){
        //Для данного класса соединение с БД устанавливаем отдельное
        $this->db_link = mysqli_connect($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_pass'], $GLOBALS['db_base']);
        mysqli_query($this->db_link, "set names " . $GLOBALS['db_encoding']);
    }
	public function isAdmin(){
		if(isset($_SESSION['username']) && $_SESSION['username'] == "baikalbear"){
			return true;
		} else {
			return false;
		}
	}

	public function getUserName(){
	    return $_SESSION['username'];
    }

    public function getUserId(){
        $sql_str = "SELECT * FROM `users` WHERE `name`='{$_SESSION['username']}'";
        //echo $sql_str;
	    $sql_res = $this->db_link->query($sql_str);
	    if($sql_res->num_rows>0){
	        return $sql_res->fetch_array()[0];
        }else{
            return false;
        }
    }
}