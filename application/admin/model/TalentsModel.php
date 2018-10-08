<?php

namespace app\admin\model;
use think\Db;
use think\Model;

class TalentsModel extends Model
{
	protected $name = 'order_take';
    protected $autoWriteTimestamp = true;
  
    public function getAllTalents()
    {
        return $this->order('id asc')->select();       
    }
    public function insertTalents($param)
    { 
        try{
            $result = $this->allowField(true)->save($param);
            if(false === $result){     
                return ['code' => -1, 'data' => '', 'msg' => $this->getError()];
            }else{
                return ['code' => 1, 'data' => '', 'msg' => '订单添加成功'];
            }
        }catch( PDOException $e){
            return ['code' => -2, 'data' => '', 'msg' => $e->getMessage()];
        }
    }
    public function editTalents($param)
    {
        try{
            $result = $this->allowField(true)->save($param, ['id' => $param['id']]);
            if(false === $result){          
                return ['code' => 0, 'data' => '', 'msg' => $this->getError()];
            }else{
                return ['code' => 1, 'data' => '', 'msg' => '订单编辑成功'];
            }
        }catch( PDOException $e){
            return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
        }
    }
    public function getOneTalents($id)
    {
        return $this->where('id', $id)->find();
    }
    public function delTalents($id)
    {
        try{
            $this->where('id', $id)->delete();
            return ['code' => 1, 'data' => '', 'msg' => '订单删除成功'];
        }catch( PDOException $e){
            return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
        }
    } 

}
