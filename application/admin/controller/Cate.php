<?php

namespace app\admin\controller;
use app\admin\controller\Common;

class Cate extends Common
{
    public function lst(){
        $cateRes = model('cate')->catetree();
        $this->assign('cateRes',$cateRes);
        return view();
    }
    public function add(){
        if(request()->isPost()){
            $data = input('post.');
            $add=db('cate')->insert($data);
            if($add){
                $this->success('添加栏目成功',url('lst'));
            }else{
                $this->success('添加栏目失败');
            }
            return;
        }
        return view();
    }
    public function upimg(){
        $file = request()->file('img');
        $info = $file->move(ROOT_PATH.'public/static/admin/uploads/cateimg');
        if($info){
            //成功上传后，获取上传信息
            echo $info->getSaveName();
        }else{
            //s上传失败获取错误信息
            echo $file->getError();
        }
    }

    public function changestatus(){
        if(request()->isAjax()) {
            $cateid = input("cateid");
            $status = db('cate')->field('status')->where('id', $cateid)->find();
            $status = $status['status'];
            if ($status == 1) {
                db('cate')->where('id', $cateid)->update(['status' => 0]);
                echo 1;
            } else {
                db('cate')->where('id', $cateid)->update(['status' => 1]);
                echo 2;
            }
        }else{
            $this->error('非法操作！');
        }
    }

    public function del_sort(){
        $data = input('post.');
        dump($data);die();
        foreach($data['sort'] as $k=>$v){
            dump($k);die();
            db('cate')->where('id',$k)->update(['sort'=>$v]);
        }
        $this->success('数据处理成功！');
    }
}