<?php
	$kn= new mysqli("localhost","NgocLinh","K@NgocLinh1998","LeLinh");
	if($kn->connect_error){
		die("Web đang gặp sự cố! Vui lòng trở lại sau");
	}
	$kn->set_charset("utf8");
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Chi tiết sản phẩm</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous"/>
	<link rel="stylesheet" type="text/css" href="css/linh.css">
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css"> -->
	<style type="text/css">
		.cardl:hover{
			transform: translateY(-2%);
    		transition: all 5s;
			box-shadow: 10px 10px 10px green;
		}
		.cardl1:not(:hover){
			transform: translateY(-2%);
    		transition: all 5s;
			/*box-shadow: 10px 10px 10px green;*/
		}
		img{
			transform: translateY(-2%);
    		transition: all 0.5s;
			box-shadow: 10px 10px 10px grey;
		}
		h5{
			text-shadow: 10px 10px 10px black;
		}
		.text:hover{
			transform: translateY(-2%);
    		transition: all 0.5s;
    		color: black;
    		text-shadow: 1px -1px 0 #767676, -1px 2px 1px #737272, -2px 4px 1px #767474, -3px 6px 1px #787777, -4px 8px 1px #7b7a7a, -5px 10px 1px #7f7d7d, -6px 12px 1px #828181, -7px 14px 1px #868585, -8px 16px 1px #8b8a89, -9px 18px 1px #8f8e8d, -10px 20px 1px #949392, -11px 22px 1px #999897, -12px 24px 1px #9e9c9c;		
		}
		.ct {
		  color: lightgreen;
		  letter-spacing: .15em;
		  text-shadow: 10px 10px 10px lightgreen;  
		}
		.ts {
		    width: 300px;
		    word-break: normal;
		}
		td{
			text-align: center;
		}
		.x{
			color: blue;
		}
		.x:hover{
			color: green;
			cursor: pointer;
		}
	</style>
</head>
<body>
	<div class="container-fluid" style="margin-top: 2%;">
		<div class="ct" style="text-align: center; color: green">
		  	<h1 class="text">CHI TIẾT SẢN PHẨM</h1>
		</div>
		<button id='submit' class="btn-success" onclick="window.location='bookshop.php'"><i class='fas fa-sign-in-alt'></i> Trở về trang chủ</button>
		<div style="position: absolute; top: 5%; right: 5%; cursor: pointer;"><a onclick="view('view')" data-toggle='modal' data-target='#cart'><i class="fa fa-shopping-basket fa-2x text"></i> (<b id="spgh"></b>)</a></div>
	</div>
	<div id='test'></div>
	<div class="container-fluid" style="margin-top: 5%;">
		<?php
			echo "<div class='row' style=': 15px'>
				<div class='col-sm-12'>";
					$sql = "select SACH.*, TL_TEN, NXB_TEN from SACH, THE_LOAI, NHA_XUAT_BAN where SACH.TL_MA = THE_LOAI.TL_MA and SACH.NXB_MA = NHA_XUAT_BAN.NXB_MA and S_MA='".$_GET["d"]."'";
					$result = $kn->query($sql);
					$row = $result->fetch_assoc();
					$gia = $row["S_GIA"];
					$gia = $gia + $gia/10;
					echo "<div class='card-deck'>
						<div class='cardl card' style='border:0'>
							<img class='card-img-top' src='./css/image book/".$row["S_ANH"]."' style='width: 400px; height:500px;' alt='book'>
							<div class='card-body' style='position: absolute; top: 0%; left: 40%'>
								<h5 class='card-title' style='text-align: center'><b>Tên sách: </b>".$row["S_TEN"]."</h5>
								<br>
								<p class='card-text'><b>Tác giả: </b>".$row["S_TACGIA"]."</p>
								<p class='card-text'><b>Nhà xuất bản: </b>".$row["NXB_TEN"]."</p>
								<p class='card-text'><b>Thể loại: </b>".$row["TL_TEN"]."</p>
								<p class='card-text'><b>Mô tả: </b>".$row["S_MOTA"]."</p>
								<p class='card-text'><b>Giá: </b><del>".$gia."</del>đ&emsp;".$row["S_GIA"]." đ</p>
								<br>
								<b>Số lượng: </b><input id='SL' type='text' name='SOLUONG' value='1' maxlength='3' style='width:50px;'>
								<br><br>
								<button id='M' class='btn btn-outline-danger' onclick='add(name)' name='add,".$_GET["d"]."'>THÊM GIỎ HÀNG</button>
								<button id='M' class='btn btn-outline-danger' onclick='buy(name)' name='add,".$_GET["d"]."'>MUA</button>
							</div>
						</div>
					</div>
				</div>
			</div>";
		?>
	</div>		
	<div class="container-fluid" style="margin-top: 5%;">
		<div>
			<span class="line">
	    		<h2><span>CÁC SÁCH CÙNG THỂ LOẠI</span></h2>
			</span>​
		</div>
		<br><br><br>
		<?php
			$sql = "select * from SACH where TL_MA='".$row["TL_MA"]."' limit 5	";
			$result = $kn->query($sql);
			echo "<div class='row' style=': 15px'>
					<div class='col-sm-12'>";
						echo "<div class='card-deck'>";
							while($row=$result->fetch_assoc()){
								if($row["S_MA"]==$_GET["d"]) continue;
								echo"<div class='card' style='border:0'>
									<img onclick='detailproduct(name)' name='".$row["S_MA"]."' class='card-img-top' src='./css/image book/".$row["S_ANH"]."' style='width: 252px; height:350px;' alt='book'>
									<div class='card-body'>
									<h5 class='card-title'>".$row["S_TEN"]."</h5>
									<p class='card-text'>".$row["S_GIA"]." đ</p>
									</div>
								</div>";
						}
					echo "</div>
				</div>
			</div>";
		?>
	</div>
	<div class="container-fluid" style="margin-top: 5%;">
		<div>
			<span class="line">
	    		<h2><span>CÁC SÁCH MỚI NHẤT</span></h2>
			</span>​
		</div>
		<br><br><br>
		<?php
			$sql = "select * from SACH order by S_MA desc limit 5";
			$result = $kn->query($sql);
			echo "<div class='row' style=': 15px'>
					<div class='col-sm-12'>";
						echo "<div class='card-deck'>";
							while($row=$result->fetch_assoc()){
								echo"<div class='card' style='border:0'>
									<img onclick='detailproduct(name)' name='".$row["S_MA"]."' class='card-img-top' src='./css/image book/".$row["S_ANH"]."' style='width: 252px; height:350px;' alt='book'>
									<div class='card-body'>
									<h5 class='card-title'>".$row["S_TEN"]."</h5>
									<p class='card-text'>".$row["S_GIA"]." đ</p>
									</div>
								</div>";
						}
					echo "</div>
				</div>
			</div>";
		?>
	</div>
	<div class="container-fluid" style="margin-top: 5%;">
		<div>
			<span class="line">
	    		<h2><span>PHẢN HỒI</span></h2>
			</span>​
		</div>
		<br><br><br>
		<div>
			<div class="container-fluid">
				<p>Nhập vào nội dung:</p>
				<textarea  type="text" id="cmt" style="width: 35%;"></textarea>
				<?php 
					if (isset($_SESSION["username"]) && isset($_SESSION["password"]))
						echo "<button onclick='report(name)' name='report,".$_GET["d"]."'>Gửi</button>";
					else echo "<button onclick='checkcmt()'>Gửi</button>";
				?>
			</div>
			<div style="margin-top: 1%; border: solid 2px;"></div>
			<br>
			<div class="container" id="comment">
				<?php
					$sql = "select * from DANH_GIA where S_MA='".$_GET["d"]."' and ID_P ='0' ORDER BY ID desc";
					$result = $kn->query($sql);
					while($row = $result->fetch_assoc()){
						echo"<div class='panel panel-default'>
								<div class='panel-footer'>
									<b style='font-size: 22px'>&emsp;&emsp;".$row["TAI_KHOAN"]." </b><i>" .date('H:i:s - d/m/Y',strtotime($row["NGAY"]))."</i>
								</div>
							  	<div class='panel-body'>
							  		&emsp;&emsp;&emsp;&emsp;".$row["NOI_DUNG"]."
								    <br><br>
								    &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<input type='text' id='linh".$row["ID"]."' style='width: 35%;'><button onclick='report1(name)' name='report,".$_GET["d"].",linh".$row["ID"]."'>Trả lời</button>
								    </div>
							</div>";
						$pa = $kn->query("select * from DANH_GIA where ID_P = '".$row["ID"]."' ");
						while($r = $pa->fetch_assoc()){
							echo"<div class='panel panel-default' style='margin-left:10%'>
									<div class='panel-footer'>
										<bstyle='font-size: 22px'>&emsp;&emsp;".$r["TAI_KHOAN"]." </b><i>" .date('H:i:s - d/m/Y',strtotime($r["NGAY"]))."</i>
									</div>
								  	<div class='panel-body'>
								  		&emsp;&emsp;&emsp;&emsp;".$r["NOI_DUNG"]."
									    </div>
								</div>";
						}	
					}
				?>
			</div>
			<div style="margin-top: 30%; border: solid 2px;"></div>
		</div>
	</div>
	<div id='product'>		
	</div>
	<div class="jumbotron text-center" style="margin-bottom:0;text-shadow: 10px 10px 10px black;">
		<p>Student: Nguyễn Ngọc Linh</p>
		<p>Teacher: Lâm Nhựt Khang</p>
	</div>
	<?php
	 	echo "<script>";
	 	echo "var cm='".$_GET["d"]."';";
	 	echo "</script>"; 
	 ?>;
	<script type="text/javascript">
		function detailproduct(s){
            window.location="detail.php?d="+s;
        }
        // function checkSL() {
        // 	var s = document.getElementById('SL').value; 
        // 	if(s<1){
        // 		document.getElementById('M').innerHTML = "<button class='btn btn-outline-danger' type='submit' onclick='return checkMua()'>MUA</button>";
        // 		return false;
        // 	} else if(!/\d/.test(s) || /\D/.test(s)){
        // 		document.getElementById('M').innerHTML = "<button class='btn btn-outline-danger' type='submit' onclick='return checkMua()'>MUA</button>";
        // 		return false;
        // 	}else{
        // 		document.getElementById('M').innerHTML = "<button class='btn btn-outline-danger' type='submit' onclick='return checkMua()' data-toggle='modal' data-target='#cart'>MUA</button>";
        // 		return true;
        // 	}
        // }
        // function checkMua() {
        // 	if(checkSL()==false){
        // 		return false;
        // 	} 
        // }
        function checkcmt() {
        	var a = confirm('Đăng nhập mới có thể phản hồi');
        	if(a==true) window.location='login.php?c='+cm;
        }
        function buy(s) {
        	var str = document.getElementById('SL').value;
        	str=s+","+str;
        	if(str=="") return;
        	var x = new XMLHttpRequest();
        	x.open("GET","product.php?product="+str,false);
        	x.send();
			window.location='buy.php';	
        }
        function buygh() {
			window.location='buy.php';	
        }
        function view(str) {
        	if(str=="") return;
        	var x = new XMLHttpRequest();
        	x.open("GET","product.php?product="+str,false);
        	x.send();
        	document.getElementById('product').innerHTML = x.responseText;
        }
        function add(s) {
        	var str = document.getElementById('SL').value;
        	str=s+","+str;
        	if(str=="") return;
        	var x = new XMLHttpRequest();
        	x.open("GET","product.php?product="+str,false);
        	x.send();
        	document.getElementById('spgh').style.color = 'red';
        	document.getElementById('spgh').innerHTML = x.responseText;
        }
        function del(s) {
        	var str = "del,";
        	str += s;
        	if(str=="") return;
        	var x = new XMLHttpRequest();
        	x.open("GET","product.php?product="+str,false);
        	x.send();
        	document.getElementById(s).innerHTML = '';
        	var a = x.responseText;
        	var b="";
        	var c="";
        	var d="";
        	for (var i=0;i<a.length;i++) {
        		if(a[i]==",") break;
        		b += a[i];
        	}
        	for (var i=a.length-1;i>-1;i--) {
        		if(a[i]==",") break;
        		c = a[i] +c;
        	}
        	document.getElementById('slsp').innerHTML="<h5 class='modal-title' id='slsp'>Bạn có "+b+" sản phẩm trong giỏ hàng</h5>";
        	document.getElementById('tt').innerHTML="<p id='tt'>Tổng tiền: "+c+" đ</p>";
        	document.getElementById('spgh').innerHTML= b;
        	for (var i=b.length-1;i>-1;i--) {
        		if(b[i]=="	") break;
        		d = b[i]+d;
        	}
        	if(d<1){
        		document.getElementById('thanhtoan').innerHTML= '';
        	}
        }
        function report(s) {
        	var str = document.getElementById('cmt').value.trim();
        	if(str=="") return;
        	str=s+",,"+str;
        	var x = new XMLHttpRequest();
        	x.open("GET","product.php?product="+str,false);
        	x.send();
			document.getElementById('comment').innerHTML = x.responseText;
			document.getElementById('cmt').value="";
        }
        function report1(s) {
        	var a="";
        	for (var i=s.length-1;i>0;i--) {
        		if(s[i]==",") break;
        		a = s[i] +a;
        	}
        	var st=""
        	for (var i=0;i<s.length-a.length-1;i++) {
        		st += s[i];
        	}
        	var str = document.getElementById(a).value.trim();
        	if(str=="") return;
        	str=st+","+a+","+str;
        	var x = new XMLHttpRequest();
        	x.open("GET","product.php?product="+str,false);
        	x.send();
        	document.getElementById('comment').innerHTML = x.responseText;
        	document.getElementById(a).value="";
        }
	</script>
    <script type="text/javascript" src="js/popper.min.js"></script> 
	<script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>
</body>
</html>
<?php
	if(isset($_SESSION["cart"])){
		if(sizeof($_SESSION["cart"])>1){
			echo "<script>";
			echo "document.getElementById('spgh').style.color = 'red';";
			echo "document.getElementById('spgh').innerHTML = '".(sizeof($_SESSION["cart"])-1)."';";
			echo "</script>";
		} else{
			echo "<script>";
			echo "document.getElementById('spgh').innerHTML = '0';";
			echo "</script>";
		}
	} else{
		echo "<script>";
		echo "document.getElementById('spgh').innerHTML = '0';";
		echo "</script>";
	}
?>