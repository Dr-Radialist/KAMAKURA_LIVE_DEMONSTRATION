<?php
	session_start();
	session_regenerate_id(true);
	require_once('../../../utilities/config.php');
	require_once('../../../utilities/lib.php');	
	charSetUTF8();
	
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

</head>

<body>

<div class="container">
<h1>Co-Medical session入力確認画面</h1>
<div class="container">
	<div width="100%" style="background-color: green; color:white; font-weight:bold; font-size:20px;">&nbsp;時刻: <?= _Q($_SESSION['sessionTime']) ?></div>
	<div class="row">
    <div class="container">
		<form name="evt" method="post" action="evt04.php">
		<div class="col-lg-12">
        <h3>セッション番号: <?= _Q($_SESSION['sessionNo']) ?></h3>
        	<h3>セッション分類: <?= _Q($_SESSION['sessionTitle']) ?></h3>
         <h3>セッション・タイトル: <?= _Q($_SESSION['sessionTitle']) ?></h3>
		<h4>座長: <?= _Q($_SESSION['sessionChair']) ?></h4>
        <?php 
			if ($_SESSION['sessionSubTitle'] != '') {
        			echo "<h5>セッション副題: "._Q($_SESSION['sessionSubTitle'])."</h5>";
         	} 
		 ?>
         <?php
		 	if ($_SESSION['sessionSpeaker'] != '') {
				echo "<h4>セッション演者: "._Q($_SESSION['sessionSpeaker'])."</h4>";
			}
		?>
        <?php
			if ($_SESSION['sessionRemark'] != '') {
        			echo "<h5>セッション注意: "._Q($_SESSION['sessionRemark'])."</h5>";
			}
		?>
        <p>セッション内容: <?= _Q($_SESSION['sessionContent']) ?></p>
        <?php
			if ($_SESSION['sponsor'] != '') {
        			echo "<h5>共催企業: "._Q($_SESSION['sponsor'])."</h5>";
			}
		?>
		</div>
    <input type="hidden" name="id" value="<?= $_SESSION['id'] ?>" />
    <input type="hidden" name="sessionNo" value="<?=$_SESSION['sessionNo']; ?>" />
    <input type="hidden" name="sessionTime" value="<?= _Q($_SESSION['sessionTime']); ?>"  />
    <input type="hidden" name="sessionTitle" value="<?= _Q($_SESSION['sessionTitle']); ?>" />  
    <input type="hidden" name="sessionChair" value="<?= _Q($_SESSION['sessionChair']); ?>"  />  
    <input type="hidden" name="sessionSubTitle" value="<?= _Q($_SESSION['sessionSubTitle']); ?>" />  
    <input type="hidden" name="sessionSpeaker" value="<?= _Q($_SESSION['sessionSpeaker']); ?>" />
    <input type="hidden" name="sessionRemark" value="<?= _Q($_SESSION['sessionRemark']); ?>" /> 
    <input type="hidden" name="sessionContent" value="<?= _Q($_SESSION['sessionContent']); ?>" />
    <input type="hidden" name="sponsor" value="<?= _Q($_SESSION['sponsor']); ?>" />
 
  <input type="submit" value="これで良いです" />
        </form>
        <form method="post" action="evt01.php">
         <input type="hidden" name="sessionNo" value="<?= $_SESSION['sessionNo']; ?>" />
         <input type="submit" value="内容に誤りがあります"  />
         </form>
        </div>
     </div>
      <hr>
  <footer>
    <p>&copy;  2013 - 2016 by NPO International TRI Network & KAMAKURA LIVE</p>
  </footer>
</div>


<script src = "https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha256-Sk3nkD6mLTMOF0EOpNtsIry+s1CsaqQC1rVLTAy+0yc= sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
<script>
	if (!window.jQuery) {
		document.write('<script src="bootstrap/jquery-2.1.4.min.js"><\/script><script src="bootstrap/js/bootstrap.min.js"><\/script>');
	}
</script>
<script src="../../../bootstrap/docs-assets/javascript/extension.js"></script>
<script src="../../../bootstrap/docs-assets/javascript/jglycy-1.0.js"></script>
<script src="../../../bootstrap/docs-assets/javascript/jtruncsubstr.js"></script>
<script src="../../index2016.js"></script>
</body>
</html>
