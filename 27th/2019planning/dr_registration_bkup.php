﻿<?php
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
	
	$stmt_latest = $pdo->prepare("SELECT MAX(`changed`) FROM `doctor_tbls` WHERE '1' = '1';");
	$stmt_latest->execute();
	$row_latest = $stmt_latest->fetch(PDO::FETCH_ASSOC);
	$latest = $row_latest['MAX(`changed`)']; 
	
	$stmt = $pdo->prepare("SELECT * FROM `doctor_tbls` WHERE '1' = '1' ORDER BY `member_kind` DESC;");
	$flag = $stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	if (!$flag) {
    		$infor = $stmt->errorInfo();
			exit($infor[2]);
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
<link rel="shortcut icon" href="../../favicon.ico">
<title>KAMAKURA LIVE Faculty Registration</title>
<!-- Bootstrap core CSS -->
<link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap.css">
<!-- Custom styles for this template -->
<link rel="stylesheet" type="text/css" href="../../bootstrap/jumbotron/jumbotron.css">
<link rel="stylesheet" type="text/css" href="../2016top.css">
<link rel="stylesheet" type="text/css" href="../db_read/tri_session_table.css">
</head>

<body>
<h1 class="text-center text-danger">Faculty Member Registration<span style="color:red; font-weight:bold; font-size:small;">&nbsp;&nbsp;最終更新日時:
  <?= $latest ?>
  </span></h1>
<div class="row">
  <div class="col-lg-11">
    <form method="post" action="../2019planning/db_entry/doctor_registration/dr01.php">
    <div class="small">
       <table class="table table-striped">
        <thead>
          <tr>
            <th class="small">#</th>
            <th class="smf">Name</th>
            <th class="smf">カナ名前</th>
            <th class="smf">名前</th>
            <th class="smf">病院名</th>         
            <th class="smf">Nation</th>
            <th class="smf">種別</th>
            <th class="smf">email</th>
          </tr>
        </thead>
        <tbody>
         <?php
		  $i = 1;
  	foreach ($rows as $row) {
		echo "<tr>";
			echo "<td><button type='hidden' value="._Q($row['id'])." name='id'>".$i."修正</button></td>";
			echo "<td>"._Q($row['english_sirname'])." "._Q($row['english_firstname'])."</td>";
			echo "<td>"._Q($row['kana_sirname'])." "._Q($row['kana_firstname'])."</td>";
			echo "<td>"._Q($row['kanji_sirname'])." "._Q($row['kanji_firstname'])."</td>";
			echo "<td>"._Q($row['hp_name_japanese'])."</td>";
			echo "<td>"._Q($row['nation'])."</td>";
			echo "<td>";
				if ($row['member_kind'] == 1) echo "NPO社員";
				if ($row['member_kind'] == 2) echo "NPO年次社員";
				if ($row['member_kind'] == 3) echo "海外招聘";
				if ($row['member_kind'] == 4) echo "国内招聘";
			echo "</td>";
			echo "<td>"._Q($row['email'])."</td>";
		echo "</tr>";
		$i++; 
	}
	?>
          <tr>
            <td><button type="submit" value="99999999" name="id" class="btn-danger"><i class="glyphicon glyphicon-plus"></i> </button></td>
          </tr>
        </tbody>
      </table>
      </div>
    </form>
  </div>
</div>
<script src = "https://code.jquery.com/jquery-2.1.4.min.js"></script> 
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha256-Sk3nkD6mLTMOF0EOpNtsIry+s1CsaqQC1rVLTAy+0yc= sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script> 
<script>
	if (!window.jQuery) {
		document.write('<script src="../../bootstrap/jquery-2.1.4.min.js"><\/script><script src="../../bootstrap/js/bootstrap.min.js"><\/script>');
	}
</script> 
<script src="../../bootstrap/docs-assets/javascript/extension.js"></script> 
<script src="../../bootstrap/docs-assets/javascript/jglycy-1.0.js"></script> 
<script src="../../bootstrap/docs-assets/javascript/jtruncsubstr.js"></script> 
<script src="../index2016.js"></script>
</body>
</html>
