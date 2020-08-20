<!DOCTYPE html>
<html>
<head>
    <title>View</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/view.css">
</head>
<body>
    <?php
        $kn = new mysqli("localhost","NgocLinh","K@NgocLinh1998","LeLinh");
        if($kn->connect_error){
            die("Web đang gặp sự cố! Vui lòng trở lại sau");
        }
        $kn->set_charset("utf8");
        $s = $_GET["search"];
        $search = "<div style='text-align: center'><h3>Không tìm thấy kết quả</h3></div>";
        if(strlen($s)>0){
            $j="";
            for ($i=0;$i<strlen($s);$i++){ 
                if($s[$i]==",") break;
                $j.=$s[$i];
            }
            $k="";
            for ($i=strlen($j)+1;$i<strlen($s);$i++){ 
                $k.=$s[$i];
            }
            if($j=="TKKH"){
                if(empty($k)) die("<div style='text-align: center'><h3>Không tìm thấy kết quả</h3></div>");
                $sql = "select * from KHACH_HANG";
                $result=$kn->query($sql);
            	while ($row=$result->fetch_assoc()){
            		$a = array_values($row);	
            		for ($i=0;$i<sizeof($a);$i++){ 
            			if(stristr($a[$i],$k)){
            				if($search=="<div style='text-align: center'><h3>Không tìm thấy kết quả</h3></div>"){
    							$search = "<form method='POST'><table border='1' class='table table-striped table-dark' style='text-align: center;'><thread><tr><th scope='col'>MÃ SỐ</th><th scope='col'>TÊN TÀI KHOẢN</th><th scope='col'>MẬT KHẨU</th><th scope='col'>HỌ VÀ TÊN</th><th scope='col'>GIỚI TÍNH</th><th scope='col'>NĂM SINH</th><th scope='col'>SỐ ĐIỆN THOẠI</th><th scope='col'><button class='dropdown-item text-danger' name='updateKH1' value='update'>Cập nhật</button></th><th scope='col'><button class='dropdown-item text-danger' onclick='return checkxoa()' name='deleteKH'>Xóa</button></th></thread>";
    				            $search = $search."<tbody><tr><th scope='row'>".$a[0]."</th>";
    				            for ($i=1;$i<sizeof($a);$i++){ 
    				                $search = $search."<td>".ucwords($a[$i])."</td>";
    				            }
                                $search = $search."<td><input type='checkbox' name='checkupdateKH[]' value='".$a[0]."'></td>";
                                $search = $search."<td><input type='checkbox' name='checkdeleteKH[]' value='".$a[0]."'></td>";
    					        $search = $search."</tr></tbody>";
    		        			break;
    	        			} else {
    	        				$search = $search."<tbody><tr><th scope='row'>".$a[0]."</th>";
                                for ($i=1;$i<sizeof($a);$i++){
                                    $search = $search."<td>".ucwords($a[$i])."</td>";
                                }
                                $search = $search."<td><input type='checkbox' name='checkupdateKH[]' value='".$a[0]."'></td>";
                                $search = $search."<td><input type='checkbox' name='checkdeleteKH[]' value='".$a[0]."'></td>";
                                $search = $search."</tr></tbody>";
    	        			}
            			}
            		}
            	}
                $search = $search."</table></form>";
                echo $search;
            } else if($j=="TKS"){
                if(empty($k)) die("<div style='text-align: center'><h3>Không tìm thấy kết quả</h3></div>");
                $sql = "select * from SACH";
                $result=$kn->query($sql);
                while ($row=$result->fetch_assoc()){
                    $a = array_values($row);    
                    for ($i=0;$i<sizeof($a);$i++){ 
                        if(stristr($a[$i],$k)){
                            if($search=="<div style='text-align: center'><h3>Không tìm thấy kết quả</h3></div>"){
                                $search = "<form method='POST'><table border='1' class='table table-striped table-dark' style='text-align: center;'><thread><tr><th scope='col'>MÃ SỐ</th><th scope='col'>TÊN SÁCH</th><th scope='col'>TÁC GIẢ</th><th scope='col'>NHÀ XUẤT BẢN</th><th scope='col'>THỂ LOẠI</th><th scope='col'>MÔ TẢ</th><th scope='col'>GIÁ</th><th scope='col'>SỐ LƯỢNG</th><th scope='col'>HÌNH ẢNH</th><th scope='col'><button class='dropdown-item text-danger' name='updateS1' value='update'>Cập nhật</button></th><th scope='col'><button class='dropdown-item text-danger' onclick='return checkxoa()' name='deleteS'>Xóa</button></th></thread>";
                                $search = $search."<tbody><tr><th scope='row'>".$a[0]."</th>";
                                for ($i=1;$i<sizeof($a);$i++){ 
                                    if($i==sizeof($a)-1){
                                        $search = $search."<td> <img src='/css/image book/".$a[$i]."' width='100%' height='70px'></td>";
                                        continue;
                                    }
                                    $search = $search."<td>".ucwords($a[$i])."</td>";
                                }
                                $search = $search."<td><input type='checkbox' name='checkupdateS[]' value='".$a[0]."'></td>";
                                $search = $search."<td><input type='checkbox' name='checkdeleteS[]' value='".$a[0]."'></td>";
                                $search = $search."</tr></tbody>";
                                break;
                            } else {
                                $search = $search."<tbody><tr><th scope='row'>".$a[0]."</th>";
                                for ($i=1;$i<sizeof($a);$i++){
                                    if($i==sizeof($a)-1){
                                        $search = $search."<td> <img src='/css/image book/".$a[$i]."' width='100%' height='70px'></td>";
                                        continue;
                                    }
                                    $search = $search."<td>".ucwords($a[$i])."</td>";
                                }
                                $search = $search."<td><input type='checkbox' name='checkupdateS[]' value='".$a[0]."'></td>";
                                $search = $search."<td><input type='checkbox' name='checkdeleteS[]' value='".$a[0]."'></td>";
                                $search = $search."</tr></tbody>";
                            }
                        }
                    }
                }
                $search = $search."</table></form>";
                echo $search;
            } else if($j=="KHTKSI"){
                if(empty($k)) die("");
                $sea='';
                $sql = "select S_TEN, S_TACGIA, NXB_TEN, TL_TEN, S_MOTA, S_GIA from SACH, NHA_XUAT_BAN, THE_LOAI where SACH.NXB_MA = NHA_XUAT_BAN.NXB_MA and THE_LOAI.TL_MA = SACH.TL_MA";
                $result=$kn->query($sql);
                $l=0;
                while ($row=$result->fetch_assoc()){
                    $a = array_values($row);
                    if(stristr(mb_strtolower($a[0]),$k)){
                        $l++;
                        $sea .= "<a class='hihi' name='".$a[0]."' onclick='searchV(name)'>".$a[0]."</a><br>";
                    }
                    if($l>5) break;
                }
                $sql = "select S_TEN, S_TACGIA, NXB_TEN, TL_TEN, S_MOTA, S_GIA from SACH, NHA_XUAT_BAN, THE_LOAI where SACH.NXB_MA = NHA_XUAT_BAN.NXB_MA and THE_LOAI.TL_MA = SACH.TL_MA";
                $result=$kn->query($sql);
                while ($row=$result->fetch_assoc()){
                    $a = array_values($row);  
                    if(stristr(mb_strtolower($a[1]),$k)){
                        $l++;
                        if($l>5) break;
                        $sea .= "<a class='hihi' name='".$a[0]."' onclick='searchV(name)'>".$a[1]."</a><br>";
                    }
                    
                }
                $sql = "select S_TEN, S_TACGIA, NXB_TEN, TL_TEN, S_MOTA, S_GIA from SACH, NHA_XUAT_BAN, THE_LOAI where SACH.NXB_MA = NHA_XUAT_BAN.NXB_MA and THE_LOAI.TL_MA = SACH.TL_MA";
                $result=$kn->query($sql);
                while ($row=$result->fetch_assoc()){
                    $a = array_values($row);  
                    if(stristr(mb_strtolower($a[2]),$k)){
                        $l++;
                        if($l>5) break;
                        $sea .= "<a class='hihi' name='".$a[0]."' onclick='searchV(name)'>".$a[2]."</a><br>";
                    }
                }
                $sql = "select S_TEN, S_TACGIA, NXB_TEN, TL_TEN, S_MOTA, S_GIA from SACH, NHA_XUAT_BAN, THE_LOAI where SACH.NXB_MA = NHA_XUAT_BAN.NXB_MA and THE_LOAI.TL_MA = SACH.TL_MA";
                $result=$kn->query($sql);
                while ($row=$result->fetch_assoc()){
                    $a = array_values($row);  
                    if(stristr(mb_strtolower($a[3]),$k)){
                        $l++;
                        if($l>5) break;
                        $sea .= "<a class='hihi' name='".$a[0]."' onclick='searchV(name)'>".$a[3]."</a><br>";
                    }
                }
                $sql = "select S_TEN, S_TACGIA, NXB_TEN, TL_TEN, S_MOTA, S_GIA from SACH, NHA_XUAT_BAN, THE_LOAI where SACH.NXB_MA = NHA_XUAT_BAN.NXB_MA and THE_LOAI.TL_MA = SACH.TL_MA";
                $result=$kn->query($sql);
                while ($row=$result->fetch_assoc()){
                    $a = array_values($row);  
                    if(stristr(mb_strtolower($a[4]),$k)){
                        $l++;
                        if($l>5) break;
                        $sea .= "<a class='hihi' name='".$a[0]."' onclick='searchV(name)'>".$a[4]."</a><br>";
                    }
                }
                $sql = "select S_TEN, S_TACGIA, NXB_TEN, TL_TEN, S_MOTA, S_GIA from SACH, NHA_XUAT_BAN, THE_LOAI where SACH.NXB_MA = NHA_XUAT_BAN.NXB_MA and THE_LOAI.TL_MA = SACH.TL_MA";
                $result=$kn->query($sql);
                while ($row=$result->fetch_assoc()){
                    $a = array_values($row);  
                    if(stristr(mb_strtolower($a[5]),$k)){
                        $l++;
                        if($l>5) break;
                        $sea .= "<a class='hihi' name='".$a[0]."' onclick='searchV(name)'>".$a[5]."</a><br>";
                    }
                }
                echo $sea;     
            }else if($j=="KHTKSB"){
                if(empty($k)) die("<div style='text-align: center'><h3>Không tìm thấy kết quả</h3></div>");
                $sql = "select * from SACH";
                $result=$kn->query($sql);
                $l=0;
                while ($row=$result->fetch_assoc()){
                    $a = array_values($row);  
                    for ($i=1;$i<sizeof($a);$i++){ 
                        if($i>6) break;
                        if(stristr($a[$i],$k)){
                            $l++;
                            if($search=="<div style='text-align: center'><h3>Không tìm thấy kết quả</h3></div>"){
                                $search = "<div class='card-deck'>";
                                $search .= " <div class='card' style='border:0'>
                                                <img onclick='detailproduct(name)' name='".$a[0]."' class='card-img-top' src='./css/image book/".$a[8]."' style='width: 252px; height:350px;' alt='book'>
                                                <div class='card-body'>
                                                    <h5 class='card-title'>".$a[1]."</h5>
                                                    <p>".$a[6]." đ</p>
                                                </div>
                                              </div>";
                                              break;
                            } else {
                                $search .= "<div class='card' style='border:0'>
                                                <img onclick='detailproduct(name)' name='".$a[0]."' class='card-img-top' src='./css/image book/".$a[8]."' style='width: 252px; height:350px;' alt='book'>
                                                <div class='card-body'>
                                                    <h5 class='card-title'>".$a[1]."</h5>
                                                    <p>".$a[6]." đ</p>
                                                </div> 
                                            </div>";
                                if($l%5==0) $search .= "</div><div class='card-deck'>";
                                break;
                            }
                        }
                    }
                }
                $search .= "</div>";
                echo $search;
            }
        }
    ?>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="js/signup.js"></script>
</body>
</html>