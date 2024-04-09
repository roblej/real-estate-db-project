<HTML>
<HEAD>
<META http-equiv="content-type" content="text/html; charset=utf-8";>
<LINK rel="stylesheet" type="text/css" href="style.css">
</HEAD>
<BODY>
<h1> 신규 회원 가입 </hl>
    <div>
        <form method="post" action="insert_result.php">
            <div class="form-group">
                <label for="HOMEUSER_ID">아이디:</label>
                <input type="text" name="HOMEUSER_ID">
            </div>

            <div class="form-group">
                <label for="PASSWORD">비밀번호:</label>
                <input type="text" name="PASSWORD">
            </div>

            <div class="form-group">
                <label for="USERNAME">이름:</label>
                <input type="text" name="USERNAME">
            </div>

            <div class="form-group">
                <label for="PHONE_DIAL">휴대폰 국번 (예: 010):</label>
                <input type="text" name="PHONE_DIAL">
            </div>

            <div class="form-group">
                <label for="PHONE_NUM">휴대폰 번호:</label>
                <input type="text" name="PHONE_NUM">
            </div>
            <div class="form-group">
                <label for="buyer">구매자</label>
                <input type="checkbox" name="PFORM[]" value="0" id = "buyer">
                <label for="seller">판매자</label>
                <input type="checkbox" name="PFORM[]" value="1" id="seller">
            </div>

            <div class="form-group">
                <input type="submit" value="회원 입력">
            </div>
        </form>
    </div>
</BODY>
</HTML>