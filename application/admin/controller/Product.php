<?php
namespace app\admin\controller;
use think\Db;
use app\admin\model\ProductModel;
use app\admin\model\ProductCateModel;
use app\admin\validate\ProductValidate;
class Product extends Base{
	//渲染作品分类页面
	public function index_cate(){
        $key = input('key');
        $map = [];
        if($key&&$key!==""){
            $map['title'] = ['like',"%" . $key . "%"];          
        }       
        $Nowpage = input('get.page') ? input('get.page'):1;
        $limits = config('list_rows');// 获取总条数
        $count = Db::name('product_cate')->where($map)->count();//计算总页面
        $allpage = intval(ceil($count / $limits));
        $product = new ProductCateModel();
        $lists = $product->getCateByWhere($map, $Nowpage, $limits);
        $this->assign('lists',$lists);
        $this->assign('Nowpage', $Nowpage); //当前页
        $this->assign('allpage', $allpage); //总页数
        $this->assign('count', $count); 
        $this->assign('val', $key);
        if(input('get.page')){
            return json($lists);
        }
        return view();
	}
	//添加分类
	 public function add_cate()
    {
        if(request()->isAjax()){

            $param = input('post.');
            $cate = new ProductCateModel();
            $flag = $cate->insertCate($param);
            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }
        return view();
    }
    //编辑分类
      public function edit_cate(){
        $cate = new ProductCateModel();
        if(request()->isAjax()){
            $param = input('post.');
            $flag = $cate->editCate($param);
            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }

        $id = input('param.id');
        $this->assign('cate',$cate->getOneCate($id));
        return $this->fetch();
    }
    //删除分类
    public function del_cate()
    {
        $id = input('param.id');
        $cate = new ProductCateModel();
        $flag = $cate->delCate($id);
        return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
    }
	//分类状态
	public function cate_state(){
        $id=input('param.id');
        $status = Db::name('product_cate')->where(array('id'=>$id))->value('status');//判断当前状态情况
        if($status==1)
        {
            $flag = Db::name('product_cate')->where(array('id'=>$id))->setField(['status'=>0]);
            return json(['code' => 1, 'data' => $flag['data'], 'msg' => '已禁止']);
        }
        else
        {
            $flag = Db::name('product_cate')->where(array('id'=>$id))->setField(['status'=>1]);
            return json(['code' => 0, 'data' => $flag['data'], 'msg' => '已开启']);
        }
    
    } 
    //渲染作品列表
    public function index(){ 
    	$key = input('key');
        $map = [];
        if($key&&$key!==""){
            $map['title'] = ['like',"%" . $key . "%"];          
        }       
        $Nowpage = input('get.page') ? input('get.page'):1;
        $limits = config('list_rows');// 获取总条数
        $count = Db::name('product')->where($map)->count();//计算总页面
        $allpage = intval(ceil($count / $limits));
        $product = new ProductModel();
        $lists = $product->getProductByWhere($map, $Nowpage, $limits);
        $this->assign('Nowpage', $Nowpage); //当前页
        $this->assign('allpage', $allpage); //总页数
        $this->assign('count', $count); 
        $this->assign('val', $key);
        if(input('get.page')){
            return json($lists);
        }
    	return view();
    }
    //添加作品列表
    public function add_list()
    {
        if(request()->isAjax()){
            $param = input('post.');
            $product = new ProductModel();
            $flag = $product->insertProduct($param);
            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }
	        $cate = new ProductCateModel();
	        $this->assign('cate',$cate->getAllCate());
	        return view();
    }
    //编作品列表
     public function edit_list()
    {
        $product = new ProductModel();     
        if(request()->isAjax()){
            $param = input('post.');         
            $flag = $product->updateProduct($param);
            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }
        $id = input('param.id');
        $cate = new ProductCateModel();
        $this->assign('cate',$cate->getAllCate());
        $this->assign('product',$product->getOneProduct($id));
        return $this->fetch();
    }
    //删除作品列表
     public function del_list()
    {
        $id = input('param.id');
        $cate = new ProductModel();
        $flag = $cate->delProduct($id);
        return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
    }
    //列表状态
    public function cate_status(){
        $id=input('param.id');
        $status = Db::name('product')->where(array('id'=>$id))->value('status');//判断当前状态情况
        if($status==1)
        {
            $flag = Db::name('product')->where(array('id'=>$id))->setField(['status'=>0]);
            return json(['code' => 1, 'data' => $flag['data'], 'msg' => '已禁止']);
        }
        else
        {
            $flag = Db::name('product')->where(array('id'=>$id))->setField(['status'=>1]);
            return json(['code' => 0, 'data' => $flag['data'], 'msg' => '已开启']);
        }
    
    } 
    //列表推荐
    public function is_tui(){
        $id=input('param.id');
        $is_tui = Db::name('product')->where(array('id'=>$id))->value('is_tui');//判断当前状态情况
        if($is_tui==1)
        {
            $flag = Db::name('product')->where(array('id'=>$id))->setField(['is_tui'=>0]);
            return json(['code' => 1, 'data' => $flag['data'], 'msg' => '否']);
        }
        else
        {
            $flag = Db::name('product')->where(array('id'=>$id))->setField(['is_tui'=>1]);
            return json(['code' => 0, 'data' => $flag['data'], 'msg' => '是']);
        }
    
    } 
}
?>