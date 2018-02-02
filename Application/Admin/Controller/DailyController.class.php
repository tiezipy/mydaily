<?php
namespace Admin\Controller;
use Think\Auth;
use Think\Controller;
use Think\Model;

class DailyController extends BaseController {
    public function index(){
        $dailys=M('Dailys');
        $model=new Model();
        $count = $dailys -> count();

        $Page = $this -> getPage($count,6);
        $show = $Page -> show();

        $res = $model -> table(array(
            'think_dailys' => 'dailys',
            'think_kind' => 'kind'
        )) -> where ('dailys.kindid=kind.id') -> field('dailys.title,dailys.id,kind.kindname,dailys.creat_time') ->order('dailys.creat_time')->
        limit($Page -> firstRow.','.$Page ->listRows) ->select();


        $this -> assign('page',$show);
        $this->assign("dailys",$res);
        $this->display();
    }

    public function delete(){
        $id=I('id');
        $dailys=M("Dailys");
        $res=$dailys -> where("id=$id") ->delete();

        if($res){
            $this->success("删除成功",U('Daily/index'));
        }else{
            $this->error("删除失败");
        }
    }

    public function edit(){
        $model=new Model();
        $id =I('id');
        $res = $model -> table(array(
            'think_dailys' => 'dailys',
            'think_kind' => 'kind'
        )) -> where ("dailys.kindid=kind.id and dailys.id=$id") -> field('dailys.title,dailys.id,dailys.content,kind.kindname,dailys.creat_time')
        ->select();
        $this -> assign('res',$res);
        $this -> display();
    }

    public function add(){
        $kind=M('Kind');
        $res=$kind -> select();
        $this->assign("kinds",$res);
        $this->display();
    }

    public function insert(){
        $dailys=M("Dailys");
        $data['title']=I('title');
        $data['kindid']=I('kindid');
        $data['content']=I('content');
        $data['creat_time']= time();
        $res= $dailys -> add($data);
        if($res){
            echo 'success';
        }else{
            echo "error";
        }

    }

    public function update(){
        $dailys=M("Dailys");
        $data['title']=I('title');
        $data['content']=I('content');
        $id=I('id');
//        echo $id;
//        exit;
        $data['creat_time']= time();
//        echo date('y-m-d H:i:s',time());
//        exit;
        $res= $dailys ->where("id=$id") -> save($data);

        if($res){
            echo 'success';
        }else{
            echo "error";
        }
    }
}