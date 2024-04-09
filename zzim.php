<?php
// addToWishlist 함수를 호출할 때 전달된 INFOHOME_NUM 값 가져오기
include 'oracle_con.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $home_id_to_add = $_POST['INFOHOME_NUM']; 

    // 현재 로그인한 사용자의 USER_ID 가져오기 
    session_start();
    $user_id = $_SESSION['HOMEUSER_ID']; 

    // 찜 테이블에 추가하는 SQL 실행
    $sql_add_to_wishlist = "INSERT INTO ZZIM (ZZIMUSER_ID, ZZIMHOME_ID) VALUES (:USER_ID, :HOME_NUM)";
    $stmt_add_to_wishlist = oci_parse($connect, $sql_add_to_wishlist);
    
    // 바인딩
    oci_bind_by_name($stmt_add_to_wishlist, ':USER_ID', $user_id);
    oci_bind_by_name($stmt_add_to_wishlist, ':HOME_NUM', $home_id_to_add);

    // 실행
    oci_execute($stmt_add_to_wishlist);
    oci_free_statement($stmt_add_to_wishlist);
    oci_close($connect);

    // 데이터베이스 처리 후 main.php로 리다이렉션
    header('Location: main.php');
    exit(); // 리다이렉션 후 스크립트 종료
}
?>