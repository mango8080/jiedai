
    /* 
     格式化错误的json数据，使其能被json_decode()解析 
     不支持健名有中文、引号、花括号、冒号 
     不支持健指有冒号 
    */  
    function format_ErrorJson($data,$quotes_key=false)  
    {  
        $con = str_replace('\'','"',$data);//替换单引号为双引号 
        $con = str_replace(array('\\"'),array('<|YH|>'),$con);//替换 
        $con = preg_replace('/(\w+):[ {]?((?<YinHao>"?).*?\k<YinHao>[,}]?)/is', '"$1": $2',$con );//若键名没有双引号则添加  
        if($quotes_key)  
        {  
            $con = preg_replace('/("\w+"): ?([^"\s]+)([,}])[\s]?/is', '$1: "$2"$3',$con );//给键值添加双引号 
        } 
        $con = str_replace(array('<|YH|>'),array('\\"'),$con);//还原替换  
        return $con;  
    }  
function htmlEncode(str) {  str = str.replace(/\s+/ig, '');  str = str.replace(/&/g, '');  str = str.replace(/</g, '');  str = str.replace(/>/g, '');  str = str.replace(/(?:t| |v|r)*n/g, '<br />');  str = str.replace(/t/g, '    ');  str = str.replace(/x22/g, '"');  str = str.replace(/x27/g, ''');  str = str.replace(/"/g, "");  return str; }