<?php
class Remotedump extends BaseController {
	function defaultAction() {
		return $this->view->load('remotedump/remotedump.main', ['auth'=>$this->auth]);
	}
	
	function saveAction() {
		return $this->view->load('remotedump/remotedump.save', ['auth'=>$this->auth]);
	}
	
	function loadAction() {
		return $this->view->load('remotedump/remotedump.load', ['auth'=>$this->auth]);
	}
	
	function uploadAction(){
		return $this->view->load('remotedump/remotedump.upload', ['auth'=>$this->auth]);
	}
	
/* 	function downloadRemoteFileAction(){
		$src_file = file_get_contents('http://baikal.home/upload/dump.sql');
	} */
	
}