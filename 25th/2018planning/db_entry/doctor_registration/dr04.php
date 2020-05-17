<?php
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


		$stmto = $pdo->prepare("SELECT * FROM `doctor_tbls` WHERE `id` = :id;");
		$stmto->bindValue(":id", $_POST['id'], PDO::PARAM_INT);
		$flago = $stmto->execute();
		if (!$flago) {
    			$infor = $stmto->errorInfo();
			exit($infor[2]);
		}
		$row = $stmto->fetch(PDO::FETCH_ASSOC);
		$change_flag = false;						// databaseに更新があったか否か調べる
		if ($row['english_sirname'] != $_POST['english_sirname']) $change_flag = true;
		if ($row['english_firstname'] != $_POST['english_firstname']) $change_flag = true;
		if ($row['email'] != $_POST['email']) $change_flag = true;
		if ($row['phone'] != $_POST['phone']) $change_flag = true;
		if ($row['is_male'] != $_POST['is_male']) $change_flag = true;
		if ($row['kana_sirname'] != $_POST['kana_sirname']) $change_flag = true;
		if ($row['kana_firstname'] != $_POST['kana_firstname']) $change_flag = true;
		if ($row['kanji_sirname'] != $_POST['kanji_sirname']) $change_flag = true;
		if ($row['kanji_firstname'] != $_POST['kanji_firstname']) $change_flag = true;
		if ($row['hp_name_english'] != $_POST['hp_name_english']) $change_flag = true;
		if ($row['hp_name_japanese'] != $_POST['hp_name_japanese']) $change_flag = true;
		if ($row['hp_place_english'] != $_POST['hp_place_english']) $change_flag = true;
		if ($row['hp_place_japanese'] != $_POST['hp_place_japanese']) $change_flag = true;
		if ($row['member_kind'] != $_POST['member_kind']) $change_flag = true;
		if ($row['sponsor'] != $_POST['sponsor']) $change_flag = true;
		if ($row['description'] != $_POST['description']) $change_flag = true;
		if ($row['nation'] != $_POST['nation']) $change_flag = true;

		if ($change_flag) {
			$stmt = $pdo->prepare("UPDATE `doctor_tbls` SET `english_sirname` = :english_sirname, ".
			"`english_firstname` = :english_firstname, `email` = :email, `phone` = :phone, `is_male` = :is_male, ".
			"`kana_sirname` = :kana_sirname, `kana_firstname` = :kana_firstname, `kanji_sirname` = :kanji_sirname, `kanji_firstname` = :kanji_firstname, ".
			"`hp_name_english` = :hp_name_english, `hp_name_japanese` = :hp_name_japanese, `hp_place_english` = :hp_place_english, ".
			"`hp_place_japanese` = :hp_place_japanese, `member_kind` = :member_kind, `sponsor` = :sponsor, `description` = :description, `nation` = :nation, ".
			"`changed` = :changed WHERE `id` = :id;");
			$stmt->bindValue(":id", $_POST['id'], PDO::PARAM_INT);
			$stmt->bindValue(":english_sirname", $_POST['english_sirname']);
			$stmt->bindValue(":english_firstname", $_POST['english_firstname']);
			$stmt->bindValue(":email", $_POST['email']);
			$stmt->bindValue(":phone", $_POST['phone']);
			$stmt->bindValue(":is_male", $_POST['is_male']);
			$stmt->bindValue(":kana_sirname", $_POST['kana_sirname']);
			$stmt->bindValue(":kana_firstname", $_POST['kana_firstname']); 
			$stmt->bindValue(":kanji_sirname", $_POST['kanji_sirname']);
			$stmt->bindValue(":kanji_firstname", $_POST['kanji_firstname']); 
			$stmt->bindValue(":hp_name_english", $_POST['hp_name_english']);
			$stmt->bindValue(":hp_name_japanese", $_POST['hp_name_japanese']);
			$stmt->bindValue(":hp_place_english", $_POST['hp_place_english']);
			$stmt->bindValue(":hp_place_japanese", $_POST['hp_place_japanese']); 
			$stmt->bindValue(":member_kind", $_POST['member_kind']);
			$stmt->bindValue(":sponsor", $_POST['sponsor']); 
			$stmt->bindValue(":description", $_POST['description']);
			$changed = date('Y-m-d H:i:s');			// 最後に変更した時間を記録
			$stmt->bindValue(":changed", $changed);
			$stmt->bindValue(":nation", $_POST['nation']);
	
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
	
	
	header('Location:../../dr_registration.php');
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
<div class="container"> </div>
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