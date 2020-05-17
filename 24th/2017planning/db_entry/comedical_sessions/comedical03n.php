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
	$class = 'com';
	
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
<div class="container">
  <h1>コメディカル・セッション入力確認画面</h1>
  <div class="container">
    <div style="width: 100%; background-color: green; color:white; font-weight:bold; font-size:20px;">&nbsp;時刻:
    	 <?php
		 if ($_SESSION['begin'] == "00:00") {
			 echo "開始時刻不定: 講演時間 15分間";
		 }  else {
    	 		echo _Q($_SESSION['begin'])." - ".date("H:i", strtotime($_SESSION['begin']) + $_SESSION['duration'] * 60); 
		 }
	 ?>
    </div>
    <div class="row">
      <form name="tri" method="post" action="comedical04n.php">
        <div class="col-lg-12">
          <h3>セッション番号:
            <?= _Q($_SESSION['sessionNo']) ?>
          </h3>
          <h3>セッション・タイトル:
            <?= _Q($_SESSION['sessionTitle']) ?>
          </h3>
          <h4>座長:
            <?=  _Q(makeComeList2017($pdo, $_SESSION['sessionNo'], 1, $class, $this_year)) ?>
          </h4>
          <?php 
			if ($_SESSION['sessionTitle'] != '') {
        			echo "<h5>セッション・タイトル: "._Q($_SESSION['sessionTitle'])."</h5>";
         	} 
		 ?>
        <h4>モデレーター: 
        		<?= _Q(makeComeList2017($pdo, $_SESSION['sessionNo'], 2, $class, $this_year)) ?>
         </h4>
          <?php
			if ($_SESSION['lectureTitle'] != '') {
        			echo "<h5>演題名: "._Q($_SESSION['lectureTitle'])."</h5>";
			}
		?>
        <h4>演者:
        		<?= _Q(makeComeList2017($pdo, $_SESSION['sessionNo'], 3, $class, $this_year)) ?>
        </h4>
        <h5>カテ室画像診断者:
        		<?= _Q(makeComeList2017($pdo, $_SESSION['sessionNo'], 4, $class, $this_year)) ?>
         </h5>
	
          <?php
			if ($_SESSION['venue'] != '') {
        			echo "<h5>会場名: "._Q($_SESSION['venue'])."</h5>";
			}
		?>
          <p>セッション内容:
            <?= _Q($_SESSION['description']) ?>
          </p>
          <?php
			if ($_SESSION['cosponsor'] != '') {
        			echo "<h5>共催企業: "._Q($_SESSION['cosponsor'])."</h5>";
			}
		?>
        </div>
        <input type="hidden" name="id" value="<?= $_SESSION['id'] ?>" />
        <input type="hidden" name="begin" value="<?=$_SESSION['begin']; ?>" />
        <input type="hidden" name="duration" value="<?= _Q($_SESSION['duration']); ?>"  />
        <input type="hidden" name="sessionTitle" value="<?= _Q($_SESSION['sessionTitle']); ?>" />
        <input type="hidden" name="lectureTitle" value="<?= _Q($_SESSION['lectureTitle']); ?>" />
        <input type="hidden" name="venue" value="<?= _Q($_SESSION['venue']); ?>" />
        <input type="hidden" name="description" value="<?= _Q($_SESSION['description']); ?>" />
        <input type="hidden" name="cosponsor" value="<?= _Q($_SESSION['cosponsor']); ?>" />
        <input type="submit" value="これで良いです" />
      </form>
      </div>
      <form method="post" action="comedical01n.php">
        <input type="hidden" name="sessionNo" value="<?= $_SESSION['sessionNo']; ?>" />
        <input type="submit" value="内容に誤りがあります"  />
      </form>
    
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
		document.write('<script src="bootstrap/jquery-2.1.4.min.js"><\/script><script src="bootstrap/js/bootstrap.min.js"><\/script>');
	}
</script> 
<script src="../../../../bootstrap/docs-assets/javascript/extension.js"></script> 
<script src="../../../../bootstrap/docs-assets/javascript/jglycy-1.0.js"></script> 
<script src="../../../../bootstrap/docs-assets/javascript/jtruncsubstr.js"></script> 
<script src="../../../index2017.js"></script>
</body>
</html>
