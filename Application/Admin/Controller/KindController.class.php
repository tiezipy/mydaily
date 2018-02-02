<?php
namespace Admin\Controller;
use Think\Controller;
class KindController extends BaseController {
    public function index(){
        $kind=M('Kind');
        $count = $kind -> count();
        $Page = $this -> getPage($count,5);
        $show = $Page -> show();
        $res=$kind -> limit($Page -> firstRow.','.$Page ->listRows) -> select();

        $this -> assign('page',$show);
        $this->assign("kinds",$res);
        $this->display();

    }

    public function delete(){
        $id=I('id');
        $kinds=M("Kind");
        $res=$kinds -> where("id=$id") ->delete();

        if($res){
            $this->success("删除成功",U('Kind/index'));
        }else{
            $this->error("删除失败");
        }
    }

    public function edit(){
        echo "edit";

    }

    public function add(){
        $this -> display();
    }

    public function insert(){
        $kind=M("Kind");
        if(IS_POST){
            $data['kindname']=I('post.kindname');
            $res=$kind ->add($data);

            if($res){
                $this->success("添加成功",U('Kind/index'));
            }else{
                $this->error("添加失败");
            }
        }

    }
}