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
	
	$stmt = $pdo->prepare("SELECT *FROM `evt_session_tbls` WHERE `sessionNo` = :sessionNo;");
	$stmt->bindValue(":sessionNo", $_POST['sessionNo'], PDO::PARAM_INT);
	$stmt->execute();
	if ($stmt->rowCount() ==0) {	// 新規登録
		$stmt1 = $pdo->prepare("INSERT INTO `evt_session_tbls` (`sessionNo`) VALUES (:sessionNo);");
		$stmt1->bindValue(":sessionNo", $_POST['sessionNo'], PDO::PARAM_INT);
		$stmt1->execute();
		$stmt = $pdo->prepare("SELECT *FROM `evt_session_tbls` WHERE `sessionNo` = :sessionNo;");
		$stmt->bindValue(":sessionNo", $_POST['sessionNo'], PDO::PARAM_INT);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);	
	} else {	
		$row = $stmt->fetch(PDO::FETCH_ASSOC);	
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

</head>

<body>

<div class="container">
<div class=" col-lg-10">
<h1>EVT Session入力・修正フォーム</h1>
  <div class="row">
  <form name="evt" method="post" action="evt02.php">
  <input type="hidden" name="id" value="<?= $row['id'] ?>" />
  <div class="form-group">
    <label for="sessionNo">session No</label>
    <input type="text" class="form-control" name="sessionNo" value="<?=$row['sessionNo'] ?>" readonly />
  </div>
  <div class="form-group">
    <label for="sessionTime">セッション時間帯<span class="req">必須</span></label>
    <input type="text" class="form-control" name="sessionTime" placeholder="セッション時間帯(例: 09:30 - 10:30 のような半角文字)を入力して下さい"
    value="<?php if (($row['sessionTime']) != '')  echo $row['sessionTime']; ?>" required />
  </div>
  <div class="form-group">
    <label for="sessionTitle">セッションタイトル<span class="req">必須</span></label>
    <input type="text" class="form-control" name="sessionTitle" placeholder="sessionタイトルを入力して下さい(必須入力)"
    value="<?php if (($row['sessionTitle']) != '')  echo $row['sessionTitle']; ?>" required />
  </div>
  <div class="form-group">
    <label for="sessionChair">セッション座長<span class="req">必須</span></label>
    <input type="text" class="form-control" name="sessionChair" placeholder="session座長を入力して下さい(必須入力)"
    value="<?php if (($row['sessionChair']) != '')  echo $row['sessionChair']; ?>" required />
  </div>
  <div class="form-group">
    <label for="sessionSubTitle">セッション副題</label>
    <input type="text" class="form-control" name="sessionSubTitle" placeholder="セッション副題を入力して下さい"
    value="<?php if (($row['sessionSubTitle']) != '')  echo $row['sessionSubTitle']; ?>" />
  </div>
  <div class="form-group">
    <label for="sessionSpeaker">セッション演者</label>
    <input type="text" class="form-control" name="sessionSpeaker" placeholder="セッション演者を入力して下さい"
    value="<?php if (($row['sessionSpeaker']) != '')  echo $row['sessionSpeaker']; ?>" />
  </div>
  <div class="form-group">
    <label for="sessionRemark">セッション注意点</label>
    <input type="text" class="form-control" name="sessionRemark" placeholder="セッション注意点(発表時間など)を入力して下さい"
    value="<?php if (($row['sessionRemark']) != '')  echo $row['sessionRemark']; ?>" />
  </div>
  <div class="form-group">
    <label for="sessionContent">セッション内容<span class="req">必須</span></label>
    <textarea class="form-control" name="sessionContent" rows="4" required><?= $row['sessionContent']; ?></textarea>
  </div>
  <div class="form-group">
    <label for="sessionContent">共催企業</label>
    <input type="text" class="form-control" name="sponsor" placeholder="共催企業があれば、入力して下さい"
    value="<?php if (($row['sponsor']) != '')  echo $row['sponsor']; ?>"  />
  </div>
  <input type="submit" value="入力"></input>
</form> 

  </div>
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
		document.write('<script src="bootstrap/jquery-2.1.4.min.js"><\/script><script src="bootstrap/js/bootstrap.min.js"><\/script>');
	}
</script>
<script src="../../../bootstrap/docs-assets/javascript/extension.js"></script>
<script src="../../../bootstrap/docs-assets/javascript/jglycy-1.0.js"></script>
<script src="../../../bootstrap/docs-assets/javascript/jtruncsubstr.js"></script>
<script src="../../index2016.js"></script>
</body>
</html>
