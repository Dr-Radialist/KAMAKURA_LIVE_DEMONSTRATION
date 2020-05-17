<?php	// message_send01.php
	require_once("../../utilities/lib.php");
	require_once("../../utilities/config.php");
	/*
	if (isset($_POST['message'])) {
		$msg = _Q($_POST['message']);
	} else {
		$msg = '';
		exit;
	}
	*/
	charSetUTF8();
//	check_auth_index();	// index.phpより入らない場合にはここで拒否
		//接続
	try {
    // MySQLサーバへ接続
		$pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_password);
	// 注意: 不要なspaceを挿入すると' $db_host'のようにみなされ、エラーとなる
	} catch(PDOException $e){
		die($e->getMessage());
	}
//	echo $db_host."--".$db_name."--".$db_user."--".$db_password."<br>";
	$stmt = $pdo->prepare("SELECT * FROM `faculty_tbls` WHERE `year` = '2015';");
	$flag = $stmt->execute();		
		//	SQL debug用
		 if (!$flag) {
			$infor = $stmt->errorInfo();
			exit($infor[2]);
		}
		
	$row_number = $stmt->rowCount();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
	$subject = "Thanks mail from Shigeru SAITO, MD, FACC, FSCAI, FJCC";
	$sender = mb_encode_mimeheader("Dr_Radialist");
	$headers  = "FROM: ".$sender."<transradial@kamakuraheart.org>\r\n";	
	$headers .= "Bcc: transradial@kamakuraheart.org, saito@shonankamakura.or.jp\r\n";	
	$parameters = '-f'.'transradial@kamakuraheart.org';
	
	foreach($rows as $row) {
		//　ここからメール内容
	$body = "Dear Professor ".$row['dr_name']." (".$row['hp_name']."):\n"."\n".
		"I would like to express my deep sincere thanks to you for your \n".
		"participation in the last KAMAKURA Live Demonstration Course.\n".
		"Because of your presence, the meeting was finished successfully.\n".
		"We are still not yet decided wheter we will continue the meeting \n".
		"or not next year in 2016. However, the meeting in 2015 will be \n".
		"memorized in your heart forever as a 20 Years' Anniversary of TRI\n".
		"in JAPAN.\n".
		"I am very much satfified, since we could promote mutual friendship\n".
		"with all of you.\n\n".
		"I wish you and your faimily a Happy New Year 2016!\n\n".
		"Best regards,\n\nShigeru SAITO, MD, FACC, FSCAI, FJCC";

		if ($_SERVER['SERVER_NAME'] === 'localhost') {
				echo $body."<br>";
		}  else {
			$sendto = $row['dr_email'];
			mb_language('ja');
			mb_internal_encoding('utf-8');
			mb_send_mail($sendto, $subject, $body, $headers, "-ffightingradialist@tri-international.org"); 
		}
	}
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
<script type="text/javascript" src="../javascriptlib/jquery-1.10.2.min.js"></script>
<script type="text/javascript">
	$(function() {
		$("#ret").click(function() {
			document.location = 'https://www.tri-international.org/ami/index.php';
		});
	});
</script>
<link rel="stylesheet" type="text/css" href="../css/nausica_basic.css"/>

<title>メッセージ入力[2/4]</title>
</head>

<body>
<h1>Faculty全員にメッセージを発信しました</h1>
<button id="ret">戻る</button>
</body>
</html>