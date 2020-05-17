<?php
/* このプログラムは MySQLに読み込むために作成したものであり
on-lineで動かすものではありません
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
	
	$stmt = $pdo->prepare("INSERT INTO `doctor_tbls` (`kanji_sirname`, `kanji_firstname`, `email`, `hp_name_japanese`, `nation`, `member_kind`) ".
		"VALUES (:kanji_sirname, :kanji_firstname, :email, :hp_name_japanese, :nation, :member_kind);");
		
	$fp = fopen('npo_member2016.txt', 'r');
	$i = 0;
	echo "<table>";
	echo "<th>#</th><th>email</th><th>姓</th><th>名</th><th>所属</th>";
	while (!feof($fp)) {
		$i++;
		$line = fgets($fp);
		$line = preg_replace('/\)/', '', $line);
		$line = preg_replace('/　/', ' ', $line);
		$row = preg_split('/[,\(,\s]/', $line);
		echo "<tr><td>".$i."</td><td>".$row['0']."</td><td>".$row['1']."</td><td>".$row['2']."</td><td>".$row['3']."</td></tr>";
		$stmt->bindValue(":kanji_sirname", $row['1']);
		$stmt->bindValue(":kanji_firstname", $row['2']);
		$stmt->bindValue(":email", $row['0']);
		$stmt->bindValue(":hp_name_japanese", $row['3']);
		$stmt->bindValue(":nation", "JAPAN");
		$stmt->bindValue(":member_kind", 1, PDO::PARAM_INT);
		$stmt->execute();
	}
	echo "</table>";
	fclose($fp);
		
		
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">

</head>

<body>

</body>
</html>
