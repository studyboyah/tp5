<?php

namespace app\admin\controller;
use app\admin\model\MemberModel;
use app\admin\model\MemberGroupModel;
use think\Db;

class Member extends Base
{
    //*********************************************会员组*********************************************//
    /**
     * [group 会员组]
     */
    public function group(){

        $key = input('key');
        $map = [];
        if($key&&$key!==""){
            $map['car_name'] = ['like',"%" . $key . "%"];          
        }      
        $group = new MemberGroupModel(); 
        $Nowpage = input('get.page') ? input('get.page'):1;
        $limits = config('list_rows');
        $count = $group->getAllCount($map);         //获取总条数
        $allpage = intval(ceil($count / $limits));  //计算总页面      
        $lists = $group->getAll($map, $Nowpage, $limits);  
        $this->assign('Nowpage', $Nowpage); //当前页
        $this->assign('allpage', $allpage); //总页数 
        $this->assign('val', $key);
        if(input('get.page')){
            return json($lists);
        }
        return $this->fetch();
    }

    /**
     * [add_group 添加旗手]
     */
    public function add_group()
    {

        if(request()->isAjax()){
            $param = input('post.');
            $param['time']=date('Y-m-d H:i:s');
            
            $group = new MemberGroupModel();
            $flag = $group->insertGroup($param);
            
            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }
        return $this->fetch();
    }


    /**
     * [edit_group 编辑旗手]
     */
    public function edit_group()
    {

        $group = new MemberGroupModel();
        if(request()->isPost()){           
            $param = input('post.');
           
            $flag = $group->editGroup($param);
            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }

        $id = input('param.id');
        $this->assign('group',$group->getOne($id));

        return $this->fetch();
    }


    /**
     * [del_group 删除旗手]
     */
    public function del_group()
    {
        $id = input('param.id');

        $group = new MemberGroupModel();
        $flag = $group->delGroup($id);
        return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
    }

    /**
     * [group_status 旗手状态]
     */
    public function group_status()
    {
        $id=input('param.id');
        $status = Db::name('user_car')->where(array('id'=>$id))->value('status');//判断当前状态情况
        if($status==1)
        {
            $flag = Db::name('user_car')->where(array('id'=>$id))->setField(['status'=>0]);
            return json(['code' => 1, 'data' => $flag['data'], 'msg' => '已禁止']);
        }
        else
        {
            $flag = Db::name('user_car')->where(array('id'=>$id))->setField(['status'=>1]);
            return json(['code' => 0, 'data' => $flag['data'], 'msg' => '已开启']);
        }   
    } 


    //*********************************************会员列表*********************************************//
    /**
     * 会员列表
     */
    public function index(){

        $key = input('key');
        $map['closed'] = 0;//0未删除，1已删除
        if($key&&$key!=="")
        {
            $map['account|nickname|mobile'] = ['like',"%" . $key . "%"];          
        }
        $member = new MemberModel();       
        $Nowpage = input('get.page') ? input('get.page'):1;
        $limits = config('list_rows');// 获取总条数
        $count = $member->getAllCount($map);//计算总页面
        $allpage = intval(ceil($count / $limits));       
        $lists = $member->getMemberByWhere($map, $Nowpage, $limits);   
        $this->assign('Nowpage', $Nowpage); //当前页
        $this->assign('allpage', $allpage); //总页数 
        $this->assign('val', $key);
     
        if(input('get.page'))
        {
            return json($lists);
        }
        return $this->fetch();
    }


    /**
     * 添加会员
     */
    public function add_member()
    {

        if(request()->isAjax()){

            $param = input('post.');
            // $param['password'] = md5(md5($param['password']) . config('auth_key'));
            
            
            $member = new MemberModel();
            $flag = $member->insertMember($param);
            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }


        return $this->fetch();
    }


    /**
     * 编辑会员
     */
    public function edit_member()
    {
        $member = new MemberModel();
        if(request()->isAjax()){
            $param = input('post.');
            if(empty($param['password'])){
                unset($param['password']);
            }else{
                $param['password'] = md5(md5($param['password']) . config('auth_key'));
            }
            $flag = $member->editMember($param);
            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }

        $id = input('param.id');
        $group = new MemberGroupModel();
        $this->assign([
            'member' => $member->getOneMember($id),
            'group' => $group->getGroup()
        ]);
        return $this->fetch();
    }


    /**
     * 删除会员
     */
    public function del_member()
    {
        $id = input('param.id');
        $member = new MemberModel();
        $flag = $member->delMember($id);
        return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
    }



    /**
     * 会员状态
     */
    public function member_status()
    {
        $id = input('param.id');
        $status = Db::name('member')->where('id',$id)->value('status');//判断当前状态情况
        if($status==1)
        {
            $flag = Db::name('member')->where('id',$id)->setField(['status'=>0]);
            return json(['code' => 1, 'data' => $flag['data'], 'msg' => '已禁止']);
        }
        else
        {
            $flag = Db::name('member')->where('id',$id)->setField(['status'=>1]);
            return json(['code' => 0, 'data' => $flag['data'], 'msg' => '已开启']);
        }
    
    }

}


            //    if( '' == $.trim($('#phone').val())){
            //     layer.msg('请输入骑手电话',{icon:2,time:1500,shade: 0.1}, function(index){
            //     layer.close(index);
            //     });
            //     return false;
            // }
            //      if( '' == $.trim($('#idcard').val())){
            //     layer.msg('请输入身份证号',{icon:2,time:1500,shade: 0.1}, function(index){
            //     layer.close(index);
            //     });
            //     return false;
            // } 
            //    if( '' == $.trim($('#live_address').val())){
            //     layer.msg('请输入居住地址',{icon:2,time:1500,shade: 0.1}, function(index){
            //     layer.close(index);
            //     });
            //     return false;
            // }  
            // 
            // 
            // 
            // 
            // //  <div class="form-group">
            //                 <label class="col-sm-3 control-label">骑手电话：</label>
                            
            //                 <div class="input-group col-sm-4">
            //                     <input id="phone" type="text" class="form-control" name="phone" >
            //                 </div>
            //             </div>
            //                   <div class="form-group">
            //                 <label class="col-sm-3 control-label">身份证号：</label>
                            
            //                 <div class="input-group col-sm-4">
            //                     <input id="idcard" type="text" class="form-control" name="idcard" >
            //                 </div>
            //             </div>
            //              <div class="form-group">
            //                 <label class="col-sm-3 control-label">居住地址：</label>
                            
            //                 <div class="input-group col-sm-4">
            //                     <input id="live_address" type="text" class="form-control" name="live_address" >
            //                 </div>
            //             </div>