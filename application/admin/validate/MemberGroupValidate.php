<?php

namespace app\admin\validate;
use think\Validate;

class MemberGroupValidate extends Validate
{
    protected $rule = [
        ['car_name', 'unique:user_car', '骑手已经存在']
    ];

}