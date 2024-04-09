<!DOCTYPE html>
<html lang="en">
<head>
<LINK rel="stylesheet" type="text/css" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>
<body>
    <h2>Login</h2>
    <form action="login_process.php" method="post">
        <label for="HOMEUSER_ID">ID:</label>
        <input type="text" id="HOMEUSER_ID" name="HOMEUSER_ID" required>
        <br>
        <label for="PASSWORD">Password:</label>
        <input type="PASSWORD" id="PASSWORD" name="PASSWORD" required>
        <br>
        <input type="submit" value="Login">
    </form>

    <!-- 회원가입으로 이동하는 버튼 -->
    <p>Don't have an account? <a href="insert.php">Sign up</a></p>
</body>
</html> 