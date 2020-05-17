<?php
	session_start();
	session_regenerate_id(true);
	require_once('../../../../utilities/config.php');
	require_once('../../../../utilities/lib.php');	
	charSetUTF8();

	$error = '';
	
	$_SESSION['id'] = $_POST['id'];
	$_SESSION['new_old'] = $_POST['new_old'];
		
	if (!isset($_POST['english_sirname'])||($_POST['english_sirname'] == '')) {
		$error .= '英語姓入力がありません!<br>';
	} else {
		$_SESSION['english_sirname'] = strtoupper(mb_convert_kana($_POST['english_sirname'], 'ash'));
		$_SESSION['english_sirname'] = preg_replace('/^[ 　]+/u', '', $_SESSION['english_sirname']);
		$_SESSION['english_sirname']  = preg_replace('/[ 　]+$/u', '', $_SESSION['english_sirname']);
		if (strlen($_POST['english_sirname']) > 99) $error .= '英語姓が長すぎます!<br>';
	}
	
	if (!isset($_POST['english_firstname'])||($_POST['english_firstname'] == '')) {
		$error .= '英語名入力がありません!<br>';
	} else {
		$_SESSION['english_firstname'] = strtoupper(mb_convert_kana($_POST['english_firstname'], 'ash'));
		$_SESSION['english_firstname'] = preg_replace('/^[ 　]+/u', '', $_SESSION['english_firstname']);
		$_SESSION['english_firstname']  = preg_replace('/[ 　]+$/u', '', $_SESSION['english_firstname']);
		if (strlen($_POST['english_firstname']) > 99) $error .= '英語名が長すぎます!<br>';
	}
	
	if (!isset($_POST['email'])) {
		$_SESSION['email'] = '';
	} else {
		$_SESSION['email'] = $_POST['email'];
		$_SESSION['email'] = preg_replace('/^[ 　]+/u', '', $_SESSION['email']);
		$_SESSION['email']  = preg_replace('/[ 　]+$/u', '', $_SESSION['email']);
		if (strlen($_POST['email']) > 99) $error .= 'email addressが長すぎます!<br>';
		if (!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $_POST['email'])) {
			$error .= '不正なemail addressです!<br>';
		}
	}
	
	if (!isset($_POST['phone'])) {
		$_SESSION['phone'] = '';
	} else {
		$_SESSION['phone'] = $_POST['phone'];
	}
	
	if (!isset($_POST['is_male'])) {
		$_SESSION['is_male'] = '0';
	} else {
		if ($_POST['is_male'] != 1) $_POST['is_male'] = 0;
		$_SESSION['is_male'] = $_POST['is_male'];
	}
	
	if (!isset($_POST['kana_sirname'])) {
		$_SESSION['kana_sirname'] = '';
	} else {
		$_SESSION['kana_sirname'] = mb_convert_kana($_POST['kana_sirname'], 'ash');
		$_SESSION['kana_sirname'] = preg_replace('/^[ 　]+/u', '', $_SESSION['kana_sirname']);
		$_SESSION['kana_sirname']  = preg_replace('/[ 　]+$/u', '', $_SESSION['kana_sirname']);
		if (strlen($_POST['kana_sirname']) > 99) $error .= 'かな姓が長すぎます!<br>';
	}
	
	if (!isset($_POST['kana_firstname'])) {
		$_SESSION['kana_firstname'] = '';
	} else {
		$_SESSION['kana_firstname'] = mb_convert_kana($_POST['kana_firstname'], 'ash');
		$_SESSION['kana_firstname'] = preg_replace('/^[ 　]+/u', '', $_SESSION['kana_firstname']);
		$_SESSION['kana_firstname']  = preg_replace('/[ 　]+$/u', '', $_SESSION['kana_firstname']);
		if (strlen($_POST['kana_firstname']) > 99) $error .= 'かな名が長すぎます!<br>';
	}
	
	if (!isset($_POST['kanji_sirname'])) {
		$_SESSION['kanji_sirname'] = '';
	} else {
		$_SESSION['kanji_sirname'] = $_POST['kanji_sirname'];
		$_SESSION['kanji_sirname'] = preg_replace('/^[ 　]+/u', '', $_SESSION['kanji_sirname']);
		$_SESSION['kanji_sirname']  = preg_replace('/[ 　]+$/u', '', $_SESSION['kanji_sirname']);
		if (strlen($_POST['kanji_sirname']) > 99) $error .= '漢字姓が長すぎます!<br>';
	}
	
	if (!isset($_POST['kanji_firstname'])) {
		$_SESSION['kanji_firstname'] = '';
	} else {
		$_SESSION['kanji_firstname'] = $_POST['kanji_firstname'];
		$_SESSION['kanji_firstname'] = preg_replace('/^[ 　]+/u', '', $_SESSION['kanji_firstname']);
		$_SESSION['kanji_firstname']  = preg_replace('/[ 　]+$/u', '', $_SESSION['kanji_firstname']);
		if (strlen($_POST['kanji_firstname']) > 99) $error .= '漢字名が長すぎます!<br>';
	}
	
	if (!isset($_POST['hp_name_english'])) {
		$_SESSION['hp_name_english'] = '';
	} else {
		$_SESSION['hp_name_english'] = mb_convert_kana($_POST['hp_name_english'], 'ash');
		$_SESSION['hp_name_english'] = preg_replace('/^[ 　]+/u', '', $_SESSION['hp_name_english']);
		$_SESSION['hp_name_english']  = preg_replace('/[ 　]+$/u', '', $_SESSION['hp_name_english']);
		if (strlen($_POST['hp_name_english']) > 99) $error .= '英語病院名が長すぎます!<br>';
	}
	
	if (!isset($_POST['hp_name_japanese'])) {
		$_SESSION['hp_name_japanese'] = '';
	} else {
		$_SESSION['hp_name_japanese'] = $_POST['hp_name_japanese'];
		$_SESSION['hp_name_japanese'] = preg_replace('/^[ 　]+/u', '', $_SESSION['hp_name_japanese']);
		$_SESSION['hp_name_japanese']  = preg_replace('/[ 　]+$/u', '', $_SESSION['hp_name_japanese']);
		if (strlen($_POST['hp_name_japanese']) > 99) $error .= '日本語病院名が長すぎます!<br>';
	}
	
	if (!isset($_POST['nation'])) {
		$_SESSION['nation'] = '';
	} else {
		$_SESSION['nation'] = strtoupper(mb_convert_kana($_POST['nation'], 'ash'));
		$_SESSION['nation'] = preg_replace('/^[ 　]+/u', '', $_SESSION['nation']);
		$_SESSION['nation']  = preg_replace('/[ 　]+$/u', '', $_SESSION['nation']);
		if (strlen($_POST['nation']) > 49) $error .= '英語国名が長すぎます!<br>';
	}
	
	if (!isset($_POST['hp_place_english'])) {
		$_SESSION['hp_place_english'] = '';
	} else {
		$_SESSION['hp_place_english'] = mb_convert_kana($_POST['hp_place_english'], 'ash');
		$_SESSION['hp_place_english'] = preg_replace('/^[ 　]+/u', '', $_SESSION['hp_place_english']);
		$_SESSION['hp_place_english']  = preg_replace('/[ 　]+$/u', '', $_SESSION['hp_place_english']);
		if (strlen($_POST['hp_place_english']) > 99) $error .= '英語病院住所が長すぎます!<br>';
	}
	
	if (!isset($_POST['hp_place_japanese'])) {
		$_SESSION['hp_place_japanese'] = '';
	} else {
		$_SESSION['hp_place_japanese'] = $_POST['hp_place_japanese'];
		$_SESSION['hp_place_japanese'] = preg_replace('/^[ 　]+/u', '', $_SESSION['hp_place_japanese']);
		$_SESSION['hp_place_japanese']  = preg_replace('/[ 　]+$/u', '', $_SESSION['hp_place_japanese']);
		if (strlen($_POST['hp_place_japanese']) > 99) $error .= '日本語病院住所が長すぎます!<br>';
	}
	
	if (!isset($_POST['member_kind'])) {
		$_SESSION['member_kind'] = '1';
	} else {
		$_SESSION['member_kind'] = $_POST['member_kind'];
		if (($_POST['member_kind'] < 1)||($_POST['member_kind'] > 7)) $error .= '不正なFaculty種別です!<br>';
	}
	
	if (!isset($_POST['sponsor'])) {
		$_SESSION['sponsor'] = '';
	} else {
		$_SESSION['sponsor'] = $_POST['sponsor'];
		$_SESSION['sponsor'] = preg_replace('/^[ 　]+/u', '', $_SESSION['sponsor']);
		$_SESSION['sponsor']  = preg_replace('/[ 　]+$/u', '', $_SESSION['sponsor']);
		if (strlen($_POST['sponsor']) > 99) $error .= 'スポンサーが長すぎます!<br>';
	}
	
	if (!isset($_POST['description'])) {
		$_SESSION['description'] = '';
	} else {
		$_SESSION['description'] = $_POST['description'];
		$_SESSION['description'] = preg_replace('/^[ 　]+/u', '', $_SESSION['description']);
		$_SESSION['description']  = preg_replace('/[ 　]+$/u', '', $_SESSION['description']);
		if (strlen($_POST['description']) > 1024) $error .= '特記事項が長すぎます!<br>';
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
<title>RAP and BEAT</title>
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
		header('Location:dr03.php');
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
