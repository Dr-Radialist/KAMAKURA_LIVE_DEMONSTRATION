﻿<?php
	session_start();
	session_regenerate_id(true);
	require_once('../../../../utilities/config.php');
	require_once('../../../../utilities/lib.php');	
	charSetUTF8();
	//接続
 	try {
    // MySQLサーバへ接続
   	$pdo = new PDO("mysql:host=$db_host;dbname=$db_name_sessions;charset=utf8", $db_user, $db_password);
	// 注意: 不要なspaceを挿入すると' $db_host'のようにみなされ、エラーとなる
	} catch(PDOException $e){
    		die($e->getMessage());
	}
	
	$stmto = $pdo->prepare("SELECT * FROM `tri_session_tbls` WHERE `id` = :id;");
	$stmto->bindValue(":id", $_POST['id'], PDO::PARAM_INT);
	$flago = $stmto->execute();
	if (!$flago) {
    		$infor = $stmto->errorInfo();
			exit($infor[2]);
	}
	$row = $stmto->fetch(PDO::FETCH_ASSOC);
	$change_flag = false;
	if ($row['begin'] != $_POST['begin']) $change_flag = true;
	if ($row['sessionTitle'] != $_POST['sessionTitle']) $change_flag = true;
	if ($row['duration'] != $_POST['duration']) $change_flag = true;
	if ($row['chair'] != $_POST['chair']) $change_flag = true;
	if ($row['moderator'] != $_POST['moderator']) $change_flag = true;
	if ($row['speaker'] != $_POST['speaker']) $change_flag = true;
	if ($row['interpreter'] != $_POST['interpreter']) $change_flag = true;
	if ($row['lectureTitle'] != $_POST['lectureTitle']) $change_flag = true;
	if ($row['venue'] != $_POST['venue']) $change_flag = true;
	if ($row['description'] != $_POST['description']) $change_flag = true;
	if ($row['cosponsor'] != $_POST['cosponsor']) $change_flag = true;

	if ($change_flag) {
		$stmt = $pdo->prepare("UPDATE `tri_session_tbls` SET `begin` = :begin, 
		`duration` = :duration, `chair` = :chair, `sessionTitle` = :sessionTitle, `moderator` = :moderator, ".
		"`speaker` = :speaker, `interpreter` = :interpreter, `lectureTitle` = :lectureTitle, `venue` = :venue, ".
		"`description` = :description, `cosponsor` = :cosponsor, `changed` = :changed WHERE `id` = :id;");
		$stmt->bindValue(":id", $_POST['id'], PDO::PARAM_INT);
		$stmt->bindValue(":begin", $_POST['begin']);
		$stmt->bindValue(":duration", $_POST['duration']);
		$stmt->bindValue(":chair", $_POST['chair']);
		$stmt->bindValue(":sessionTitle", $_POST['sessionTitle']);
		$stmt->bindValue(":moderator", $_POST['moderator']);
		$stmt->bindValue(":speaker", $_POST['speaker']);
		$stmt->bindValue(":interpreter", $_POST['interpreter']); 
		$stmt->bindValue(":lectureTitle", $_POST['lectureTitle']);
		$stmt->bindValue(":venue", $_POST['venue']); 
		$stmt->bindValue(":description", $_POST['description']);
		$stmt->bindValue(":cosponsor", $_POST['cosponsor']);
		$changed = date('Y-m-d H:i:s');			// 最後に変更した時間を記録
		$stmt->bindValue(":changed", $changed);
	
		try {
			$pdo->beginTransaction();
			$flag = $stmt->execute();
			if (!$flag) {
    				$infor = $stmt->errorInfo();
				exit($infor[2]);
			}

			$pdo->commit();
		} catch (Exception $e) {
			$pdo->rollBack();
			echo "Failed to update Database".$e->getMessage();
		}	
	}
	header('Location:../../index2016tri_mod.php');
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


</div>
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
</html>