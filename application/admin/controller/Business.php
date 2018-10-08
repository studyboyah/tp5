<?php
namespace app\admin\controller;
use think\Db;
use app\admin\model\BusinessCateModel;
use app\admin\model\BusinessModel;
use think\Request;
use think\Hook;
use think\Upload;
class Business extends Base
{
////////////////业务分类/////////////////
    public function index_cate()
    {   
        $cate = new BusinessCateModel();
        $list = $cate->getAllCate();
        $this->assign('list',$list);
        return $this->fetch();
    }
    public function cate_state()
    {
        $id=input('param.id');
        $status = Db::name('business_cate')->where(array('id'=>$id))->value('status');//判断当前状态情况
        if($status==1)
        {
            $flag = Db::name('business_cate')->where(array('id'=>$id))->setField(['status'=>0]);
            return json([
                'code' => 1, 
                'data' => $flag['data'], 
                'msg' => '已禁止'
            ]);
        }
        else
        {
            $flag = Db::name('business_cate')->where(array('id'=>$id))->setField(['status'=>1]);
            return json([
                'code' => 0, 
                'data' => $flag['data'], 
                'msg' => '已开启'
            ]);
        }
    
    }
    public function add_cate()
    {
        if(request()->isAjax()){
            
            $param = input('post.');
            $cate = new BusinessCateModel();
            $flag = $cate->insertCate($param);
            return json([
                'code' => $flag['code'], 
                'data' => $flag['data'], 
                'msg' => $flag['msg']
            ]);
        }

        return $this->fetch();
    }
    
    public function edit_cate()
    {
        $cate = new BusinessCateModel();

        if(request()->isAjax()){
 
            $param = input('post.');
            $flag = $cate->editCate($param);
            return json([
                'code' => $flag['code'], 
                'data' => $flag['data'], 
                'msg' => $flag['msg']
            ]);
        }

        $id = input('param.id');
        $this->assign('cate',$cate->getOneCate($id));
        return $this->fetch();
    }
    public function del_cate()
    {
        $id = input('param.id');
        $cate = new BusinessCateModel();
        $flag = $cate->delCate($id);
        return json([
            'code' => $flag['code'], 
            'data' => $flag['data'], 
            'msg' => $flag['msg']
        ]);
    }

///////////////////业务列表页////////////////////
    public function index(){
        
        $key = input('key');
        $map = [];
        if($key&&$key!==""){
            $map['title'] = ['like',"%" . $key . "%"];          
        }       
        $Nowpage = input('get.page') ? input('get.page'):1;
        $limits = config('list_rows');// 获取总条数
        $count = Db::name('business')->where($map)->count();//计算总页面
        $allpage = intval(ceil($count / $limits));
        $business = new BusinessModel();
        $lists = $business->getNewsByWhere($map, $Nowpage, $limits);
        $this->assign('Nowpage', $Nowpage); //当前页
        $this->assign('allpage', $allpage); //总页数
        $this->assign('count', $count); 
        $this->assign('val', $key);
        if(input('get.page')){
            return json($lists);
        }
        return $this->fetch();
    }
    public function add_business()
    {
        if(request()->isAjax()){

            $param = input('post.');
            $news = new BusinessModel();
            $flag = $news->insertBusiness($param);
            return json([
                'code' => $flag['code'], 
                'data' => $flag['data'], 
                'msg' => $flag['msg']
            ]);
        }
        $cate = Db::name('business_cate')->where('status',1)->select();
        $this->assign('cate',$cate);
        return $this->fetch();
    }
    public function business_state()
    {
        $id=input('param.id');
        $status = Db::name('business')->where(array('id'=>$id))->value('status');//判断当前状态情况
        if($status==1)
        {
            $flag = Db::name('business')->where(array('id'=>$id))->setField(['status'=>0]);
            return json([
                'code' => 1, 
                'data' => $flag['data'], 
                'msg' => '已禁止'
            ]);
        }
        else
        {
            $flag = Db::name('business')->where(array('id'=>$id))->setField(['status'=>1]);
            return json([
                'code' => 0, 
                'data' => $flag['data'], 
                'msg' => '已开启'
            ]);
        }
    
    }
    public function edit_business()
    {
        $business = new BusinessModel();     
        if(request()->isAjax()){
            $param = input('post.');         
            $flag = $business->updateBusiness($param);
            // if(input('.photo') !=$business['photo']){
            //     $filename='/uploads/images/'.'/$business['photo']';
            //     unlink($filename);
            // }
            return json([
                'code' => $flag['code'], 
                'data' => $flag['data'], 
                'msg' => $flag['msg']
            ]);
        }

        $id = input('param.id');
        $cate = new BusinessCateModel();
        $this->assign('cate',$cate->getAllCate());
        $this->assign('business',$business->getOneBusiness($id));
        return $this->fetch();
    }
    public function del_business()
    {
        $id = input('param.id');
        $cate = new BusinessModel();
        $flag = $cate->delBusiness($id);
        return json([
            'code' => $flag['code'], 
            'data' => $flag['data'], 
            'msg' => $flag['msg']
        ]);
    }






}
