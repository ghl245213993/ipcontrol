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
            <button class="je-btn" id="addart"><i class="je-icon je-f20">&#xe66e;</i> 添加服务器</button>
            <button class="je-btn je-bg-red" onclick="getTheCheckBoxValue()"><i class="je-icon je-f20">&#xe63e;</i> 批量删除</button>
            <button class="je-btn je-bg-orange" onclick="location.reload()"><i class="je-icon je-f20">&#xe601;</i></button>
        </p>
    </blockquote>
    <table class="je-table je-mb20" id="newCheck">
        <thead>
        <tr>
            <th width="5%"><input type="checkbox" name="checkbox" id="gocheck" jename="chunk"></th>
            <th width="5%" align="left">ID</th>
            <th width="8%">名称</th>
            <th width="8%">CNAME</th>
            <th width="10%">IP</th>
            <th width="10%">网卡IP</th>
            <th width="9%">Key</th>
            <th width="4%">网卡名</th>
            <th width="4%">带宽</th>
            <th width="15%">备注</th>
            <th width="22%">操作</th>
        </tr>
        </thead>
        <tbody>
    	<?php foreach( $server_list as $v ){ ?>
        	<tr>
	            <td align="center"><input type="checkbox" name="checkbox" jename="chunk" value="<?php echo $v['id'];?>"></td>
	            <td><?php echo $v['id'];?></td>
	            <td><?php echo $v['name'];?></td>
                <td><?php echo $v['server_cname'];?></td>
                <td><?php echo $v['server_ip'];?></td>
                <td><?php echo $v['server_in_ip'];?></td>
                <td><?php echo $v['server_key'];?></td>
                <td><?php echo $v['eth'];?></td>
                <td><?php echo $v['speed'];?></td>
                <td><?php echo $v['remark'];?></td>
	            <td align="center">
                    <input type="checkbox" name="dynamic_enable" value="<?php echo $v['id'];?>" jename="switch" small jetext="动态IP,静态IP" <?php if( $v['dynamic_enable'] ){ ?>checked<?php } ?>>
                    <input type="checkbox" name="check_mode" value="<?php echo $v['id'];?>" jename="switch" small jetext="宽松模式,严格模式" <?php if( $v['check_mode'] == 1 ){ ?>checked<?php } ?>>
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
                            url: "serverdelete",
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

        url = 'editserver?id='+id;
        jeBox.open({
            type: 'iframe',
            boxSize: ['70%', '82%'],
            maxBtn: true,
            scrollbar: false,
            content: url
        });

    }

    jeui.use(["jquery","jeBox","jeDate","jeCheck","jeSelect"],function () {

        $("#newCheck").jeCheck({
            jename:"switch",
            itemfun:function(elem){
                console.log(elem);
                console.log(elem[0].value);
                console.log(elem[0].name);
                console.log(elem[0].checked);

                var id = elem[0].value, v = elem[0].checked?1:0, name = elem[0].name;
                $.ajax({
                    type: "POST",
                    url: "enableajax",
                    timeout: 60000,
                    async: true,
                    data: {
                        "id": id,
                        "type": name,
                        "value": v
                    },
                    success: function(data, textStatus) {   
                        console.log(data);
                        if(data.ret == 0){
                            jeBox.alert(data.message);
                            setTimeout(function(){
                                    location.reload()
                            },1000);
                        }else{
                            jeBox.msg('操作成功。');
                        }
                    }
                });

            }
        });

        $("#check_mode").jeCheck({
            jename:"switch",
            itemfun:function(elem){
                console.log(elem);
                console.log(elem[0].value);
                console.log(elem[0].checked);

            //     var id = elem[0].value, dynamic_enable = elem[0].checked?1:0;
            //     $.ajax({
            //         type: "POST",
            //         url: "enableajax",
            //         timeout: 60000,
            //         async: true,
            //         data: {
            //             "id": id,
            //             "dynamic_enable": dynamic_enable
            //         },
            //         success: function(data, textStatus) {   
            //             console.log(data);
            //             if(data.ret == 0){
            //                 jeBox.alert(data.message);
            //                 setTimeout(function(){
            //                         location.reload()
            //                 },1000);
            //             }else{
            //                 jeBox.msg('操作成功。');
            //             }
            //         }
            //     });

            }
        });

        $("#addart").on("click",function(){
            jeBox.open({
                type: 'iframe',
                boxSize: ['70%', '82%'],
                maxBtn: true,
                scrollbar: false,
                content: 'addserver'
            });
        })
        $(".checkbox").jeCheck();
        $(".checkbox").jeCheck({jename:"radio"});
        $(".checkbox").jeCheck({jename:"switch"});
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
    });
</script>
</body>
</html>