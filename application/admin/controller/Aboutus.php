<?php

namespace app\admin\controller;
use think\Request;
use think\Db;
use app\admin\model\Com_profile;
use app\admin\model\Ideas;
//use app\admin\validate\AboutusValidate;
class Aboutus extends Base
{
    public function profile()
    {
        $key = input('key');
        $map = [];
        if($key&&$key!==""){
            $map['title'] = ['like',"%" . $key . "%"];          
        }
        $Nowpage = input('get.page') ?:1;
        $limits = config('list_rows');// 获取总条数
        $profile = new Com_profile();
        $count = $profile->where($map)->count();//计算总页面   
        $allpage = intval(ceil($count / $limits));
        $lists = $profile->getArticleByWhere($map, $Nowpage, $limits);
        $this->assign([
            'Nowpage' => $Nowpage,
            'allpage' => $allpage,
            'count'   => $count,
            'val'     => $key
            ]);
        if(input('get.page')){
            return json($lists);
        }
        return $this->fetch('index');
    }

    public function add_profile(Request $request)
    {
        if($request->isGet())
        {
            return view();
        }
        if($request->isAjax())
        {
            // $data = $request->post();
            // $data['create_time'] = time();
            // $profile = new Com_profile();
            // $cata = $profile->data($data);
            // $c = $profile->allowField(true)->save();
            // return json(['code' => 1, 'msg' => '添加成功']);
            $data = $request->post();
            //$data['create_time'] = time();
            //if ($code = $this->validate_about($data)) {
            //    return json($code);
            //}
            $profile = new Com_profile();
            $flag = $profile->insertCom_profile($data);
            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }
    }

    public function edit_profile(Request $request)
    {

        if ($request->isGet()) 
        {
            $id = $request->param('id');
            $profile = Com_profile::get($id);  
            return view('edit_profile',['profile' => $profile]);
        }
        if ($request->isAjax()) 
        {
            $data = $request->post();
            // if ($code = $this->validate_about($data)) {
            //     return json($code);
            // }
            $profile = new Com_profile();
            if($profile->allowField(true)->save($data,['id'=>$data['id']]))
            {
                return json([
                'code' => 1,
                'msg'  => '编辑成功'
                ]);
            };
        }
    }

    public function profile_state()
    {
        $id=input('param.id');
        $profile = new Com_profile();
        $status = $profile->where(['id'=>$id])->value('status');
        if ($status == 1) 
        {
            $profile->where(['id'=>$id])->setField(['status' => 0]);
            return json([
                'code'  => 1,
                'msg' => '已禁用'
                ]);
        }
        else
        {
            $profile->where(['id'=>$id])->setField(['status' => 1]);
            return json([
                'code'  => 0,
                'msg' => '已开启'
                ]);
        }
    }

    public function del_profile()
    {
        $id = input('param.id');
        $cate = new Com_profile();
        $flag = $cate->delProfile($id);
        return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
    }

    // public function validate_about( $data )
    // {
    //     // $validate = Loader::validate('AboutusValidate');
    //     $validate = new AboutusValidate();
    //     if(!$validate->check($data)){
    //         // dump($validate->getError());
    //         return [
    //             'code' => 0,
    //             'msg'  => $validate->getError()
    //         ];
    //     }
    // }

    public function ideas(Ideas $ideas)
    {

        $key = input('key');
        $map = [];
        if($key&&$key!==""){
            $map['idea'] = ['like',"%" . $key . "%"];          
        }
        $Nowpage = input('get.page') ?:1;
        $limits = config('list_rows');// 获取总条数
        $count = $ideas->where($map)->count();//计算总页面   
        $allpage = intval(ceil($count / $limits));
        $lists = $ideas->getArticleByWhere($map, $Nowpage, $limits);
        $this->assign([
            'Nowpage' => $Nowpage,
            'allpage' => $allpage,
            'count'   => $count,
            'val'     => $key
            ]);
        if(input('get.page')){
            return json($lists);
        }
        return $this->fetch('index_ideas');
    }

    public function add_ideas(Request $request , Ideas $ideas)
    {
        if ($request->isAjax()) {
            $data = $request->param();
            $ideas->allowField(true)->save($data);
            return json([
                'code' => 1,
                'msg'  => '添加成功'
            ]);
        }
        return view();
    }

    public function edit_ideas(Request $request , Ideas $ideas,$id)
    {
        if ($request->isAjax()) {
            $data = $request->param();
            $ideas->allowField(true)->save($data,["id = $id"]);
            return json([
                'code' => 1,
                'msg'  => '修改成功'
            ]);
        }
        $data = $ideas->where("id=$id")->find();
        return view('edit_ideas',['data'=>$data]);
    }

    public function del_ideas(Ideas $ideas,$id)
    {
        $ideas->where("id = $id")->delete();
        return json([
                'code' => 1,
                'msg'  => '删除成功'
            ]);
    }

    public function ideas_state(Ideas $ideas,$id)
    {
        $status = $ideas->where(['id'=>$id])->value('status');
        if ($status == 1) 
        {
            $ideas->where(['id'=>$id])->setField(['status' => 0]);
            return json([
                'code'  => 1,
                'msg' => '已禁用'
                ]);
        }
        else
        {
            $ideas->where(['id'=>$id])->setField(['status' => 1]);
            return json([
                'code'  => 0,
                'msg' => '已开启'
                ]);
        }
    }
}
