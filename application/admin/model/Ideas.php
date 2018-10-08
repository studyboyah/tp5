<?php

namespace app\admin\model;

use think\Model;

class Ideas extends Model
{
    public function getArticleByWhere($map, $Nowpage, $limits)
    {
        return $this->where($map)->page($Nowpage, $limits)->select();
    }
}
