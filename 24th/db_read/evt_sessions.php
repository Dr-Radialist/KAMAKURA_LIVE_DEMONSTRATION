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
	
	$stmt = $pdo->prepare("SELECT * FROM `session_tbls` WHERE `sessionNo` = :sessionNo AND `class` = :class;");
	$stmt->bindValue(":sessionNo", $_POST['sessionNo'], PDO::PARAM_INT);
	$stmt->bindValue(":class", 'evt', PDO::PARAM_STR);
	$flag = $stmt->execute();
	if (!$flag) {
    		$infor = $stmt->errorInfo();
			exit($infor[2]);
	}
	$row = $stmt->fetch(PDO::FETCH_ASSOC);	
	
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
<title>KAMAKURA LIVE</title>
<!-- Bootstrap core CSS -->
<link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap.css">
<!-- Custom styles for this template -->
<link rel="stylesheet" type="text/css" href="../../bootstrap/jumbotron/jumbotron.css">
<link rel="stylesheet" type="text/css" href="../2016top.css">
</head>

<body>

<div class="container">
  <h1>EVTセッション詳細</h1>
  <div class="container">
    <div style="width: 100%; background-color: green; color:white; font-weight:bold; font-size:20px;">&nbsp;時刻:
    	 	<?= _Q(mb_substr($row['begin'], 0, 5))." - ".date("H:i", strtotime($row['begin']) + $row['duration'] * 60); ?>
    </div>
        <div class="row">

        <div class="col-lg-12">
          <h3>セッション番号:
            <?= _Q($row['sessionNo']) ?>
          </h3>
          <h3>セッション・タイトル:
            <?= _Q($row['sessionTitle']) ?>
          </h3>
          <h4>座長:
            <?=  _Q(makeEvtList($pdo, $row['sessionNo'], 1)) ?>
          </h4>
          <?php 
			if ($row['sessionTitle'] != '') {
        			echo "<h5>セッション・タイトル: "._Q($row['sessionTitle'])."</h5>";
         	} 
		 ?>
        <h4>モデレーター: 
        		<?= _Q(makeEvtList($pdo, $row['sessionNo'], 2)) ?>
         </h4>
          <?php
			if ($row['lectureTitle'] != '') {
        			echo "<h5>演題名: "._Q($row['lectureTitle'])."</h5>";
			}
		?>
        <h4>演者:
        		<?= _Q(makeEvtList($pdo, $row['sessionNo'], 3)) ?>
        </h4>
        <h5>カテ室画像診断者:
        		<?= _Q(makeEvtList($pdo, $row['sessionNo'], 4)) ?>
         </h5>
	
          <?php
			if ($row['venue'] != '') {
        			echo "<h5>会場名: "._Q($row['venue'])."</h5>";
			}
		?>
          <p>セッション内容:
            <?= _Q($row['description']) ?>
          </p>
          <?php
			if ($row['cosponsor'] != '') {
        			echo "<h5>共催企業: "._Q($row['cosponsor'])."</h5>";
			}
		?>
        </div>
       
      </div>
     
       <!-- <p><a class="btn btn-primary btn-lg" href="evt_session_all_read.php">戻る　&raquo;</a></p> -->
    
    <hr>
    <footer>
      <p>&copy;  2013 - 2016 by NPO International TRI Network & KAMAKURA LIVE</p>
    </footer>
  </div>
</div>



<script src = "https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha256-Sk3nkD6mLTMOF0EOpNtsIry+s1CsaqQC1rVLTAy+0yc= sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
<script>
	if (!window.jQuery) {
		document.write('<script src="../../../bootstrap/jquery-2.1.4.min.js"><\/script><script src="../../../bootstrap/js/bootstrap.min.js"><\/script>');
	}
</script>
<script src="../../bootstrap/docs-assets/javascript/extension.js"></script>
<script src="../../bootstrap/docs-assets/javascript/jglycy-1.0.js"></script>
<script src="../../bootstrap/docs-assets/javascript/jtruncsubstr.js"></script>
<script src="../index2016.js"></script>
</body>
</html>
