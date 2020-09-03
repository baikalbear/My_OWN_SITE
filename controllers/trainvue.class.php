<?
class Trainvue extends BaseController{

	function defaultAction(){
		return $this->view->load('trainvue/trainvue', []);
	}
}