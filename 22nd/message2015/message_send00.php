<?php	// message_send00.php
	require_once("../../utilities/lib.php");
	require_once("../../utilities/config.php");

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
		font-size:18px;
		font-weight:bold;
		color:red;
	}
</style>
<title>メッセージ入力</title>
</head>

<body>
<h1>Faculty全員に以下のメッセージを発信します</h1>

<form action="message_send01.php" method="post">
	<textarea name="message" class="msg"  cols="80" rows="10">ここにメッセージを打ち込んで下さい</textarea><br /><br />
    <input type="submit" id="smt" value="メール発信" />
</form>
</body>
</html>