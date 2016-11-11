<?php

class topListController extends Controller {

    public function index(){
        $data=file_get_contents("/data/user.json");
        $data=json_decode($data, true);
        $this->setResponce($data);
    }

}