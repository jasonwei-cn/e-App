<?php
/*返回菜品的列表*/
header('Content-Type: application/json');
@$start = $_REQUEST['start'];  //@符号可以压制当前行产生的错误提示
if( empty($start) ){  //若$start变量为空（即客户端未提交该变量）
    $start = 0;     //若客户端未提交其实行号则从第0行开始读取记录
}
$pageSize = 5;  //一次可以向客户端返回的最大的记录数
$dishList = []; //即将要输出给客户端的菜品列表

$conn = mysqli_connect('127.0.0.1','root','','kaifanla');
$sql = 'SET NAMES UTF8';
mysqli_query($conn,  $sql);
$sql = "SELECT did,name,price,img_sm,material  FROM  kf_dish  LIMIT  $start,$pageSize";
$result = mysqli_query($conn, $sql);
while( true ){
    //从结果集中读取一行记录
    $row = mysqli_fetch_assoc($result);
    if(! $row ){  //没有获取到更多记录行
        break;
    }
    $dishList[] = $row;
}

//把php数组转换为json字符串格式，发送给客户端
$jsonString = json_encode($dishList);
echo $jsonString;
?>
