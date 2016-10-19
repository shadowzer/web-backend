<?php

class indexController extends Controller {

	public function index(){
		$message = 'This in index page. This message is in controllers/indexController.php file';
		$this->setResponce($message);
	}
		
}