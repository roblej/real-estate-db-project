<?php
session_start();

// Oracle 연결 정보
include 'oracle_con.php';

// 사용자가 입력한 ID와 비밀번호
$HOMEUSER_ID = $_POST['HOMEUSER_ID'];
$PASSWORD = $_POST['PASSWORD'];

// 데이터베이스에서 사용자 정보를 조회
$sql = "SELECT * FROM HOMEUSER WHERE HOMEUSER_ID = :HOMEUSER_ID AND PASSWORD = :PASSWORD";
$stid = oci_parse($connect, $sql);

oci_bind_by_name($stid, ':HOMEUSER_ID', $HOMEUSER_ID);
oci_bind_by_name($stid, ':PASSWORD', $PASSWORD);

oci_execute($stid);

// 조회 결과 확인
if ($row = oci_fetch_assoc($stid)) {
    // 로그인 성공
    $_SESSION['HOMEUSER_ID'] = $row['HOMEUSER_ID'];
    header('Location: main.php'); // 로그인 성공 시 이동할 페이지
} else {
    // 로그인 실패
    header('Location: login.php?error=1'); // 로그인 실패 시 이동할 페이지 및 오류 메시지 전달
}

oci_free_statement($stid);
oci_close($conn);
?>