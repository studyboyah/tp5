<?php
namespace app\index\controller;
use think\Db;
class Product extends Home{
	public function outstandingWorkslist(){
		 if(!input('param.id') || input('param.id')==7){
            $id = 7;
            $all = DB::name('product')->order('id asc')->where('status',1)->select();
        }else{
            $id = input('param.id');  
            $all = DB::name('product')->order('id asc')->where('status',1)->where('cate_id',$id)->select();
        }
        $cate = DB::name('product_cate')->order('orderby asc')->where('status' , 1)->select();
        foreach ($cate as $key => $value) {
            $cate[$key]['cate_id'] = $id;
        }
		$this->assign('all',$all);
		$this->assign('cate',$cate);






		//分页
		$lists =db::name('product')->where('status',1)->paginate(9,true);
		$page = $lists->render();
		$this->assign('page', $page);
		$this->assign('lists', $lists);

		//底部
		$contact=Db::name('contact')->find();
        $this->assign('contact',$contact);

        $bu_cate=Db::name('business_cate')->select();
        $this->assign('bu_cate',$bu_cate);
		return $this->fetch('outstandingWorkslist');	
	}
}
?>