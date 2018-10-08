<?php

namespace app\admin\model;
use think\Db;
use think\Model;

class BusinessCateModel extends Model
{
    protected $name = 'business_cate';
    protected $autoWriteTimestamp = true;
    public function getAllCate()
    {
        return $this->order('id asc')->select();       
    }
    public function insertCate($param)
    {
        try{
            $result = $this->save($param);
            if(false === $result){     
                return ['code' => -1, 'data' => '', 'msg' => $this->getError()];
            }else{
                return ['code' => 1, 'data' => '', 'msg' => '分类添加成功'];
            }
        }catch( PDOException $e){
            return ['code' => -2, 'data' => '', 'msg' => $e->getMessage()];
        }
    }
    public function editCate($param)
    {
        try{
            $result = $this->save($param, ['id' => $param['id']]);
            if(false === $result){          
                return ['code' => 0, 'data' => '', 'msg' => $this->getError()];
            }else{
                return ['code' => 1, 'data' => '', 'msg' => '分类编辑成功'];
            }
        }catch( PDOException $e){
            return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
        }
    }
    public function getOneCate($id)
    {
        return $this->where('id', $id)->find();
    }
    public function delCate($id)
    {
        try{
            $this->where('id', $id)->delete();
            return ['code' => 1, 'data' => '', 'msg' => '分类删除成功'];
        }catch( PDOException $e){
            return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
        }
    }
}
