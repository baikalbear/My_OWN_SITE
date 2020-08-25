<?php
class Service extends BaseController {
	function defaultAction(){
		return $this->view->load('service/service.main', ['auth'=>$this->auth]);
		
	}
}