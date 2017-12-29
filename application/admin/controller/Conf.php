<?php
namespace app\admin\controller;
use think\Controller;

class Conf extends Controller
{
    public function conflst()
    {
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