<?php
namespace app\admin\controller;
use think\Db;
use app\admin\model\ContactModel;
use app\admin\model\FooterModel;
use think\Request;
use think\Hook;
class contact extends Base{
	public function index(){
		$key = input('key');
        $map = [];
        if($key&&$key!==""){
            $map['title'] = ['like',"%" . $key . "%"];          
        }       
        $Nowpage = input('get.page') ? input('get.page'):1;
        $limits = config('list_rows');// 获取总条数
        $count = Db::name('contact')->where($map)->count();
        $allpage = intval(ceil($count / $limits));
        $contact = new ContactModel();
        $lists = $contact->getContactByWhere($map, $Nowpage, $limits);
        $this->assign('Nowpage', $Nowpage); //当前页
        $this->assign('allpage', $allpage); //总页数
        $this->assign('count', $count); 
        $this->assign('val', $key);
        if(input('get.page')){
            return json($lists);
        }
		return view();
	}
    //添加联系我们
    public function add()
    {
      if(request()->isAjax()){
        $param=input('post.');
        $contact=new ContactModel();
        $flag=$contact->insertContact($param);
        return ['code'=>$flag['code'],'data'=>$flag['data'],'msg'=>$flag['msg']];
      }
            return view();
    }
    //编辑联系我们
        public function edit(){
        $contact = new  ContactModel();     
        if(request()->isAjax()){
            $param = input('post.');         
            $flag = $contact->updateContact($param);
            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }
        $id = input('param.id');
        $this->assign('contact',$contact->getOneContact($id));
        return $this->fetch();
    }
    //删除联系我们
    public function delete(){
        
        $id=input('param.id');
        $contact=new ContactModel();
        $flag=$contact->deleteContact($id);
        return json(['code'=>$flag['code'],'data'=>$flag['data'],'msg'=>$flag['msg']]);
    }
    //状态
     public function cate_status()
    {
        $id=input('param.id');
        $status = Db::name('contact')->where(array('id'=>$id))->value('status');//判断当前状态情况
        if($status==1)
        {
            $flag = Db::name('contact')->where(array('id'=>$id))->setField(['status'=>0]);
            return json(['code' => 1, 'data' => $flag['data'], 'msg' => '已禁止']);
        }
        else
        {
            $flag = Db::name('contact')->where(array('id'=>$id))->setField(['status'=>1]);
            return json(['code' => 0, 'data' => $flag['data'], 'msg' => '已开启']);
        }
    }
    //渲染底部页面
    public function index_footer(){
        $key = input('key');
        $map = [];
        if($key&&$key!==""){
            $map['title'] = ['like',"%" . $key . "%"];          
        }       
        $Nowpage = input('get.page') ? input('get.page'):1;
        $limits = config('list_rows');// 获取总条数
        $count = Db::name('footer')->where($map)->count();
        $allpage = intval(ceil($count / $limits));
        $contact = new FooterModel();
        $lists = $contact->getFooterByWhere($map, $Nowpage, $limits);
        $this->assign('Nowpage', $Nowpage); //当前页
        $this->assign('allpage', $allpage); //总页数
        $this->assign('count', $count); 
        $this->assign('val', $key);
        if(input('get.page')){
            return json($lists);
        }
        return view('footer_index');
    }
   //添加底部
   public function add_footer(){
        if(request()->isAjax()){
            $param=input('post.');
            $contact=new FooterModel();
            $flag=$contact->insertFooter($param);
            return ['code'=>$flag['code'],'data'=>$flag['data'],'msg'=>$flag['msg']];
          }
        return view();
   }
   //编辑底部
   public function edit_footer(){
       $contact = new  FooterModel();     
            if(request()->isAjax()){
                $param = input('post.');         
                $flag = $contact->updateFooter($param);
                return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
            }
            $id = input('param.id');
            $this->assign('contact',$contact->getOneFooter($id));
            return $this->fetch();
   }
   //删除底部信息
    public function delete_footer(){
        
        $id=input('param.id');
        $contact=new FooterModel();
        $flag=$contact->deleteFooter($id);
        return json(['code'=>$flag['code'],'data'=>$flag['data'],'msg'=>$flag['msg']]);
    }
    //状态
     public function cate()
    {
        $id=input('param.id');
        $status = Db::name('footer')->where(array('id'=>$id))->value('status');//判断当前状态情况
        if($status==1)
        {
            $flag = Db::name('footer')->where(array('id'=>$id))->setField(['status'=>0]);
            return json(['code' => 1, 'data' => $flag['data'], 'msg' => '已禁止']);
        }
        else
        {
            $flag = Db::name('footer')->where(array('id'=>$id))->setField(['status'=>1]);
            return json(['code' => 0, 'data' => $flag['data'], 'msg' => '已开启']);
        }
    }
}
?>