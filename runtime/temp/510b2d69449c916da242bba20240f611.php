<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:76:"D:\phpStudy\WWW\tp5\public/../application/admin\view\product\index_cate.html";i:1513166384;s:71:"D:\phpStudy\WWW\tp5\public/../application/admin\view\public\header.html";i:1492388819;s:71:"D:\phpStudy\WWW\tp5\public/../application/admin\view\public\footer.html";i:1492388819;}*/ ?>
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
            <h5>优秀作品分类</h5>
        </div>
        <div class="ibox-content">
            <!--搜索框开始-->           
            <div class="row">
                <div class="col-sm-12">   
                <div  class="col-sm-2" style="width: 100px">
                    <div class="input-group" >  
                        <a href="<?php echo url('add_cate'); ?>"><button class="btn btn-outline btn-primary" type="button">添加作品分类</button></a> 
                    </div>
                </div>                                                                    
                </div>
            </div>
            <!--搜索框结束-->
            <div class="hr-line-dashed"></div>
            <div class="example-wrap">
                <div class="example">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr class="long-tr">
                                <th>ID</th>
                                <th>名称</th>
                                <th>状态</th>
                                <th width="15%">添加时间</th>
                                <th width="15%">更新时间</th>
                                <th width="20%">操作</th>
                            </tr>
                        </thead>
                        <tbody id="product_list">
                            <?php if(is_array($lists) || $lists instanceof \think\Collection || $lists instanceof \think\Paginator): if( count($lists)==0 ) : echo "" ;else: foreach($lists as $key=>$vo): ?>
                                <tr class="long-td">
                                    <td><?php echo $vo['id']; ?></td>
                                    <td><?php echo $vo['name']; ?></td>
                                    <td>
                                        <?php if($vo['status'] == 1): ?>
                                            <a href="javascript:;" onclick="cate_state(<?php echo $vo['id']; ?>);">
                                                <div id="zt<?php echo $vo['id']; ?>"><span class="label label-info">开启</span></div>
                                            </a>
                                        <?php else: ?>    
                                            <a href="javascript:;" onclick="cate_state(<?php echo $vo['id']; ?>);">
                                                <div id="zt<?php echo $vo['id']; ?>"><span class="label label-danger">禁用</span></div>
                                            </a>
                                        <?php endif; ?>   
                                    </td>
                                    <td><?php echo $vo['create_time']; ?></td>
                                    <td><?php echo $vo['update_time']; ?></td>
                                    <td>
                                        <a href="<?php echo url('edit_cate',['id'=>$vo['id']]); ?>" class="btn btn-primary btn-outline btn-xs">
                                            <i class="fa fa-paste"></i> 编辑</a>&nbsp;&nbsp;
                                        <a href="javascript:;" onclick="del_cate(<?php echo $vo['id']; ?>)" class="btn btn-danger btn-outline btn-xs">
                                            <i class="fa fa-trash-o"></i> 删除</a>   
                                    </td>
                                </tr>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </tbody>
                    </table>
                    <div id="AjaxPage" style="text-align:right;"></div>
                    <div style="text-align: right;">
                        共<?php echo $count; ?>条数据，<span id="allpage"></span>
                    </div>
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
  Ajaxpage();
    function Ajaxpage(curr){
        var key=$('#key').val();
        $.getJSON('<?php echo url("product/index_cate"); ?>', {
            page: curr || 1,key:key
        }, function(data){      //data是后台返回过来的JSON数据
            $(".spiner-example").css('display','none'); //数据加载完关闭动画
            if(data==''){
                $("#list-content").html('<td colspan="20" style="padding-top:10px;padding-bottom:10px;font-size:16px;text-align:center">暂无数据</td>');
            }else{
                var tpl = document.getElementById('list-template').innerHTML;
                laytpl(tpl).render(data, function(html){
                    document.getElementById('list-content').innerHTML = html;
                });
                laypage({
                    cont: $('#AjaxPage'),//容器。值支持id名、原生dom对象，jquery对象,
                    pages:'<?php echo $allpage; ?>',//总页数
                    skip: true,//是否开启跳页
                    skin: '#1AB5B7',//分页组件颜色
                    curr: curr || 1,
                    groups: 3,//连续显示分页数
                    jump: function(obj, first){
                        if(!first){
                            Ajaxpage(obj.curr)
                        }
                        $('#allpage').html('第'+ obj.curr +'页，共'+ obj.pages +'页');
                    }
                });
            }
        });
    }
/**
 * [del 删除用户]
 * @Author[田建龙 864491238@qq.com]
 * @param   {[type]}    id [用户id]
 */
function del_cate(id){
    layer.confirm('确认删除此分类?', {icon: 3, title:'提示'}, function(index){
        //do something
        $.getJSON('./del_cate', {'id' : id}, function(res){
            if(res.code == 1){
                layer.msg(res.msg,{icon:1,time:1500,shade: 0.1},function(){
                    window.location.href="<?php echo url('product/index_cate'); ?>";
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