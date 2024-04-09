<html>
<body>
<?php
session_start();
include 'oracle_con.php';

//write down your SQL HERE SQL문 작성
$HOMEUSER_ID = $_POST["HOMEUSER_ID"];
$PHONE_DIAL = $_POST["PHONE_DIAL"];
$USERNAME = $_POST["USERNAME"];
$PASSWORD = $_POST["PASSWORD"];
$PHONE_NUM = $_POST["PHONE_NUM"];
$selectedPFORM = isset($_POST["PFORM"]) ? $_POST["PFORM"][0] : 0;  // 체크하지 않으면 default 값으로 0 즉 구매자 계정으로 생성됨

$sql_pform = " INSERT INTO PERMISSIONS VALUES('".$HOMEUSER_ID."', '".$selectedPFORM."')";
$sql =" INSERT INTO HOMEUSER VALUES('".$HOMEUSER_ID."','".$PHONE_DIAL."','".$USERNAME."', '".$PASSWORD."', '".$PHONE_NUM."')";

//parse & execute SQL
echo "<h1> 신규 회원 입력 결과</h1>";
$ret = oci_execute(oci_parse($connect, $sql));
$ret_permission = oci_execute(oci_parse($connect, $sql_pform));


if($ret && $ret_permission)
    echo "성공<br> <a href='login.php'> <--로그인 화면</a>";
else
    echo "실패!!!!<br> <a href='insert.php'> <--회원가입 화면</a>";

//disconnect & logoff
oci_close($connect);

?>
</body>
</html>

