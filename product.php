<?php
	$kn= new mysqli("localhost","NgocLinh","K@NgocLinh1998","LeLinh");
	if($kn->connect_error){
		die("Web đang gặp sự cố! Vui lòng trở lại sau");
	}
	$kn->set_charset("utf8");
	date_default_timezone_set('Asia/Ho_Chi_Minh');
	session_start();
	// session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Product</title>
</head>
<body>
			<?php
				$p = $_GET["product"];


//-----------------------------------------------THÊM GIỏ HÀNG------------------------------------------------------- 




				$pro="";

				for($i=0;$i<strlen($p);$i++) {
					if($p[$i]==",") break; 
					$pro .= $p[$i];	
				}
				if($pro=="add"){
					$MA="";
					for($i=4;$i<strlen($p);$i++) {
						if($p[$i]==",") break;
						$MA .= $p[$i];	
					}
					$SL="";
					for($i=strlen($p)-1;$i>0;$i--) {
						if($p[$i]==",") break;
						$SL = $p[$i].$SL;	
					}
					$SL=(int)$SL;
					if($SL>0){
						if(!isset($_SESSION["cart"]["tong"])) $_SESSION["cart"]["tong"]=0;
						if(!isset($_SESSION["cart"][$MA])){
							$_SESSION["cart"][$MA]=$SL;
							$sql = "select * from SACH where S_MA='".$MA."'";
							$result = $kn->query($sql);
							$row = $result->fetch_assoc();
							$row["S_GIA"]*=$SL;
							$_SESSION["cart"]["tong"] += $row["S_GIA"];
							$_SESSION["p"][$MA]="<div id='".$MA."'><div class='modal-body modal-header' id='".$MA."'>
						        	<table width='100%'>
						        		<tr><td></td><th>Tên sản phẩm</th><td>Số lượng</td><td>Giá tiền</td><td></td></tr>
						        		<tr><td><img src='css/image book/".$row["S_ANH"]."'  width='100px' height='70px' alt='hinh anh'></td><th class='ts'>".$row["S_TEN"]."</th><td align='center'>".$_SESSION["cart"][$MA]."</td><td>".$row["S_GIA"]." đ</td><td class='x'><a onclick='del(name)' name='".$MA."'>xóa</a></td></tr>
						        	</table>
						        </div></div>";
						}else{
							foreach($_SESSION["cart"] as $key => $value) {
								if($key==$MA){
									$sql = "select * from SACH where S_MA='".$MA."'";
									$result = $kn->query($sql);
									$row = $result->fetch_assoc();
									$_SESSION["cart"]["tong"]-=$row["S_GIA"]*$value;
									$_SESSION["cart"][$MA]=$SL;
									if($_SESSION["cart"][$MA]>999) $_SESSION["cart"][$MA]=999;
									$_SESSION["cart"]["tong"] += $row["S_GIA"]*$SL;
									$row["S_GIA"] *= $_SESSION["cart"][$MA];
									$_SESSION["p"][$MA]="<div id='".$MA."'><div class='modal-body modal-header'>
											        	<table width='100%'>
											        		<tr><td></td><th>Tên sản phẩm</th> <td>Số lượng</td><td>Giá tiền</td><td></td></tr>
											        		<tr><td><img src='css/image book/".$row["S_ANH"]."'  width='100px' height='70px' alt='hinh anh'></td><th class='ts'>".$row["S_TEN"]."</th><td>".$_SESSION["cart"][$MA]."</td><td>".$row["S_GIA"]." đ</td><td class='x'><a onclick='del(name)' name='".$MA."'>xóa</a></td></tr>
											        	</table>
									       			</div></div>";
								}
							}
						}
						echo (sizeof($_SESSION["cart"])-1);
					}
				} 





//--------------------------------------------------HIỂN THỊ GIỏ HÀNG------------------------------------------------------





				else if ($p=="view") {
					if(isset($_SESSION["cart"]) && sizeof($_SESSION["cart"])>1){
						echo"
							<div class='modal fade' id='cart'>
							    <div class='modal-dialog modal-lg' role='document'>
							      	<div class='modal-content'>
							        	<div class='modal-header'>";
							        		if($_SESSION["cart"])
							          		echo "<h5 class='modal-title' id='slsp'>Bạn có ".(sizeof($_SESSION["cart"])-1)." sản phẩm trong giỏ hàng</h5>";
							          		else echo "<h5 class='modal-title' id='slsp'>Bạn có 0 sản phẩm trong giỏ hàng</h5>";
						echo"	          	<button class='close' type='button' data-dismiss='modal'>
							            		<span aria-hidden='true'>X</span>
							          		</button>
							        	</div>";
							        	foreach ($_SESSION["p"] as $key => $value) {
							        		echo $value;
							        	}
						echo"        	<div class='modal-footer'>
											<p id='thanhtoan'><button class='btn btn-primary' onclick='buygh()'>Thanh toán</button></p>";
											if(isset($_SESSION["cart"]["tong"])) echo "<p id='tt'>Tổng tiền: ".$_SESSION["cart"]["tong"]."đ</p>"; else echo "<p id='tt'>Tổng tiền: 0đ</p>";
						echo"	       	</div>
							    	</div>
							    </div>
							</div>
						";
					} else{
						echo"
							<div class='modal fade' id='cart'>
							    <div class='modal-dialog modal-lg' role='document'>
							      	<div class='modal-content'>
							        	<div class='modal-header'>
							          		<h5 class='modal-title' id='slsp'>Bạn có 0 sản phẩm trong giỏ hàng</h5>
							          		<button class='close' type='button' data-dismiss='modal'>
							            		<span aria-hidden='true'>X</span>
							          		</button>
							        	</div>";
						echo"        	<div class='modal-footer'>
											<p id='tt'>Tổng tiền: 0 đ</p>
							        	</div>
							    	</div>
							    </div>
							</div>
						";						
					}
				}





//-----------------------------------------------XÓA GIỏ HÀNG-------------------------------------------------------





				else if($pro=="del"){
					$MA="";
					for($i=4;$i<strlen($p);$i++) {
						if($p[$i]==",") break;
						$MA .= $p[$i];	
					}
					$sql = "select S_GIA from SACH where S_MA='".$MA."'";
					$result = $kn->query($sql);
					$row = $result->fetch_assoc();
					$_SESSION["cart"]["tong"] -= ($row["S_GIA"]*$_SESSION["cart"][$MA]);
					unset($_SESSION["cart"][$MA]);
					unset($_SESSION["p"][$MA]);
					if($_SESSION["cart"]["tong"]==0) unset($_SESSION["cart"]["tong"]);
					if(isset($_SESSION["cart"]["tong"])) echo (sizeof($_SESSION["cart"])-1).",".$_SESSION["cart"]["tong"];
					else echo "0,0";
				}





//-----------------------------------------------THANH TOÁN-------------------------------------------------------





				else if($pro=="TTS") {

				// --------------XỬ LÝ MÃ HÓA ĐƠN---------------
	

				    $result=$kn->query("select HD_MA from HOA_DON");
				    $MA=[];
				    $i=0;
				    while ($row=$result->fetch_assoc()) {
				        $sub=substr($row["HD_MA"],strrpos($row["HD_MA"],"D",0)+1,strlen($row["HD_MA"]));
				        $MA[$i] = $sub;
				        $i++;
				    }
				    if (empty($MA)){
				        $MA[0]=0;
				    }   
				    $HD = max($MA)+1;
				    $j=strlen($HD);
				    if($j<4){
				        while($j<4){
				            $HD ="0".$HD;
				            $j++;
				        }
				    }	


				// -------------------THÊM HÓA ĐƠN--------------

				    $SOLUONG=[];
				    $j=0;
				    $temp="";
					for($i=4;$i<strlen($p);$i++) {
						if($p[$i]==",") {
							$SOLUONG[$j]=$temp;
							$temp="";
							$j++;
							continue;
						}
						$temp .= $p[$i];

					}
					$sql = "select * from KHACH_HANG where KH_TAIKHOAN = '".$_SESSION["username"]."'";
					$resultKH = $kn->query($sql);
					$sql = "select NV_MA from NHAN_VIEN";
					$resultNV = $kn->query($sql);
					$rowKH = $resultKH->fetch_assoc();
					$rowNV = $resultNV->fetch_assoc();
					$i=0;
					foreach ($_SESSION["cart"] as $key => $value) {
						if($key=="tong") continue;
						$sql = "select * from SACH where S_MA='".$key."'";
						$result = $kn->query($sql);
						$row = $result->fetch_assoc();
						$_SESSION["cart"]["tong"] -= ($row["S_GIA"]*$value);
						$_SESSION["cart"]["tong"] += ($row["S_GIA"]*$SOLUONG[$i]);
						$_SESSION["cart"][$key]=$SOLUONG[$i];
						$i++;
					}
					$sql = "insert into HOA_DON values('HD".$HD."',now(),'".$rowNV["NV_MA"]."','".$rowKH["KH_MA"]."','".$_SESSION["cart"]["tong"]."','1')";
					if($kn->query($sql)){
						foreach ($_SESSION["cart"] as $key => $value) {
							if($key=="tong") continue;
							$sql = "select * from SACH where S_MA='".$key."'";
							$result = $kn->query($sql);
							$row = $result->fetch_assoc();
							$sql = "insert into CHI_TIET_HOA_DON values('HD".$HD."','".$row["S_MA"]."','".$value."')";
							$kn->query($sql);
						}
				    	$kh = $kn->query("select * from KHACH_HANG where KH_TAIKHOAN='".$_SESSION["username"]."'");
				    	$nv = $kn->query("select * from NHAN_VIEN");
				    	$hd = $kn->query("select * from HOA_DON where HD_MA = 'HD".$HD."'");
				    	$k = $kh->fetch_assoc();
				    	$n = $nv->fetch_assoc();
				    	$h = $hd->fetch_assoc();
						echo "<div id='myModal' class='modal fade' role='dialog' onclick='xong()'>
							  	<div class='modal-dialog modal-lg'>
							   		<div class='modal-content'>
							     		<div class='modal-body'>
							        		<h3 align='center' style='text-shadow: 10px 10px 10px lightgreen; color: green;'>HÓA ĐƠN</h3>
							        		<table width='100%'>
								        		<tr><td align='left'>Người lập: <b>".ucwords($n["NV_TEN"])."</b></td><td align='right'>Số hóa đơn: <b>".$h["HD_MA"]."</b><td></tr>
								     			<tr><td></td><td align='right'>Ngày lập: <b>".date('H:i:s - d/m/Y',strtotime($h["HD_NGAY"]))."</b></td></tr>
							     			</table>
							      		</div>
							     		<div class='modal-footer'>
							     			<table width='100%'>
								        		<tr><td align='left'>Khách hàng: <b>".ucwords($k["KH_TEN"])."</b></td><td align='right'>Điện thoại: <b>".$k["KH_SDT"]."</b></td></tr>
												<tr><td align='left'>Tài khoản: <b>".$k["KH_TAIKHOAN"]."</b></td></tr>
											</table>
							      		</div>
							     		<div class='modal-body'>
							     			<table width='100%' class='t'>
								        		<tr><th>Số thứ tự</th><th>Tên sách</th><th>Đơn giá</th><th>Số lượng</th><th>Thành tiền</th></tr>";
								        			$re = $kn->query("select * from CHI_TIET_HOA_DON, HOA_DON, SACH where SACH.S_MA = CHI_TIET_HOA_DON.S_MA and CHI_TIET_HOA_DON.HD_MA = HOA_DON.HD_MA and CHI_TIET_HOA_DON.HD_MA = '".$h["HD_MA"]."'");
								        			$i=1;
											    	while ($row = $re->fetch_assoc()){
											    		echo "<tr>
											    			<td>$i</td>
												    		<td>".$row["S_TEN"]."</td>
												    		<td>".$row["S_GIA"]."đ</td>
												    		<td>".$row["SOLUONG"]."</td>
												    		<td>".$row["S_GIA"]*$row["SOLUONG"]."đ</td>
											    		</tr>";
											    		$i++;
											    	}
						echo"				</table>
							      		</div>
							      		<div class='modal-footer'>
							      			<p align='right'>Tổng số tiền đã thanh toán: <b>".$h["HD_TONGTIEN"]."đ</b></p>
							        		<p><button type='button' class='btn-primary' data-dismiss='modal'>Close</button></p>
							     		</div>
							    	</div>
								</div>
							</div>";
						unset($_SESSION["cart"]);
						unset($_SESSION["p"]);
					} else {
						echo "<script>
							alert('Xảy ra lỗi! Vui lòng thử lại');
						</script>";
					}

				}







//------------------------------------------CHI TIẾT HÓA ĐƠN--------------------------------------------------




				else if ($pro=="xem") {
					$MA="";
					for($i=4;$i<strlen($p);$i++) {
						if($p[$i]==",") break;
						$MA .= $p[$i];
					}
					$NGAY="";
					for($i=strlen($p)-1;$i>-1;$i--) {
						if($p[$i]==",") break;
						$NGAY = $p[$i].$NGAY;	
					}
	    			$result = $kn->query("select * from CHI_TIET_HOA_DON, HOA_DON, SACH, KHACH_HANG, NHAN_VIEN where SACH.S_MA = CHI_TIET_HOA_DON.S_MA and CHI_TIET_HOA_DON.HD_MA = HOA_DON.HD_MA and HOA_DON.KH_MA = KHACH_HANG.KH_MA and NHAN_VIEN.NV_MA = HOA_DON.NV_MA and KH_TAIKHOAN = '".$_SESSION["username"]."' and HOA_DON.HD_MA = '".$MA."' and HOA_DON.HD_NGAY = '".$NGAY."'");
	    			$row = $result->fetch_assoc();
					echo "<div id='xem' class='modal fade' role='dialog' onclick='xong()' style='z-index: 2048'>
						  	<div class='modal-dialog modal-lg'>
						   		<div class='modal-content'>
						     		<div class='modal-body'>
						        		<h3 align='center' style='text-shadow: 10px 10px 10px lightgreen; color: green;'>HÓA ĐƠN</h3>
						        		<table width='100%'>
							        		<tr><td align='left'>Người lập: <b>".ucwords($row["NV_TEN"])."</b></td><td align='right'>Số hóa đơn: <b>".$row["HD_MA"]."</b><td></tr>
							     			<tr><td></td><td align='right'>Ngày lập: <b>".date('H:i:s - d/m/Y',strtotime($row["HD_NGAY"]))."</b></td></tr>
						     			</table>
						      		</div>
						     		<div class='modal-footer'>
						     			<table width='100%'>
							        		<tr><td align='left'>Khách hàng: <b>".ucwords($row["KH_TEN"])."</b></td><td align='right'>Điện thoại: <b>".$row["KH_SDT"]."</b></td></tr>
											<tr><td align='left'>Tài khoản: <b>".$row["KH_TAIKHOAN"]."</b></td></tr>
										</table>
						      		</div>
						     		<div class='modal-body'>
						     			<table width='100%' class='t'>
							        		<tr><th>Số thứ tự</th><th>Tên sách</th><th>Đơn giá</th><th>Số lượng</th><th>Thành tiền</th></tr>";
							        			$re = $kn->query("select * from CHI_TIET_HOA_DON, HOA_DON, SACH where SACH.S_MA = CHI_TIET_HOA_DON.S_MA and CHI_TIET_HOA_DON.HD_MA = HOA_DON.HD_MA and CHI_TIET_HOA_DON.HD_MA = '".$row["HD_MA"]."'");
							        			$i=1;
										    	while ($r = $re->fetch_assoc()){
										    		echo "<tr>
										    			<td>$i</td>
											    		<td>".$r["S_TEN"]."</td>
											    		<td>".$r["S_GIA"]."đ</td>
											    		<td>".$r["SOLUONG"]."</td>
											    		<td>".$r["S_GIA"]*$r["SOLUONG"]."đ</td>
										    		</tr>";
										    		$i++;
										    	}
					echo"				</table>
						      		</div>
						      		<div class='modal-footer'>
						      			<p align='right'>Tổng số tiền đã thanh toán: <b>".$row["HD_TONGTIEN"]."đ</b></p>
						        		<p><button type='button' class='btn-primary' data-dismiss='modal'>Close</button></p>
						     		</div>
						    	</div>
							</div>
						</div>";	
				}








//---------------------------------------------ĐÁNH GIÁ-------------------------------------------------






				else if($pro=="report"){
					$MS="";
					for($i=strlen($pro)+1;$i<strlen($p);$i++) {
						if($p[$i]==",") break;
						$MS .= $p[$i];	
					}

					$ID="";
					for($i=strlen($MS)+strlen($pro)+2;$i<strlen($p);$i++) {
						if($p[$i]==",") break;
						$ID .= $p[$i];
					}

					$content="";
					for($i=strlen($MS)+strlen($pro)+strlen($ID)+3;$i<strlen($p);$i++) {
						$content .= $p[$i];	
					}

					$ID_P="";
					for($i=0;$i<strlen($ID);$i++) {
						if($ID[$i]=="l" || $ID[$i]=="i" || $ID[$i]=="n" || $ID[$i]=="h") continue;
						$ID_P .= $ID[$i];
					}

					if($ID==""){
						$sql = "insert into DANH_GIA(TAI_KHOAN,S_MA,NOI_DUNG,NGAY) values('".$_SESSION["username"]."','".$MS."','".$content."',now())";
						$kn->query($sql);
						$sql = "select * from DANH_GIA where S_MA='".$MS."' and ID_P='0' ORDER BY ID desc";
						$result = $kn->query($sql);
						while($row = $result->fetch_assoc()){
							echo"<div class='panel panel-default'>
									<div class='panel-footer'>
										<b style='font-size: 22px'>&emsp;&emsp;".$row["TAI_KHOAN"]." </b><i>" .date('H:i:s - d/m/Y',strtotime($row["NGAY"]))."</i>
									</div>
								  	<div class='panel-body'>
								  		&emsp;&emsp;&emsp;&emsp;".$row["NOI_DUNG"]."
									    <br><br>
									    &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<input type='text' id='linh".$row["ID"]."' style='width: 35%;'><button onclick='report1(name)' name='report,".$MS.",linh".$row["ID"]."'>Trả lời</button>
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
					} else{
						$sql = "insert into DANH_GIA(ID_P,TAI_KHOAN,S_MA,NOI_DUNG,NGAY) values('".$ID_P."','".$_SESSION["username"]."','".$MS."','".$content."',now())";

						$kn->query($sql);
						$sql = "select * from DANH_GIA where S_MA='".$MS."' and ID_P='0' ORDER BY ID desc";
						$result = $kn->query($sql);
						while($row = $result->fetch_assoc()){
							echo"<div class='panel panel-default'>
									<div class='panel-footer'>
										<b style='font-size: 22px'>&emsp;&emsp;".$row["TAI_KHOAN"]." </b><i>" .date('H:i:s - d/m/Y',strtotime($row["NGAY"]))."</i>
									</div>
								  	<div class='panel-body'>
								  		&emsp;&emsp;&emsp;&emsp;".$row["NOI_DUNG"]."
									    <br><br>
									    &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<input type='text' id='linh".$row["ID"]."' style='width: 35%;'><button onclick='report1(name)' name='report,".$MS.",linh".$row["ID"]."'>Trả lời</button>
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
					}
				}







//---------------------------------------HIỂN THỊ THỂ LOẠI GIÁO TRÌNH---------------------------------------------- 




				else if($p=="GT001"){
					$count = $kn->query("select count(*) from SACH where TL_MA = 'GT001'");
					$c = $count->fetch_assoc();
					for ($i=0;$i<$c["count(*)"]; $i+=5) { 
						echo "<div class='card-deck'>";
						$sql="select * from SACH where TL_MA = 'GT001' limit $i,5";
						$result=$kn->query($sql);
						while($row=$result->fetch_assoc()){
							echo"<div class='card' style='border:0'>
									<img onclick='detailproduct(name)' name='".$row["S_MA"]."' class='card-img-top' src='./css/image book/".$row["S_ANH"]."' style='width: 252px; height:350px;' alt='book'>
									<div class='card-body'>
									<h5 class='card-title'>".$row["S_TEN"]."</h5>
									<p class='card-text'>".$row["S_GIA"]." đ</p>
									</div>
								</div>";
						}
						echo "</div>";
					}




//---------------------------------------HIỂN THỊ THỂ LOẠI CÔNG NGHỆ THÔNG TIN------------------------------------------- 



				} else if($p=="IF001"){
					$count = $kn->query("select count(*) from SACH where TL_MA = 'IF001'");
					$c = $count->fetch_assoc();
					for ($i=0;$i<$c["count(*)"]; $i+=5) { 
						echo "<div class='card-deck'>";
						$sql="select * from SACH where TL_MA = 'IF001' limit $i,5";
						$result=$kn->query($sql);
						while($row=$result->fetch_assoc()){
							echo"<div class='card' style='border:0'>
									<img onclick='detailproduct(name)' name='".$row["S_MA"]."' class='card-img-top' src='./css/image book/".$row["S_ANH"]."' style='width: 252px; height:350px;' alt='book'>
									<div class='card-body'>
									<h5 class='card-title'>".$row["S_TEN"]."</h5>
									<p class='card-text'>".$row["S_GIA"]." đ</p>
									</div>
								</div>";
						}
						echo "</div>";
					}




//---------------------------------------HIỂN THỊ THỂ LOẠI KHOA HỌC CÔNG NGHỆ----------------------------------------------



				} else if($p=="KH012"){
					$count = $kn->query("select count(*) from SACH where TL_MA = 'KH012'");
					$c = $count->fetch_assoc();
					for ($i=0;$i<$c["count(*)"]; $i+=5) { 
						echo "<div class='card-deck'>";
						$sql="select * from SACH where TL_MA = 'KH012' limit $i,5";
						$result=$kn->query($sql);
						while($row=$result->fetch_assoc()){
							echo"<div class='card' style='border:0'>
									<img onclick='detailproduct(name)' name='".$row["S_MA"]."' class='card-img-top' src='./css/image book/".$row["S_ANH"]."' style='width: 252px; height:350px;' alt='book'>
									<div class='card-body'>
									<h5 class='card-title'>".$row["S_TEN"]."</h5>
									<p class='card-text'>".$row["S_GIA"]." đ</p>
									</div>
								</div>";
						}
						echo "</div>";
					}



//---------------------------------------HIỂN THỊ THỂ LOẠI KINH TẾ----------------------------------------------



				} else if($p=="KT001"){
					$count = $kn->query("select count(*) from SACH where TL_MA = 'KT001'");
					$c = $count->fetch_assoc();
					for ($i=0;$i<$c["count(*)"]; $i+=5) { 
						echo "<div class='card-deck'>";
						$sql="select * from SACH where TL_MA = 'KT001' limit $i,5";
						$result=$kn->query($sql);
						while($row=$result->fetch_assoc()){
							echo"<div class='card' style='border:0'>
									<img onclick='detailproduct(name)' name='".$row["S_MA"]."' class='card-img-top' src='./css/image book/".$row["S_ANH"]."' style='width: 252px; height:350px;' alt='book'>
									<div class='card-body'>
									<h5 class='card-title'>".$row["S_TEN"]."</h5>
									<p class='card-text'>".$row["S_GIA"]." đ</p>
									</div>
								</div>";
						}
						echo "</div>";
					}




//---------------------------------------HIỂN THỊ THỂ LOẠI LỊCH SỬ----------------------------------------------



				} else if($p=="LS001"){
					$count = $kn->query("select count(*) from SACH where TL_MA = 'LS001'");
					$c = $count->fetch_assoc();
					for ($i=0;$i<$c["count(*)"]; $i+=5) { 
						echo "<div class='card-deck'>";
						$sql="select * from SACH where TL_MA = 'LS001' limit $i,5";
						$result=$kn->query($sql);
						while($row=$result->fetch_assoc()){
							echo"<div class='card' style='border:0'>
									<img onclick='detailproduct(name)' name='".$row["S_MA"]."' class='card-img-top' src='./css/image book/".$row["S_ANH"]."' style='width: 252px; height:350px;' alt='book'>
									<div class='card-body'>
									<h5 class='card-title'>".$row["S_TEN"]."</h5>
									<p class='card-text'>".$row["S_GIA"]." đ</p>
									</div>
								</div>";
						}
						echo "</div>";
					}



//-----------------------------------------HIỂN THỊ THỂ LOẠI MANGA - COMIC----------------------------------------------



				} else if($p=="MG001"){
					$count = $kn->query("select count(*) from SACH where TL_MA = 'MG001'");
					$c = $count->fetch_assoc();
					for ($i=0;$i<$c["count(*)"]; $i+=5) { 
						echo "<div class='card-deck'>";
						$sql="select * from SACH where TL_MA = 'MG001' limit $i,5";
						$result=$kn->query($sql);
						while($row=$result->fetch_assoc()){
							echo"<div class='card' style='border:0'>
									<img onclick='detailproduct(name)' name='".$row["S_MA"]."' class='card-img-top' src='./css/image book/".$row["S_ANH"]."' style='width: 252px; height:350px;' alt='book'>
									<div class='card-body'>
									<h5 class='card-title'>".$row["S_TEN"]."</h5>
									<p class='card-text'>".$row["S_GIA"]." đ</p>
									</div>
								</div>";
						}
						echo "</div>";
					}



//-----------------------------------------HIỂN THỊ THỂ LOẠI THAM KHẢO----------------------------------------------



				} else if($p=="TK001"){
					$count = $kn->query("select count(*) from SACH where TL_MA = 'TK001'");
					$c = $count->fetch_assoc();
					for ($i=0;$i<$c["count(*)"]; $i+=5) { 
						echo "<div class='card-deck'>";
						$sql="select * from SACH where TL_MA = 'TK001' limit $i,5";
						$result=$kn->query($sql);
						while($row=$result->fetch_assoc()){
							echo"<div class='card' style='border:0'>
									<img onclick='detailproduct(name)' name='".$row["S_MA"]."' class='card-img-top' src='./css/image book/".$row["S_ANH"]."' style='width: 252px; height:350px;' alt='book'>
									<div class='card-body'>
									<h5 class='card-title'>".$row["S_TEN"]."</h5>
									<p class='card-text'>".$row["S_GIA"]." đ</p>
									</div>
								</div>";
						}
						echo "</div>";
					}



//-----------------------------------------HIỂN THỊ THỂ LOẠI SÁCH THIẾU NHI----------------------------------------------



				} else if($p=="TN102"){
					$count = $kn->query("select count(*) from SACH where TL_MA = 'TN102'");
					$c = $count->fetch_assoc();
					for ($i=0;$i<$c["count(*)"]; $i+=5) { 
						echo "<div class='card-deck'>";
						$sql="select * from SACH where TL_MA = 'TN102' limit $i,5";
						$result=$kn->query($sql);
						while($row=$result->fetch_assoc()){
							echo"<div class='card' style='border:0'>
									<img onclick='detailproduct(name)' name='".$row["S_MA"]."' class='card-img-top' src='./css/image book/".$row["S_ANH"]."' style='width: 252px; height:350px;' alt='book'>
									<div class='card-body'>
									<h5 class='card-title'>".$row["S_TEN"]."</h5>
									<p class='card-text'>".$row["S_GIA"]." đ</p>
									</div>
								</div>";
						}
						echo "</div>";
					}




//-----------------------------------------HIỂN THỊ THỂ LOẠI TRUYỆN TRANH----------------------------------------------



				} else if($p=="TT023"){
					$count = $kn->query("select count(*) from SACH where TL_MA = 'TT023'");
					$c = $count->fetch_assoc();
					for ($i=0;$i<$c["count(*)"]; $i+=5) { 
						echo "<div class='card-deck'>";
						$sql="select * from SACH where TL_MA = 'TT023' limit $i,5";
						$result=$kn->query($sql);
						while($row=$result->fetch_assoc()){
							echo"<div class='card' style='border:0'>
									<img onclick='detailproduct(name)' name='".$row["S_MA"]."' class='card-img-top' src='./css/image book/".$row["S_ANH"]."' style='width: 252px; height:350px;' alt='book'>
									<div class='card-body'>
									<h5 class='card-title'>".$row["S_TEN"]."</h5>
									<p class='card-text'>".$row["S_GIA"]." đ</p>
									</div>
								</div>";
						}
						echo "</div>";
					}



//----------------------------------------HIỂN THỊ THỂ LOẠI VĂN HỌC NGHỆ THUẬT--------------------------------------------



				} else if($p=="VH001"){
					$count = $kn->query("select count(*) from SACH where TL_MA = 'VH001'");
					$c = $count->fetch_assoc();
					for ($i=0;$i<$c["count(*)"]; $i+=5) { 
						echo "<div class='card-deck'>";
						$sql="select * from SACH where TL_MA = 'VH001' limit $i,5";
						$result=$kn->query($sql);
						while($row=$result->fetch_assoc()){
							echo"<div class='card' style='border:0'>
									<img onclick='detailproduct(name)' name='".$row["S_MA"]."' class='card-img-top' src='./css/image book/".$row["S_ANH"]."' style='width: 252px; height:350px;' alt='book'>
									<div class='card-body'>
									<h5 class='card-title'>".$row["S_TEN"]."</h5>
									<p class='card-text'>".$row["S_GIA"]." đ</p>
									</div>
								</div>";
						}
						echo "</div>";
					}



//-----------------------------------------HIỂN THỊ THỂ LOẠI VĂN HỌC XÃ HỘI----------------------------------------------




				}else if($p=="VH002"){
					$count = $kn->query("select count(*) from SACH where TL_MA = 'VH002'");
					$c = $count->fetch_assoc();
					for ($i=0;$i<$c["count(*)"]; $i+=5) { 
						echo "<div class='card-deck'>";
						$sql="select * from SACH where TL_MA = 'VH002' limit $i,5";
						$result=$kn->query($sql);
						while($row=$result->fetch_assoc()){
							echo"<div class='card' style='border:0'>
									<img onclick='detailproduct(name)' name='".$row["S_MA"]."' class='card-img-top' src='./css/image book/".$row["S_ANH"]."' style='width: 252px; height:350px;' alt='book'>
									<div class='card-body'>
									<h5 class='card-title'>".$row["S_TEN"]."</h5>
									<p class='card-text'>".$row["S_GIA"]." đ</p>
									</div>
								</div>";
						}
						echo "</div>";
					}



//--------------------------------------HIỂN THỊ THỂ LOẠI Y HỌC - SỨC KHỎE--------------------------------------------



				}else if($p=="YH001"){
					$count = $kn->query("select count(*) from SACH where TL_MA = 'YH001'");
					$c = $count->fetch_assoc();
					for ($i=0;$i<$c["count(*)"]; $i+=5) { 
						echo "<div class='card-deck'>";
						$sql="select * from SACH where TL_MA = 'YH001' limit $i,5";
						$result=$kn->query($sql);
						while($row=$result->fetch_assoc()){
							echo"<div class='card' style='border:0'>
									<img onclick='detailproduct(name)' name='".$row["S_MA"]."' class='card-img-top' src='./css/image book/".$row["S_ANH"]."' style='width: 252px; height:350px;' alt='book'>
									<div class='card-body'>
									<h5 class='card-title'>".$row["S_TEN"]."</h5>
									<p class='card-text'>".$row["S_GIA"]." đ</p>
									</div>
								</div>";
						}
						echo "</div>";
					}



//-------------------------------------------HIỂN THỊ SẢN PHẨM-------------------------------------------------



				}else if($p=="linh"){
					$count=$kn->query("select count(*) from SACH");
					$c=$count->fetch_assoc();
					if($c["count(*)"]<5){
						for ($i=$c["count(*)"]; $i>=0;$i-=5) {
							echo "<div class='card-deck'>";
							$sql="select * from SACH limit $i";
							$result=$kn->query($sql);
							while($row=$result->fetch_assoc()){
								echo"<div class='card' style='border:0'>
										<img onclick='detailproduct(name)' name='".$row["S_MA"]."' class='card-img-top' src='./css/image book/".$row["S_ANH"]."' style='width: 252px; height:350px;' alt='book'>
										<div class='card-body'>
											<h5 class='card-title'>".$row["S_TEN"]."</h5>
											<p class='card-text'>".$row["S_GIA"]." đ</p>
										</div>
									</div>
								";
							}
							echo "</div>";
						}						
					} else if($c["count(*)"]<10 && $c["count(*)"]>=5){
						for ($i=$c["count(*)"]; $i>=$c["count(*)"]-5;$i-=5) {
							echo "<div class='card-deck'>";
							$sql="select * from SACH limit $i,5";
							$result=$kn->query($sql);
							while($row=$result->fetch_assoc()){
								echo"<div class='card' style='border:0'>
										<img onclick='detailproduct(name)' name='".$row["S_MA"]."' class='card-img-top' src='./css/image book/".$row["S_ANH"]."' style='width: 252px; height:350px;' alt='book'>
										<div class='card-body'>
											<h5 class='card-title'>".$row["S_TEN"]."</h5>
											<p class='card-text'>".$row["S_GIA"]." đ</p>
										</div>
									</div>
								";
							}
							echo "</div>";
						}						
					} else if($c["count(*)"]<15 && $c["count(*)"]>=10){
						for ($i=$c["count(*)"]-5; $i>=$c["count(*)"]-(5*2);$i-=5) {
							echo "<div class='card-deck'>";
							$sql="select * from SACH limit $i,5";
							$result=$kn->query($sql);
							while($row=$result->fetch_assoc()){
								echo"<div class='card' style='border:0'>
										<img onclick='detailproduct(name)' name='".$row["S_MA"]."' class='card-img-top' src='./css/image book/".$row["S_ANH"]."' style='width: 252px; height:350px;' alt='book'>
										<div class='card-body'>
											<h5 class='card-title'>".$row["S_TEN"]."</h5>
											<p class='card-text'>".$row["S_GIA"]." đ</p>
										</div>
									</div>
								";
							}
							echo "</div>";
						}
					} else {
						for ($i=$c["count(*)"]-5; $i>=$c["count(*)"]-(5*3);$i-=5) {
							echo "<div class='card-deck'>";
							$sql="select * from SACH limit $i,5";
							$result=$kn->query($sql);
							while($row=$result->fetch_assoc()){
								echo"<div class='card' style='border:0'>
										<img onclick='detailproduct(name)' name='".$row["S_MA"]."' class='card-img-top' src='./css/image book/".$row["S_ANH"]."' style='width: 252px; height:350px;' alt='book'>
										<div class='card-body'>
											<h5 class='card-title'>".$row["S_TEN"]."</h5>
											<p class='card-text'>".$row["S_GIA"]." đ</p>
										</div>
									</div> 
								";
							}
							echo "</div>";
						}					
					}
				}

			?>
</body>
</html>