<?php
namespace app\admin\validate;
use think\Validate;
class ContactValidate extends Validate{
        protected $rule =   [
        'title|大标题'  => 'require|max:50',
        'name|小标题'  => 'require|max:30',  
        'ename|英文名称'=>'require|^\\S[\\sA-Za-z,\\.·\\-]*\\S$',
        'phone|电话号码'=>'number|max:11|/^1[3-8]{1}[0-9]{9}$/',
        'fax|传真'=>'require|/^(\d{3,4}-)?\d{7,8}$/',
        'qq|扣扣号码'=>'require|/^[1-9][0-9]{4,14}$/',
        'email|电子邮箱'=>'email',
        'address|地址'=>'require',
        'xname|姓名'=>'require',
        'xphone|电话号码'=>'require|max:11|/^1[3-8]{1}[0-9]{9}$/',
        'xaddress|地址'=>'require'
    ];
        protected $message  =   [
        'title.max'     => '大标题最多不能超过50个字符',
        'name.max'=>'小标题最多不超过30个字符',  
    ];
}
?>