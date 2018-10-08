<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:71:"D:\phpStudy\WWW\tp5\public/../application/admin\view\talents\index.html";i:1538278712;s:71:"D:\phpStudy\WWW\tp5\public/../application/admin\view\public\header.html";i:1492388819;s:71:"D:\phpStudy\WWW\tp5\public/../application/admin\view\public\footer.html";i:1492388819;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo config('WEB_SITE_TITLE'); ?></title>
    <link href="/static/admin/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="/static/admin/css/font-awesome.min.css?v=4.4.0" rel="stylesheet">
    <link href="/static/admin/css/animate.min.css" rel="stylesheet">
    <link href="/static/admin/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="/static/admin/css/plugins/chosen/chosen.css" rel="stylesheet">
    <link href="/static/admin/css/plugins/switchery/switchery.css" rel="stylesheet">
    <link href="/static/admin/css/style.min.css?v=4.1.0" rel="stylesheet">
    <link href="/static/admin/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
    <style type="text/css">
    .long-tr th{
        text-align: center
    }
    .long-td td{
        text-align: center
    }
    </style>
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
    <!-- Panel Other -->
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>取件订单</h5>
        </div>
        <div class="ibox-content">
            <!--搜索框开始-->           
            <div class="row">
                <div class="col-sm-12">   
                <div  class="col-sm-2" style="width: 100px">
                    <div class="input-group" >  
                        <a href="<?php echo url('add_talents'); ?>"><button class="btn btn-outline btn-primary" type="button">添加订单</button></a> 
                    </div>
                </div> 
                    <form name="admin_list_sea" class="form-search" method="post" action="<?php echo url('index_select'); ?>">
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input type="text" id="key" class="form-control" name="key" value="" placeholder="输入需查询的订单号" />   
                                <span class="input-group-btn"> 
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> 搜索</button> 
                                </span>
                            </div>
                        </div>
                    </form>                                                                  
                </div>
            </div>
            <!--搜索框结束-->
            <div class="hr-line-dashed"></div>

            <div class="example-wrap">
                <div class="example">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr class="long-tr">
                                
                                <th>订单号</th>
                                <th>用户姓名</th>
                                <th>订单价格</th>
                                
                                <th>状态</th>
                                <th width="15%">下单时间</th>
                                <th>接单骑手</th>
                                <th>骑手电话</th>
                                <th>取件地址</th>
                                <th>取件号码</th>
                                <th>收件地址</th>

                                <th width="20%">操作</th>
                            </tr>
                        </thead>
                        <tbody id="article_list">
                            <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): if( count($list)==0 ) : echo "" ;else: foreach($list as $key=>$vo): ?>
                                <tr class="long-td">
                                    <td><?php echo $vo['id']; ?></td>
                                    <td><?php echo $vo['user_name']; ?></td>
                                    <td><?php echo $vo['price']; ?></td>
                                                                                                 
                                    <td>
                                        <?php if($vo['status'] == 0): ?>
                                            <div>待接单</div>
                                        <?php endif; if($vo['status'] == 1): ?>   
                                            <div>进行中</div>
                                         <?php endif; if($vo['status'] == 2): ?>   
                                            <div>已完成</div>
                                         <?php endif; if($vo['status'] == 3): ?>   
                                            <div>已退单</div>
                                         <?php endif; ?>  
                                    </td>
                                    <td><?php echo $vo['order_time']; ?></td>
                                    <td><?php echo $vo['car_name']; ?></td>
                                    <td><?php echo $vo['car_phone']; ?></td>
                                    <td><?php echo $vo['receive_address']; ?></td>
                                    <td><?php echo $vo['receive_code']; ?></td>
                                    <td><?php echo $vo['collect_address']; ?></td>
                                    <td>
                                    <?php if($vo['status'] == 0): ?>
                                        <a href="<?php echo url('edit_talents',['id'=>$vo['id']]); ?>" class="btn btn-primary btn-outline btn-xs">
                                            <i class="fa fa-paste"></i> 编辑</a>&nbsp;&nbsp;
                                    <?php endif; ?>
                                        <a href="javascript:;" onclick="del_talents(<?php echo $vo['id']; ?>)" class="btn btn-danger btn-outline btn-xs">
                                            <i class="fa fa-trash-o"></i> 删除</a>   
                                    </td>
                                </tr>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Panel Other -->
</div>
<script src="__JS__/jquery.min.js?v=2.1.4"></script>
<script src="__JS__/bootstrap.min.js?v=3.3.6"></script>
<script src="__JS__/content.min.js?v=1.0.0"></script>
<script src="__JS__/plugins/chosen/chosen.jquery.js"></script>
<script src="__JS__/plugins/iCheck/icheck.min.js"></script>
<script src="__JS__/plugins/layer/laydate/laydate.js"></script>
<script src="__JS__/plugins/switchery/switchery.js"></script><!--IOS开关样式-->
<script src="__JS__/jquery.form.js"></script>
<script src="__JS__/layer/layer.js"></script>
<script src="__JS__/laypage/laypage.js"></script>
<script src="__JS__/laytpl/laytpl.js"></script>
<script src="__JS__/lunhui.js"></script>
<script>
    $(document).ready(function(){$(".i-checks").iCheck({checkboxClass:"icheckbox_square-green",radioClass:"iradio_square-green",})});
</script>


<script type="text/javascript">

/**
 * [del 删除用户]
 * @Author[田建龙 864491238@qq.com]
 * @param   {[type]}    id [用户id]
 */
function del_talents(id){
    layer.confirm('确认删除此订单?', {icon: 3, title:'提示'}, function(index){
        //do something
        $.getJSON('./del_talents', {'id' : id}, function(res){
            if(res.code == 1){
                layer.msg(res.msg,{icon:1,time:1500,shade: 0.1},function(){
                    window.location.href="<?php echo url('Talents/index'); ?>";
                });               
            }else{
                layer.msg(res.msg,{icon:0,time:1500,shade: 0.1});
            }
        });

        layer.close(index);
    })

}

/**
 * [user_state 用户状态]
 * @param  {[type]} val [description]
 * @Author[田建龙 864491238@qq.com]
 */
function cate_state(val){
    $.post('<?php echo url("cate_state"); ?>',
    {id:val},
    function(data){
         
        if(data.code==1){
            var a='<span class="label label-danger">禁用</span>'
            $('#zt'+val).html(a);
            layer.msg(data.msg,{icon:2,time:1500,shade: 0.1,});
            return false;
        }else{
            var b='<span class="label label-info">开启</span>'
            $('#zt'+val).html(b);
            layer.msg(data.msg,{icon:1,time:1500,shade: 0.1,});
            return false;
        }         
        
    });
    return false;
}


</script>
</body>
</html>