<?php
  session_start();
  $kn = new mysqli("localhost","NgocLinh","K@NgocLinh1998","LeLinh");
  if($kn->connect_error){
    die("Web đang gặp sự cố! Vui lòng trở lại sau");
  }
  $kn->set_charset("utf8");
  if(!isset($_SESSION["username"]) || !isset($_SESSION["password"])){
    header("Location: login.php");
  } else if($_SESSION["permission"]!="NV"){
    header("Location: bookshop.php");
  }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Nhân viên bookshop</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous"/>
</head>
<body>
                        <div class="row no-gutters align-items-center">
                        <div class="col">
                          <div class="progress progress-sm mr-2">
                            <div class="progress-bar bg-info" role="progressbar" style="width: 100%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </div>
                      </div>
  <div id="wrapper">
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
          <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" method="POST">
            <div class="input-group">
              <input type="text" class="form-control bg-light border-0 small" placeholder="Tìm kiếm..." aria-label="Search" aria-describedby="basic-addon2" name="keyword">
              <div class="input-group-append">
                <div class=" dropdown">
                  <button class="btn btn-primary text-xs font-weight-bold text-uppercase mb-1 btn dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown">
                  <i class="fas fa-search fa-sm"></i>
                  </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <button class="dropdown-item text-primary" name="searchKH">Khách hàng</button> 
                      <button class="dropdown-item text-primary" name="searchS">Sách</button> 
                      <button class="dropdown-item text-primary" name="searchDT">Doanh thu</button>
                      <button class="dropdown-item text-primary" name="searchHD">Hóa đơn</button>
                    </div>
                </div>
              </div>
            </div>
          </form>
          <ul class="navbar-nav ml-auto">
            <div class="topbar-divider d-none d-sm-block"></div>
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small" style="font-size: 150%"><?php echo $_SESSION["username"] ?></span>
                <img class="img-profile rounded-circle" src="linh1.jpg" style="width: 50px">
              </a>
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Hồ sơ
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Cài đặt
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout.php" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Đăng xuất
                </a>
              </div>
            </li>
          </ul>
        </nav>
        <div id="view"></div>
        <div class="container-fluid fixed-bottom shadow" style="background-color: rgba(255,255,255,0.5)">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800" style="color: brown;">DANH MỤC QUẢN LÝ</h1>
            <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
          </div>
            <div class="row">
              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card shadow h-100 py-2" style="background-color: rgba(255,255,255,0.5)">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class=" dropdown">
                          <button class="text-xs font-weight-bold text-danger text-uppercase mb-1 btn dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"><i class="fa fa-user fa-2x text-gray-300"></i> Khách hàng</button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <button class="dropdown-item text-danger" onclick="view(value)" value="HTKH">Hiển thị</button> 
                            <button class="dropdown-item text-danger" onclick="view(value)" value="TKH">Thêm</button> 
                            <button class="dropdown-item text-danger" onclick="view(value)" value="CNKH">Cập nhật</button>
                            <button class="dropdown-item text-danger" onclick="view(value)" value="XKH">Xóa</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card shadow h-100 py-2" style="background-color: rgba(255,255,255,0.5)">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class=" dropdown">
                          <button class="text-xs font-weight-bold text-warning text-uppercase mb-1 btn dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"><i class="fa fa-book fa-2x text-gray-300"></i> Sách</button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <button class="dropdown-item text-warning" onclick="view(value)" value="HTS">Hiển thị</button> 
                            <button class="dropdown-item text-warning" onclick="view(value)" value="TS">Thêm</button> 
                            <button class="dropdown-item text-warning" onclick="view(value)" value="CNS">Cập nhật</button>
                            <button class="dropdown-item text-warning" onclick="view(value)" value="XS">Xóa</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card shadow h-100 py-2" style="background-color: rgba(255,255,255,0.5)">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class=" dropdown">
                          <button class="text-xs font-weight-bold text-success text-uppercase mb-1 btn dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"><i class="fas fa-dollar-sign fa-2x text-gray-300"></i> Danh thu</button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <button class="dropdown-item text-success" onclick="view(value)" value="HTDT">Hiển thị</button>
                            <button class="dropdown-item text-success" onclick="view(value)" value="TDT">Thêm</button> 
                            <button class="dropdown-item text-success" onclick="view(value)" value="CNDT">Cập nhật</button>
                            <button class="dropdown-item text-success" onclick="view(value)" value="XDT">Xóa</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card shadow h-100 py-2" style="background-color: rgba(255,255,255,0.5)">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class=" dropdown">
                          <button class="text-xs font-weight-bold text-info text-uppercase mb-1 btn dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"><i class="fas fa-clipboard-list fa-2x text-gray-300"></i> Hóa đơn</button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <button class="dropdown-item text-info" onclick="view(value)" value="HTHD">Hiển thị</button> 
                            <button class="dropdown-item text-info" onclick="view(value)" value="THD">Thêm</button> 
                            <button class="dropdown-item text-info" onclick="view(value)" value="CNHD">Cập nhật</button>
                            <button class="dropdown-item text-info" onclick="view(value)" value="XHD">Xóa</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
  <br><br><br><br><br><br><br><br><br><br>
  <div class="modal fade" id="logoutModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Đăng xuất</h5>
          <button class="close" type="button" data-dismiss="modal">
            <span aria-hidden="true">X</span>
          </button>
        </div>
        <div class="modal-body">Bạn có muốn đăng xuất?</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Thoát</button>
          <a class="btn btn-primary" href="logout.php">Đăng xuất</a>
        </div>
      </div>
    </div>
  </div>
    <script type="text/javascript">
      function view(v){
        if (v==""){
          return;
        }
        var x = new XMLHttpRequest();
        x.open("GET","view.php?view="+v,true);
        x.send();
        x.onreadystatechange = function(){
          if(x.readyState == 4 && x.status == 200){
            document.getElementById("view").innerHTML = x.responseText;
          }
        } 
      }
      function search(s){
        if(s==''){
           return;
        }
        var x = new XMLHttpRequest();
        x.open("GET","search.php?search="+s,true);
        x.send();
        x.onreadystatechange = function(){
          if(x.readyState == 4 && x.status == 200){
            document.getElementById("view").innerHTML = x.responseText;
          }
        }
      }
      function update(u){
        if(u==''){
          return;
        }
        var x = new XMLHttpRequest();
        x.open("GET","update.php?update="+u,true);
        x.send();
        x.onreadystatechange = function(){
          if(x.readyState == 4 && x.status == 200){
            document.getElementById('view').innerHTML = x.responseText;
          }
        }
      }
    </script>
    <script type="text/javascript" src="js/popper.min.js"></script> 
		<script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.js"></script>
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
        function checkxoa() {
          return confirm('Bạn có chắc muốn xóa?');
        }
        function checkcapnhat() {
          return confirm('Bạn có chắc muốn thay đổi?');
        }
        function checksls(){
          var sls = document.getElementById('sls').value;
          if(!/\d/.test(sls)){
            document.getElementById('mess2').style.color='red'; document.getElementById('mess2').innerHTML = '<i class="fa fa-times"></i>';
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
<?php
    $sql="select S_TEN from SACH";
    $result=$kn->query($sql);
    echo "<script type='text/javascript'> var TEN_SACH=[]";
    $i=0;
    while ($row=$result->fetch_assoc()) {
        echo "
            TEN_SACH[$i]='".trim(mb_strtolower($row['S_TEN']),' ')."';
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
    function checkbookname() {
        var bookname = document.getElementById('ts').value.trim();
        if(bookname == ""){
            document.getElementById('mess1').style.color='red'; document.getElementById('mess1').innerHTML = 'Tên sách không được rỗng';
            return false;
        }
        bookname = bookname.toLowerCase();
        var t1=",";
        t1+=bookname;
        t1+=",";
        var t2=",";
        t2+=TEN_SACH.toString();
        t2+=",";
        if(t2.search(t1)>-1){
          document.getElementById('mess1').style.color='red'; document.getElementById('mess1').innerHTML='Sách đã có';
          return false;
        } else{
          document.getElementById('mess1').innerHTML='';
          return true;
        }
    }
    function checksubmitKH(){
        if (checkusername()==false || checkconfirm()==false ||checksdt()==false ||checkhoten()==false){
            return false;
        }

    }
    function checksubmitS(){
        if (checksls()==false || checkbookname()==false){
            return false;
        }

    }
</script>
<?php
    $result=$kn->query("select KH_MA from KHACH_HANG");
    $MAKH=[];
    $i=0;
    while ($row=$result->fetch_assoc()) {
        $sub=substr($row["KH_MA"],strrpos($row["KH_MA"],"H",0)+1,strlen($row["KH_MA"]));
        $MAKH[$i] = $sub;
        $i++;
    }
    if (empty($MAKH)){
        $MAKH[0]=0;
    }   
    $KH = max($MAKH)+1;
    $j=strlen($KH);
    if($j<7){
        while($j<7){
            $KH ="0".$KH;
            $j++;
        }
    }
    if(isset($_POST["addKH"])){
      if($kn->query("insert into KHACH_HANG values('KH".$KH."','".mb_strtolower($_POST["TK_TEN"])."','".sha1(md5($_POST["TK_MATKHAU"]))."','".mb_strtolower($_POST["KH_TEN"])."','".mb_strtolower($_POST["KH_GIOITINH"])."','".$_POST["KH_NAMSINH"]."','".$_POST["KH_SDT"]."')")){
        echo "<script>alert('Thêm thành công'); view('HTKH');</script>";
      } else {
        echo "<script>alert('Thêm thất bại'); view('HTKH');</script>";
      }
    }
?>

<?php
    $result=$kn->query("select S_MA from SACH");
    $MAS=[];
    $i=0;
    while ($row=$result->fetch_assoc()) {
        $sub=substr($row["S_MA"],strrpos($row["S_MA"],"S",0)+1,strlen($row["S_MA"]));
        $MAS[$i] = $sub;
        $i++;
    }
    if (empty($MAS)){
        $MAS[0]=0;
    }   
    $S = max($MAS)+1;
    $j=strlen($S);
    if($j<5){
        while($j<5){
            $S ="0".$S;
            $j++;
        }
    }
    if(isset($_POST["addS"])){
      $fileName = $_FILES['S_ANH']['name'];
      if($kn->query("insert into SACH values('S".$S."','".mb_strtoupper($_POST["S_TEN"])."','".mb_strtolower($_POST["S_TACGIA"])."','".$_POST["NXB_MA"]."','".$_POST["TL_MA"]."','".$_POST["S_MOTA"]."','".$_POST["S_SOLUONG"]."','".$fileName."')")){
        echo "<script>alert('Thêm thành công'); view('HTS');</script>";
      } else {
        echo "<script>alert('Thêm thất bại'); view('HTS');</script>";
      }
    }
?>

<?php 
    if(isset($_POST["searchKH"])){
      echo "<script>";
      echo "search('"."TKKH,".$_POST["keyword"]."')";
      echo "</script>";
    }

    if(isset($_POST["searchS"])){
      echo "<script>";
      echo "search('"."TKS,".$_POST["keyword"]."')";
      echo "</script>";
    }


    if(isset($_POST["deleteKH"])){
      if(isset($_POST["checkdeleteKH"])){
        for($i=0;$i<sizeof($_POST["checkdeleteKH"]);$i++) { 
          $sql="delete from KHACH_HANG where KH_MA='".$_POST["checkdeleteKH"][$i]."'";
          $kn->query($sql);
        }
        echo "<script> alert('Xóa thành công!!!'); view('XKH');</script>";
      } else {
        echo "<script>view('XKH');</script>";
      }
    }



   if(isset($_POST["deleteS"])){
      if(isset($_POST["checkdeleteS"])){
        for($i=0;$i<sizeof($_POST["checkdeleteS"]);$i++) { 
          $sql="delete from SACH where S_MA='".$_POST["checkdeleteS"][$i]."'";
          $kn->query($sql);
        }
        echo "<script> alert('Xóa thành công!!!'); view('XS');</script>";
      } else {
        echo "<script>view('XS');</script>";
      }
    }



    if(isset($_POST["updateKH1"])){
      if(isset($_POST["checkupdateKH"])){
        echo "<script> var a = [];";
        echo "a[0] = 'CNKH';";
          for($i=0;$i<sizeof($_POST["checkupdateKH"]);$i++) {
            echo " a[$i+1] = '".$_POST["checkupdateKH"][$i]."';";
          }
          echo "update(a);";
        echo "</script>";
      } else {
        echo "<script>view('CNKH');</script>";
      }
    }
    if(isset($_POST["updateKH2"])){
      $result = $kn->query("select * from KHACH_HANG;");
      echo "<form method='POST'>";
      $a = [];
      $i = 1;
      $a[0] = "HTCNKH";
      while ($row = $result->fetch_assoc()) {
        if(!isset($_POST["".$row["KH_MA"]."1"])) continue;
        $a[$i] = $row["KH_MA"];
        $i++;
        $sql = "update KHACH_HANG set KH_TAIKHOAN='".mb_strtolower($_POST["".$row["KH_MA"]."1"])."', KH_MATKHAU='".sha1(md5($_POST["".$row["KH_MA"]."2"]))."', KH_TEN='".mb_strtolower($_POST["".$row["KH_MA"]."3"])."', KH_GIOITINH='".mb_strtolower($_POST["".$row["KH_MA"]."4"])."', KH_NAMSINH='".$_POST["".$row["KH_MA"]."5"]."', KH_SDT='".$_POST["".$row["KH_MA"]."6"]."'  where  KH_MA='".$row["KH_MA"]."'";
        $kn->query($sql);
      }
      echo "<script> var a = [];";
      for($i=0;$i<sizeof($a);$i++) { 
        echo "a[$i] = '".$a[$i]."';"; 
      }
      echo "</script>";
      echo "<script> alert('Thao tác đã hoàn tất!'); update(a); </script>";
    }





    if(isset($_POST["updateS1"])){
      if(isset($_POST["checkupdateS"])){
        echo "<script> var a = [];";
        echo "a[0] = 'CNS';";
          for($i=0;$i<sizeof($_POST["checkupdateS"]);$i++) {
            echo " a[$i+1] = '".$_POST["checkupdateS"][$i]."';";
          }
          echo "update(a);";
        echo "</script>";
      } else {
        echo "<script>view('CNS');</script>";
      }
    }
    if(isset($_POST["updateS2"])){
      $result = $kn->query("select * from SACH");
      echo "<form method='POST'>";
      $a = [];
      $i = 1;
      $a[0] = "HTCNS";
      while ($row = $result->fetch_assoc()) {
        if(!isset($_POST["".$row["S_MA"]."1"])) continue;
        if(empty($_FILES[$row["S_MA"]."7"]['name'])){
          $a[$i] = $row["S_MA"];
          $i++;
          $sql = "update SACH set S_TEN='".mb_strtolower($_POST["".$row["S_MA"]."1"])."', S_TACGIA='".mb_strtolower($_POST["".$row["S_MA"]."2"])."', NXB_MA='".$_POST["".$row["S_MA"]."3"]."', TL_MA='".$_POST["".$row["S_MA"]."4"]."', S_MOTA='".$_POST["".$row["S_MA"]."5"]."', S_GIA='".$_POST["".$row["S_MA"]."6"]."', S_SOLUONG='".$_POST["".$row["S_MA"]."7"]."' where  S_MA='".$row["S_MA"]."'";
          $kn->query($sql);
        } else{
          $fileName = $_FILES[$row["S_MA"]."7"]['name'];
          $a[$i] = $row["S_MA"];
          $i++;
          $sql = "update SACH set S_TEN='".mb_strtolower($_POST["".$row["S_MA"]."1"])."', S_TACGIA='".mb_strtolower($_POST["".$row["S_MA"]."2"])."', NXB_MA='".$_POST["".$row["S_MA"]."3"]."', TL_MA='".$_POST["".$row["S_MA"]."4"]."', S_MOTA='".$_POST["".$row["S_MA"]."5"]."', S_SOLUONG='".$_POST["".$row["S_MA"]."6"]."', S_ANH='".$fileName."' where  S_MA='".$row["S_MA"]."'";
          $kn->query($sql);
        }
      }
      echo "<script> var a = [];";
      for($i=0;$i<sizeof($a);$i++) { 
        echo "a[$i] = '".$a[$i]."';"; 
      }
      echo "</script>";
      echo "<script> alert('Thao tác đã hoàn tất!'); update(a); </script>";
    }
?>