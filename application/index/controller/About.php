<?php
namespace app\index\controller;
use think\Db;
class About extends Home{
	public function index(){
		//公司简介
		$profile=Db::name('com_profile')->find();
		$this->assign('profile',$profile);
		//企业文化
		$culture=Db::name('com_culture')->find();
		$this->assign('culture',$culture);
		//企业理念
		$ideas=Db::name('ideas')->select();
		$this->assign('ideas',$ideas);

		$contact=Db::name('contact')->find();
        $this->assign('contact',$contact);

        $bu_cate=Db::name('business_cate')->select();
        $this->assign('bu_cate',$bu_cate);
		return view('aboutus');
	}
}
?>