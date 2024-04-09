<!DOCTYPE html>
<html lang="ko">
<head>
    <link rel="stylesheet" href="mainstyle.css">
</head>
<body>
    <div class="wrap">
        <div class="intro_bg">
            <div class="header">
                <div class="top"></div>
                <ul class="nav">
                    <li><a href="mypage.php">마이페이지</a></li>
                    <li><a href="login.php">로그아웃</a></li>
                </ul>
            </div>
        </div>
        <?php
        // permission_check.php 파일 불러오기
        include 'permission_check.php';
        ?>
        <!-- 구매자로 로그인하면 등록하기 화면 띄우지 않음 -->
        <div class="register" <?php if ($show_register) echo 'style="display:none;"'; ?>>
            <a href="board.php" style="height:50px;font-size:30px;">등록하기</a>
        </div>
        <div class="search">
            <form action="main.php" method="post">
                <?php
                include 'oracle_con.php';

                // Address
                $query_home_address = "SELECT DISTINCT ADDRESS FROM HOME";
                $stmt_home_address = oci_parse($connect, $query_home_address);
                oci_execute($stmt_home_address);

                echo "<select name='ADDRESS'>";
                echo "<option value='전체'>전체</option>";
                while ($row_home_address = oci_fetch_assoc($stmt_home_address)) {
                    echo "<option value='{$row_home_address['ADDRESS']}'>{$row_home_address['ADDRESS']}</option>";
                }
                echo "</select>";

                // Homeform
                $query_infohome_homeform = "SELECT DISTINCT HOMEFORM FROM INFOHOME";
                $stmt_infohome_homeform = oci_parse($connect, $query_infohome_homeform);
                oci_execute($stmt_infohome_homeform);

                echo "<select name='HOMEFORM'>";
                echo "<option value='전체'>전체</option>";
                while ($row_infohome_homeform = oci_fetch_assoc($stmt_infohome_homeform)) {
                    echo "<option value='{$row_infohome_homeform['HOMEFORM']}'>{$row_infohome_homeform['HOMEFORM']}</option>";
                }
                echo "</select>";

                // Room
                $query_infohome_room = "SELECT DISTINCT ROOM FROM INFOHOME";
                $stmt_infohome_room = oci_parse($connect, $query_infohome_room);
                oci_execute($stmt_infohome_room);

                echo "<select name='ROOM'>";
                echo "<option value='전체'>전체</option>";
                while ($row_infohome_room = oci_fetch_assoc($stmt_infohome_room)) {
                    echo "<option value='{$row_infohome_room['ROOM']}'>{$row_infohome_room['ROOM']}</option>";
                }
                echo "</select>";

                // Homeprice range
                echo "<input type='number' name='minPrice' placeholder='최소'>";
                echo "<input type='number' name='maxPrice' placeholder='최대'>";

                echo "<button type='submit' class='searchbutton'>검색하기</button>";
                ?>
            </form>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $selected_address = $_POST['ADDRESS'];
                $selected_homeform = $_POST['HOMEFORM'];
                $selected_room = $_POST['ROOM'];
                $min_price = isset($_POST['minPrice']) ? $_POST['minPrice'] : null;
                $max_price = isset($_POST['maxPrice']) ? $_POST['maxPrice'] : null;

                $query_selected_data = "SELECT * FROM INFOHOME INNER JOIN HOME ON INFOHOME.INFOHOME_NUM = HOME.HOME_NUM ";

                if ($selected_address != '전체') {
                    $query_selected_data .= " AND HOME.ADDRESS = '$selected_address'";
                }
                if ($selected_homeform != '전체') {
                    $query_selected_data .= " AND INFOHOME.HOMEFORM = '$selected_homeform'";
                }
                if ($selected_room != '전체') {
                    $query_selected_data .= " AND INFOHOME.ROOM = '$selected_room'";
                }
                if (!empty($min_price) && !empty($max_price)) {
                    $query_selected_data .= " AND INFOHOME.HOMEPRICE BETWEEN $min_price AND $max_price";
                }

                $stmt_selected_data = oci_parse($connect, $query_selected_data);
                oci_execute($stmt_selected_data);

                echo "<table border='1' style='text-align:center; margin: 0 auto;'>
                        <tr>
                            <th>주소</th>
                            <th>방개수</th>
                            <th>가격</th>
                            <th>주택형태</th>
                            <th>상세정보</th>
                            <th>찜</th>
                        </tr>";

                while ($row_selected_data = oci_fetch_assoc($stmt_selected_data)) {
                    echo "<tr>
                            <td>{$row_selected_data['ADDRESS']}</td>
                            <td>{$row_selected_data['ROOM']}</td>
                            <td>{$row_selected_data['HOMEPRICE']}</td>
                            <td>{$row_selected_data['HOMEFORM']}</td>
                            <td><a href='home_detail.php?HOME_NUM={$row_selected_data['INFOHOME_NUM']}'>상세정보보기</a></td>
                            <td>
                                <form action='zzim.php' method='post'>
                                    <input type='hidden' name='INFOHOME_NUM' value='{$row_selected_data['INFOHOME_NUM']}'>
                                    <button type='submit'>찜하기</button>
                                </form>
                            </td>
                        </tr>";
                }

                echo "</table>";

                oci_free_statement($stmt_selected_data);
            }

            oci_free_statement($stmt_home_address);
            oci_free_statement($stmt_infohome_homeform);
            oci_free_statement($stmt_infohome_room);
            oci_close($connect);
            ?>
        </div>
    </div>
</body>
</html>