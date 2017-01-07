<?php
/*根据ID号查询一个菜品信息*/
header('Content-Type: application/json');
@$id = $_REQUEST['id'];
if(empty($id)){
    echo '{"errno":101, "errmsg":"未提供菜品ID，无法查询"}';
    return;
}

$conn = mysqli_connect('127.0.0.1','root','','kaifanla');
$sql = 'SET NAMES UTF8';
mysqli_query($conn,  $sql);
$sql = "SELECT did,name,price,img_lg,material,detail FROM  kf_dish WHERE did=$id";
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);  //此处无需循环
if($row){ //根据指定的id查询到菜品
    echo json_encode( $row );
}else{  //根据指定的id未查询到菜品
    echo '{"errno":102, "errmsg":"指定的菜品ID不存在"}';
}
?>
