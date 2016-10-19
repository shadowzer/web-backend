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
		// PUT  http://localhost/?controller=example&id=2 {'title'='новый текст записи'}
        // $id => array('id' => 2)
		//if(isset($id['id']) && isset($_POST['title'])){
        if(isset($id['id'])) {
			// мы передаем в модель массив с данными
			// модель должна вернуть boolean
            parse_str(file_get_contents("php://input"),$post_vars);
			if (isset($post_vars['title'])) {
				$dataToEdit = array('id' => $id['id'], 'title' => $post_vars['title']);
				$editedItem = $this->model->save($dataToEdit);
				$this->setResponce($editedItem);
			}
		}
	}	

	public function delete($id) {
        // DELETE http://localhost/?controller=example&id=2
        // $id = array($id => 2)
        if(isset($id['id'])) {
            $dataToDelete = $id['id'];
            $deletedItem = $this->model->delete($dataToDelete);
            $this->setResponce($deletedItem);
        }
    }
}