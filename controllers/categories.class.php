<?php
class Categories extends BaseController {
    function showAction(){
        //Получаю уникальное имя записи
        $alias = $this->mvc->getPiece(2);
        //Возвращаю HTML
        return $this->view->load('categories/category', ['alias'=>$alias]);
    }

	function defaultAction(){
		return $this->showAction();
	}
}