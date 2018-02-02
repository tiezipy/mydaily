<?php
namespace Admin\Controller;
use Think\Controller;

class Child2Controller extends ChildController{
    public function _initialize(){
        echo 'Child2';
    }

    public function index(){

    }
}