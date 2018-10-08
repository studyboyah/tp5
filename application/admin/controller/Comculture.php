<?php
namespace app\admin\controller;
use think\Request;
use app\admin\model\Com_culture;
use think\Hook;
class Comculture extends Base
{
    public function index()
    {
        // $data = __DIR__;
        // Hook::listen('hahah',$data);
        $key = input('key');
        $map = [];
        if($key&&$key!==""){
            $map['name'] = ['like',"%" . $key . "%"];          
        }
        $Nowpage = input('get.page') ?: 1;
        $limits = config('list_rows');// 获取总条数
        $profile = new Com_culture();
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

    public function add_culture(Request $request)
    {
         if($request->isGet())
        {
            return view();
        }
        if($request->isAjax())
        {
            $data = $request->post();
            $data['create_time'] = time();
            // if ($code = $this->validate_about($data)) {
            //     return json($code);
            // }
            $profile = new Com_culture();
            $flag = $profile->insertCom_culture($data);
            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }
    }

    public function edit_culture(Request $request)
    {
        if ($request->isGet())
        {
            $id = $request->param('id');
            $culture = Com_culture::get($id);  
            return view('edit_culture',['culture' => $culture]);
        }
        if ($request->isAjax()) 
        {
            $data = $request->post();
            // if ($code = $this->validate_about($data)) {
            //     return json($code);
            // }
            $culture = new Com_culture();
            if($culture->allowField(true)->save($data,['id'=>$data['id']]))
            {
                return json([
                'code' => 1,
                'msg'  => '编辑成功'
                ]);
            };
        }
    }

    public function del_culture()
    {
        $id = input('param.id');
        $cate = new Com_culture();
        $flag = $cate->delProfile($id);
        return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
    }

    public function culture_state()
    {
        $id=input('param.id');
        $culture = new Com_culture();
        $status = $culture->where(['id'=>$id])->value('status');
        if ($status == 1) 
        {
            $culture->where(['id'=>$id])->setField(['status' => 0]);
            return json([
                'code'  => 1,
                'msg' => '已禁用'
                ]);
        }
        else
        {
            $culture->where(['id'=>$id])->setField(['status' => 1]);
            return json([
                'code'  => 0,
                'msg' => '已开启'
                ]);
        }
    }

}
