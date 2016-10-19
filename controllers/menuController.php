<?php

class menuController extends Controller {

	public function index(){
		$menu = $this->model->load();
		$this->setResponce($menu);
	}
		
}