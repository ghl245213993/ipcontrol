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
                <label class="je-label je-f14">名称</label>
                <div class="je-inputbox">
                    <input type="text" id="name" autocomplete="off" value="<?php echo $server['name'];?>" class="je-input">
                </div>
            </div>

            <div class="je-form-item">
                <label class="je-label je-f14">CNAME</label>
                <div class="je-inputbox">
                    <input type="text" id="server_cname" autocomplete="off" value="<?php echo $server['server_cname'];?>" class="je-input">
                </div>
            </div>

            <div class="je-form-item">
                <label class="je-label je-f14">IP</label>
                <div class="je-inputbox">
                    <input type="text" id="server_ip" autocomplete="off" value="<?php echo $server['server_ip'];?>" class="je-input">
                </div>
            </div>

            <div class="je-form-item">
                <label class="je-label je-f14">网卡IP</label>
                <div class="je-inputbox">
                    <input type="text" id="server_in_ip" autocomplete="off" value="<?php echo $server['server_in_ip'];?>" class="je-input">
                </div>
            </div>

            <div class="je-form-item">
                <label class="je-label je-f14">网卡</label>
                <div class="je-inputbox">
                    <input type="text" id="eth" autocomplete="off" value="<?php echo $server['eth'];?>" class="je-input">
                </div>
            </div>

            <div class="je-form-item">
                <label class="je-label je-f14">总带宽</label>
                <div class="je-inputbox">
                    <input type="text" id="speed" autocomplete="off" value="<?php echo $server['speed'];?>" class="je-input">
                </div>
            </div>

            <div class="je-form-item">
                <label class="je-label je-f14">备注</label>
                <div class="je-inputbox">
                    <input type="text" id="remark" autocomplete="off" value="<?php echo $server['remark'];?>" class="je-input">
                </div>
            </div>


            <div class="je-form-item je-f14">
                <label class="je-label je-f14"></label>
                <button class="je-btn" id="btnIframe">更改</button>
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

        var name = document.getElementById("name").value;
        var server_cname = document.getElementById("server_cname").value;
        var server_ip = document.getElementById("server_ip").value;
        var remark = document.getElementById("remark").value;

        var server_in_ip = document.getElementById("server_in_ip").value;
        var speed = document.getElementById("speed").value;
        var eth = document.getElementById("eth").value;

        var id = "<?php echo $_GET['id'];?>";
        $.ajax({
            type: "POST",
            url: "editserverajax",
            timeout: 60000,
            async: true,
            data: {
                "name": name,
                "server_cname": server_cname,
                "server_ip": server_ip,
                "remark": remark,
                "id": id,
                "server_in_ip": server_in_ip,
                "speed": speed,
                "eth": eth
            },
            success: function(data, textStatus) {   
    			console.log(data);
                if(data.ret == 0)
                    jeBox.alert(data.message);
                else if(data.ret == 1){
                    parent.jeBox.msg('更改成功。');
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
<!--
http://www.qdfuns.com/notes/13967/3cdebc6a132f33a3e65aa2b6019a7487.html
http://www.jq22.com/demo/jQueryNavHover20161129/
-->
</body>
</html>