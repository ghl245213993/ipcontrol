<?php if (!defined('POEM_PATH')) exit();?><?php if (!defined('POEM_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>IP盾构机</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="wcodeth=device-wcodeth, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/themes/jeui/css/jeui.css"  media="all">
    <link rel="stylesheet" href="/themes/jeui/css/admin.css"  media="all">
    <link href="/themes/jeui/css/skin/jebox.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="/themes/jeui/css/gload.css"  media="all">
    <script type="text/javascript" src="/themes/jeui/js/modules/jeui.js"></script>
    
    <link rel="stylesheet" href="/themes/jeui/css/skin/jedate.css"  media="all">
</head>
<body>
<div jepane="top" class="je-admin-top">
    <div class="je-admin-logo je-tc je-fl je-white" title="IP盾机构"></div>
    <div class="shrink je-fl je-white je-icon je-f28 je-mr10">&#xe626;</div>
    
    <div class="je-admin-user je-fr">
        <a href="/logout"><div class="usertext je-pl8 je-fl je-f14 je-pr30">退出登陆</div></a>
    </div>
</div>
<div jepane="left" class="je-admin-left">
    <ul class="je-admin-menu">

        <li class="level">
            <h3><em class="ico"></em>规则管理<i></i></h3>
            <ul class="levelnext">
                <!--<li><a href="javascript:;" data-tab="p2" data-text="服务器列表" data-url="servers.html" addtab>服务器列表</a></li>-->
                
                <li><a href="javascript:;" data-tab="p3" data-text="iptables转发" data-url="iptables/rules.html" addtab>iptables转发</a></li>
                <li><a href="javascript:;" data-tab="p4" data-text="Brook转发" data-url="brook/rules.html" addtab>Brook转发</a></li>
                <li><a href="javascript:;" data-tab="p5" data-text="Gost隧道转发" data-url="gost/rules.html" addtab>Gost隧道转发</a></li>
            </ul>
        </li>
        
    <?php if( $user['admin'] == 1 ){ ?>
        <li class="level">
            <h3><em class="ico"></em>管理员设置<i></i></h3>
            <ul class="levelnext">
                <li><a href="javascript:;" data-tab="p6" data-text="流量统计" data-url="traffic.html" addtab>流量统计</a></li>
                <li><a href="javascript:;" data-tab="user_list" data-text="用户列表" data-url="admin_user.html" addtab>用户列表</a></li>
                <li><a href="javascript:;" data-tab="server_list" data-text="服务器列表" data-url="admin_server.html" addtab>服务器列表</a></li>
                <li><a href="javascript:;" data-tab="server_list_gost" data-text="落地服务器列表" data-url="admin_server_gost.html" addtab>落地服务器列表</a></li>
                <li><a href="javascript:;" data-tab="rules_log" data-text="系统日志" data-url="logs.html" addtab>系统日志</a></li>
                <!--<li><a href="javascript:;" data-tab="config" data-text="系统设置" data-url="system/config" addtab>系统设置</a></li>-->
            </ul>
        </li>
    <?php } ?>

    </ul>

</div>
<div jepane="center" class="je-admin-center" tabpane>

</div>
<?php if (!defined('POEM_PATH')) exit();?><div jepane="right" class="je-admin-right">right</div>
<div jepane="bottom" class="je-admin-bottom"><p>2020 © Lofter MIT license</p></div>

<script type="text/javascript">
    jeui.use(["jquery","jeBox","jeLayout","jeTabPane","jeAccordion"],function () {
        //Layout面板布局
        $("body").jeLayout();
        $("#myTabNav").find("li").on("click",function () {
            $(this).addClass('curr').siblings().removeClass('curr');
        });
        //折叠菜单
        $(".je-admin-menu").jeAccordion({
            accIndex: 0,
            titCell:"h3",
            conCell:"ul", 
            multiple:false,
            success:function (titelem, conelem) {
                //给菜单绑定事件
                conelem.children().on("click",function(){
                    conelem.children().removeClass("current");
                    $(this).addClass("current");
                });
            }
        });
        //addtabs
        $("[tabpane]").jeTabPane({
            firstItem:{                              //默认首页
                tab: "main",
                text: "后台首页",
                url: "main.html",
                closable:false
            }
        });
    });
</script>
</body>
</html>