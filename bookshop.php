<?php
	session_start();
	$kn = new mysqli("localhost","NgocLinh","K@NgocLinh1998","LeLinh");
	if($kn->connect_error){
		die("Web đang gặp sự cố! Vui lòng trở lại sau");
	}
	$kn->set_charset("utf8");
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>BÁN SÁCH</title>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous"/>
		<link rel="stylesheet" type="text/css" href="css/linh.css"/>
		<link rel="stylesheet" type="text/css" href="css/default.css" />
		<link rel="stylesheet" type="text/css" href="css/component.css" />
		<style type="text/css">
			.t{
				text-align: center;
			}
			.hihi:hover{
				background-color: lightgrey;
				cursor: pointer;
			}
			.t td{
				text-align: center;
			}
			.t img{
				transform: translateY(-2%);
	    		transition: all 0.5s;
				box-shadow: 10px 10px 10px grey;
			}
			.x{
				color: blue;
			}
			.x:hover{
				color: green;
				cursor: pointer;
			}
			.text:hover{
				transform: translateY(-2%);
	    		transition: all 0.5s;
	    		color: black;
	    		text-shadow: 1px -1px 0 #767676, -1px 2px 1px #737272, -2px 4px 1px #767474, -3px 6px 1px #787777, -4px 8px 1px #7b7a7a, -5px 10px 1px #7f7d7d, -6px 12px 1px #828181, -7px 14px 1px #868585, -8px 16px 1px #8b8a89, -9px 18px 1px #8f8e8d, -10px 20px 1px #949392, -11px 22px 1px #999897, -12px 24px 1px #9e9c9c;		
			}
			.ts {
			    width: 300px;
			    word-break: normal;
			}
		</style>
	</head>
	<body>
		<div style="position: absolute; z-index: 0;" id="carousel">
			<div id="carouselExampleIndicators" class="carousel slide animated owl-animated-out owl-animated-in fadeOut " data-ride="carousel">
			  <ol class="carousel-indicators">
			    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
			    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
			    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
			  </ol>
			  <div class="carousel-inner">
			    <div class="carousel-item active">
			      <img src="css/carousel/carousel1.jpg" class="d-block w-100" alt="carousel1">
			      <div style="position: absolute; top: 25%; left: 25%;" class="carousel1">
			      	<h1>WELCOME TO THE BOOKSHOP</h1>
			      </div>
			    </div>
			    <div class="carousel-item">
			      <img src="css/carousel/carousel2.jpg" class="d-block w-100" alt="carousel2">
			    </div>
			    <div class="carousel-item">
			      <img src="css/carousel/carousel3.jpg" class="d-block w-100" alt="carousel3">
			    </div>
			  </div>
			  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
			    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
			    <span class="sr-only">Previous</span>
			  </a>
			  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
			    <span class="carousel-control-next-icon" aria-hidden="true"></span>
			    <span class="sr-only">Next</span>
			  </a>
			</div>
		</div>
		<div style="background: rgba(255,255,255,0.7); position: relative; z-index: 1021">
			<div class="container-fluid">
				<div class="row">
					<div class="col">
						<img src="css/logo/logo.png" alt="Logo" width="150px" height="100px">
					</div>
					<div class="col">
						<br>
						<input id='se' type="search" class="" placeholder="Tìm kiếm... " onkeyup="searchI('KHTKSI')">
						<button type="submit" class="btn-info" onclick="searchB('KHTKSB')"><i class="fa fa-search"></i></button>
						<div id="sea"></div>
					</div>
					<div class="col"> <br> <i class="fa">&#xf2a0;</i> <b>HOTLINE <br> 0363162033</b>
					</div>
					<div class="col"> <br>
						<div><a onclick="view('view')" data-toggle='modal' data-target='#cart' style="cursor: pointer;"><i class="fa fa-shopping-basket fa-lg text"></i> <b>GIỎ HÀNG</b></a></div>
						<div style="font-size: 115%">(<b id="spgh"></b>)</div>
					</div>
					<div class="col">
						<div  id="login"> <br> <i class="fa fa-user"></i> <b><a href="login.php">ĐĂNG NHẬP</a></b></div>
						<div class=" dropdown" id="user"> <br> <i class="fa fa-user"></i>
							<button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><b><?php echo"".$_SESSION["username"]."" ?></b></button>
							<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
								<button class="dropdown-item" onclick="history()" data-toggle="modal" data-target="#myModal">Lịch sử</button> 
								<button class="dropdown-item" onclick="changepassword()">Đổi mật khẩu</button> 
								<button class="dropdown-item" onclick="logout()">Đăng xuất</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="sticky-top navb">
			<ul><b>
			  <li><a href="bookshop.php">TRANG CHỦ</a></li>
			  <li><a href="#news">VỀ CHÚNG TÔI</a></li>
			  <li><a href="#news">TIN TỨC</a></li>
			  <li><a href="#news">LIÊN HỆ</a></li>
			  <li style="float: right" class="dropdownl">
				<a href="javascript:void(0)" class="dropbtnl"> <i class="fa">&#xf039; THỂ LOẠI SÁCH</i></a>
				<div class="dropdownl-content">
				 	<?php
					  	$result = $kn->query('select * from THE_LOAI');
					  	while($row=$result->fetch_assoc()) {
					  		echo"<button class='text-success' style='width:100%;' onclick='product(value)' value='".$row["TL_MA"]."'>".$row["TL_TEN"]."</button>";
					  	}
					?>
				</div>

			  </li>
			</b></ul>
		</div>
		<div id="searchproduct"></div>
		<div class="container-fluid" style="margin-top: 50%">
			<div class="hi-icon-wrap hi-icon-effect-8 hi-icon-effect-6">
				<div class="row">
					<div class="col gioithieu">
						<i class="hi-icon hi-icon-bookmark"></i><b>SÁCH NHIỀU THỂ LOẠI</b>
					</div>
					<div class="col gioithieu">
						<i class="hi-icon hi-icon-clock"></i><b>LÀM VIỆC 24/7</b>
					</div>
					<div class="col gioithieu">
						<i class="hi-icon hi-icon-mobile"></i><b>HỖ TRỢ TẬN TÌNH</b>
					</div>
					<div class="col gioithieu">
						<i class="hi-icon hi-icon-earth"></i><b>GIAO HÀNG TOÀN QUỐC</b>
					</div>
				</div>
			</div>
		</div>
		<div class="container-fluid">
			<div>
				<span class="line">
	    			<h2><span>SÁCH MỚI NHẤT</span></h2>
				</span>​
			</div>
			<br><br><br>
			<div class="row" style=": 15px">
				<div class="col-sm-12">
					<div id='product'></div>
					<div id='product2'></div>
				</div>
			</div>
		</div>
		<br><br><br>
		<div class="jumbotron text-center" style="margin-bottom:0;text-shadow: 10px 10px 10px black;">
			<p>Student: Nguyễn Ngọc Linh</p>
			<p>Teacher: Lâm Nhựt Khang</p>
		</div>
		<div id="myModal" class="modal fade" role="dialog">
		  <div class="modal-dialog modal-lg">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h4 class="modal-title">Lịch sử giao dịch</h4>
		      </div>
		      <div class="modal-body">
				<?php
					if (isset($_SESSION["username"]) && isset($_SESSION["password"])) {
		    			$result = $kn->query("select * from HOA_DON, KHACH_HANG where HOA_DON.KH_MA = KHACH_HANG.KH_MA and KH_TAIKHOAN = '".$_SESSION["username"]."'");
		    			$i=1;
		    			echo "<table width='100%' class='t'>
			     			<tr><td>STT</td><td>Ngày giao dịch: <b></b></td><td>Số hóa đơn</td><td>Tổng tiền</td><td>Chi tiết</td></tr>";
					    	while ($row = $result->fetch_assoc()){
					    		echo "<tr>
					    			<td>$i</td>
						    		<td>".date('H:i:s - d/m/Y',strtotime($row["HD_NGAY"]))."</td>
						    		<td>".$row["HD_MA"]."</td>
						    		<td>".$row["HD_TONGTIEN"].".đ</td>
						    		<td><button class='btn-success' onclick='xem(name)' name='xem,".$row["HD_MA"].",".$row["HD_NGAY"]."' data-toggle='modal' data-target='#xem'>xem</button></td>
					    		</tr>";
					    		$i++;
					    	} 
					    echo "</table>"; 						
					}
     			?>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		      </div>
		    </div>
		  </div>
		</div>
		<div id="product1" class="t"></div>
    	<script type="text/javascript" src="js/popper.min.js"></script> 
		<script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.js"></script>
		<script type="text/javascript" src="js/modernizr.custom.js"></script>
		<script type="text/javascript">
            function logout() {
               window.location="logout.php";
            }
            function changepassword(){
            	window.location="changepassword.php";
            }
            function detailproduct(s){
            	window.location="detail.php?d="+s;
            }
            function searchI(str) {
            	var s = document.getElementById('se').value
            	if(str=="") return;
            	str += ","+s;
            	var x = new XMLHttpRequest();
            	x.open("GET","search.php?search="+str,true);
            	x.send();
            	x.onreadystatechange = function () {
            		if(x.readyState == 4 && x.status==200){
            			document.getElementById('sea').innerHTML = x.responseText;
            			document.getElementById('sea').value = x.responseText;
				      	document.getElementById("sea").style.background="white";
            		}
            	}
            }
            function searchB(str) {
            	var s = document.getElementById('se').value
            	if(str=="") return;
            	str += ","+s;
            	var x = new XMLHttpRequest();
            	x.open("GET","search.php?search="+str,true);
            	x.send();
            	x.onreadystatechange = function () {
            		if(x.readyState == 4 && x.status==200){
            			document.getElementById('carousel').innerHTML = '';
            			document.getElementById('searchproduct').innerHTML = x.responseText;
            		}
            	}
            }
            function searchV(s) {
            	if(s=="") return;
            	str = "KHTKSB,"+s;
            	var x = new XMLHttpRequest();
            	x.open("GET","search.php?search="+str,true);
            	x.send();
            	x.onreadystatechange = function () {
            		if(x.readyState == 4 && x.status==200){
            			document.getElementById('se').value=s;
            			document.getElementById('sea').innerHTML='';
            			document.getElementById('carousel').innerHTML = '';
            			document.getElementById('searchproduct').innerHTML = x.responseText;
            		}
            	}

            }
            function product(str) {
            	if(str=="") return;
            	var x = new XMLHttpRequest();
            	x.open("GET","product.php?product="+str,true);
            	x.send();
            	x.onreadystatechange = function () {
            		if(x.readyState == 4 && x.status==200){
            			document.getElementById('product').innerHTML = x.responseText;
            		}
            	}
            }
            function xem(str) {
            	if(str=="") return;
            	var x = new XMLHttpRequest();
            	x.open("GET","product.php?product="+str,false);
            	x.send();
            	document.getElementById('product2').innerHTML = x.responseText;
            }
            window.onload = function(){
            	product('linh');
            }
	        function view(str) {
	        	if(str=="") return;
	        	var x = new XMLHttpRequest();
	        	x.open("GET","product.php?product="+str,false);
	        	x.send();
	        	document.getElementById('product1').innerHTML = x.responseText;
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
	        function buygh() {
				window.location='buy.php';	
        	}
            $(document).on('hidden.bs.modal', '.modal', function () { $('.modal:visible').length && $(document.body).addClass('modal-open'); });
    	</script>
	</body>
</html>
<?php
	
	// ###################### THAY ĐỔI BIỂU TƯỢNG KHI ĐĂNG NHẬP #################################

	if (isset($_SESSION["username"]) && isset($_SESSION["password"])) {
		echo"
			<script> 
				document.getElementById('login').style.display='none';
			</script>
		";
	} else {
		echo"
			<script> 
				document.getElementById('user').style.display='none';
			</script>
		";
	}

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
	$kn->close();
?>