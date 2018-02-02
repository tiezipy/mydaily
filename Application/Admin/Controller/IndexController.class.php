<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller{
    public function index(){
        $this -> display();
    }

    public function login(){
        $username=I('post.username');
        $password=md5(I('post.password'));
        $user=M('User');
        $res = $user -> query("select * from think_user where username='$username' and password='$password'");
        if($res){
            session('username',$username);
            $this ->redirect('daily/index');
        }else{
            $this -> error('error');
        }
    }

    public function logout(){
        session('username',null);
        session('[destroy]');
        $this -> success('success',U('index/index'));
    }
}