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
        $v = $_GET["view"];
        if ($v=="HTKH"){
            $result = $kn->query("select * from KHACH_HANG;");
            echo "<table border='1' class='table table-striped table-dark' style='text-align: center;'>";
            echo "<thread><tr><th scope='col'>MÃ SỐ</th><th scope='col'>TÊN TÀI KHOẢN</th><th scope='col'>MẬT KHẨU</th><th scope='col'>HỌ VÀ TÊN</th><th scope='col'>GIỚI TÍNH</th><th scope='col'>NĂM SINH</th><th scope='col'>SỐ ĐIỆN THOẠI</th></tr></thread>";
            while($row = $result->fetch_assoc()){
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
                echo "</tr></tbody>";
            }
            echo "</table>";
        } elseif ($v=="TKH") {
            echo "
                <div style='text-align: center; color: blue'><h1> THÊM KHÁCH HÀNG </h1></div>
                <div id='logreg-forms' style='margin-top: 1%'>
                    <form method='post'>

                        <div class='input-group'>
                            <input id='id' type='text' class='form-control' placeholder='Tên tài khoản' required='required' name='TK_TEN' onkeyup='checkusername()'><i id='mess1' style='font-size: 15px; position: absolute; top: 100%; left: 0%;'></i>
                        </div>
                        <br>
                        <div class='input-group'>
                            <input id='pwd' type='password' class='form-control' placeholder='Mật khẩu' required='required' name='TK_MATKHAU' onkeyup='checkconfirm()'><i id='mess2' style='font-size: 15px; position: absolute; top: 100%; left: 0%;'></i>
                        </div>
                        <br>
                        <div class='input-group'>
                            <input id='confirm' type='password' class='form-control' placeholder='Xác nhận mật khẩu' required='required' onkeyup='checkconfirm()'><i id='mess3' style='font-size: 15px; position: absolute; top: 27%; left: 100.5%;'></i>
                        </div>
                        <br>
                        <div class='input-group'>
                            <input type='text' class='form-control' placeholder='Họ và tên' required='required' name='KH_TEN' id='hoten' onkeyup='checkhoten()'><i id='mess4' style='font-size: 15px; position: absolute; top: 100%; left: 0%;'></i>
                        </div>
                        <br>
                        <div class='input-group' style='color: grey;'>
                            <table>
                                <tr><td> Giới tính:&emsp;</td><td><input type='radio' class='form-control' required='required' name='KH_GIOITINH' value='nam'></td><td>Nam </td><td>&emsp;</td><td><input type='radio' class='form-control' required='required' name='KH_GIOITINH' value='nữ'></td><td>Nữ</td></tr>
                            </table>
                        </div>
                        <br>    
                        <div class='input-group'>
                            <input type='date' class='form-control' placeholder='Năm sinh' required='required' name='KH_NAMSINH'>
                        </div>
                        <br>
                        <div class='input-group'>
                            <input type='text' class='form-control' placeholder='Số điện thoại' required='required' name='KH_SDT' id='sdt' onkeyup
                            ='checksdt()'><i id='mess5' style='font-size: 15px; position: absolute; top: 27%; left: 100.5%;'></i>
                        </div>
                        <br>
                        <div class='input-group'>
                          <button id='submit' onclick='return checksubmitKH()' class='btn btn-md btn-rounded btn-block form-control submit' type='submit' name='addKH'><i class='fas fa-sign-in-alt'></i> Thêm</button>
                        </div>
                    </form>
                </div>";
        } else if($v=="CNKH"){
            $result = $kn->query("select * from KHACH_HANG ");
            echo "<form method='POST'>";
            echo "<table border='1' class='table table-striped table-dark' style='text-align: center;'>";
            echo "<thread><tr><th scope='col'>MÃ SỐ</th><th scope='col'>TÊN TÀI KHOẢN</th><th scope='col'>MẬT KHẨU</th><th scope='col'>HỌ VÀ TÊN</th><th scope='col'>GIỚI TÍNH</th><th scope='col'>NĂM SINH</th><th scope='col'>SỐ ĐIỆN THOẠI</th><th scope='col'><button class='dropdown-item text-danger' name='updateKH1' value='update'>Cập nhật</button></th></tr></thread>";
            while($row = $result->fetch_assoc()){
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
            echo "</form>";
        } else if($v=="XKH"){
            $result = $kn->query("select * from KHACH_HANG");
            echo "<form method='POST'>";
            echo "<table border='1' class='table table-striped table-dark' style='text-align: center;'>";
            echo "<thread><tr><th scope='col'>MÃ SỐ</th><th scope='col'>TÊN TÀI KHOẢN</th><th scope='col'>MẬT KHẨU</th><th scope='col'>HỌ VÀ TÊN</th><th scope='col'>GIỚI TÍNH</th><th scope='col'>NĂM SINH</th><th scope='col'>SỐ ĐIỆN THOẠI</th><th scope='col'><button class='dropdown-item text-danger' onclick='return checkxoa()' name='deleteKH'>Xóa</button></th></tr></thread>";
            while($row = $result->fetch_assoc()){
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
                echo "<td><input type='checkbox' name='checkdeleteKH[]' value='".$a[0]."'></td>";
                echo "</tr></tbody>";
            }
            echo "</table>";
            echo "</form>";
        } else if ($v=="HTS"){
            $result = $kn->query("select S_MA, S_TEN, S_TACGIA, NXB_TEN, TL_TEN, S_MOTA, S_GIA, S_SOLUONG, S_ANH from SACH, NHA_XUAT_BAN, THE_LOAI where SACH.NXB_MA=NHA_XUAT_BAN.NXB_MA and SACH.TL_MA=THE_LOAI.TL_MA order by S_MA");
            echo "<table border='1' class='table table-striped table-dark' style='text-align: center;'>";
            echo "<thread><tr><th scope='col'>MÃ SỐ</th><th scope='col'>TÊN SÁCH</th><th scope='col'>TÁC GIẢ</th><th scope='col'>NHÀ XUẤT BẢN</th><th scope='col'>THỂ LOẠI</th><th scope='col'>MÔ TẢ</th><th scope='col'>GIÁ</th><th scope='col'>SỐ LƯỢNG</th><th scope='col'>HÌNH ẢNH</th></tr></thread>";
            while($row = $result->fetch_assoc()){
                $a = array_values($row);
                echo "<tbody><tr>";
                echo "<th scope='row'>".$a[0]."</th>";
                for ($i=1;$i<sizeof($row);$i++) { 
                    if($i==1 || $i==2){
                        echo "<td>".mb_strtoupper($a[$i])."</td>";
                        continue;
                    } else if($i==sizeof($row)-1){
                        echo "<td> <img src='./css/image book/".$a[$i]."' width='100%' height='70px' alt='hinh anh'></td>";
                        continue;
                    } else if($i==5){
                        echo "<td>".$a[$i]."</td>";
                        continue;
                    } else{
                        echo "<td>".ucwords($a[$i])."</td>";
                    }
                }
                echo "</tr></tbody>";
            }
            echo "</table>";
        } else if ($v=="TS"){
            $NXB = $kn->query("select * from NHA_XUAT_BAN");
            $TL = $kn->query("select * from THE_LOAI");
            echo "
                <div style='text-align: center; color: blue'><h1> THÊM SÁCH </h1></div>
                <div id='logreg-forms' style='margin-top: 1%'>
                    <form method='POST' enctype='multipart/form-data'>
                        <div class='input-group'>
                            <input type='text' class='form-control' placeholder='Tên sách' required='required' id='ts' name='S_TEN' onkeyup='checkbookname()'><i id='mess1' style='font-size: 15px; position: absolute; top: 100%; left: 0%;'></i>
                        </div>
                        <br>
                        <div class='input-group'>
                            <input type='text' class='form-control' placeholder='Tác giả' required='required' name='S_TACGIA'>
                        </div>
                        <br>
                        <div class='input-group'>
                            <select name='NXB_MA' class='form-control' required='required'>
                                <option value=''>Nhà xuất bản</option>";
                                while($row = $NXB->fetch_assoc()) {
                                    echo"
                                        <option value='".$row["NXB_MA"]."'>".$row["NXB_TEN"]."</option>
                                    ";
                                }
            echo "          </select>
                        </div>
                        <br>
                        <div class='input-group'>
                            <select name='TL_MA' class='form-control' style='text-decoration: none' required='required'>
                                <option value=''>Thể loại</option>";
                                while($row = $TL->fetch_assoc()) {
                                    echo"
                                        <option value='".$row["TL_MA"]."'>".$row["TL_TEN"]."</option>
                                    ";
                                }
            echo "          </select>
                        </div>
                        <br>
                        <div class='input-group'>
                            <textarea required='required' name='S_MOTA' style='width: 100%;'></textarea>
                        </div>
                        <br>
                        <div class='input-group'>
                            <input type='text' class='form-control' placeholder='Giá' required='required' id='sls' name='S_GIA' onkeyup='checksls()'><i id='mess2' style='font-size: 15px; position: absolute; top: 25%; left: 101%;'></i>
                        </div>
                        <br>
                        <div class='input-group'>
                            <input type='text' class='form-control' placeholder='Số lượng' required='required' id='sls' name='S_SOLUONG' onkeyup='checksls()'><i id='mess2' style='font-size: 15px; position: absolute; top: 25%; left: 101%;'></i>
                        </div>
                        <br>
                        <div class='input-group'>
                             Hình ảnh:&emsp;<input type='file' required='required' name='S_ANH'>
                        </div>
                        <br>
                        <div class='input-group'>
                          <button id='submit' onclick='return checksubmitS()' class='btn btn-md btn-rounded btn-block form-control submit' type='submit' name='addS'><i class='fas fa-sign-in-alt'></i> Thêm</button>
                        </div>
                    </form>
                </div>";       
        } else if($v=="CNS"){
            $result = $kn->query("select S_MA, S_TEN, S_TACGIA, NXB_TEN, TL_TEN, S_MOTA, S_GIA, S_SOLUONG, S_ANH from SACH, NHA_XUAT_BAN, THE_LOAI where SACH.NXB_MA=NHA_XUAT_BAN.NXB_MA and SACH.TL_MA=THE_LOAI.TL_MA order by S_MA");
            echo "<form method='POST'>";
            echo "<table border='1' class='table table-striped table-dark' style='text-align: center;'>";
            echo "<thread><tr><th scope='col'>MÃ SÁCH</th><th scope='col'>TÊN SÁCH</th><th scope='col'>TÁC GIẢ</th><th scope='col'>TÊN NHÀ XUẤT BẢN</th><th scope='col'>THỂ LOẠI</th><th scope='col'>MÔ TẢ</th><th scope='col'>GIÁ</th><th scope='col'>SỐ LƯỢNG</th><th scope='col'>HÌNH ẢNH</th><th scope='col'><button class='dropdown-item text-danger' name='updateS1' value='update'>Cập nhật</button></tr></thread>";
            while($row = $result->fetch_assoc()){
                echo "<tbody><tr>";
                $a = array_values($row);
                echo "<th scope='row'>".$a[0]."</th>";
                for ($i=1;$i<sizeof($row);$i++){
                     if($i==sizeof($row)-1){
                        echo "<td> <img src='./css/image book/".$a[$i]."' width='100%' height='70px' alt='hinh anh'></td>";
                        continue;
                    }
                    echo "<td>".$a[$i]."</td>";
                }
                echo "<td><input type='checkbox' name='checkupdateS[]' value='".$a[0]."'></td>";
                echo "</tr></tbody>";
            }
            echo "</table>";
            echo "</form>";
        } else if($v=="XS"){
            $result = $kn->query("select S_MA, S_TEN, S_TACGIA, NXB_TEN, TL_TEN, S_MOTA, S_GIA, S_SOLUONG, S_ANH from SACH, NHA_XUAT_BAN, THE_LOAI where SACH.NXB_MA=NHA_XUAT_BAN.NXB_MA and SACH.TL_MA=THE_LOAI.TL_MA order by S_MA");
            echo "<form method='POST'>";
            echo "<table border='1' class='table table-striped table-dark' style='text-align: center;'>";
            echo "<thread><tr><th scope='col'>MÃ SỐ</th><th scope='col'>TÊN SÁCH</th><th scope='col'>TÁC GIẢ</th><th scope='col'>NHÀ XUẤT BẢN</th><th scope='col'>THỂ LOẠI</th><th scope='col'>MÔ TẢ</th><th scope='col'>GIÁ</th><th scope='col'>SỐ LƯỢNG</th><th scope='col'>HÌNH ẢNH</th><th scope='col'><button class='dropdown-item text-danger' onclick='return checkxoa()' name='deleteS'>Xóa</button></th></tr></thread>";
            while($row = $result->fetch_assoc()){
                $a = array_values($row);
                echo "<tbody><tr>";
                echo "<th scope='row'>".$a[0]."</th>";
                for ($i=1;$i<sizeof($row);$i++) { 
                    if($i==1 || $i==2){
                        echo "<td>".mb_strtoupper($a[$i])."</td>";
                        continue;
                    } else if($i==sizeof($row)-1){
                        echo "<td> <img src='./css/image book/".$a[$i]."' width='100%' height='70px' alt='hinh anh'></td>";
                        continue;
                    } else if($i==5){
                        echo "<td>".$a[$i]."</td>";
                        continue;
                    } else{
                        echo "<td>".ucwords($a[$i])."</td>";
                    }
                }
                echo "<td><input type='checkbox' name='checkdeleteS[]' value='".$a[0]."'></td>";
                echo "</tr></tbody>";
            }
            echo "</table>"; 
            echo "</form>";           
        }
    ?>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="js/signup.js"></script>
</body>
</html>