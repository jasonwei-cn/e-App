<?php
/*返回指定手机号码对应的订单的列表*/
header('Content-Type: application/json');
$phone= $_REQUEST['phone'];

$conn = mysqli_connect('127.0.0.1','root','','kaifanla');
$sql = 'SET NAMES UTF8';
mysqli_query($conn,  $sql);
$sql = "SELECT oid,addr,user_name,phone,sex,order_time,d.did as did,img_sm  FROM  kf_dish d,kf_order o  WHERE phone=$phone AND o.did = d.did ORDER BY o.order_time DESC";
$result = mysqli_query($conn, $sql);
$orderList = [];
while( true ){
    //从结果集中读取一行记录
    $row = mysqli_fetch_assoc($result);
    if(! $row ){  //没有获取到更多记录行
        break;
    }
    $orderList[] = $row;
}

//把php数组转换为json字符串格式，发送给客户端
$jsonString = json_encode($orderList);
echo $jsonString;
?>
