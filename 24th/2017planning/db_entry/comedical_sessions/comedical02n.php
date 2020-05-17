<?php
	session_start();
	session_regenerate_id(true);
	require_once('../../../../utilities/config.php');
	require_once('../../../../utilities/lib.php');	
	charSetUTF8();

	$error = '';
	
	$_SESSION['id'] = $_POST['id'];
	
	if (!isset($_POST['sessionNo'])||!is_numeric($_POST['sessionNo'])||($_POST['sessionNo'] == '')||!preg_match('/^[0-9]+$/', $_POST['sessionNo'])) {
		$error .= ' セッション番号が半角数字でありません!<br />';
	} else {
		$_SESSION['sessionNo'] = $_POST['sessionNo'];
		if (($_SESSION['sessionNo'] <= 0)||($_SESSION['sessionNo'] > 40)) $error .= 'あり得ないセッション番号です!<br />';
	}
	
	if (!isset($_POST['begin'])||($_POST['begin'] == '')) {
		$error .= 'セッション開始時刻入力がありません!<br>';
	} else {
		$time_han = mb_convert_kana($_POST['begin'], 'as', "UTF-8");
		if (preg_match('/^[0-9]:/', $time_han)) $time_han = '0'.$time_han;
		$_SESSION['begin'] = $time_han;
		if (!preg_match('/[0-9]{2}:[0-9]{2}/', $time_han)) $error .= '正しい開始時刻入力ではありません!<br>';
	}
	
	if (!isset($_POST['duration'])||($_POST['duration'] == '')||!is_numeric($_POST['duration'])) {
		$error .= 'セッション持続時間(分)入力が適切ではありません!<br>';
	} else {
		$_SESSION['duration'] = $_POST['duration'];
		if (($_POST['duration'] > 600)||($_POST['duration'] < 0)) $error .= 'セッション持続時間(分)が違法です!<br>';
	}
	
	if (!isset($_POST['sessionTitle'])||($_POST['sessionTitle'] == '')) {
		$error .= 'セッション・タイトル入力がありません!<br>';
	} else {
		$_SESSION['sessionTitle'] = $_POST['sessionTitle'];
		if (strlen($_POST['sessionTitle']) > 299) $error .= 'セッション・タイトルが長すぎます!<br>';
	}
	
	if (!isset($_POST['lectureTitle'])) {
		$_SESSION['lectureTitle'] = '';
	} else {
		$_SESSION['lectureTitle'] = $_POST['lectureTitle'];
		if (strlen($_POST['lectureTitle']) > 299) $error .= '講演演題名が長すぎます!<br>';
	}
	
	if (!isset($_POST['venue'])) {
		$_SESSION['venue'] = '';
	} else {
		$_SESSION['venue'] = $_POST['venue'];
		if (strlen($_POST['venue']) > 49) $error .= '会場名が長すぎます!<br>';
	}
	
	if (!isset($_POST['description'])) {
		$_SESSION['description'] = '';
	} else {
		$_SESSION['description'] = $_POST['description'];
		if (strlen($_POST['description']) > 1024) $error .= 'セッションの内容記述が長すぎます!<br>';
	}
	
	if (!isset($_POST['cosponsor'])) {
		$_SESSION['cosponsor'] = '';
	} else {
		$_SESSION['cosponsor'] = $_POST['cosponsor'];
		if (strlen($_POST['cosponsor']) > 199) $error .= '共催企業名が長すぎます!<br>';
	}
	
	
// 入力エラー画面
	if ($error != '') {
	
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
	body {background-color:black;}
	h1 {width: 800px; background-color:red; color:white; border:white 5px solid; margin-left:auto; margin-right:auto;text-align:center;}
	h2 {width: 600px; background-color:yellow; color:brown; border:brown 3px solid; margin-left:auto; margin-right:auto; text-align:center;}
	p {font-size:24px; color:white; text-align:center;font-weight:bold;}
	div#pict {width:736px; margin-left:auto; margin-right:auto;}
</style>
<title>コメディカル入力</title>
</head>

<body>
<h1>Input Data contain erroneous values!</h1>
<p><?=$error ?></p>
<h2>You have to return to the previous screen using RETURN button of your browser!</h2>
<br />
<div id="pict"><img src="../../../imgs/Guitar_colored.png" width="736" height="697" alt="Guitar" /></div>
<?php
		exit;
	} else {
		header('Location:comedical03n.php');
	}
?>

<script src = "https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha256-Sk3nkD6mLTMOF0EOpNtsIry+s1CsaqQC1rVLTAy+0yc= sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
<script>
	if (!window.jQuery) {
		document.write('<script src="../../../../bootstrap/jquery-2.1.4.min.js"><\/script><script src="../../../../bootstrap/js/bootstrap.min.js"><\/script>');
	}
</script>
<script src="../../../../bootstrap/docs-assets/javascript/extension.js"></script>
<script src="../../../../bootstrap/docs-assets/javascript/jglycy-1.0.js"></script>
<script src="../../../../bootstrap/docs-assets/javascript/jtruncsubstr.js"></script>
<script src="../../../index2016.js"></script>
</body>
</body>
</html>
