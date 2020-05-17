<?php
/*
これは非公開用Faculty Listデータベース維持プログラムである
*/

	session_start();
	session_regenerate_id(true);
	require_once('../../utilities/config.php');
	require_once('../../utilities/lib.php');	
	charSetUTF8();
	//接続
 	try {
    // MySQLサーバへ接続
   	$pdo = new PDO("mysql:host=$db_host;dbname=$db_name_sessions;charset=utf8", $db_user, $db_password);
	// 注意: 不要なspaceを挿入すると' $db_host'のようにみなされ、エラーとなる
	} catch(PDOException $e){
    	die($e->getMessage());
	}
	
	$stmt = $pdo->prepare("SELECT * FROM `doctor_tbls` WHERE '1' = '1';");
	$flag = $stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
  	foreach ($rows as $row) {
		$_SESSION['email'] = preg_replace('/^[ 　]+/u', '', $_SESSION['email']);
		$_SESSION['email']  = preg_replace('/[ 　]+$/u', '', $_SESSION['email']);
		$hp_name_japanese = mb_convert_kana($row['hp_name_japanese'], 'ash');
		$hp_name_japanese = trim($hp_name_japanese) . '/医師';
		$stmt1 = $pdo->prepare("UPDATE `doctor_tbls` SET `hp_name_japanese` = :hp_name_japanese WHERE `id` = :id;");
		$stmt1->bindValue(":hp_name_japanese", $hp_name_japanese);
		$stmt1->bindValue(":id", $row['id'], PDO::PARAM_INT);
		$stmt1->execute();
	}
          
	

?>
