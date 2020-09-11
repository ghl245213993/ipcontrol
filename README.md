# ipcontrol


伪静态：

location /{     
    if (!-e $request_filename) {       
        rewrite ^/(.*)$ /index.php/$1 last;       
        break;     
    }    
}


替换授权文件目录：
/app/home/controller/softauth.php
