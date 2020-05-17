<?php		// document_dwnld02.php
	session_start();
	session_regenerate_id(true);
	require_once('../utilities/config.php');
	require_once('../utilities/lib.php');
	charSetUTF8();
	
	if (isset($_POST['message_to_all'])) {
		$_SESSION['message_to_all'] = _Q($_POST['message_to_all']);
	} else {
		$_SESSION['message_to_all'] = "";
		header('Location: messae_to_all01.php');
		exit;
	}
	
	//接続
 	try {
    // MySQLサーバへ接続
   	$pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_password);
	// 注意: 不要なspaceを挿入すると' $db_host'のようにみなされ、エラーとなる
	} catch(PDOException $e){
    		die($e->getMessage());
	}
	
	$stmt = $pdo->prepare("SELECT DISTINCT(`hp_tbl_id`) as `hp_tbl_id` FROM `pt_tbls` WHERE `is_finalized` = '0';");
	$stmt->execute();
	$rows_nonfinalized_hp = $stmt->fetchAll(PDO::FETCH_ASSOC);
	/////
	$subject = "Please finalize the cases: from RAP AND BEAT Clinical Trial";
	$sender = mb_encode_mimeheader("RAP AND BEAT Clinical Trial");
	$headers = "FROM: ".$sender."<fightingradialist`tri-international.org>\r\n";
	$headers .= "Bcc: transradial@kamakuraheart.org,	rie_iwamoto@kamakuraheart.org, kaori_sudo@kamakuraheart.org, keiko.asou@tokushukai.jp";
	$headers .= 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-Type: multipart/related;boundary="1000000000"' . "\r\n";
	$doc1 = file_get_contents("How_to_finalize.pdf");
	$doc_encode64_001 = chunk_split(base64_encode($doc1));

	foreach($rows_nonfinalized_hp as $row_nonfinalized_hp) {		// これでfinalizeされていない症例がある施設一覧出力
			
		$stmt = $pdo->prepare("SELECT `email`, `firstname`, `sirname` FROM `dr_tbls` WHERE `hp_tbl_id` = :hp_tbl_id;");
		$stmt->bindValue(":hp_tbl_id", $_SESSION['hp_tbl_id'], PDO::PARAM_INT);
		$stmt->execute();
		$rows_nonfinalized_dr = $stmt->fetchAll(PDO::FETCH_ASSOC);	// これで finalizedされていない症例のある施設毎の investigators' email抽出
		$sendto = $rows_nonfinalized_dr['email'];
	
	
//// 必要書類の送付	

	//文書の取得と文書のエンコード
	$doc1 = file_get_contents("NAUSCIA_AMI_consent.doc");
	$doc_encode64_001 = chunk_split(base64_encode($doc1));
	$doc2 = file_get_contents("NAUSICA_AMI_protocolv0726.pdf");
	$doc_encode64_002 = chunk_split(base64_encode($doc2));	
	$doc3 = file_get_contents("Database_StructureV7.pdf");
	$doc_encode64_003 = chunk_split(base64_encode($doc3));
	$doc4 = file_get_contents("Registration_Form.pdf");
	$doc_encode64_004 = chunk_split(base64_encode($doc4));		
	$doc5 = file_get_contents("stent_handling2011_07_20.pdf");
	$doc_encode64_005 = chunk_split(base64_encode($doc5));		
	
	//ヘッダ情報
	$sendto   = $_POST['email'];
	$subject  = "NAUSICA AMI試験　ご請求書類の送付";
	$sender = mb_encode_mimeheader("NAUSICA AMI試験事務局");
	$headers  = "FROM: ".$sender."<fightingradialist@tri-international.org>\r\n";	
	$headers .= 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-Type: multipart/related;boundary="1000000000"' . "\r\n";

$message =<<<END
--1000000000
Content-Type: text/plain; charset=iso-2022-jp
Content-Transfer-Encoding: 7bit

{$_POST['dr_name']}　様

ご請求のあったNAUSICA AMI試験についての書類送付しました。

特定非営利活動法人ティー・アール・アイ国際ネットワーク
https://www.tri-international.org/ami/index.php

--1000000000
Content-Type: text/html; charset=iso-2022-jp
Content-Transfer-Encoding: 7bit

--1000000000
Content-Type: application/msword; name="consent.doc"
Content-Transfer-Encoding: base64
Content-ID: <doc_id_001>

$doc_encode64_001
--1000000000
Content-Type: application/pdf; name="protocol.pdf"
Content-Transfer-Encoding: base64
Content-ID: <doc_id_002>

$doc_encode64_002
--1000000000
Content-Type: application/pdf; name="database.pdf"
Content-Transfer-Encoding: base64
Content-ID: <doc_id_03>

$doc_encode64_003
--1000000000
Content-Type: application/pdf; name="registration_forms.pdf"
Content-Transfer-Encoding: base64
Content-ID: <doc_id_04>

$doc_encode64_004
--1000000000
Content-Type: application/pdf; name="stent_handling2011_07_20.pdf"
Content-Transfer-Encoding: base64
Content-ID: <doc_id_05>

$doc_encode64_005
--1000000000

END;



//メール用にサブジェクトと本文をエンコード
$subject = mb_encode_mimeheader($subject);
$message = mb_convert_encoding($message, "JIS");

mail($sendto, $subject, $message, $headers, "-ffightingradialist@tri-international.org"); 	
//　最後の-f optionがenvelopeの存在を示すようだ

/*
Content-ID: <img_id_000>
	// この部分の空白行が必要　これが無いとファイルが壊れる
$img_encode64_001
*/

//// 書類送付の連絡

	//ヘッダ情報
	$sendto   = 'nausica.ami@gmail.com,fightingradialist@tri-international.org';
	$subject  = "NAUSICA AMI試験　書類送付記録";
	$sender = mb_encode_mimeheader("NAUSICA AMI試験事務局");
	$headers  = "FROM: ".$sender."<fightingradialist@tri-international.org>\r\n";	
	$headers .= 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-Type: multipart/related;boundary="1000000000"' . "\r\n";

$message =<<<END
--1000000000
Content-Type: text/plain; charset=iso-2022-jp
Content-Transfer-Encoding: 7bit

{$_POST['dr_name']} <{$_POST['email']}> 先生 ({$_POST['hp_name']})に

NAUSICA AMI試験についての書類送付しました。

--1000000000
END;



//メール用にサブジェクトと本文をエンコード
$subject = mb_encode_mimeheader($subject);
$message = mb_convert_encoding($message, "JIS");

mail($sendto, $subject, $message, $headers, "-ffightingradialist@tri-international.org"); 	
//　最後の-f optionがenvelopeの存在を示すようだ

	session_destroy();
	}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="favicon.ico">
<title>鎌倉ライブ2016</title>

<link rel="stylesheet" type="text/css" href="../../bootstrap-3.3.6/dist/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../../23rd/2016top_main.css">
</head>

<body>

<div align="center">
  <h1>NAUSICA AMI試験基本文書ダウンロード<br/>
    5種類送付しました<br />
    <br />
  </h1>
  <h2><font color="red">1時間以内に書類が届いておられない場合には<br />
    、
    迷惑メール・フォルダに振り分けられている可能性があります。<br />
    申し訳ありませんが、「迷惑メール・フォルダ」も<br />
    チェックお願いします。</font></h2>
  <h2><a href="../index2016.php">[戻る]</a></h2>
</div>

<script src="http://code.jquery.com/jquery.js"></script> 
<script>
	if (!window.jQuery) {
		document.write('<script src="../../js/jquery3-1-0.js"><\/script>');
	}
</script> 
<script src="../../bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
<script src="../../bootstrap/docs-assets/javascript/extension.js"></script> 
<script src="../../bootstrap/docs-assets/javascript/jglycy-1.0.js"></script> 
<script src="../../bootstrap/docs-assets/javascript/jtruncsubstr.js"></script> 

</body>
</html>
