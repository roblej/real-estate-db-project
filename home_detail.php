<html>
<head>
    <title>상세정보</title>
<style>
        table {
            border-collapse: collapse;
            width: 60%;
        }

        th, td {
            padding: 8px;
            word-break: break-all; /* 긴 단어 줄 바꿈 */
            max-width: 200px; /* 셀 최대 너비 */
            overflow: hidden; /* 넘치는 부분 숨기기 */
            text-overflow: ellipsis; /* 넘칠 때 ...으로 표시 */
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>상세정보</h2>
    <?php
    include 'oracle_con.php';
    $home_id = $_GET['HOME_NUM'];

    $sql = "SELECT i.INFOHOME_NUM, i.HOMEFORM, i.CONDITION, i.HOMEPRICE, i.HOMESIZE, i.ROOM, h.ADDRESS , h.USER_ID
            FROM INFOHOME i
            INNER JOIN HOME h ON i.INFOHOME_NUM = h.HOME_NUM
            WHERE i.INFOHOME_NUM = :HOME_NUM";

    $stid = oci_parse($connect, $sql);
    oci_bind_by_name($stid, ':HOME_NUM', $home_id);
    oci_execute($stid);

    echo "<table width='300' border='1' cellpadding='0' cellspacing='0'>\n";
    while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
        echo "<tr>\n";
        foreach ($row as $column => $value) {
            if ($column !== 'HOME_NUM') { // HOME_ID 컬럼을 출력에서 제외합니다.
                echo "<td>" . ($value !== NULL ? htmlentities($value, ENT_QUOTES) : "&nbsp;") . "</td>\n";
            }
        }
        echo "</tr>\n";
    }
    echo "</table>\n";

    oci_free_statement($stid);
    oci_close($connect);
?>
<?php
    include 'oracle_con.php';
    $home_id = $_GET['HOME_NUM'];

    $sql = "SELECT h.USER_ID
            FROM HOME h
            WHERE h.HOME_NUM = :HOME_NUM";

    $stid = oci_parse($connect, $sql);
    oci_bind_by_name($stid, ':HOME_NUM', $home_id);
    oci_execute($stid);

    $row = oci_fetch_assoc($stid);
    if ($row) {
        $user_id = $row['USER_ID'];

        $sql_user = "SELECT PHONE_NUM
                     FROM HOMEUSER
                     WHERE HOMEUSER_ID = :USER_ID";

        $stid_user = oci_parse($connect, $sql_user);
        oci_bind_by_name($stid_user, ':USER_ID', $user_id);
        oci_execute($stid_user);

        $row_user = oci_fetch_assoc($stid_user);

        echo "<table>\n";
        echo "<tr>\n";
        echo "<th>연락처</th>\n";
echo "<td>" . ($row_user['PHONE_NUM'] ?? 'Phone number not found') . "</td>\n";
        echo "</tr>\n";
        echo "</table>\n";

        oci_free_statement($stid_user);
    } else {
        echo "Home ID not found";
    }

    oci_free_statement($stid);
    oci_close($connect);
    ?>
</body>
</html>