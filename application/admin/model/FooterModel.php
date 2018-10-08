<?php
namespace app\admin\model;
use think\Model;
use think\Db;
class FooterModel extends Model{
	 protected $name = 'footer';
	//渲染底部的数据
     public function getFooterByWhere($map, $Nowpage, $limits)
    {
       return $this->field('think_footer.*')->where($map)->page($Nowpage, $limits)->order('id asc')->select();
    }
    //添加底部
       public function insertFooter($param){
          try{
              $result = $this->allowField(true)->save($param);
              if(false === $result){             
                  return ['code' => -1, 'data' => '', 'msg' => $this->getError()];
              }else{
                  return ['code' => 1, 'data' => '', 'msg' => '添加信息成功'];
              }
          }catch( PDOException $e){
              return ['code' => -2, 'data' => '', 'msg' => $e->getMessage()];
          }
    }
    //编辑底部我们
    public function updateFooter($param){
      try{
        $result=$this->allowField(true)->save($param,['id'=>$param['id']]);
        if(false==$result){
          return ['code'=>-1,'data'=>'','msg'=>$this->getError()];
        }else{
          return ['code'=>1,'data'=>'','msg'=>'编辑信息成功'];
        }
      }catch(PDOException $e){
        return ['code'=>1,'data'=>'','msg'=>$e->getMessage];
      }
    }
    //根据ID获取其中的一条数据
    public function getOneFooter($id){
      return $this->where('id',$id)->find();
    }
    //删除底部我们
    public function deleteFooter($id){
      try{
        $this->where('id',$id)->delete();
        return ['code'=>1,'data'=>'','msg'=>'删除信息成功'];
      }catch(PDOException $e){
        return ['code'=>0,'data'=>'','msg'=>$e->getMessage()];
      }
    }
}
?>