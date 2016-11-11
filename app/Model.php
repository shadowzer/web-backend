<?php

class Model{

	// здесь будем хранить название файла данных для этой модель
	public $dataFileName;

	public function __construct($modelName){
		// конструируем название файла данных
		// должно получиться примерно /data/modelname.json
		$this->dataFileName=DATA_FOLDER.DS.$modelName.'.json';
	}
	
	// общие методы для всех моделей

	public function load($id=false){
		// считаем файл
		$data=file_get_contents($this->dataFileName);
		// декодируем 
		$data=json_decode($data, true);

		// если id не передан - то возвращаем все записи, иначе только нужную
		if($id===false){
			return $data;
		}else{
			if(array_key_exists($id, $data)){
				return $data[$id];	
			}	
		}
		return false;
	}


	public function create(array $item){
		// считываем нашу "базу данных"
		$data=file_get_contents($this->dataFileName);
		// декодируем
		$data=json_decode($data, true);
		// добавляем элемент
		array_push($data, $item);
		// сохраняем файл, и возвращаем результат сохранения (успех или провал)
		return file_put_contents($this->dataFileName, json_encode($data));
	}


	public function save($dataToEdit){
        // PUT  http://localhost/?controller=example&id=2 {'title'='новый текст записи'}
        // $dataToEdit = array(id => 2, title =>'новый текст записи')
		// считываем нашу "базу данных"
		$data=file_get_contents($this->dataFileName);
		// декодируем
		$data=json_decode($data, true);
        // изменяем элемент
		if(array_key_exists($dataToEdit['id'], $data)) {
            $data[$dataToEdit['id']] = array('title' => $dataToEdit['title']);
        }
        // сохраняем файл, и возвращаем результат сохранения (успех или провал)
        return file_put_contents($this->dataFileName, json_encode($data));
	}


	public function delete($id){
        // считываем нашу "базу данных"
        $data=file_get_contents($this->dataFileName);
        // декодируем
        $data=json_decode($data, true);
        // изменяем элемент
        if(array_key_exists($id, $data)) {
            unset($data[$id]);
        }
        // сохраняем файл, и возвращаем результат сохранения (успех или провал)
        return file_put_contents($this->dataFileName, json_encode($data));
	}
}