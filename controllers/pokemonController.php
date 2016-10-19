<?php

class pokemonController extends Controller {

	public function index(){
		$examples=$this->model->load();		// просим у модели все записи
		$this->setResponce($examples);		// возвращаем ответ 
	}

	public function view($data){
		$example=$this->model->load($data['id']); // просим у модели конкретную запись
		$this->setResponce($example);
	}

	public function add(){
		if(isset($_POST['name']) && isset($_POST['image']) && isset($_POST['HP'])){
			// мы передаем в модель массив с данными
			// модель должна вернуть boolean
			$dataToSave=array('name' => $_POST['name'], 'image' => $_POST['image'], 'HP' => $_POST['HP']);
			$addedItem=$this->model->create($dataToSave);
			$this->setResponce($addedItem);
		}
	}

	public function edit($id){
		// PUT  http://localhost/?controller=example&id=2 {'title'='новый текст записи'}
        // $id => array('id' => 2)
        if(isset($id['id'])) {
			// мы передаем в модель массив с данными
			// модель должна вернуть boolean
            parse_str(file_get_contents("php://input"),$post_vars);
			if(isset($_POST['name']) && isset($_POST['image']) && isset($_POST['HP'])) {
				$dataToEdit = array('id' => $id['id'], 'name' => $post_vars['name'], 'image' => $post_vars['image'], 'HP' => $post_vars['HP']);
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