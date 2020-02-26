<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Test</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
	<link rel="stylesheet" href="../../../assets/css/style.css">
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
	<script src="https://kit.fontawesome.com/96b9b8551b.js" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
		<header class="d-flex justify-content-between align-items-center">
			<a href="/" class="header-logo">Home</a>
			<?php if(isset($_SESSION['user'])) { ?>
				<span>Hello <?php echo $_SESSION['user']['username']?> <a href="javascript:void(0)" class="btn_login" id="logout">Logout</a></span>
			<?php } else { ?>
				<a href="/login" class="btn_login">Login</a>
			<?php } ?>
		</header>