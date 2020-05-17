<?php
session_start();
session_regenerate_id( true );
require_once( '../../../../utilities/config.php' );
require_once( '../../../../utilities/lib.php' );
charSetUTF8();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="shortcut icon" href="../../../../favicon.ico">
	<title>KAMAKURA LIVE</title>
	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" type="text/css" href="../../../../bootstrap/css/bootstrap.css">
	<!-- Custom styles for this template -->
	<link rel="stylesheet" type="text/css" href="../../../../bootstrap/jumbotron/jumbotron.css">
	<link rel="stylesheet" type="text/css" href="../../../2016top.css">
</head>

<body>
	<div class="container">
		<h2 class="text-center text-info">鎌倉ライブ<?=$this_year; ?>　TRI Session 時間割作成プログラム</h2>
		<div class="container">
			<div class="row">
				<?= "<h4>sessionNo:　　"._Q($_SESSION[ 'sessionNo' ]) ."</h4>"; ?>
				<?= "<h4>beginDate:　　"._Q($_SESSION[ 'beginDate' ] )."</h4>"; ?>
				<?= "<h4>duration:　　"._Q($_SESSION[ 'duration' ] )."</h4>"; ?>
				<?= "<h4>sessionTitle:　　"._Q($_SESSION[ 'sessionTitle' ])."</h4>"; ?>
				<?= "<h4>cosponsor:　　"._Q($_SESSION[ 'cosponsor' ] )."</h4>"; ?>
				<?= "<h4>lectureTitle:　　"._Q($_SESSION[ 'lectureTitle' ] )."</h4>"; ?>
				<?= "<h4>description:　　"._Q($_SESSION[ 'description' ] )."</h4>"; ?>
			</div>
			<form name="doctor" method="post" action="tri_db_mod03.php">
				<input type="hidden" name="id" value="<?= _Q($_SESSION['id']); ?>"/>"
				<input type="hidden" name="sessionNo" value="<?= _Q($_SESSION['sessionNo']); ?>"/>
				<input type="hidden" name="beginDate" value="<?= _Q($_SESSION['beginDate']); ?>"/>
				<input type="hidden" name="duration" value="<?= _Q($_SESSION['duration']); ?>"/>
				<input type="hidden" name="sessionTitle" value="<?= _Q($_SESSION['sessionTitle']); ?>"/>
				<input type="hidden" name="cosponsor" value="<?= _Q($_SESSION['cosponsor']); ?>"/>
				<input type="hidden" name="lectureTitle" value="<?= _Q($_SESSION['lectureTitle']); ?>"/>
				<input type="hidden" name="description" value="<?= _Q($_SESSION['description']); ?>"/>

				<input type="submit" value="これで良いです" class="btn btn-primary"/><br>
			</form>
		</div>
		<div><br><br>
		</div>
		<form method="post" action="tri_db_mod00.php">
			<input type="hidden" name="id" value="<?= $_SESSION['id']; ?>"/>
			<input type="submit" value="内容に誤りがあります"/>
		</form>
		<hr>
		<footer>
			<p>&copy; 2013 - 2019 by NPO International TRI Network & KAMAKURA LIVE</p>
		</footer>
	</div>
	</div>
	<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha256-Sk3nkD6mLTMOF0EOpNtsIry+s1CsaqQC1rVLTAy+0yc= sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
	<script>
		if ( !window.jQuery ) {
			document.write( '<script src="bootstrap/jquery-2.1.4.min.js"><\/script><script src="bootstrap/js/bootstrap.min.js"><\/script>' );
		}
	</script>
	<script src="../../../../bootstrap/docs-assets/javascript/extension.js"></script>
	<script src="../../../../bootstrap/docs-assets/javascript/jglycy-1.0.js"></script>
	<script src="../../../../bootstrap/docs-assets/javascript/jtruncsubstr.js"></script>
	<script src="../../../index2016.js"></script>
</body>
</html>