<?php
	session_start();
	session_regenerate_id(true);
	require_once('../../../utilities/config.php');
	require_once('../../../utilities/lib.php');	
	charSetUTF8();

	$error = '';
	
	$_SESSION['id'] = $_POST['id'];
	
	if (!isset($_POST['sessionNo'])||!is_numeric($_POST['sessionNo'])||($_POST['sessionNo'] == '')||!preg_match('/^[0-9]+$/', $_POST['sessionNo'])) {
		$error .= ' セッション番号が半角数字でありません!<br />';
	} else {
		$_SESSION['sessionNo'] = $_POST['sessionNo'];
		if (($_SESSION['sessionNo'] <= 0)||($_SESSION['sessionNo'] > 20)) $error .= 'あり得ないセッション番号です!<br />';
	}
	
	if (!isset($_POST['sessionTime'])||($_POST['sessionTime'] == '')) {
		$error .= 'セッション時間入力がありません!<br>';
	} else {
		$time_han = mb_convert_kana($_POST['sessionTime'], 'as', "UTF-8");
		$_SESSION['sessionTime'] = $time_han;
		if (!preg_match('/[0-9]{2}:[0-9]{2} - [0-9]{2}:[0-9]{2}/', $time_han)) $error .= '正しい時刻入力ではありません!<br>';
	}
	
	if (!isset($_POST['sessionTitle'])||($_POST['sessionTitle'] == '')) {
		$error .= 'セッション・タイトル入力がありません!<br>';
	} else {
		$_SESSION['sessionTitle'] = $_POST['sessionTitle'];
		if (strlen($_POST['sessionTitle']) > 49) $error .= 'セッション・タイトルが長すぎます!<br>';
	}
	
	if (!isset($_POST['sessionChair'])||($_POST['sessionChair'] == '')) {
		$error .= '座長入力がありません!<br>';
	} else {
		$_SESSION['sessionChair'] = $_POST['sessionChair'];
		if (strlen($_POST['sessionChair']) > 99) $error .= '座長が長すぎます!<br>';
	}
	
	if (!isset($_POST['sessionSubTitle'])) {
		$_SESSION['sessionSubTitle'] = '';
	} else {
		$_SESSION['sessionSubTitle'] = $_POST['sessionSubTitle'];
		if (strlen($_POST['sessionSubTitle']) > 199) $error .= 'セッション副演題が長すぎます!<br>';
	}
	
	if (!isset($_POST['sessionSpeaker'])) {
		$_SESSION['sessionSpeaker'] = '';
	} else {
		$_SESSION['sessionSpeaker'] = $_POST['sessionSpeaker'];
		if (strlen($_POST['sessionSpeaker']) > 99) $error .= 'セッション演者が長すぎます!<br>';
	}
	
	if (!isset($_POST['sessionRemark'])) {
		$_SESSION['sessionRemark'] = '';
	} else {
		$_SESSION['sessionRemark'] = $_POST['sessionRemark'];
		if (strlen($_POST['sessionRemark']) > 199) $error .= 'セッション注意点が長すぎます!<br>';
	}
	if (isset($_POST['sessionContent'])&&($_POST['sessionContent'] == "セッションの内容について記載してください")) {
		$_POST['sessionContent'] = "";
	}
	if (!isset($_POST['sessionContent'])||($_POST['sessionContent'] == '')) {
		$error .= 'セッション内容入力がありません!<br>';
	} else {
		$_SESSION['sessionContent'] = $_POST['sessionContent'];
		if (strlen($_POST['sessionContent']) > 255) $error .= 'セッション内容が長すぎます!<br>';
	}
	
	if (!isset($_POST['sponsor'])) {
		$_SESSION['sponsor'] = '';
	} else {
		$_SESSION['sponsor'] = $_POST['sponsor'];
		if (strlen($_POST['sponsor']) > 99) $error .= '共催企業が長すぎます!<br>';
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
    <link rel="shortcut icon" href="../../favicon.ico">
<style type="text/css">
	body {background-color:black;}
	h1 {width: 800px; background-color:red; color:white; border:white 5px solid; margin-left:auto; margin-right:auto;text-align:center;}
	h2 {width: 600px; background-color:yellow; color:brown; border:brown 3px solid; margin-left:auto; margin-right:auto; text-align:center;}
	p {font-size:24px; color:white; text-align:center;font-weight:bold;}
	div#pict {width:736px; margin-left:auto; margin-right:auto;}
</style>
<title>RAP and BEAT</title>
</head>

<body>
<h1>Input Data contain erroneous values!</h1>
<p><?=$error ?></p>
<h2>You have to return to the previous screen using RETURN button of your browser!</h2>
<br />
<div id="pict"><img src="../../imgs/Guitar_colored.png" width="736" height="697" alt="Guitar" /></div>
<?php
		exit;
	} else {
		header('Location:comedical03.php');
	}
?>
</body>
</html>
