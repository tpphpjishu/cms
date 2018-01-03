<?php
namespace app\admin\controller;
use app\admin\controller\Common;

class Conf extends Common
{
    public function conflst()
    {
        if(request()->isPost()){
            $data = input('post.');
           // dump($data);
            $enameArr=db('conf')->column('ename');
            $imgcolum=db('conf')->where('dt_type',6)->column('ename');
            $confArr=array();
          //  dump($enameArr);die();
            foreach($data as $k=>$v){
                $confArr[]=$k;
                if(is_array($v)){
                    $v=implode(',',$v);
                }
                db('conf')->where('ename',$k)->update(['value'=>$v]);
            }
            foreach($enameArr as $k=>$v){
                if(!in_array($v,$confArr)&&!in_array($v,$imgcolum)){
                    db('conf')->where('ename',$v)->update(['value'=>'']);
                }
            }
            //附件类型处理

            foreach($imgcolum as $k=>$v){
                if($_FILES[$v]['tmp_name']!=''){
                    $file = request()->file($v);
                    $info = $file->move(ROOT_PATH.'public/static/admin/uploads');
                    $imgSrc = $info->getSaveName();
                    if($imgSrc != '') {
                        db('conf')->where('ename', $v)->update(['value' => $imgSrc]);
                    }
                }

            }
            //dump($imgcolum);die();
            $this->success('修改配置成功！',url('conflst'));
            return;
        }
        $confRes = db('conf')->select();
        $this->assign('confRes',$confRes);
        return view();
    }

    public function lst()
    {
        $confRes = db('conf')->field('id,cname,ename,value,values')->paginate(10);
        $this->assign('confRes',$confRes);
        return view();
    }

    public function add()
    {
        if(request()->isPost()){
            $data =input('post.');
            $validate = validate('conf');
            if(!$validate->scene('add')->check($data)){
                $this->error($validate->getError());
            }
            $add = db('conf')->insert($data);
            if($add){
                $this->success('添加配置项成功！',url('lst'));
            }else{
                $this->error('添加配置下失败');
            }

        }
        return view();
    }

    public function edit($id)
    {
        if(request()->isPost()){
            $data = input('post.');
           // dump($data);die();
            $save = db('conf')->update($data);
            if($save){
                $this->success('修改配置成功',url('lst'));
            }else{
                $this->error('修改配置失败');
            }
        }

        $confs = db('conf')->find($id);
        $this->assign('confs',$confs);
        return view();
    }

    public function del($id){
        $del = db('conf')->delete($id);
        if($del){
            $this->success('删除配置项成功！',url('lst'));
        }else{
            $this->error('删除配置项失败');
        }
    }

}