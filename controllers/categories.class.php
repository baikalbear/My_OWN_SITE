<?php
class Categories extends BaseController {
	
	function showAction(){
		//Получаю уникальное имя записи
		$unique_name = $this->mvc->getPiece(2);
	
		return $this->view->load('categories/category');
	}
	
	function defaultAction(){
		return $this->showAction();
	}
}