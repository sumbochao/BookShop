<?php
	session_start();
	$kn = new mysqli("localhost","NgocLinh","K@NgocLinh1998","LeLinh");
	if($kn->connect_error){
		die("Web đang gặp sự cố! Vui lòng trở lại sau");
	}
	$kn->set_charset("utf8");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body>
<div class="container">
	<div class="d-flex justify-content-center h-100">
		<div class="card">
			<div class="card-header">
				<h3>Đăng Nhập</h3>
			</div>
			<div class="card-body">
				<form method="POST">
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
						<input type="text" class="form-control" placeholder="Tên đăng nhập" required name="TK_TEN">
					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
						<input type="password" class="form-control" placeholder="Mật khẩu" required name="TK_MATKHAU">
					</div>
					<div class="row align-items-center remember">
						<input type="checkbox">Nhớ mật khẩu
					</div>
					<div class="form-group">
						<input type="submit" value="Đăng nhập" class="btn float-right login_btn" name="login">
					</div>
				</form>
			</div>
			<div class="card-footer">
				<div class="d-flex justify-content-center links">
					Bạn không có tài khoản?<a style="color: lightgreen" href="signup.php">Đăng Ký</a>
				</div>
				<div class="d-flex justify-content-center">
					<a style="color: yellow;" href="bookshop.php">Trở Về Trang Chủ</a>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
</body>
</html>
<?php
	// $kn->query("insert into NHAN_VIEN values('NV0001','tigerboy','".sha1(md5('linh'))."','nguyen ngoc linh','Soc trang','nam','1998-09-14','0363162033')");
	if(isset($_POST["login"])){
		$sqlkh="select * from KHACH_HANG where KH_TAIKHOAN='".mb_strtolower($_POST["TK_TEN"])."' and KH_MATKHAU='".sha1(md5($_POST["TK_MATKHAU"]))."'";
		$sqlnv="select * from NHAN_VIEN where NV_TAIKHOAN='".mb_strtolower($_POST["TK_TEN"])."' and NV_MATKHAU='".sha1(md5($_POST["TK_MATKHAU"]))."'";
		if(($resultkh = $kn->query($sqlkh)) && ($resultnv = $kn->query($sqlnv))){
			if($resultkh->num_rows>0){
				$row=$resultkh->fetch_assoc();
				$per = "";
				for($i=0;$i<2;$i++) {
					$per .= $row["KH_MA"][$i];
				}
				if($per=="KH"){
					$_SESSION["username"]=$row["KH_TAIKHOAN"];
					$_SESSION["password"]=$row["KH_MATKHAU"];
					$_SESSION["permission"]=$per;
					if(isset($_GET["b"])) header("Location: buy.php");
					else if(isset($_GET["c"])) header("Location: detail.php?d=".$_GET["c"]."");
					else header("Location: ./bookshop.php");
				}
			} else if($resultnv->num_rows>0) {
				$row=$resultnv->fetch_assoc();
				$per = "";
				for($i=0;$i<2;$i++) {
					$per .= $row["NV_MA"][$i];
				}
				if($per=="NV"){
					$_SESSION["username"]=$row["NV_TAIKHOAN"];
					$_SESSION["password"]=$row["NV_MATKHAU"];
					$_SESSION["permission"]=$per;
					if(isset($_GET["b"])) header("Location: buy.php");
					else if(isset($_GET["c"])) header("Location: detail.php?d=".$_GET["c"]."");
					else header("Location: ./admin.php");
				}
			} else {
				echo "<script> alert('Tài khoản hoặc mật khẩu không đúng') </script>";
			}
		} else {
			echo "<script> alert('Tài khoản hoặc mật khẩu không đúng') </script>";
		}
		$kn->close();
	}
?>