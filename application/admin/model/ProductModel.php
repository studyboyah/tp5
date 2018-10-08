<?php
namespace app\admin\model;
use think\Model;
use think\Db;
class ProductModel extends Model
{
    protected $name = 'product';
    
    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = true;
    /**
     * 根据搜索条件获取用户列表信息
     */
      public function getProductByWhere($map, $Nowpage, $limits)
    {
        return $this->field('think_product.*,name')->join('think_product_cate', 'think_product.cate_id = think_product_cate.id')->where($map)->page($Nowpage, $limits)->order('id asc')->select();
    }
    /**
     * [insertArticle 添加作品列表]
     */
    public function insertProduct($param)
    {
        try{
            $result = $this->allowField(true)->save($param);
            if(false === $result){             
                return ['code' => -1, 'data' => '', 'msg' => $this->getError()];
            }else{
                return ['code' => 1, 'data' => '', 'msg' => '作品列表添加成功'];
            }
        }catch( PDOException $e){
            return ['code' => -2, 'data' => '', 'msg' => $e->getMessage()];
        }
    }



    /**
     * [updateArticle 编辑作品列表]
     */
    public function updateProduct($param)
    {
        try{
            $result = $this->allowField(true)->save($param, ['id' => $param['id']]);
            if(false === $result){          
                return ['code' => 0, 'data' => '', 'msg' => $this->getError()];
            }else{
                return ['code' => 1, 'data' => '', 'msg' => '作品列表编辑成功'];
            }
        }catch( PDOException $e){
            return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
        }
    }
    /**
     * [getOneArticle 根据文章id获取一条信息]
     */
    public function getOneProduct($id)
    {
        return $this->where('id', $id)->find();
    }
    public function getAllCate()
    {
        return $this->order('id asc')->select();       
    }


    /**
     * [delArticle 删除作品列表]
     */
    public function delProduct($id)
    {
        try{
            $this->where('id', $id)->delete();
            return ['code' => 1, 'data' => '', 'msg' => '作品列表删除成功'];
        }catch( PDOException $e){
            return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
        }
    }

}