<?php
/*添加订单*/
header('Content-Type: application/json');
$user_name = $_REQUEST['user_name'];
$sex = $_REQUEST['sex'];
$phone = $_REQUEST['phone'];
$addr = $_REQUEST['addr'];
$did = $_REQUEST['did'];
$order_time = time()*1000;


$conn = mysqli_connect('127.0.0.1','root','','kaifanla');
$sql = 'SET NAMES UTF8';
mysqli_query($conn,  $sql);
$sql = "INSERT INTO kf_order(oid, phone,user_name,sex,order_time,addr,did) VALUES(NULL,'$phone','$user_name',$sex,$order_time,'$addr',$did)";
$result = mysqli_query($conn, $sql);

if($result){
    $output = ['result'=>200, 'oid'=>mysqli_insert_id($conn)];
}else {
    $output = ['result'=>500];
}
echo json_encode($output);
?>
