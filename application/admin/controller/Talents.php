<?php

namespace app\admin\controller;
use think\Db;
use think\Request;
use app\admin\model\TalentsModel;
use app\admin\model\TalentsOpusModel;
class Talents extends Base
{
//////////////取件列表/////////////////
    public function index()
    {
        // Hook::listen('appEnd' , $params);
        $cate = new TalentsModel();
        $list = $cate->getAllTalents();
        $this->assign('list',$list);
        return $this->fetch();
    }
       
    
    public function index_select(){
        $key = input('key');
        $cate = new TalentsModel();
        $cate=$cate->getOneTalents($key);
        $this->assign('cate',$cate);
        return $this->fetch();
    }
    public function add_talents()
    {
        if(request()->isAjax()){
            $param = input('post.');
            $param['order_time']=date('Y-m-d H:i:s');
            $cate = new TalentsModel();
            $flag = $cate->insertTalents($param);
            return json([
                'code' => $flag['code'], 
                'data' => $flag['data'], 
                'msg' => $flag['msg']
            ]);
        }

        return $this->fetch();
    }
    public function edit_talents()
    {
        $cate = new TalentsModel();

        if(request()->isAjax()){

            $param = input('post.');
            $flag = $cate->editTalents($param);
            return json([
                'code' => $flag['code'], 
                'data' => $flag['data'], 
                'msg' => $flag['msg']
            ]);
        }

        $id = input('param.id');
        $this->assign('cate',$cate->getOneTalents($id));
        return $this->fetch();
    }
    public function del_talents()
    {
        $id = input('param.id');
        $cate = new TalentsModel();
        $flag = $cate->delTalents($id);
        return json([
            'code' => $flag['code'], 
            'data' => $flag['data'], 
            'msg' => $flag['msg']
        ]);
    }
    public function cate_state()
    {
        $id=input('param.id');
        $status = Db::name('talents')->where(array('id'=>$id))->value('status');//判断当前状态情况
        if($status==1)
        {
            $flag = Db::name('talents')->where(array('id'=>$id))->setField(['status'=>0]);
            return json([
                'code' => 1, 
                'data' => $flag['data'], 
                'msg' => '已禁止'
            ]);
        }
        else
        {
            $flag = Db::name('talents')->where(array('id'=>$id))->setField(['status'=>1]);
            return json([
                'code' => 0, 
                'data' => $flag['data'], 
                'msg' => '已开启'
            ]);
        }
    }
//////////////寄件列表/////////////////
    public function index_opus(){
        $key = input('key');
        $map = [];
        if($key&&$key!==""){
            $map['id'] = ['like',"%" . $key . "%"];          
        }       
        $Nowpage = input('get.page') ? input('get.page'):1;
        $limits = config('list_rows');// 获取总条数
        $count = Db::name('order_take')->where($map)->count();//计算总页面

        $allpage = intval(ceil($count / $limits));
        $news = new TalentsOpusModel();
        $lists = $news->getOpusByWhere($map, $Nowpage, $limits);
        // var_dump($lists);die;
        $this->assign('Nowpage', $Nowpage); //当前页
        $this->assign('allpage', $allpage); //总页数
        $this->assign('count', $count); 
        $this->assign('val', $key);
        if(input('get.page')){
            
            return json($lists);
        }
        return $this->fetch();
    }
    //添加
    public function add_opus()
    {
        if(request()->isAjax()){

            $param = input('post.');
             $param['order_time']=date('Y-m-d H:i:s');

            $news = new TalentsOpusModel();
            $flag = $news->insertOpus($param);
            return json([
                'code' => $flag['code'], 
                'data' => $flag['data'], 
                'msg' => $flag['msg']
            ]);
        }
       
        return $this->fetch();
    }
    //编辑
    public function edit_opus()
    {
        $opus = new TalentsOpusModel();     
        if(request()->isAjax()){

            $param = input('post.');         
            $flag = $opus->updateOpus($param);
            return json([
                'code' => $flag['code'], 
                'data' => $flag['data'], 
                'msg' => $flag['msg']
            ]);
        }

        $id = input('param.id');
        $cate = new TalentsModel();
        $this->assign('cate',$cate->getAllTalents());
        $this->assign('opus',$opus->getOneOpus($id));
        return $this->fetch();
    }
    //删除
    public function del_opus()
    {
        $id = input('param.id');
        $cate = new TalentsOpusModel();
        $flag = $cate->delOpus($id);
        return json([
            'code' => $flag['code'], 
            'data' => $flag['data'], 
            'msg' => $flag['msg']
        ]);
    }
    //状态
    public function opus_state()
    {
        $id=input('param.id');
        $status = Db::name('talents_opus')->where(array('id'=>$id))->value('status');//判断当前状态情况
        if($status==1)
        {
            $flag = Db::name('talents_opus')->where(array('id'=>$id))->setField(['status'=>0]);
            return json([
                'code' => 1, 
                'data' => $flag['data'], 
                'msg' => '已禁止'
            ]);
        }
        else
        {
            $flag = Db::name('talents_opus')->where(array('id'=>$id))->setField(['status'=>1]);
            return json([
                'code' => 0, 
                'data' => $flag['data'], 
                'msg' => '已开启'
            ]);
        }
    
    }
    //推荐
    public function opus_istui()
    {
        $id=input('param.id');
        $istui = Db::name('talents_opus')->where(array('id'=>$id))->value('is_tui');//判断当前状态情况
        if($istui==1)
        {
            $flag = Db::name('talents_opus')->where(array('id'=>$id))->setField(['is_tui'=>0]);
            return json([
                'code' => 1, 
                'data' => $flag['data'], 
                'msg' => '取消推荐'
            ]);
        }
        else
        {
            $flag = Db::name('talents_opus')->where(array('id'=>$id))->setField(['is_tui'=>1]);
            return json([
                'code' => 0, 
                'data' => $flag['data'], 
                'msg' => '开启推荐'
            ]);
        }
    
    }


}
