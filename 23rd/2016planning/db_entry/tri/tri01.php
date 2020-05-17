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
	
	$stmt = $pdo->prepare("SELECT *FROM `tri_session_tbls` WHERE `sessionNo` = :sessionNo;");
	$stmt->bindValue(":sessionNo", $_POST['sessionNo'], PDO::PARAM_INT);
	$stmt->execute();
	if ($stmt->rowCount() ==0) {	// 新規登録
		$stmt1 = $pdo->prepare("INSERT INTO `tri_session_tbls` (`sessionNo`) VALUES (:sessionNo);");
		$stmt1->bindValue(":sessionNo", $_POST['sessionNo'], PDO::PARAM_INT);
		$stmt1->execute();
		$stmt = $pdo->prepare("SELECT *FROM `tri_session_tbls` WHERE `sessionNo` = :sessionNo;");
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
  <div class=" col-lg-10">
    <h1>TRIセッション入力・修正フォーム</h1>
    <div class="row">
      <form name="tri" method="post" action="tri02.php">
        <input type="hidden" name="id" value="<?= $row['id'] ?>" />
        <div class="form-group">
          <label for="sessionNo">session No</label>
          <input type="text" class="form-control" name="sessionNo" value="<?= _Q($row['sessionNo']); ?>" readonly />
        </div>
        <div class="form-group">
          <label for="sessionTime">セッション開始時刻</label>
          <input type="text" class="form-control" name="begin" placeholder="開始時刻を入力して下さい"
    value="<?php if (($row['begin']) != '')  echo _Q(mb_substr($row['begin'], 0, 5)); ?>" />
        </div>
        <div class="form-group">
          <label for="sessionTime">セッション開催時間(分)<span class="req">必須</span></label>
          <input type="text" class="form-control" name="duration" placeholder="セッション持続時間(分)を入力して下さい"
    value="<?php if (($row['duration']) != '')  echo _Q($row['duration']); ?>" required />
        </div>
        <div class="form-group">
          <label for="sessionTitle">セッションタイトル<span class="req">必須</span></label>
          <input type="text" class="form-control" name="sessionTitle" placeholder="sessionタイトルを入力して下さい(必須入力)"
    value="<?php if (($row['sessionTitle']) != '')  echo _Q($row['sessionTitle']); ?>" required />
        </div>
        <div class="form-group">
          <label for="chair">セッション座長<span class="req" id="chair_req">必須</span></label>
          <div class="form-inline">
            <label class="checkbox-inline" for="chair_non_determine">
            <input type="checkbox" name="chair_non_determine" id="chair_non_determine" />
            <p class="control-label"> <b>座長については後日決定します</b></p>
            </label>
          </div>
          <input type="text" class="form-control"  id="input_chair"  name="chair" placeholder="session座長を入力して下さい(必須入力)"
    value="<?php if (($row['chair']) != '')  echo _Q($row['chair']); ?>" required/>
        </div>
        <div class="form-group">
          <label for="moderator">Moderator</label>
          <input type="text" class="form-control" name="moderator" placeholder="Moderatorを入力して下さい"
    value="<?php if (($row['moderator']) != '')  echo _Q($row['moderator']); ?>" />
        </div>
        <div class="form-group">
          <label for="speaker">セッション演者</label>
          <input type="text" class="form-control" name="speaker" placeholder="セッション演者を入力して下さい"
    value="<?php if (($row['speaker']) != '')  echo _Q($row['speaker']); ?>" />
        </div>
        <div class="form-group">
          <label for="interpreter">カテ室画像診断</label>
          <input type="text" class="form-control" name="interpreter" placeholder="カテ室画像診断者を入力して下さい"
    value="<?php if (($row['interpreter']) != '')  echo _Q($row['interpreter']); ?>" />
        </div>
        <div class="form-group">
          <label for="lectureTitle">講演演題名</label>
          <input type="text" class="form-control" name="lectureTitle" placeholder="講演演題名を入力して下さい"
    value="<?php if (($row['lectureTitle']) != '')  echo _Q($row['lectureTitle']); ?>" />
        </div>
        <div class="form-group">
          <label for="venue">会場</label>
          <input type="text" class="form-control" name="venue" placeholder="会場名を入力して下さい"
    value="<?php if (($row['venue']) != '')  echo _Q($row['venue']); ?>" />
        </div>
        <div class="form-group">
          <label for="description">セッション内容</label>
          <textarea class="form-control" name="description" rows="4" 
    placeholder="セッションの内容について記載してください"><?= _Q($row['description']); ?>
</textarea>
        </div>
        <div class="form-group">
          <label for="sessionContent">共催企業</label>
          <input type="text" class="form-control" name="cosponsor" placeholder="共催企業があれば、入力して下さい"
    value="<?php if (($row['cosponsor']) != '')  echo _Q($row['cosponsor']); ?>"  />
        </div>
        <input type="submit" value="入力" />
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
		document.write('<script src="../../../../bootstrap/jquery-2.1.4.min.js"><\/script><script src="../../../../bootstrap/js/bootstrap.min.js"><\/script>');
	}
</script> 
<script src="../../../../bootstrap/docs-assets/javascript/extension.js"></script> 
<script src="../../../../bootstrap/docs-assets/javascript/jglycy-1.0.js"></script> 
<script src="../../../../bootstrap/docs-assets/javascript/jtruncsubstr.js"></script> 
<script src="../../../index2016.js"></script> 
<script type="text/javascript">
	jQuery(function() {
		$("#chair_non_determine").click(function() {
			if ($(this).is(":checked")) {
				$("#chair_req").hide();
				$("#input_chair").removeAttr('required');
				$("#input_chair").val("");
			} else {
				$("#chair_req").show();
				$("#input_chair").addAttr('required');
			}
		});
	});	
</script>
</body>
</html>
