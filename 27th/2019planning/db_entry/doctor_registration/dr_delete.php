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
?>

<script>
	var ret = confirm("このFaculty番号"+<?= _Q($_POST['dr_delete']) ?>+"を削除します");
	if (!ret) {
		document.location = '../../dr_registration.php';
	}
</script>
	
	
<?php

	$stmt = $pdo->prepare("DELETE FROM `doctor_tbls` WHERE `id` = :id;");
	$stmt->bindValue(":id", $_POST['dr_delete'], PDO::PARAM_INT);
	$stmt->execute();
	header("Location: ../../dr_registration.php");
	exit();
			
?>

