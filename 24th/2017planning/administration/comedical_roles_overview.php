<?php
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
	
	$stmt = $pdo->prepare("SELECT * FROM `session_tbls`WHERE `class` = 'com' ORDER BY `sessionNo` ASC;");
	$flag = $stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	if (!$flag) {
    		$infor = $stmt->errorInfo();
			exit($infor[2]);
	}
						
	$stmt = $pdo->prepare("SELECT MAX(`changed`) FROM `session_tbls`;");
	$stmt->execute();
	$row_come = $stmt->fetch(PDO::FETCH_ASSOC);
	
	$stmt = $pdo->prepare("SELECT MAX(`created`) FROM `role_tbls`");
	$stmt->execute();
	$row_role = $stmt->fetch(PDO::FETCH_ASSOC);
	
	$latest = $latest = max($row_come['MAX(`changed`)'], $row_role['MAX(`created`)']);
	
	$stmt = $pdo->prepare("SELECT * FROM `session_tbls` WHERE `sessionNo` > '0' AND `sessionNo`< '20' AND `class` = 'com' ORDER BY `sessionNo` ASC;");
	$stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	$result = "";
	$i = 1;
	foreach ($rows as $row) {
		$result .= "<tr><td class='small_left_align'>"._Q(mb_substr($row['begin'], 0, 5))." - ".date("H:i" , strtotime($row['begin']) +$row['duration']*60)."</td>";
		$result .= "<td class='small_left_align'>"._Q($row['sessionTitle'])._Q($row['lectureTitle'])."</td>";
		$result .= "<td class='small_left_align'>"._Q(makeComeList2($pdo, $i, 1))."</td>";
		$result .= "<td class='small_left_align'>"._Q(makeComeList2($pdo, $i, 2))._Q(makeComeList2($pdo, $i, 3))."</td></td>";
		$i++;
	}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="../../../favicon.ico">
<title>KAMAKURA LIVE</title>
<!-- Bootstrap core CSS -->
<link rel="stylesheet" type="text/css" href="../../../bootstrap/css/bootstrap.css">
<!-- Custom styles for this template -->
<link rel="stylesheet" type="text/css" href="../../../bootstrap/jumbotron/jumbotron.css">
<link rel="stylesheet" type="text/css" href="../../2016top.css">
<link rel="stylesheet" type="text/css" href="../../db_read/come_session_table.css">

</head>

<body>

<div class="container">
  <div class="row">
 
  <table class="table table-bordered small">
    <thead>
    <caption><h1 class="text-center text-danger">Role Overview 12/17 (SAT) <span style="color:red; font-weight:bold; font-size:small;">&nbsp;&nbsp;最終更新日時:
<?= $latest ?>
</span></h1></caption>
      <tr>
        <th class="small">時刻</th>
        <th class="small col-sm-2">Session</th>
        <th class="small">座長</th>
        <th class="small">Moderator/Speaker</th>
      </tr>
    </thead>
    <tbody>
   <?= $result ?>
    </tbody>
  </table>
  <hr>
  <footer>
    <p>&copy;  2013 - 2017 by NPO International TRI Network & KAMAKURA LIVE</p>
  </footer>
  </div>
</div>
<script src = "https://code.jquery.com/jquery-2.1.4.min.js"></script> 
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha256-Sk3nkD6mLTMOF0EOpNtsIry+s1CsaqQC1rVLTAy+0yc= sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script> 
<script>
	if (!window.jQuery) {
		document.write('<script src="../../bootstrap/jquery-2.1.4.min.js"><\/script><script src="../../bootstrap/js/bootstrap.min.js"><\/script>');
	}
</script> 
<script src="../../../bootstrap/docs-assets/javascript/extension.js"></script> 
<script src="../../../bootstrap/docs-assets/javascript/jglycy-1.0.js"></script> 
<script src="../../../bootstrap/docs-assets/javascript/jtruncsubstr.js"></script> 
<script src="../../index2016.js"></script>
</body>
</html>
