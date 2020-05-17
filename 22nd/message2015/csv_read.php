<?php
	require_once("../../utilities/config.php");
	require_once("../../utilities/lib.php");


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
	$stmt = $pdo->prepare("INSERT INTO `faculty_tbls` (`dr_name`, `hp_name`, `nation`, `dr_email`, `sponsor`, `year`, `is_active`) "
		."VALUES (:dr_name, :hp_name, :nation, :dr_email, :sponsor, :year, :is_active);");

	$csv  = array();
	$file = 'faculty2015.csv';
	$fp   = fopen($file, "r");
 
	while (($data = fgetcsv($fp, 0, ",")) !== FALSE) {
		echo $data[0]."-*-".$data[1]."-*-".$data[2]."-*-".$data[3]."-*-".$data[4]."<br>";
		$stmt->bindValue(":dr_name", $data[0], PDO::PARAM_STR);
		$stmt->bindValue(":hp_name", $data[1], PDO::PARAM_STR);
		$stmt->bindValue(":nation", $data[2], PDO::PARAM_STR);
		$stmt->bindValue(":dr_email", $data[3], PDO::PARAM_STR);
		$stmt->bindValue(":sponsor", $data[4], PDO::PARAM_STR);
		$stmt->bindValue(":year", '2015', PDO::PARAM_INT);
		$stmt->bindValue(":is_active", '1', PDO::PARAM_INT);
		$stmt->execute();  
	}
	fclose($fp);


/*

		$subject = "${site_name} : メルアド変更メール";
		$sender = mb_encode_mimeheader("J-WINC/NPO International TRI Network");
		$headers  = "FROM: ".$sender."<$support_mail>\r\n";		
		$parameters = '-f'.$support_mail;	
		$md5 = substr(hash("sha512", $_POST['dr_pwd'].$magic_code), 10, 32);

	//　ここからメール内容
	$body = <<< _EOT_
{$_SESSION['dr_name']}　様、:
	
J-WINC研究者のメルアド変更します。
新しいemail_tempアドレスが正しくあなたのものであることを確認する
ために、下記のリンクをクリックして下さい。
	
{$site_url}email_change/email_chg03.php?email_temp={$_POST['email_temp']}&md5={$md5}&email={$row['email']}


あなたの新しいemail_tempアドレス: {$_POST['email_temp']}
	
ご不明の点がありますれば、{$support_mail} にメールをお願いします
===========================================================
	$site_name
	$site_url
_EOT_;
	// _EOT_　は行の最初に記述し、;の後にコメントも無し、にしないとエラーとなる	

		mb_language('ja');
		mb_internal_encoding('utf-8');
		mb_send_mail($_POST['email_temp'], $subject, $body, $headers, "-f$support_mail"); 
		if ($_SERVER['HTTP_HOST'] == 'localhost') {
			echo $body;
		}
//		$_SESSION = array();
//		session_destroy();
*/
?>