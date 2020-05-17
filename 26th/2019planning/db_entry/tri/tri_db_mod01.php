<?php
session_start();
session_regenerate_id( true );
require_once( '../../../../utilities/config.php' );
require_once( '../../../../utilities/lib.php' );
charSetUTF8();

$error = '';

$_SESSION['id'] = $_POST['id'];
if ( !isset( $_POST[ 'sessionNo' ] ) || ( $_POST[ 'sessionNo' ] == '' ) ) {
	$error .= 'sessionNo がありません!<br>';
} else {
	$_SESSION[ 'sessionNo' ] = $_POST[ 'sessionNo' ];
	if ( strlen( $_POST[ 'sessionNo' ] ) > 2 )$error .= 'sessionNo が長すぎます!<br>';
	if ( !is_numeric( ( $_POST[ 'sessionNo' ] ) ) )$error .= 'sessionNo が数字でありません!<br>';
}

if ( !isset( $_POST[ 'beginDate' ] ) || ( $_POST[ 'beginDate' ] == '' ) ) {
	$error .= '開始時刻がありません!<br>';
} else {
	$_SESSION[ 'beginDate' ] = $_POST[ 'beginDate' ];
	if (!preg_match( "/^2019-12-1[45]\s[01][0-9]:[0-9][0-9]:[0-9][0-9]/", $_POST[ 'beginDate' ] )) $error .= '開始時刻が不正です!';
}

if ( !isset( $_POST[ 'duration' ] ) ) {
	$_SESSION[ 'duration' ] = '';
} else {
	$_SESSION[ 'duration' ] = $_POST[ 'duration' ];
	if ( !is_numeric( ( $_POST[ 'duration' ] ) ) )$error .= 'duration が数字でありません!<br>';
}

if ( !isset( $_POST[ 'sessionTitle' ] ) ) {
	$_SESSION[ 'sessionTitle' ] = '';
} else {
	$_SESSION[ 'sessionTitle' ] = $_POST[ 'sessionTitle' ];
	if ( strlen( $_POST[ 'sessionTitle' ] ) > 300 )$error .= 'sessionTitle が長すぎます!<br>';
}

if ( !isset( $_POST[ 'cosponsor' ] ) ) {
	$_SESSION[ 'cosponsor' ] = '';
} else {
	$_SESSION[ 'cosponsor' ] = $_POST[ 'cosponsor' ];
	if ( strlen( $_POST[ 'cosponsor' ] ) > 300 )$error .= 'cosponsor が長すぎます!<br>';
}

if ( !isset( $_POST[ 'lectureTitle' ] ) ) {
	$_SESSION[ 'lectureTitle' ] = '';
} else {
	$_SESSION[ 'lectureTitle' ] = $_POST[ 'lectureTitle' ];
	if ( strlen( $_POST[ 'lectureTitle' ] ) > 300 )$error .= 'lectureTitle が長すぎます!<br>';
}

if ( !isset( $_POST[ 'description' ] ) ) {
	$_SESSION[ 'description' ] = '';
} else {
	$_SESSION[ 'description' ] = $_POST[ 'description' ];
	if ( strlen( $_POST[ 'description' ] ) > 2000 )$error .= '内容 が長すぎます!<br>';
}

// 入力エラー画面
if ( $error != '' ) {

	?>

	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="RAP and BEAT Clinical Trial">
		<meta name="author" content="Shigeru SAITO, MD, FACC, FSCAI, FJCC">
		<meta http-equiv="cache-Control" content="no-cache">
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="expires" content="0">
		<link rel="shortcut icon" href="../../../favicon.ico">

		<style type="text/css">
			body {
				background-color: black;
			}
			
			h1 {
				width: 800px;
				background-color: red;
				color: white;
				border: white 5px solid;
				margin-left: auto;
				margin-right: auto;
				text-align: center;
			}
			
			h2 {
				width: 600px;
				background-color: yellow;
				color: brown;
				border: brown 3px solid;
				margin-left: auto;
				margin-right: auto;
				text-align: center;
			}
			
			p {
				font-size: 24px;
				color: white;
				text-align: center;
				font-weight: bold;
			}
			
			div#pict {
				width: 736px;
				margin-left: auto;
				margin-right: auto;
			}
		</style>
		<title>KAMAKURA Live Demonstration</title>
	</head>

	<body>
		<h1>Input Data contain erroneous values!</h1>
		<p>
			<?=$error ?>
		</p>
		<h2>You have to return to the previous screen using RETURN button of your browser!</h2>
		<br/>
		<div id="pict"><img src="../../../imgs/Guitar_colored.png" width="736" height="697" alt="Guitar"/>
		</div>
		<?php
		exit;
		}
		else {
			header( 'Location:tri_db_mod02.php' );
		}
		?>

		<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha256-Sk3nkD6mLTMOF0EOpNtsIry+s1CsaqQC1rVLTAy+0yc= sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
		<script>
			if ( !window.jQuery ) {
				document.write( '<script src="../../../../bootstrap/jquery-2.1.4.min.js"><\/script><script src="../../../../bootstrap/js/bootstrap.min.js"><\/script>' );
			}
		</script>
		<script src="../../../../bootstrap/docs-assets/javascript/extension.js"></script>
		<script src="../../../../bootstrap/docs-assets/javascript/jglycy-1.0.js"></script>
		<script src="../../../../bootstrap/docs-assets/javascript/jtruncsubstr.js"></script>
		<script src="../../../index2016.js"></script>
	</body>
	</body>
	</html>