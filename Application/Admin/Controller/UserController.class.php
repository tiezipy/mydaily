<?php
namespace Admin\Controller;
use Think\Auth;
use Think\Controller;

class UserController extends BaseController{
    public function index(){
        $user=M('User');
        $model = M();
        $count = $user -> count();
        $Page = $this -> getPage($count,5);
        $show = $Page -> show();

        $res=  $model -> table(array(
                "think_user" => "user",
                "think_auth_group_access"=>"access",
                "think_auth_group"=>"group")
        )
        ->where('user.id=access.uid and  access.group_id=group.id')->field("user.id,user.username,user.addtime,group.title")->limit($Page -> firstRow.','.$Page ->listRows) -> select();
//       echo  $model -> _sql();
//       exit;
        $this -> assign('Page',$show);
        $this -> assign('user',$res);
        $this->display();
    }

    public function delete(){
        $user = M('User');
        $id = I('get.id');
        $res = $user -> where("id=$id") -> delete();
        if($res){
            $this->success("删除成功",U('User/index'));
        }else{
            $this->error("删除失败");
        }
    }

    public function add(){
        $user_group=M('Auth_group');
        $res = $user_group -> select();
        if($res){
            $this -> assign('group',$res);
        }else{
            $this -> error('错误');
        }
        $this -> display();
    }

    public function insert(){
        $user=M("User");
        if(IS_POST){
            $data['username']=I('post.username');
            $data['password']=I('post.password');
            $res=$user ->add($data);

            if($res){
                $this->success("添加成功",U('User/index'));
            }else{
                $this->error("添加失败");
            }
        }
    }

    public function fenpei(){
        $user=M("User");
        $auth_group = M("Auth_group");
        $id = I('get.id');
        $res = $user -> where("id=$id") -> select();
        $group = $auth_group -> select();


        $this -> assign('user',$res);
        $this -> assign('group',$group);
        $this -> display();
    }

    public function saveManager(){
        $auth_group_access = M("Auth_group_access");
        $data['uid'] = I('post.uid');
        $uid=I('post.uid');
        $data['group_id'] = I('post.group_id');
        $res = $auth_group_access ->where("uid=$uid")-> save($data);
        if($res){
            $this -> success("成功",U('User/index'));
        }else{
            $this -> error('错误');
        }

    }


}