<?php
namespace app\admin\model;
use think\Model;
class Cate extends Model
{
    public function catetree(){
        $cateRes=$this->order('id desc')->select();
        return $this->sort($cateRes);
    }

    public function sort($cateRes,$pid=0,$level=0){
        static $arr = array();
        foreach($cateRes as $k=>$v){
            if($v['pid']==$pid){
                $v['level']=$level;
                $arr[]=$v;
                $this->sort($cateRes,$v['id'],$level+1);
            }
        }
        return $arr;
    }


}