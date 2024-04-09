<?php
session_start();
include 'oracle_con.php';

// 현재 로그인된 사용자의 아이디를 가져옴
$user_id = $_SESSION['HOMEUSER_ID'];

// 사용자 권한을 확인하는 쿼리
$query_permission = "SELECT PFORM FROM PERMISSIONS WHERE PUSERID = :USER_ID";
$stmt_permission = oci_parse($connect, $query_permission);
oci_bind_by_name($stmt_permission, ':USER_ID', $user_id);
oci_execute($stmt_permission);

$row_permission = oci_fetch_assoc($stmt_permission);
$permission = $row_permission['PFORM'];

// 등록하기 화면의 표시 여부 결정
$show_register = ($permission == 0) ? true : false;

oci_free_statement($stmt_permission);
?>