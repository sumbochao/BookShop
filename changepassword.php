<?php
    session_start();
    if(!(isset($_SESSION["username"]) && isset($_SESSION["password"]))){
        header("Location: ./bookshop.php");
    }
    $kn = new mysqli("localhost","NgocLinh","K@NgocLinh1998","LeLinh");
    if($kn->connect_error){
        die("Web đang gặp sự cố! Vui lòng trở lại sau");
    }
    $kn->set_charset("utf8");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Changepassword</title>
    <link href='css/bootstrap.min.css' rel='stylesheet'>
    <link href='css/changepassword.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
</head>
<body>
    <div id='user'>
        <div class='container'>
            <div id='user-row' class='row justify-content-center align-items-center'>
                <div id='user-column' class='col-md-6'>
                    <div id='user-box' class='col-md-12'>
                        <form id='user-form' class='form' action='' method='post'>
                            <h3 class='text-center text-info'>Đổi Mật Khẩu</h3>
                            <div class='form-group'>
                                <label for='oldpassword' class='text-info'>Mật khẩu cũ:</label><br>
                                <input type='password' name='oldpassword' class='form-control' required="required">
                            </div>
                            <div class='form-group'>
                                <label for='newpassword' class='text-info'>Mật khẩu mới:</label><br>
                                <input type='password' name='newpassword' class='form-control' id='pass' required="required">
                            </div>
                            <div class='form-group'>
                                <label for='confirmnewpassword' class='text-info'>Xác nhận mật khẩu mới:</label><br>
                                <input type='password' name='confirmnewpassword' class='form-control' id='confirm' onkeyup="checkconfirm()"><i id="mess2" style="font-size: 15px; position: absolute; top: 69%; right: 2%;"></i>
                            </div>
                            <div class='form-group'>
                                <input type='submit' name='submit' class='btn btn-info btn-md' value='Xác nhận đổi' id='submit' onclick="return checksubmit()">
                            </div>
                            <div class='form-group' style="position: absolute; top:0%; right: 0%;">
                                <a href="bookshop.php"><input type='button' class='btn btn-info btn-md' value='Trang chủ' id='home'></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function checkconfirm() {
            var pass=document.getElementById('pass').value
            var confirm=document.getElementById('confirm').value;
            if (confirm==pass) {
                document.getElementById('mess2').style.color='green'; document.getElementById('mess2').innerHTML = '<i class="fa fa-check"></i>';
                return true;
            } else {
                document.getElementById('mess2').style.color='red'; document.getElementById('mess2').innerHTML = '<i class="fa fa-times"></i>';
                return false;
            } 
        }
        function checksubmit(){
            if (checkconfirm()==false){
                return false;
            }

        }
    </script>
    <script src='js/bootstrap.min.js'></script>
    <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
</body>
</html>
<?php 
    if(isset($_POST["submit"])){
        if($kn->query("select * from KHACH_HANG where KH_TAIKHOAN='".$_SESSION["username"]."' and KH_MATKHAU='".sha1(md5($_POST["oldpassword"]))."'")->num_rows>0){
            if($kn->query("update KHACH_HANG set KH_MATKHAU='".sha1(md5($_POST["newpassword"]))."' where KH_MATKHAU='".sha1(md5($_POST["oldpassword"]))."'")){
                echo "<script> alert('Đổi mật khẩu thành công!!!') </script>";
            }
        }  else {
            echo "<script> alert('Mật khẩu cũ không đúng') </script>";
        }
    }
?>