<?php
namespace app\admin\validate;
use think\validate;
class Conf extends validate
{
    protected $rule = [
        'cname'=>'require|max:60|unique:conf',
        'ename'=>'require|max:60|unique:conf',
        'dt_type'=>'require|number',
        'cf_type'=>'require|number',
    ];
    protected $message=[
        'cname.require'=>'中文名称不对为空！',
        'cname.unique'=>'中文名称不得重复',
    ];

    protected $scene=[
        'add'=>['cname','ename'],
        'edit'=>[]
    ];


}