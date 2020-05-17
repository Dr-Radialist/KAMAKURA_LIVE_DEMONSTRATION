<?php
/* このファイルは tri_session_tblsより session_tblsにデータ移行用に作成した*/
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

	$stmt = $pdo->prepare("SELECT * FROM `evt_session_tbls` WHERE `id` < '50' AND `id` > '1';");
	$stmt->execute();
	$rows_tri = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	
	
	$sql = "UPDATE `session_tbls` SET `begin` = :begin, `duration` = :duration, `sessionTitle` = :sessionTitle, ";
	$sql .= "`cosponsor` = :cosponsor, `chair` = :chair, `moderator` = :moderator, `speaker` = :speaker, ";
	$sql .= "`interpreter` = :interpreter, `lectureTitle` = :lectureTitle, `venue` = :venue, `description` = :description, ";
	$sql .= "`changed` = :changed WHERE `sessionNo` = :sessionNo AND `class` = 'evt';";
	$stmt = $pdo->prepare($sql);
	
	foreach ($rows_tri as $row_tri) {
		$stmt->bindValue(":begin", $row_tri['begin']);
		$stmt->bindValue(":duration", $row_tri['duration'], PDO::PARAM_INT);
		$stmt->bindValue(":sessionTitle", $row_tri['sessionTitle']);
		$stmt->bindValue(":cosponsor", $row_tri['cosponsor']);
		$stmt->bindValue(":chair", $row_tri['chair']);
		$stmt->bindValue(":moderator", $row_tri['moderator']);
		$stmt->bindValue(":speaker", $row_tri['speaker']);
		$stmt->bindValue(":interpreter", $row_tri['interpreter']);
		$stmt->bindValue(":lectureTitle", $row_tri['lectureTitle']);
		$stmt->bindValue(":venue", $row_tri['venue']);
		$stmt->bindValue(":description", $row_tri['description']);
		$stmt->bindValue(":changed", $row_tri['changed']);
		$stmt->bindValue(":sessionNo", $row_tri['sessionNo'], PDO::PARAM_INT);
		$stmt->execute();
	}
	
?>

