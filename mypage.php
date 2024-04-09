<!DOCTYPE html>
<html>
<head>
    <title>마이페이지</title>
</head>
<body>
    <h2>찜목록</h2>
    <?php
    session_start();
    include 'oracle_con.php';

    $logined_ID = $_SESSION['HOMEUSER_ID'];
    $sql = "SELECT ZZIMHOME_ID FROM ZZIM WHERE ZZIMUSER_ID = :HOMEUSER_ID";
    $stid = oci_parse($connect, $sql);
    oci_bind_by_name($stid, ':HOMEUSER_ID', $logined_ID);
    oci_execute($stid);
    echo "<table width='300' border='1' cellpadding='0' cellspacing='0'>\n";

    while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
        echo "<tr>\n";
        foreach ($row as $item) {
            // Add hyperlink to detail.php with HOMEUSER_ID as parameter
            echo "<td><a href='home_detail.php?home_id=" . urlencode($item) . "'>" . ($item !== NULL ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</a></td>\n";
        }
        echo "<td><form method='post' action='delete_zzim.php'><input type='hidden' name='zzimhome_id' value='" . $row['ZZIMHOME_ID'] . "'><input type='submit' value='삭제'></form></td>";
        echo "</tr>\n";
    }
    echo "</table>\n";

    oci_free_statement($stid);
    oci_close($connect);
    ?>
    <?php
    include 'permission_check.php';
    ?>
    <?php if(!$show_register): ?>
    <h2>등록한 매물</h2>
    <?php
    session_start();
    include 'oracle_con.php';
    $logined_ID = $_SESSION['HOMEUSER_ID'];
    $sql = "SELECT HOME_NUM from HOME where USER_ID = :HOMEUSER_ID";
    $stid = oci_parse($connect, $sql);
    oci_bind_by_name($stid, ':HOMEUSER_ID', $logined_ID);
    oci_execute($stid);
    echo "<table width='300' border='1' cellpadding='0' cellspacing='0'>\n";
    while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
        echo "<tr>\n";
        foreach ($row as $item) {
            // Add hyperlink to detail.php with HOMEUSER_ID as parameter
            echo "<td><a href='home_detail.php?HOME_NUM=" . urlencode($item) . "'>" . ($item !== NULL ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</a></td>\n";
        }
        echo "<td><form method='post' action='delete_register.php'><input type='hidden' name='HOME_NUM' value='" . $row['HOME_NUM'] . "'><input type='submit' value='삭제'></form></td>";    
        echo "</tr>\n";
    }
    echo "</table>\n";

    oci_free_statement($stid);
    oci_close($connect);
    ?>
    <?php endif; ?>
</body>
</html>