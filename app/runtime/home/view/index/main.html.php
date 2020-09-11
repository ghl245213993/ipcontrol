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
<div class="je-p10">


    <div class="je-row-ml je-ovh je-boxsiz">
        <div class="je-wlg33 je-wmd33 je-wsm33 je-wmn50 je-fl je-pl10 je-pb10 je-boxsiz">
            <a class="pane-link">
                <div class="je-w40 pane-icon je-bg-blue je-tc">
                    <em class="je-icon je-white" style="font-size:40px;">&#xe602;</em>
                </div>
                <div class="je-w60 je-tc pane-word"><span><?php echo $user_count;?></span><cite>用户数量</cite></div>
            </a>
        </div>
        
        <div class="je-wlg33 je-wmd33 je-wsm33 je-wmn50 je-fl je-pl10 je-pb10 je-boxsiz">
            <a class="pane-link">
                <div class="je-w40 pane-icon je-bg-olive je-tc">
                    <em class="je-icon je-white" style="font-size:40px;">&#xe631;</em>
                </div>
                <div class="je-w60 je-tc pane-word"><span><?php echo $server_count;?></span><cite>服务器数量</cite></div>
            </a>
        </div>
        <div class="je-wlg33 je-wmd33 je-wsm33 je-wmn50 je-fl je-pl10 je-pb10 je-boxsiz">
            <a class="pane-link">
                <div class="je-w40 pane-icon je-bg-green je-tc">
                    <em class="je-icon je-white" style="font-size:40px;">&#xe60e;</em>
                </div>
                <div class="je-w60 je-tc pane-word"><span><?php echo $rules_count;?></span><cite>规则数量</cite></div>
            </a>
        </div>
    </div>
    
    <?php if( $nowversion ){ ?>

    <blockquote class="je-quote green je-f16 je-ovh  je-mb10">
        <p class="je-pb5">
            当前版本：<?php echo $nowversion;?> 最新版本：<?php echo $newversion;?> <?php if( $newversion != $nowversion ){ ?> <a target="_blank" href="https://taolu-soft.github.io/iptables-doc/more/update.html">查看更新文档</a> <button class="je-btn" id="update">在线更新</button><?php } ?>
        </p>
    </blockquote>
    
    <?php } ?>

</div>
<script type="text/javascript">
jeui.use(["jquery","jeTabs","echarts"],function () {

    $('#update').click(function(val){

        var san = parent.jeBox.loading(2,"Loading...");

        $.ajax({
            type: "POST",
            url: "/update",
            timeout: 60000,
            async: true,
            success: function(data, textStatus) {   
                parent.jeBox.close(san)
                if(data.ret == 0)
                    parent.jeBox.alert(data.message);
                else if(data.ret == 1){
                    parent.jeBox.msg('更新成功！');
                    setTimeout(function(){
                        parent.location.reload()
                    },1000);
                }else{
                    parent.jeBox.msg(data);
                }
            }
        });
        
    });
})
  
</script>

</body>
</html>