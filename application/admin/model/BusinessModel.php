<?php

namespace app\admin\model;
use think\Db;
use think\Model;

class BusinessModel extends Model
{
	protected $name = 'business';
    protected $autoWriteTimestamp = true;
    public function getNewsByWhere($map, $Nowpage, $limits)
    {
        return $this->field('think_business.*,name')->join('think_business_cate', 'think_business.cate_id = think_business_cate.id')->where($map)->page($Nowpage, $limits)->order('id desc')->select();
    }
    public function insertBusiness($param)
    {
        try{
            $result = $this->allowField(true)->save($param);
            if(false === $result){             
                return ['code' => -1, 'data' => '', 'msg' => $this->getError()];
            }else{
                return ['code' => 1, 'data' => '', 'msg' => '文章添加成功'];
            }
        }catch( PDOException $e){
            return ['code' => -2, 'data' => '', 'msg' => $e->getMessage()];
        }
    }
    public function updateBusiness($param)
    {
        try{
            $result = $this->allowField(true)->save($param, ['id' => $param['id']]);
            if(false === $result){          
                return ['code' => 0, 'data' => '', 'msg' => $this->getError()];
            }else{
                return ['code' => 1, 'data' => '', 'msg' => '文章编辑成功'];
            }
        }catch( PDOException $e){
            return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
        }
    }
    public function getOneBusiness($id)
    {
        return $this->where('id', $id)->find();
    }
    public function delBusiness($id)
    {
        try{
            $this->where('id', $id)->delete();
            return ['code' => 1, 'data' => '', 'msg' => '文章删除成功'];
        }catch( PDOException $e){
            return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
        }
    }
}
