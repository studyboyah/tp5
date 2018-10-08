<?php
namespace app\index\controller;
use think\Db;
class News extends Home{
    public function newslist(){
        if(!input('param.id') || input('param.id')==7){
            $id = 7;
            $all = DB::name('news')->order('id asc')->where('status',1)->select();
        }else{
            $id = input('param.id');  
            $all = DB::name('news')->order('id asc')->where('status',1)->where('cate_id',$id)->select();
        }
        $cate = DB::name('news_cate')->order('orderby asc')->where('status' , 1)->select();
        foreach ($cate as $key => $value) {
            $cate[$key]['cate_id'] = $id;
        }
        foreach($all as $k =>$v){
                $all[$k]['update_time'] = date('Y-m-d' , $v['update_time']);
        }
        $contact=Db::name('contact')->find();
        $this->assign('contact',$contact);

        $bu_cate=Db::name('business_cate')->select();
        $this->assign('bu_cate',$bu_cate);
        return view('newslist' , ['all'=>$all , 'cate'=>$cate]);
    }
     public function news_page(){
        //底部
         $contact=Db::name('contact')->find();
        $this->assign('contact',$contact);

        $bu_cate=Db::name('business_cate')->select();
        $this->assign('bu_cate',$bu_cate);
            return view();
        }  
}
?>