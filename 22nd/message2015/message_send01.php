<?php	// message_send01.php
	require_once("../../utilities/lib.php");
	require_once("../../utilities/config.php");
	if (isset($_POST['message'])) {
		$msg = $_POST['message'];
	} else {
		$msg = '';
	}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="favicon.ico">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../css/nausica_basic.css"/>
<style type="text/css">
	.msg {
		font:"ＭＳ ゴシック", "MS Gothic", "Osaka－等幅", Osaka-mono, monospace;
		font-size:16px;
		font-weight:bold;
		color:blue;
		background-color:#CCC;
	}
</style>
<title>メッセージ入力[2/4]</title>
</head>

<body>
<h1>Faculty全員に以下のメッセージを発信します</h1>
<form action="message_send02.php" method="post">
	<textarea name="message" class="msg"  cols="80" rows="10" readonly="readonly"><?php echo htmlentities($msg, ENT_QUOTES, 'UTF-8'); ?></textarea><br /><br />
    <input type="submit" name="smt" value="メール送信OK" /><br /><br />
    <a href="message_send00.php"><input type="button" value="戻る" /></a>
</body>
</html>