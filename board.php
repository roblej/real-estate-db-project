<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시판</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <style>
    </style>
</head>
<body>
    <h2>매물 등록</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        주소: <input type="text" name="ADDRESS" required><br>
        주택형태(아파트/빌라/주택): <input type="text" name="HOMEFORM" required><br>
        조건(전세/월세/매매): <input type="text" name="CONDITION" required><br>
        가격: <input type="text" name="HOMEPRICE" required><br>
        평수: <input type="text" name="HOMESIZE" required><br>
        방 개수: <input type="text" name="ROOM" required><br>
        <input type="submit" name="submit_add" value="등록">
    </form>
    <!--
    <h2>매물 수정</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        매물 ID: <input type="text" name="edit_property_id" required><br>
        주소: <input type="text" name="edit_address" required><br>
        가격: <input type="text" name="edit_price" required><br>
        설명: <textarea name="edit_description" required></textarea><br>
        <input type="submit" name="submit_edit" value="수정">
    </form>
    
    <h2>매물 삭제</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        매물 ID: <input type="text" name="delete_property_id" required><br>
        <input type="submit" name="submit_delete" value="삭제">
    </form>
    -->
</body>
<?php
session_start();
// 매물 등록 처리
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_add'])) {
    $user_id = $_SESSION['HOMEUSER_ID'];
    $address = $_POST["ADDRESS"];
    $homeform = $_POST["HOMEFORM"];
    $condition = $_POST["CONDITION"];
    $price = $_POST["HOMEPRICE"];
    $homesize = $_POST["HOMESIZE"];
    $room = $_POST["ROOM"];

    $home_sql = " INSERT INTO HOME (HOME_NUM, ADDRESS, USER_ID) VALUES (HOME_SEQ.NEXTVAL, :ADDRESS, :USER_ID)";
    $homeinfo_sql = " INSERT INTO INFOHOME (INFOHOME_NUM, HOMEFORM, CONDITION, HOMEPRICE, HOMESIZE, ROOM) 
    VALUES (INFOHOME_SEQ.NEXTVAL, :HOMEFORM, :CONDITION, :HOMEPRICE, :HOMESIZE, :ROOM)";

    include 'oracle_con.php';
    $stid_home = oci_parse($connect, $home_sql);
    // 바인딩 후 SQL문 실행
    oci_bind_by_name($stid_home, ':ADDRESS', $address);
    oci_bind_by_name($stid_home, ':USER_ID', $user_id);

    if (oci_execute($stid_home)) {
        echo "HOME 테이블에 데이터 삽입 성공<br>";
        oci_free_statement($stid_home);
    } else {
        $error = oci_error($stid_home);
        echo "HOME 테이블에 데이터 삽입 실패: " . $error['message'] . "<br>";
        oci_free_statement($stid_home);
    }

    // INFOHOME 테이블에 데이터 삽입
    $stid_homeinfo = oci_parse($connect, $homeinfo_sql);
    oci_bind_by_name($stid_homeinfo, ':HOMEFORM', $homeform);
    oci_bind_by_name($stid_homeinfo, ':CONDITION', $condition);
    oci_bind_by_name($stid_homeinfo, ':HOMEPRICE', $price);
    oci_bind_by_name($stid_homeinfo, ':HOMESIZE', $homesize);
    oci_bind_by_name($stid_homeinfo, ':ROOM', $room);

    if (oci_execute($stid_homeinfo)) {
        echo "INFOHOME 테이블에 데이터 삽입 성공<br>";
        oci_free_statement($stid_homeinfo);
        oci_close($connect);
        header("Location: main.php");
        exit();
    } else {
        $error = oci_error($stid_homeinfo);
        echo "INFOHOME 테이블에 데이터 삽입 실패: " . $error['message'] . "<br>";
    }
}
/*
// 매물 수정 처리
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_edit'])) {
    $property_id = $_POST["edit_property_id"];
    $address = $_POST["edit_address"];
    $price = $_POST["edit_price"];
    $description = $_POST["edit_description"];

    $sql = "UPDATE properties SET address='$address', price='$price', description='$description' WHERE id=$property_id";

    if ($conn->query($sql) === TRUE) {
        echo "매물이 성공적으로 수정되었습니다.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// 매물 삭제 처리
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_delete'])) {
    $property_id = $_POST["delete_property_id"];

    $sql = "DELETE FROM properties WHERE id=$property_id";

    if ($conn->query($sql) === TRUE) {
        echo "매물이 성공적으로 삭제되었습니다.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// 게시판 목록 조회

$sql = "SELECT * FROM properties";
$result = $conn->query($sql);
*/
?>
</html>

