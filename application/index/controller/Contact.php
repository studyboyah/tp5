<?php
namespace app\index\controller;
use think\Db;
class Contact extends Home{
	public function index(){
	 	$contact=Db::name('contact')->find();
        $this->assign('contact',$contact);

        $bu_cate=Db::name('business_cate')->select();
        $this->assign('bu_cate',$bu_cate);

		
		return view('contact_us');
	}
}
?>