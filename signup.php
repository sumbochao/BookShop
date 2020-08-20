<?php
    $kn= new mysqli("localhost","NgocLinh","K@NgocLinh1998","LeLinh");
    if($kn->connect_error){
        die("Web đang gặp sự cố! Vui lòng trở lại sau");
    }
    $kn->set_charset("utf8");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/signup.css">
</head>
<body>
    <div id="test"></div>
    <div id="logreg-forms" style="margin-top: 1%">
        <form class="form-signin" method="post">
            <h1 class="h3 mb-3 font-weight-normal" style="text-align: center;">ĐĂNG KÝ</h1>
            <div class="input-group">
                <input id="id" type="text" class="form-control" placeholder="Tên đăng nhập" required="required" name="TK_TEN" onkeyup="checkusername()"><i id="mess1" style="font-size: 15px; position: absolute; top: 100%; left: 0%;"></i>
            </div>
            <br>
            <div class="input-group">
                <input id="pwd" type="password" class="form-control" placeholder="Mật khẩu" required="required" name="TK_MATKHAU" onkeyup="checkconfirm()"><i id="mess2" style="font-size: 15px; position: absolute; top: 100%; left: 0%;"></i>
            </div>
            <br>
            <div class="input-group">
                <input id="confirm" type="password" class="form-control" placeholder="Xác nhận mật khẩu" required="required" onkeyup="checkconfirm()"><i id="mess3" style="font-size: 15px; position: absolute; top: 27%; left: 100.5%;"></i>
            </div>
            <br>
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Họ và tên" required="required" name="KH_TEN" id="hoten" onkeyup="checkhoten()"><i id="mess4" style="font-size: 15px; position: absolute; top: 100%; left: 0%;"></i>
            </div>
            <br>
            <div class="input-group" style="color: grey;">
                Giới tính:
                <table>
                    <tr><td>&emsp;</td><td><input type="radio" class="form-control" required="required" name="KH_GIOITINH" value="nam"></td><td>Nam </td><td>&emsp;</td><td><input type="radio" class="form-control" required="required" name="KH_GIOITINH" value="nữ"></td><td>Nữ</td></tr>
                </table>
            </div>
            <br>    
            <div class="input-group">
                <input type="date" class="form-control" placeholder="Năm sinh" required="required" name="KH_NAMSINH">
            </div>
            <br>
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Số điện thoại" required="required" name="KH_SDT" id="sdt" onkeyup
                ="checksdt()"><i id="mess5" style="font-size: 15px; position: absolute; top: 27%; left: 100.5%;"></i>
            </div>
            <br>
            <div class="input-group">
              <button id="submit" onclick="return checksubmit()" class="btn btn-md btn-rounded btn-block form-control submit" type="submit" name="signup"><i class="fas fa-sign-in-alt"></i> Đăng ký</button>
            </div>
            <br>
            <hr>
            <a href="login.php"><button class="btn btn-primary btn-block"><i class="fas fa-user"></i> Trở về đăng nhập</button></a>
        </form>
        <div style="position: absolute; top:97%; left: 36%"><a href="./bookshop.php">Trang chủ</a></div>
    </div>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="js/signup.js"></script>
    <script type="text/javascript">
        function checkconfirm() {
            var pwd=document.getElementById('pwd').value
            var confirm=document.getElementById('confirm').value;
            if(pwd == ""){
                document.getElementById('mess2').style.color='red'; document.getElementById('mess2').innerHTML = 'Mật khẩu không được rỗng';
                return false;
            } else if (pwd != "") {
                document.getElementById('mess2').style.color='green'; document.getElementById('mess2').innerHTML = '<i class="fa fa-check"></i>';
            } 
            if (confirm==pwd) {
                document.getElementById('mess3').style.color='green'; document.getElementById('mess3').innerHTML = '<i class="fa fa-check"></i>';
                return true;
            } else {
                document.getElementById('mess3').style.color='red'; document.getElementById('mess3').innerHTML = '<i class="fa fa-times"></i>';
                return false;
            } 
        }
        function checkhoten() {
            var hoten=document.getElementById('hoten').value;
            if((hoten == "") || (/\d/.test(hoten))){
                document.getElementById('mess4').style.color='red'; document.getElementById('mess4').innerHTML = 'Tên không hợp lệ';
                return false;
            } else {
                document.getElementById('mess4').style.color='green'; document.getElementById('mess4').innerHTML = '<i class="fa fa-check"></i>';
                return true;                
            }
        }
        function checksdt() {
            var sdt = document.getElementById('sdt').value;
            if(/\b((070|079|077|076|078|089|090|093|083|084|085|081|082|088|091|094|032|033|034|035|036|037|038|039|086|096|097|098|056|058|092|059|099)+([0-9]{7})\b)/.test(sdt)){
                 document.getElementById('mess5').style.color='green'; document.getElementById('mess5').innerHTML = '<i class="fa fa-check"></i>';
                 return true;
            } else {
                document.getElementById('mess5').style.color='red'; document.getElementById('mess5').innerHTML = '<i class="fa fa-times"></i>';
                return false;
            }
        }

    </script>
</body>
</html>
<?php
    $sql="select KH_TAIKHOAN from KHACH_HANG";
    $result=$kn->query($sql);
    echo "<script type='text/javascript'> var TAI_KHOAN=[]";
    $i=0;
    while ($row=$result->fetch_assoc()) {
        echo "
            TAI_KHOAN[$i]='".$row['KH_TAIKHOAN']."';
        ";
        $i++;
    }
    echo"</script>";
?>
<script type="text/javascript">
    function checkusername() {
        var username = document.getElementById('id').value;
        if(username == ""){
            document.getElementById('mess1').style.color='red'; document.getElementById('mess1').innerHTML = 'Tên tài khoản không được rỗng';
            return false;
        }
        username = username.toLowerCase();
        var t1=",";
        t1+=username;
        t1+=",";
        var t2=",";
        t2+=TAI_KHOAN.toString();
        t2+=",";
        if(/\s/.test(username)){
            document.getElementById('mess1').style.color='red'; document.getElementById('mess1').innerHTML = 'Tên tài khoản không hợp lệ';
            return false;
        } else if(t2.search(t1)>-1){
            document.getElementById('mess1').style.color='red'; document.getElementById('mess1').innerHTML='Tên tài khoản đã tồn tại';
            return false;
        } else{
            document.getElementById('mess1').style.color='green'; document.getElementById('mess1').innerHTML = '<i class="fa fa-check"></i>';
            return true;
            }
    }
    function checksubmit(){
        if (checkusername()==false || checkconfirm()==false ||checksdt()==false){
            return false;
        }

    }
</script>
<?php
    $resultma=$kn->query("select KH_MA from KHACH_HANG");
    $MA=[];
    $i=0;
    while ($row=$resultma->fetch_assoc()) {
        $sub=substr($row["KH_MA"],strrpos($row["KH_MA"],"H",0)+1,strlen($row["KH_MA"]));
        $MA[$i] = $sub;
        $i++;
    }
    if (empty($MA)){
        $MA[0]=0;
    }   
    $KH = max($MA)+1;
    $j=strlen($KH);
    if($j<7){
        while($j<7){
            $KH ="0".$KH;
            $j++;
        }
    }
    if(isset($_POST["signup"])){
        $kn->query("insert into KHACH_HANG values('KH".$KH."','".mb_strtolower($_POST["TK_TEN"],'UTF-8')."','".sha1(md5($_POST["TK_MATKHAU"]))."','".mb_strtolower($_POST["KH_TEN"],'UTF-8')."','".mb_strtolower($_POST["KH_GIOITINH"],'UTF-8')."','".$_POST["KH_NAMSINH"]."','".$_POST["KH_SDT"]."')");
        echo "<meta http-equiv='refresh' content='3;./bookshop.php'>";
    }
?>