<?php
namespace app\admin\model;
use think\Db;
use think\Model;
class ContactModel extends Model{
	//先找到表
	 protected $name = 'contact';
	 //开启自动时间戳
	 protected $autoWriteTimestamp = true;
	 //渲染数据库的数据到页面
	  public function getContactByWhere($map, $Nowpage, $limits)
    {
       return $this->field('think_contact.*')->where($map)->page($Nowpage, $limits)->order('id asc')->select();
    }
    //添加联系我们
       public function insertContact($param){
	        try{
	            $result = $this->validate('ContactValidate')->allowField(true)->save($param);
	            if(false === $result){             
	                return ['code' => -1, 'data' => '', 'msg' => $this->getError()];
	            }else{
	                return ['code' => 1, 'data' => '', 'msg' => '联系我们添加成功'];
	            }
	        }catch( PDOException $e){
	            return ['code' => -2, 'data' => '', 'msg' => $e->getMessage()];
	        }
    }
    //编辑联系我们
    public function updateContact($param){
    	try{
    		$result=$this->validate('ContactValidate')->allowField(true)->save($param,['id'=>$param['id']]);
    		if(false==$result){
    			return ['code'=>-1,'data'=>'','msg'=>$this->getError()];
    		}else{
    			return ['code'=>1,'data'=>'','msg'=>'联系我们编辑成功'];
    		}
    	}catch(PDOException $e){
    		return ['code'=>1,'data'=>'','msg'=>$e->getMessage];
    	}
    }
    //根据ID获取其中的一条数据
   	public function getOneContact($id){
   		return $this->where('id',$id)->find();
   	}
   	//删除联系我们
   	public function deleteContact($id){
   		try{
   			$this->where('id',$id)->delete();
   			return ['code'=>1,'data'=>'','msg'=>'删除联系我们成功'];
   		}catch(PDOException $e){
   			return ['code'=>0,'data'=>'','msg'=>$e->getMessage()];
   		}
   	}
}
?>