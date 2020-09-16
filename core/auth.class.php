<?php
class Auth {
    public $user_id; //ID текущего залогиненого пользователя, если нет залогиненого пользователя то вернёт 0.

    function __construct(){
        //Для данного класса соединение с БД устанавливаем отдельное
        $this->db_link = mysqli_connect($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_pass'], $GLOBALS['db_base']);
        mysqli_query($this->db_link, "set names " . $GLOBALS['db_encoding']);
        $this->user_id = $this->getUserId();
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
	    if(!$sql_query = $this->db_link->query($sql_str)){ return false; }
	    if($sql_query->num_rows>0){
	        return $sql_query->fetch_array()[0];
        }else{
            return 0;
        }
    }

    public function isUserInGroup($groupname){
        $sql_str = "SELECT `users_groups`.`user_id` FROM `users_groups`
                LEFT JOIN `usergroups` ON `usergroups`.`id`=`users_groups`.`group_id`
                WHERE `usergroups`.`name`='{$groupname}' AND `users_groups`.`user_id`={$this->user_id}";

        if(!$sql_query = $this->db_link->query($sql_str)){
            return "Не удалось определить права для пользователя {$_SESSION['username']} в отношении группы безопасности {$groupname}";
        }

        if($sql_query->num_rows > 0){
            return true;
        }else{
            return "У пользователя {$_SESSION['username']} нет прав доступа к группе безопасности {$groupname}";
        }
    }
}