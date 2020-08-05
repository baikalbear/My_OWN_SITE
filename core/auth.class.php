<?php
class Auth {
	public function isAdmin(){
		if(isset($_SESSION['username']) && $_SESSION['username'] == "baikalbear"){
			return true;
		} else {
			return false;
		}
	}	
}