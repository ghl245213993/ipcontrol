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
            <button class="je-btn" id="addart"><i class="je-icon je-f20">&#xe66e;</i> 添加iptables转发</button>
            <button class="je-btn je-bg-red" onclick="getTheCheckBoxValue()"><i class="je-icon je-f20">&#xe63e;</i> 批量删除</button>
            <button class="je-btn je-bg-orange" onclick="location.reload()"><i class="je-icon je-f20">&#xe601;</i></button>
            <a id="switchself">
            <input  type="checkbox" value="1" jename="switch" jetext="自己,全部" <?php if($_GET['self_add']){ ?>checked <?php } ?>></a>
            <button class="je-btn je-bg-blue">已用：<?php echo toGb($traffic_all_used); ?>G</button>
            <input class="je-input" value="KEY: <?php echo $server_key;?>"> 
        </p>
    </blockquote>
    <table class="je-table je-mb20" id="newCheck">
        <thead>
        <tr>
            <th width="5%"><input type="checkbox" name="checkbox" id="gocheck" jename="chunk"></th>
            <th width="5%" align="left">ID</th>
            <th width="5%">本地端口</th>
            <th width="5%">远程端口</th>
            <th width="10%">远程DDNS</th>
            <th width="8%">远程IP</th>
            <th width="8%">本地IP</th>
            <th width="4%">限速</th>
            <th width="10%">流量/重置日</th>
            <th width="20%">备注</th>
            <th width="20%">操作</th>
        </tr>
        </thead>
        <tbody>
    	<?php foreach( $rule_list as $v ){ ?>
        	<tr>
	            <td align="center"><input type="checkbox" name="checkbox" jename="chunk" value="<?php echo $v['id'];?>"></td>
	            <td><?php echo $v['id'];?></td>
	            <td><?php echo $v['local_port'];?></td>
	            <td><?php echo $v['remote_port'];?></td>
	            <td><?php echo $v['remote_cname'];?></td>
	            <td><?php echo $v['remote_ip'];?></td>
                <td><?php echo $v['local_ip'];?></td>
                <td><?php if( $v['limit_speed'] != 0 ){ ?><?php echo $v['limit_speed'];?><?php }else{ ?>无限<?php } ?></td>
                <td><?php if( $v['reset_day'] != 0 ){ ?><?php echo toGb($v['traffic_used']); ?>G/<?php if( $v['traffic_all'] != 0 ){ ?><?php echo toGb($v['traffic_all']); ?>G<?php }else{ ?>无限<?php } ?>/<?php } ?><?php echo getResetday($v['reset_day']); ?></td>
                <td><?php echo $v['remark'];?></td>
	            <td align="center">
                    <input type="checkbox" name="checkboxswitch" jename="switch" small disabled jetext="已生效,<?php if( $v['status'] == 2 ){ ?>已挂起<?php }else{ ?>未生效<?php } ?>" <?php if( $v['status'] == 1 ){ ?>checked<?php } ?>>
                    <input type="checkbox" name="enable" value="<?php echo $v['id'];?>" jename="switch" small jetext="启用,暂停" <?php if( $v['enable'] ){ ?>checked<?php } ?>>
	                <button class="je-btn je-btn-mini je-f12" onclick="edit('<?php echo $v['id'];?>')">编辑</button>
	            </td>
	        </tr>
		<?php } ?>
        
        </tbody>
    </table>
</div>
<script type="text/javascript">

	function getTheCheckBoxValue(){

        parent.jeBox.msg('是否删除？', {
            time: 0 ,
            button: [ 
                {
                    name: '删除',
                    callback:function(index){
                        jeBox.close(index);
                        var test = $("input[name='checkbox']:checked");
                        var checkBoxValue = ""; 
                        test.each(function(){
                            checkBoxValue += $(this).val()+",";
                        })
                        checkBoxValue = checkBoxValue.substring(0,checkBoxValue.length-1);
                        console.log(checkBoxValue);

                        $.ajax({
                            type: "POST",
                            url: "/iptables/rulesdelete",
                            timeout: 60000,
                            async: true,
                            data: {
                                "data":checkBoxValue
                            },
                            success: function(data, textStatus) {  
                                console.log(data); 
                                if(data.ret == 0)
                                    parent.jeBox.alert(data.message);
                                else if(data.ret == 1){
                                    parent.jeBox.msg('删除成功。');
                                    setTimeout(function(){
                                        location.reload()
                                    },1000);
                                }
                            }
                        });

                    }
                },{
                    name: '取消'
                }
            ]
        });

        

    }

    function edit(id){

        url = '/iptables/editrules?rule='+id+'&id=<?php echo $server_id;?>';
        jeBox.open({
            type: 'iframe',
            boxSize: ['70%', '90%'],
            maxBtn: true,
            scrollbar: false,
            content: url
        });

    }

    jeui.use(["jquery","jeBox","jeDate","jeCheck","jeSelect"],function () {

        $("#addart").on("click",function(){
            jeBox.open({
                type: 'iframe',
                boxSize: ['70%', '90%'],
                maxBtn: true,
                scrollbar: false,
                content: '/iptables/addrules?id=<?php echo $server_id;?>'
            });
        })
        $(".myselect").jeSelect({
        	sosList: false,
        	itemfun:function(elem, index, val) {
        		console.log(val);
                if(val != undefined){
            		url = "/iptables/rules?id=" + val;
            		window.location.href=url;
                }
        	}
        });

        $("#newCheck").jeCheck({
            jename:"chunk",
            attrName:[false,"勾选"], 
            itemfun: function(elem,bool) {
            	console.log(elem)
                console.log(bool)
                console.log(elem.prop('checked'))
            },
            success:function(elem){
                jeui.chunkSelect(elem,'#gocheck','on')
                
            }
        });

        $("#switchself").jeCheck({
            jename:"switch",
            itemfun:function(elem){
                console.log(elem);
                console.log(elem[0].value);
                console.log(elem[0].checked);

                var is_self = elem[0].checked?1:0;

                var url = "/iptables/rules?id=<?php echo $_GET['id']; ?>&self_add=" + is_self;
                window.location.href=url;

            }
        });

        $("#newCheck").jeCheck({
            jename:"switch",
            itemfun:function(elem){
                console.log(elem);
                console.log(elem[0].value);
                console.log(elem[0].checked);

                var id = elem[0].value, enable = elem[0].checked?1:0;
                $.ajax({
                    type: "POST",
                    url: "/iptables/enableajax",
                    timeout: 60000,
                    async: true,
                    data: {
                        "id": id,
                        "enable": enable
                    },
                    success: function(data, textStatus) {   
                        console.log(data);
                        if(data.ret == 0){
                            jeBox.alert(data.message);
                            setTimeout(function(){
                                    location.reload()
                            },1000);
                        }else if(data.ret == 1){
                            jeBox.msg('操作成功。');
                        }else{
                            jeBox.msg(data);
                        }
                    }
                });

            }
        });
    });
</script>
</body>
</html>