﻿<?php
/*
これは非公開用Faculty Listデータベース維持プログラムである
*/

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
	} catch(PDOException $e) {
    		die($e->getMessage());
	}
	
	$sql = "INSERT INTO `role_tbls` (`sessionNo`, `dr_tbl_id`, `role_kind`, `created`, `class`) ";
	$sql .= "VALUES (:sessionNo, :dr_tbl_id, :role_kind, :created, :class);";
	$stmt = $pdo->prepare($sql);
	
	$stmt->bindValue(":sessionNo", $_POST['sessionNo'], PDO::PARAM_INT);
	$stmt->bindValue(":dr_tbl_id", $_POST['dr_id'], PDO::PARAM_INT);
	$stmt->bindValue(":role_kind", $_POST['role_kind'], PDO::PARAM_INT);
	$stmt->bindValue(":class", 'evt', PDO::PARAM_STR);
	$created = date('Y-m-d H:i:s');			// 作成した時刻を記録
	$stmt->bindValue(":created", $created);
	
	$flag = $stmt->execute();
	
	if (!$flag) {
    		$infor = $stmt->errorInfo();
			exit($infor[2]);
	}
	
	header("Location: ../../index2016evt_mod-m.php");
	exit();
         
?>

