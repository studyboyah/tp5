<?php
namespace app\admin\controller;
use app\admin\model\NewsModel;
use app\admin\model\NewsCateModel;
use think\Db;
class News extends Base
{
    /**
     * [index 新闻列表]
     */
    public function index(){

        $key = input('key');
        $map = [];
        if($key&&$key!==""){
            $map['title'] = ['like',"%" . $key . "%"];          
        }       
        $Nowpage = input('get.page') ? input('get.page'):1;
        $limits = config('list_rows');// 获取总条数
        $count = Db::name('news')->where($map)->count();//计算总页面
        $allpage = intval(ceil($count / $limits));
        $news = new NewsModel();
        $lists = $news->getNewsByWhere($map, $Nowpage, $limits);
        $this->assign('Nowpage', $Nowpage); //当前页
        $this->assign('allpage', $allpage); //总页数
        $this->assign('count', $count); 
        $this->assign('val', $key);
        if(input('get.page')){
            return json($lists);
        }
        return $this->fetch();
    }


    /**
     * [add_article 添加新闻列表]
     * @return [type] [description]
     */
    public function add_list()
    {
        if(request()->isAjax()){

            $param = input('post.');
            $news = new NewsModel();
            $flag = $news->insertNews($param);
            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }

        $cate = new NewsCateModel();
        $this->assign('cate',$cate->getAllCate());
        return $this->fetch();
    }


    /**
     * [edit_article 编辑新闻列表]
     * @return [type] [description]
     */
    public function edit_list()
    {
        $news = new NewsModel();     
        if(request()->isAjax()){

            $param = input('post.');         
            $flag = $news->updateNews($param);
            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }

        $id = input('param.id');
        $cate = new NewsCateModel();
        $this->assign('cate',$cate->getAllCate());
        $this->assign('news',$news->getOneNews($id));
        return $this->fetch();
    }

    /**
     * [del_article 删除新闻列表]
     * @return [type] [description]
     */
    public function del_list()
    {
        $id = input('param.id');
        $cate = new NewsModel();
        $flag = $cate->delNews($id);
        return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
    }



    /**
     * [article_state 新闻列表状态]
     * @return [type] [description]
     */
    public function cate_status()
    {
        $id=input('param.id');
        $status = Db::name('news')->where(array('id'=>$id))->value('status');//判断当前状态情况
        if($status==1)
        {
            $flag = Db::name('news')->where(array('id'=>$id))->setField(['status'=>0]);
            return json(['code' => 1, 'data' => $flag['data'], 'msg' => '已禁止']);
        }
        else
        {
            $flag = Db::name('news')->where(array('id'=>$id))->setField(['status'=>1]);
            return json(['code' => 0, 'data' => $flag['data'], 'msg' => '已开启']);
        }
    
    }
    //是否推荐
      public function is_tui()
    {
        $id=input('param.id');
        $is_tui = Db::name('news')->where(array('id'=>$id))->value('is_tui');//判断当前状态情况
        if($is_tui==1)
        {
            $flag = Db::name('news')->where(array('id'=>$id))->setField(['is_tui'=>0]);
            return json(['code' => 1, 'data' => $flag['data'], 'msg' => '否']);
        }
        else
        {
            $flag = Db::name('news')->where(array('id'=>$id))->setField(['is_tui'=>1]);
            return json(['code' => 0, 'data' => $flag['data'], 'msg' => '是']);
        }
    
    }



    //*********************************************分类管理*********************************************//

    /**
     * [index_cate 新闻分类]
     * @return [type] [description]
     */
    public function index_cate(){
        $cate = new NewsCateModel();
        $list = $cate->getAllCate();
        $this->assign('list',$list);
        return $this->fetch();
    }


    /**
     * [add_cate 添加新闻分类]
     * @return [type] [description]
     */
    public function add_cate()
    {
        if(request()->isAjax()){

            $param = input('post.');
            $cate = new NewsCateModel();
            $flag = $cate->insertCate($param);
            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }

        return $this->fetch();
    }


    /**
     * [edit_cate 编辑新闻分类]
     * @return [type] [description]
     */
    public function edit_cate()
    {
        $cate = new NewsCateModel();

        if(request()->isAjax()){

            $param = input('post.');
            $flag = $cate->editCate($param);
            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }

        $id = input('param.id');
        $this->assign('cate',$cate->getOneCate($id));
        return $this->fetch();
    }


    /**
     * [del_cate 删除新闻分类]
     * @return [type] [description]
     */
    public function del_cate()
    {
        $id = input('param.id');
        $cate = new NewsCateModel();
        $flag = $cate->delCate($id);
        return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
    }



    /**
     * [cate_state 分类状态]
     * @return [type] [description]
     */
    public function cate_state()
    {
        $id=input('param.id');
        $status = Db::name('news_cate')->where(array('id'=>$id))->value('status');//判断当前状态情况
        if($status==1)
        {
            $flag = Db::name('news_cate')->where(array('id'=>$id))->setField(['status'=>0]);
            return json(['code' => 1, 'data' => $flag['data'], 'msg' => '已禁止']);
        }
        else
        {
            $flag = Db::name('news_cate')->where(array('id'=>$id))->setField(['status'=>1]);
            return json(['code' => 0, 'data' => $flag['data'], 'msg' => '已开启']);
        } 
    }  




     //*********************************************新闻内容*********************************************//
     public function content(){
        $key = input('key');
        $map = [];
        if($key&&$key!==""){
            $map['title'] = ['like',"%" . $key . "%"];          
        }       
        $Nowpage = input('get.page') ? input('get.page'):1;
        $limits = config('list_rows');// 获取总条数
        $count = Db::name('news')->where($map)->count();//计算总页面
        $allpage = intval(ceil($count / $limits));
        $news = new NewsModel();
        $lists = $news->getNewsByWhere($map, $Nowpage, $limits);
        $this->assign('Nowpage', $Nowpage); //当前页
        $this->assign('allpage', $allpage); //总页数
        $this->assign('count', $count); 
        $this->assign('val', $key);
        if(input('get.page')){
            return json($lists);
        }
        return view('index_content');
     }

}