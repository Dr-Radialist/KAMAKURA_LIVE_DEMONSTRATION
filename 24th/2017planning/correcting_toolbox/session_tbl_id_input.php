<?php
/*
これは非公開用
role_tblsに session_tbl_idを正確に入力するルーチン
*/

	session_start();
	session_regenerate_id(true);
	require_once('../../../utilities/config.php');
	require_once('../../../utilities/lib.php');	
	charSetUTF8();
	//接続
 	try {
    // MySQLサーバへ接続
   	$pdo = new PDO("mysql:host=$db_host;dbname=$db_name_sessions;charset=utf8", $db_user, $db_password);
	// 注意: 不要なspaceを挿入すると' $db_host'のようにみなされ、エラーとなる
	} catch(PDOException $e){
    		die($e->getMessage());
	}

	$sql = "SELECT * FROM `role_tbls` WHERE `sessionNo` <> '0' AND `year` = '".$this_year."' ORDER BY `id` ASC;";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);	// これで$rowsには　`role_tbls`の`id`を含めた集合が格納された
	
	foreach($rows as $row) {	// $rowには`role_tbls`の一行のみ収納された
			$sql2 = "SELECT * FROM `session_tbls` WHERE `sessionNo` = :sessionNo AND `class` = :class AND `year` = :year;";
			$stmt2 = $pdo->prepare($sql2);
			$stmt2->bindValue(":sessionNo", $row['sessionNo'], PDO::PARAM_INT);
			$stmt2->bindValue(":class", $row['class'], PDO::PARAM_STR) ;
			$stmt2->bindValue(":year", $this_year, PDO::PARAM_INT);
			$stmt2->execute();
			$row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
			$session_tbl_id = $row2['id'];	// $session_idは session_tblsの idである
			$sql3 = "UPDATE `role_tbls` SET `session_tbl_id` = :session_tbl_id WHERE `id` = :id;";
			$stmt3 = $pdo->prepare($sql3);
			$stmt3->bindValue(":session_tbl_id", $session_tbl_id, PDO::PARAM_INT);
			$stmt3->bindValue(":id", $row['id'], PDO::PARAM_INT);
			$stmt3->execute();
			//print_r($row);
			//echo "今から修正する role_tblsの id = ".$row['id']."<br>";
			//echo "修正する role_tblsの session_tbl_id = ".$session_tbl_id."<br><br>";
	}
	
	echo "修正完了<br>"; exit;
?>


