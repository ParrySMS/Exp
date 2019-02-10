<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2019-2-10
 * Time: 16:36
 */
require './func/pm.php';
require './func/check.php';

try {


//todo 获取参数
    $acccout = isset($_POST['account']) ? $_POST['account'] : null;
    $password = $_POST['password'] ?? null;
    $res = 'FAILED';


//todo 参数校验
    lenCheck($acccout, 5, 10);
    lenCheck($password, 6, 12);
    numChar($acccout);//还没写好
    noSP($acccout);
    noZH($acccout);
    noSP($password);
    noZH($password);


//todo 验证账号密码

    check($acccout,$password);
    $res = 'SUCCESS';

//todo 返回结果


}catch (Exception $e){
//    echo 'INFO:'.$e->getMessage().'<br/>';
    $res = 'FAILED:'.$e->getMessage();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>

    <script type="text/javascript">
        function validate_email(field, alerttxt) {
            with (field) {
                apos = value.indexOf("@")
                dotpos = value.lastIndexOf(".")
                if (apos < 1 || dotpos - apos < 2) {
                    alert(alerttxt);
                    return false
                }
                else {
                    return true
                }
            }
        }

        function validate_form(thisform) {
            with (thisform) {
                if (validate_email(email, "Not a valid e-mail address!") == false) {
                    email.focus();
                    return false
                }
            }
        }
    </script>
</head>
<body>


<!--<form action="submitpage.htm" onsubmit="return validate_form(this);" method="post">-->
    <form action="./login.php" method="post">
        <p>ACCOUNT: <input type="text" name="account" value="admin" /></p>
        <p>PASSWORD: <input type="password" name="password" placeholder="please input password" /></p>
        <input type="submit" value="LOGIN" />
    </form>

    <h2><?php echo $res ?></h2>

</body>

</html>
