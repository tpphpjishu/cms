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
        $cateid = input('cateid');
        $cateRes = model('cate')->catetree();

        $this->assign(
            array(
                'cateRes'=>$cateRes,
                'cateid'=>$cateid,

            ));

        return view();
    }

    //编辑栏目
    public function edit(){
        if(request()->isPost()){
            $data = input('post.');
           $_data=array();
            foreach($data as $k=>$v){
                $_data[]=$k;
            }
           // dump($_data);die();
            if(!in_array('status',$_data)){
                $data['status']=1;
            }
            $save=db('cate')->update($data);
            if($save){
                $this->success('修改栏目成功',url('lst'));
            }else{
                $this->success('修改栏目失败');
            }
            return;
        }
        $cateid = input('cateid');
        $cateRes = model('cate')->catetree();
        $cates=db('cate')->find($cateid);

        $this->assign(
            array(
                'cateRes'=>$cateRes,
                'cateid'=>$cateid,
                'cates'=>$cates,
            ));
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
       // dump($data);die();
//        foreach($data['sort'] as $k=>$v){
//            dump($k);die();
//            db('cate')->where('id',$k)->update(['sort'=>$v]);
//        }
        if($data['itm']){
            model('cate')->pdel($data['itm']);
//            foreach ($data['itm'] as $k =>$v){
//                $childrenidsarr[]=model('cate')->childrenids($v);
//                $childrenidsarr[]=(int)$v;
//            }
//            $_childrenidsarr =array();
//            foreach($childrenidsarr as $k=>$v){
//                if(is_array($v)){
//
//                    foreach($v as $k1=>$v1){
//                        $_childrenidsarr[] =$v1;
//                    }
//                }else{
//                    $_childrenidsarr[] =$v;
//                }
//            }
//            $_childrenidsarr=array_unique($_childrenidsarr);
//            db('cate')->delete($_childrenidsarr);
        }
        $this->success('数据处理成功！',url('lst'));
    }

    public function del(){
        $cateid=input('cateid');
        $childrenids=model('cate')->childrenids($cateid);
        $childrenids[]=$cateid;
        $del=db('cate')->delete($childrenids);
        if($del){
            $this->success('删除栏目成功',url('lst'));
        }else{
            $this->error('删除栏目失败');
        }
    }

    public function delimg(){
        $imgurl = input('imgurl');
        $imgurl =ADMINIMG.$imgurl;
        $res = unlink($imgurl);
        if($res){
            echo 1;
        }else{
            echo 2;
        }
    }
}