<!DOCTYPE html>
<html>
<head>
	<title>Them</title>
	<script type="text/javascript">
		function them1() {
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
			  document.getElementById("result").innerHTML = this.responseText;
			}
			};
			xhttp.open("POST", "test1.php/", true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			var mssv = document.getElementById('mssv').value;
			var hoten = document.getElementById('hoten').value;
			xhttp.send("mssv="+mssv+"&hoten="+hoten);
		}
	</script>
</head>
<body>
	<div id="result"></div>
		<form action='javascript:them1()'>
			<input type="text" id="mssv" name="ms">
	        <br>
			<input type="text" id="hoten" name="ten">
			<br>
			<select name="makhoa">
				<option value="KH000001">CNTT</option>
			</select>
			<br>
			<input type="submit" name="submit">
		</form>
</body>
</html>