<?php
	session_start();
	session_regenerate_id(true);
	require_once('file:///Macintosh HD/Users/transradial/Sites/utilities/config.php');
	require_once('file:///Macintosh HD/Users/transradial/Sites/utilities/lib.php');	
	charSetUTF8();
	//接続
 	try {
    // MySQLサーバへ接続
   	$pdo = new PDO("mysql:host=$db_host;dbname=$db_name_sessions;charset=utf8", $db_user, $db_password);
	// 注意: 不要なspaceを挿入すると' $db_host'のようにみなされ、エラーとなる
	} catch(PDOException $e){
    	die($e->getMessage());
	}
	
	$stmt = $pdo->prepare("UPDATE `comedical_session_tbls` SET `sessionNo` = :sessionNo, `sessionTime` = :sessionTime, 
		`sessionTitle` = :sessionTitle, `sessionChair` = :sessionChair, `sessionSubTitle` = :sessionSubTitle, ".
		"`sessionSpeaker` = :sessionSpeaker, `sessionRemark` = :sessionRemark, `sessionContent` = :sessionContent, ".
		"`sponsor` = :sponsor, `changed` = :changed WHERE `id` = :id;");
	$stmt->bindValue(":id", $_SESSION['id'], PDO::PARAM_INT);
	$stmt->bindValue(":sessionNo", $_SESSION['sessionNo'], PDO::PARAM_INT);
	$stmt->bindValue(":sessionTime", $_SESSION['sessionTime']);
	$stmt->bindValue(":sessionTitle", $_SESSION['sessionTitle']);
	$stmt->bindValue(":sessionChair", $_SESSION['sessionChair']);
	$stmt->bindValue(":sessionSubTitle", $_SESSION['sessionSubTitle']); 
	$stmt->bindValue(":sessionSpeaker", $_SESSION['sessionSpeaker']);
	$stmt->bindValue(":sessionRemark", $_SESSION['sessionRemark']); 
	$stmt->bindValue(":sessionContent", $_SESSION['sessionContent']);
	$stmt->bindValue(":sponsor", $_SESSION['sponsor']);
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
	header('Location:../../index2016mod.html');
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="file:///Macintosh HD/Users/transradial/Sites/favicon.ico">
<title>KAMAKURA LIVE</title>
<!-- Bootstrap core CSS -->
<link rel="stylesheet" type="text/css" href="file:///Macintosh HD/Users/transradial/Sites/bootstrap/css/bootstrap.css">
<!-- Custom styles for this template -->
<link rel="stylesheet" type="text/css" href="file:///Macintosh HD/Users/transradial/Sites/bootstrap/jumbotron/jumbotron.css">
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
<script src="file:///Macintosh HD/Users/transradial/Sites/bootstrap/docs-assets/javascript/extension.js"></script>
<script src="file:///Macintosh HD/Users/transradial/Sites/bootstrap/docs-assets/javascript/jglycy-1.0.js"></script>
<script src="file:///Macintosh HD/Users/transradial/Sites/bootstrap/docs-assets/javascript/jtruncsubstr.js"></script>
<script src="../../../index2016.js"></script>
</body>
</html>