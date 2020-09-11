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

	<blockquote class="je-quote green je-f16 je-ovh  je-mb10">
        <p class="je-pb5 checkbox">
            <?php echo $message;?>
        </p>
    </blockquote>

    <div style="margin-top: 50px;">
	    <div class="je-form-item">
	        <label class="je-label je-f14">授权码</label>
	        <div class="je-inputbox">
	            <input type="text" id="softcode" autocomplete="off" class="je-input">
	        </div>
	    </div>

	    <div class="je-form-item je-f14">
	        <label class="je-label je-f14"></label>
	        <button class="je-btn je-bg-native je-btn-big je-f18" id="btnIframe">授权</button>
	    </div>
    </div>
        <!--</form>-->
    
</div>

<script type="text/javascript">
    
jeui.use(["jquery","jeBox","jeCheck","jeSelect"],function () {
    
    var index = parent.jeBox.frameIndex(window.name);
    $('#btnIframe').click(function(val){

        var softcode = document.getElementById("softcode").value;

        $.ajax({
            type: "POST",
            url: "/softauth_ajax",
            timeout: 60000,
            async: true,
            data: {
                "softcode": softcode
            },
            success: function(data, textStatus) {   
    			console.log(data);
                
                if(data.ret != 1)
                    jeBox.alert(data.message);
                else{
                    parent.jeBox.msg('授权成功。');
                    setTimeout(function(){
                    	location.href="/";
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