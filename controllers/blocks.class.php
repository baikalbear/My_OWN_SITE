<?php
class Blocks extends BaseController {

	function mainPageAction(){
		return $this->view->load('blocks/main', []);
	}
}