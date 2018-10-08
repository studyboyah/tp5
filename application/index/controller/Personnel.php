<?php
namespace app\index\controller;
use think\Db;
class Personnel extends Home{
	public function index(){
		$talent=Db::name('talents_opus')->select();
		$this->assign('talent',$talent);



		$contact=Db::name('contact')->find();
        $this->assign('contact',$contact);

        $bu_cate=Db::name('business_cate')->select();
        $this->assign('bu_cate',$bu_cate);
		return view('peoplelist');
	}
}
?>