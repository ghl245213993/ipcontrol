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
            <select class="myselect" id="mySelect">

            	<?php foreach( $list as $v ){ ?>
            		<option value="<?php echo $v['id'];?>" <?php if( $_GET['id']==$v['id'] ){ ?>selected<?php } ?>><?php echo $v['name'];?> - <?php echo $v['server_cname'];?> - <?php echo $v['server_ip'];?> - <?php echo $v['server_port'];?></option>
				<?php } ?>
                <!--<option value="2" selected>服务器2</option>-->
            </select>
            <button class="je-btn je-bg-orange" onclick="location.reload()"><i class="je-icon je-f20">&#xe601;</i></button>
            <button class="je-btn je-bg-blue">已用：<?php echo toGb($traffic_all_used); ?>G</button>
        </p>
    </blockquote>
    <table class="je-table je-mb20" id="newCheck">
        <thead>
        <tr>
            <th width="10%" align="left">ID</th>
            <th width="40%">用户</th>
            <th width="50%">已用流量</th>
        </tr>
        </thead>
        <tbody>
    	<?php foreach( $users as $v ){ ?>
        	<tr>
	            <td><?php echo $v['id'];?></td>
                <td><?php echo $v['username'];?></td>
                <td><?php echo toGb($v['traffic_used']); ?>G</td>
	        </tr>
		<?php } ?>
        
        </tbody>
    </table>
</div>
<script type="text/javascript">

    jeui.use(["jquery","jeBox","jeDate","jeCheck","jeSelect"],function () {
        $(".myselect").jeSelect({
            sosList: false,
            itemfun:function(elem, index, val) {
                console.log(val);
                if(val != undefined){
                    url = "/traffic?id=" + val;
                    window.location.href=url;
                }
            }
        });
    });
</script>
</body>
</html>