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
<div class="je-p20">

        <!--<form id="itemcheac">-->
            <div class="je-form-item">
                <label class="je-label je-f14">本地端口</label>
                <div class="je-inputbox">
                    <input type="text" id="local_port" autocomplete="off" placeholder="本地监听端口" class="je-input">
                </div>
            </div>

            <div class="je-form-item">
                <label class="je-label je-f14">监听端口</label>
                <div class="je-inputbox">
                    <input type="text" id="listen_port" autocomplete="off" placeholder="远程GOST监听端口" class="je-input">
                </div>
            </div>

            <div class="je-form-item">
                <label class="je-label je-f14">远程端口</label>
                <div class="je-inputbox">
                    <input type="text" id="to_port" autocomplete="off" placeholder="远程服务的启动端口" class="je-input">
                </div>
            </div>

            <div class="je-form-item">
                <label class="je-label je-f14">远程DDNS</label>
                <div class="je-inputbox">
                    <input type="text" id="remote_cname" autocomplete="off" placeholder="远程DDNS，不输入为转发至本地" class="je-input">
                </div>
            </div>

            <div class="je-form-item">
                <label class="je-label je-f14">远程IP</label>
                <div class="je-inputbox">
                    <input type="text" id="remote_ip" autocomplete="off" placeholder="远程服务的IP(不填写默认监听本地服务)，不输入为转发至本地" class="je-input">
                </div>
            </div>

            <div class="je-form-item">
                <label class="je-label je-f14">隧道类型</label>
                <div class="je-inputbox">
                    <select class="myselect" id="type">
                        <option value="tls">tls</option>
                        <option value="wss">wss</option>
                        <option value="ws">ws</option>
                        <option value="ssh">ssh</option>
                        <option value="gost_relay">gost_relay</option>
                        <option value="kcp">kcp</option>
                        <option value="quic">quic</option>
                    </select>
                </div>
            </div>

            <div class="je-form-item">
                <label class="je-label je-f14">后端服务器</label>
                <div class="je-inputbox">
                    <select class="myselect" id="gost_server_id">
                        <?php foreach( $lists as $v ){ ?>
                            <option value="<?php echo $v['id'];?>"><?php echo $v['name'];?> - <?php echo $v['remark'];?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="je-form-item">
                <label class="je-label je-f14">限速</label>
                <div class="je-inputbox">
                    <input <?php if( $user['admin']==-1 ){ ?>disabled<?php } ?> type="text" id="limit_speed" autocomplete="off" placeholder="0为不限速，默认为0。" class="je-input">
                </div>
            </div>

            <div class="je-form-item">
                <label class="je-label je-f14">流量</label>
                <div class="je-inputbox">
                    <input <?php if( $user['admin']==-1 ){ ?>disabled<?php } ?> type="text" id="traffic_all" autocomplete="off" placeholder="0为不限制流量，默认为0。" class="je-input">
                </div>
            </div>

            <div class="je-form-item">
                <label class="je-label je-f14">流量重置日</label>
                <div class="je-inputbox">
                    <input <?php if( $user['admin']==-1 ){ ?>disabled<?php } ?> type="text" id="reset_day" autocomplete="off" placeholder="0为不统计流量，默认为1" class="je-input">
                </div>
            </div>


            <div class="je-form-item">
                <label class="je-label je-f14">备注</label>
                <div class="je-inputbox">
                    <input type="text" id="remark" autocomplete="off" placeholder="请输入" class="je-input">
                </div>
            </div>

            <div class="je-form-item">
                <label class="je-label je-f14">指定用户</label>
                <div class="je-inputbox">
                    <select class="myselect" id="user_id">
                        <option value="not" selected>自己</option>
                        <?php foreach( $users as $v ){ ?>
                            <option value="<?php echo $v['id'];?>"><?php echo $v['username'];?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="je-form-item je-f14">
                <label class="je-label je-f14"></label>
                <button class="je-btn" id="btnIframe">添加</button>
                <button class="je-btn je-bg-native">重置</button>
            </div>
        <!--</form>-->
    
</div>

<script type="text/javascript">
    
jeui.use(["jquery","jeBox","jeCheck","jeSelect"],function () {
    
    $(".checkbox").jeCheck();
    $(".radio").jeCheck({jename:"radio"});
    $(".switch").jeCheck({jename:"switch"});
    $(".myselect").jeSelect({
        sosList: false
    });
    var index = parent.jeBox.frameIndex(window.name);
    $('#btnIframe').click(function(val){

        var local_port = document.getElementById("local_port").value;
        var listen_port = document.getElementById("listen_port").value;
        var to_port = document.getElementById("to_port").value;
        var gost_server_id = document.getElementById("gost_server_id").value;
        var remark = document.getElementById("remark").value;
        var limit_speed = document.getElementById("limit_speed").value;
        var type = document.getElementById("type").value;
        var user_id = document.getElementById("user_id").value;
        var traffic_all = document.getElementById("traffic_all").value;
        var reset_day = document.getElementById("reset_day").value;
        var remote_cname = document.getElementById("remote_cname").value;
        var remote_ip = document.getElementById("remote_ip").value;
        var id = "<?php echo $_GET['id'];?>";
        $.ajax({
            type: "POST",
            url: "/gost/rulesajax",
            timeout: 60000,
            async: true,
            data: {
                "local_port": local_port,
                "listen_port": listen_port,
                "to_port": to_port,
                "gost_server_id": gost_server_id,
                "remark": remark,
                "id": id,
                "limit_speed": limit_speed,
                "type": type,
                "reset_day": reset_day,
                "traffic_all": traffic_all,
                "user_id": user_id,
                "remote_ip": remote_ip,
                "remote_cname": remote_cname
            },
            success: function(data, textStatus) {   
    			console.log(data);
                if(data.ret == 0)
                    jeBox.alert(data.message);
                else{
                    parent.jeBox.msg('添加成功。');
                    setTimeout(function(){
                    	parent.location.reload()
                    },1000);
                }
            }
        });
        
    });
 })
    
</script>
<!--
http://www.qdfuns.com/notes/13967/3cdebc6a132f33a3e65aa2b6019a7487.html
http://www.jq22.com/demo/jQueryNavHover20161129/
-->
</body>
</html>