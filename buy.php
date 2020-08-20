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
	<title>Buy product</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/view.css">
    <script type="text/javascript" src="js/popper.min.js"></script> 
	<script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<style type="text/css">
		.text:hover{
			transform: translateY(-2%);
    		transition: all 5s;
    		color: black;
    		text-shadow: 1px -1px 0 #767676, -1px 2px 1px #737272, -2px 4px 1px #767474, -3px 6px 1px #787777, -4px 8px 1px #7b7a7a, -5px 10px 1px #7f7d7d, -6px 12px 1px #828181, -7px 14px 1px #868585, -8px 16px 1px #8b8a89, -9px 18px 1px #8f8e8d, -10px 20px 1px #949392, -11px 22px 1px #999897, -12px 24px 1px #9e9c9c;		
		}
		.t{
			text-align: center;
		}
	</style>
</head>
<body>
 	<div class="modal fade" id="login" onclick="window.location='login.php?b='">
    	<div class="modal-dialog" role="document">
      		<div class="modal-content">
        		<div class="modal-header">
       			</div>
        		<div class="modal-body">Cần đăng nhập trước khi mua</div>
        		<div class="modal-footer">
          			<button class="btn btn-primary">Đăng nhập</button>
        		</div>
      		</div>
    	</div>
  	</div>
	<?php
		if(!isset($_SESSION["cart"]) || sizeof($_SESSION["cart"])<2){
			header("Location: bookshop.php");
		}
		if(!isset($_SESSION["username"]) && !isset($_SESSION["password"])){
			echo "<script>
			    $(window).on('load',function(){
			        $('#login').modal('show');
			    });
			</script>";
			die();
		}
	?>
    <div style='text-align: center; color: blue; text-shadow: 10px 10px 10px blue;'><h1>THANH TOÁN SẢN PHẨM</h1>
	<button id='submit' class="btn-success" onclick="window.location='bookshop.php'"><i class='fas fa-sign-in-alt'></i> Tiếp tục mua hàng</button>
    </div>
<!--         <div class='input-group'>
            <input id='id' type='text' class='form-control' placeholder='Tên tài khoản' required='required' name='TK_TEN' onkeyup='checkusername()'><i id='mess1' style='font-size: 15px; position: absolute; top: 100%; left: 0%;'></i>
        </div> -->
    <div style='margin-top: 5%'> 
        <table class="table table-striped" width='100%'>
        	<tr><th></th><th>Tên sách</th><th>Tác giả</th><th>Nhà xuất bản</th><th>Thể loại</th><th>Số lượng</th><th>Giá</th></tr>
        	<?php
        		$i = 1;
        		foreach ($_SESSION["cart"] as $key => $value) {
        			if($key=="tong") continue;
        			$sql = "select SACH.*, NXB_TEN, TL_TEN from SACH, NHA_XUAT_BAN, THE_LOAI where SACH.NXB_MA = NHA_XUAT_BAN.NXB_MA and SACH.TL_MA = THE_LOAI.TL_MA and S_MA='".$key."'";
        			$result = $kn->query($sql);
        			$row = $result->fetch_assoc();
        			echo "<tr>";
        			echo "<td> <img src='./css/image book/".$row["S_ANH"]."' width='60px' height='50px' alt='hinh anh'></td>";
        			echo "<td>".$row["S_TEN"]."</td>";
        			echo "<td>".$row["S_TACGIA"]."</td>";
        			echo "<td>".$row["NXB_TEN"]."</td>";
        			echo "<td>".$row["TL_TEN"]."</td>";
        			echo "<td><input id='id".$i."' type='text' value=".$value." maxlength='3' style='width:50px;'></td>";
        			echo "<td>".$value*$row["S_GIA"]."đ</td>";
        			echo "</tr>";
        			$i++;
        		}
        		echo "<script> var i = '".($i-1)."' </script>";
        	?>
        	<tr><td colspan="7" align="right"><b>Tổng tiền:  <?php if(isset($_SESSION["cart"]["tong"])) echo $_SESSION["cart"]["tong"]; else echo "0";?>đ</b>	</td></tr>
        </table>
    </div>
    <div id="product"></div>
    <div id='logreg-forms' style='margin-top: 1%'>
		<br><br>
		<button id='submit' class='btn btn-md btn-rounded btn-block form-control submit' onclick="TT(name)" name="TTS" style="background: purple" data-toggle='modal' data-target='#myModal'><i class='fas fa-sign-in-alt'></i> Thanh toán</button>
    </div>
    <script type="text/javascript">
    	function TT(str) {
    		var c = confirm("Bạn có chắc muốn thanh toán?");
    		if (c==false) return;
        	if(str=="") return;
        	var sl=str;
        	for(var j=1;j<=i;j++){
        		sl += ","+document.getElementById("id"+j).value;
        	}
        	sl +=",";
        	var x = new XMLHttpRequest();
        	x.open("GET","product.php?product="+sl,false);
        	x.send();
        	document.getElementById('product').innerHTML = x.responseText;
        }
        function xong(){
        	window.location="bookshop.php";
        }
    </script>
</body>
</html>
<?php

?>
<!-- 					    $(window).on('load',function(){
					        $('#myModal').modal('show');
					  	}); -->
<!-- create table HOA_DON
(
   HD_MA                varchar(6) not null  comment '',
   HD_NGAY              date not null  comment '',
   NV_MA                varchar(6) not null  comment '',
   KH_MA                varchar(9) not null  comment '',
   HD_TONGTIEN          float not null comment '',
   HD_TINHTRANG         bool not null comment '',
   primary key (HD_MA, HD_NGAY)
);

/*==============================================================*/
/* Table: CHI_TIET_HOA_DON                                      */
/*==============================================================*/
create table CHI_TIET_HOA_DON
(
   HD_MA                varchar(6) not null  comment '',
   S_MA                 varchar(6) not null  comment '',
   SOLUONG 		int not null comment ''
); -->
