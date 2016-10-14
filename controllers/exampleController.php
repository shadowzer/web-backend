<?php

class exampleController extends Controller {

	public function index(){
		$examples=$this->model->load();		// просим у модели все записи
		$this->setResponce($examples);		// возвращаем ответ 
	}

	public function view($data){
		$example=$this->model->load($data['id']); // просим у модели конкретную запись
		$this->setResponce($example);
	}

	public function add(){
		if(isset($_POST['title'])){
			// мы передаем в модель массив с данными
			// модель должна вернуть boolean
			$dataToSave=array('title'=>$_POST['title']);
			$addedItem=$this->model->create($dataToSave);
			$this->setResponce($addedItem);
		}
	}

	public function edit($id){
		// НАПИШИТЕ РЕАЛИЗАЦИЮ метода save в классе Model

	}	

}