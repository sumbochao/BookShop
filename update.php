<!DOCTYPE html>
<html>
<head>
	<title>updatedate</title>
</head>
<body>
	<?php
		$kn = new mysqli("localhost","NgocLinh","K@NgocLinh1998","LeLinh");
        if($kn->connect_error){
            die("Web đang gặp sự cố! Vui lòng trở lại sau");
        }
        $kn->set_charset("utf8");
        $temp="";
        for ($i=0;$i<strlen($_GET["update"]);$i++) { 
	        if($_GET["update"][$i]==",") break;
	        $temp.=$_GET["update"][$i];
	    }
        if($temp=="HTCNKH"){
	        $u = [];
	        $s="";
	        $j=0;
	        for ($i=7;$i<strlen($_GET["update"]);$i++) { 
	        	if($_GET["update"][$i]==",") continue;
	        	$s.=$_GET["update"][$i];
	        	if(strlen($s)==9){
	        		$u[$j]=$s;
	        		$j++;
	        		$s="";
	        	}
	        }
            $result = $kn->query("select * from KHACH_HANG");
            echo "<form method='POST'>";
            echo "<table border='1' class='table table-striped table-dark' style='text-align: center;'>";
            echo "<thread><tr><th scope='col'>MÃ SỐ</th><th scope='col'>TÊN TÀI KHOẢN</th><th scope='col'>MẬT KHẨU</th><th scope='col'>HỌ VÀ TÊN</th><th scope='col'>GIỚI TÍNH</th><th scope='col'>NĂM SINH</th><th scope='col'>SỐ ĐIỆN THOẠI</th><th scope='col'><button class='dropdown-item text-danger' name='updateKH1' value='update'>Cập nhật</button></tr></thread>";
            $j=0;
            while($row = $result->fetch_assoc()){
            	if($row["KH_MA"]!=$u[$j]) continue;
            	if($j<sizeof($u)-1)$j++;
                echo "<tbody><tr>";
                $a = array_values($row);
                echo "<th scope='row'>".$a[0]."</th>";
                for ($i=1;$i<sizeof($row);$i++) {
                    if($i==1){
                        echo "<td>".mb_strtoupper($a[$i])."</td>";
                       continue; 
                    } else if($i==2){
                        echo "<td>".$a[$i]."</td>";
                       continue; 
                    }
                    echo "<td>".ucwords($a[$i])."</td>";
                }
                echo "<td><input type='checkbox' name='checkupdateKH[]' value='".$a[0]."'></td>";
                echo "</tr></tbody>";
            }
            echo "</table>";
        } else if($temp=="CNKH"){
	        $u = [];
	        $s="";
	        $j=0;
	        for ($i=5;$i<strlen($_GET["update"]);$i++) { 
	        	if($_GET["update"][$i]==",") continue;
	        	$s.=$_GET["update"][$i];
	        	if(strlen($s)==9){
	        		$u[$j]=$s;
	        		$j++;
	        		$s="";
	        	}
	        }
	        $result = $kn->query("select * from KHACH_HANG");
	        echo "<form method='POST'>";
	        echo "<table border='1' class='table table-striped table-dark' style='text-align: center;'>";
	        echo "<thread><tr><th scope='col'>MÃ SỐ</th><th scope='col'>TÊN TÀI KHOẢN</th><th scope='col'>MẬT KHẨU</th><th scope='col'>HỌ VÀ TÊN</th><th scope='col'>GIỚI TÍNH</th><th scope='col'>NĂM SINH</th><th scope='col'>SỐ ĐIỆN THOẠI</th></tr></thread>";
	        $k=0;
	        while($row = $result->fetch_assoc()){
	        	if($row["KH_MA"]!=$u[$k]) continue;
		        if($k<sizeof($u)-1) $k++;
		       	echo "<tbody><tr>";
		        $a = array_values($row);
		        echo "<th scope='row'>".$a[0]."</th>";
		        for ($i=1;$i<sizeof($row);$i++) {
		        	if($i==1){
		             	echo "<td><input type='text' name='".$row["KH_MA"].$i."' value='".mb_strtoupper($a[$i])."'></i></td>";
		               	continue; 
		            } else if($i==2){
		             	echo "<td><input type='password' name='".$row["KH_MA"].$i."' value='".$a[$i]."'></td>";
		               	continue; 
		            } else if($i==4){
		            	if($a[$i]=="nam"){
		            		echo "<td> <select name='".$row["KH_MA"].$i."'><option value='nam' selected='selected'>Nam</option><option value='nữ'>Nữ</option></td>";
		            	} else{
							echo "<td> <select name='".$row["KH_MA"].$i."'><option value='nam'>Nam</option><option value='nữ' selected='selected'>Nữ</option></td>";	
		            	}
		            	continue;
		            } else if($i==5){
		        		echo "<td><input type='date' name='".$row["KH_MA"].$i."' value='".ucwords($a[$i])."' style='width:120px'></td>";
		        		continue;
		        	} else if($i==6){
		        		echo "<td><input type='text' name='".$row["KH_MA"].$i."' value='".ucwords($a[$i])."' style='width:106px'></td>";
						continue;
		        	}
		        	echo "<td><input type='text' name='".$row["KH_MA"].$i."' value='".ucwords($a[$i])."'></td>";
		        }
		        echo "</tr></tbody>";
	        }
	        echo "</table>";
	        echo "<button style='position: absolute;left:48%;' class='text-danger' onclick='return checkcapnhat()' name='updateKH2'>Cập nhật</button>";
	        echo "</form>";
	    } else if ($temp=="HTCNS"){
	        $u = [];
	        $s="";
	        $j=0;
	        for ($i=6;$i<strlen($_GET["update"]);$i++) { 
	        	if($_GET["update"][$i]==",") continue;
	        	$s.=$_GET["update"][$i];
	        	if(strlen($s)==6){
	        		$u[$j]=$s;
	        		$j++;
	        		$s="";
	        	}
	        }
            $result = $kn->query("select S_MA, S_TEN, S_TACGIA, NXB_TEN, TL_TEN, S_MOTA, S_GIA, S_SOLUONG, S_ANH from SACH, NHA_XUAT_BAN, THE_LOAI where SACH.NXB_MA=NHA_XUAT_BAN.NXB_MA and SACH.TL_MA=THE_LOAI.TL_MA order by S_MA");
            echo "<form method='POST'>";
            echo "<table border='1' class='table table-striped table-dark' style='text-align: center;'>";
            echo "<thread><tr><th scope='col'>MÃ SÁCH</th><th scope='col'>TÊN SÁCH</th><th scope='col'>TÁC GIẢ</th><th scope='col'>TÊN NHÀ XUẤT BẢN</th><th scope='col'>THỂ LOẠI</th><th scope='col'>MÔ TẢ</th><th scope='col'>GIÁ</th><th scope='col'>SỐ LƯỢNG</th><th scope='col'>HÌNH ẢNH</th><th scope='col'><button class='dropdown-item text-danger' name='updateS1' value='update'>Cập nhật</button></tr></thread>";
            $j=0;
            while($row = $result->fetch_assoc()){
            	if($row["S_MA"]!=$u[$j]) continue;
            	if($j<sizeof($u)-1)$j++;
                $a = array_values($row);
                echo "<tbody><tr>";
                echo "<th scope='row'>".$a[0]."</th>";
                for ($i=1;$i<sizeof($row);$i++) {
                     if($i==sizeof($row)-1){
                        echo "<td> <img src='./css/image book/".$a[$i]."' width='100%' height='70px' alt='hinh anh'></td>";
                        continue;
                    }
                    echo "<td>".$a[$i]."</td>";
                }
                echo "<td><input type='checkbox' name='checkupdateS[]' value='".$a[0]."'></td>";
                echo "</tr></tbody>";
            }	    	
	    } else if($temp=="CNS"){
	        $u = [];
	        $s="";
	        $j=0;
	        for ($i=4;$i<strlen($_GET["update"]);$i++) { 
	        	if($_GET["update"][$i]==",") continue;
	        	$s.=$_GET["update"][$i];
	        	if(strlen($s)==6){
	        		$u[$j]=$s;
	        		$j++;
	        		$s="";
	        	}
	        }
	        $result = $kn->query("select * from SACH");
	        echo "<form method='POST' enctype='multipart/form-data'>";
	        echo "<table border='1' class='table table-striped table-dark' style='text-align: center;'>";
	        echo "<thread><tr><th scope='col'>MÃ SÁCH</th><th scope='col'>TÊN SÁCH</th><th scope='col'>TÁC GIẢ</th><th scope='col'>TÊN NHÀ XUẤT BẢN</th><th scope='col'>THỂ LOẠI</th><th scope='col'>MÔ TẢ</th><th scope='col'>GIÁ</th><th scope='col'>SỐ LƯỢNG</th><th scope='col'>HÌNH ẢNH</th></tr></thread>";
	        $k=0;
	        while($row = $result->fetch_assoc()){
	        	if($row["S_MA"]!=$u[$k]) continue;
		        if($k<sizeof($u)-1) $k++;
		       	echo "<tbody><tr>";
		        $a = array_values($row);
		        echo "<th scope='row' style='width:40px'>".$a[0]."</th>";
		        for ($i=1;$i<sizeof($row);$i++) {
		        	if($i==1 || $i==2){
		             	echo "<td><input type='text' name='".$row["S_MA"].$i."' value='".mb_strtoupper($a[$i])."'></i></td>";
		               	continue; 
		            } else if($i==3){
		            	$re = $kn->query("select * from NHA_XUAT_BAN");
		            	echo "<td> <select name='".$row["S_MA"].$i."' style='width:150px'>";
		            	while($ro=$re->fetch_assoc()){
		            		if($a[$i]==$ro["NXB_MA"]){
		            			echo "<option value='".$ro["NXB_MA"]."' selected='selected'>".$ro["NXB_TEN"]."</option>";
		            			continue;
		            		}
			            	echo "<option value='".$ro["NXB_MA"]."'>".$ro["NXB_TEN"]."</option>";
			            }
			            echo "</select></td>";
		            	continue;
		            } else if($i==4){
		            	$re = $kn->query("select * from THE_LOAI");
		            	echo "<td> <select name='".$row["S_MA"].$i."' style='width:100px'>";
		            	while($ro=$re->fetch_assoc()){
		            		if($a[$i]==$ro["TL_MA"]){
		            			echo "<option value='".$ro["TL_MA"]."' selected='selected'>".$ro["TL_TEN"]."</option>";
		            			continue;
		            		}
			            	echo "<option value='".$ro["TL_MA"]."'>".$ro["TL_TEN"]."</option>";
			            }
			            echo "</select></td>";
		            	continue;
		            } else if($i==5){
		        		echo "<td><textarea name='".$row["S_MA"].$i."' style='width:200px'>".$a[$i]."</textarea></td>";
		        		continue;
		        	} else if($i==6){
		        		echo "<td><input type='text' name='".$row["S_MA"].$i."' value='".$a[$i]."' style='width:70px'></td>";
						continue;
		        	} else if($i==7){
		        		echo "<td><input type='text' name='".$row["S_MA"].$i."' value='".$a[$i]."' style='width:40px'></td>";
						continue;
		        	}else{
		        		echo "<td><img src='css/image book/".$row["S_ANH"]."'  width='50px' height='50px'><input type='file' name='".$row["S_MA"].$i."' style='width:100px'></td>";
						continue;
		        	}
		        }
		        echo "</tr></tbody>";
	        }
	        echo "</table>";
	        echo "<button style='position: absolute;left:48%;' class='text-danger' onclick='return checkcapnhat()' name='updateS2'>Cập nhật</button>";
	        echo "</form>";
	    } 
	?>
</body>
</html>