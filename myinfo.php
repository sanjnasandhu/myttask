<?php
//ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');
///error_reporting(E_ALL);
?>
<html>
<head>
<style>

#information-container {
	width: 400px;
	margin: 50px auto;
	padding: 20px;
	border: 1px solid #cccccc;
}

.information {
	margin: 0 0 30px 0;
}

.information label {
	display: inline-block;
	vertical-align: middle;
	width: 150px;
	font-weight: 700;
}

.information span {
	display: inline-block;
	vertical-align: middle;
}

.information img {
	display: inline-block;
	vertical-align: middle;
	width: 100px;
}

</style>
</head>

<body>

<div id="information-container">
	<h2>MY PROFILE</h2>
	<div class="information">
		<label>ID</label><span><?php  echo  $administrations->id; ?>
	</div>
	<div class="information">
		<label>NAME</label><?php echo  $administrations->name; ?>
	</div>
	<div class="information">
		<label>Email</label><?php echo $administrations->email; ?>
	</div>
	 <a href="logout.php" class="btn btn-info btn-block"> <class="btn btn-primary btn-block">LOGOUT</a>
	</div>

</body>
</html> 