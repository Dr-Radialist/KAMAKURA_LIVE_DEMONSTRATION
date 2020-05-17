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
	
	$stmt = $pdo->prepare("SELECT * FROM `session_tbls` WHERE `sessionNo` = :sessionNo  AND `class` = :class AND `year` = '".$this_year."';");
	$stmt->bindValue(":sessionNo", $_POST['sessionNo'], PDO::PARAM_INT);
	$stmt->bindValue(":class", 'com', PDO::PARAM_STR);
	$stmt->execute();
	$row = $stmt->fetch(PDO::FETCH_ASSOC);	
	
	$sql = "SELECT * FROM `doctor_tbls` INNER JOIN `role_tbls` ON `doctor_tbls`.`id` = `role_tbls`.`dr_tbl_id` ";
	$sql .= "WHERE `role_tbls`.`sessionNo` = :sessionNo AND `role_tbls`.`role_kind` = :role_kind AND `role_tbls`.`class` = :class";
	$sql .= " AND `role_tbls`.`year` = '".$this_year."';";
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(":sessionNo", $_POST['sessionNo'], PDO::PARAM_INT);
	$stmt->bindValue(":role_kind", '1', pdo::PARAM_INT);
	$stmt->bindValue(":class", 'com', PDO::PARAM_STR);
	$stmt->execute();
	$chairs = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	$chair_list = '';
	echo '<div name="delete_role" class="input-group">';
	foreach ($chairs as $chair) {
		$chair_list .= '<form class="form-inline" method="post" action="delete_role.php">';
		$chair_list .= '<button type="submit" id="delete_role" /><i class="glyphicon glyphicon-remove-sign"></i></button>';
		$chair_list .= '<input type="hidden" name="id" value="'.$chair['id'].'" />';
		if (!isset($chair['kanji_sirname'])||$chair['kanji_sirname'] == "") {
			$chair_list .= $chair['english_sirname']." ".$chair['english_firstname'];
			$chair_list .= " (".$chair['hp_name_english']."), ";
		} else {
			$chair_list .= $chair['kanji_sirname']." ".$chair['kanji_firstname'];
			$chair_list .= " (".$chair['hp_name_japanese']."), ";		
		}
		$chair_list .= '</form>';
	}
	echo '</div>';
	$chair_list = rtrim($chair_list, ', ');
	
	
	$sql = "SELECT * FROM `doctor_tbls` INNER JOIN `role_tbls` ON `doctor_tbls`.`id` = `role_tbls`.`dr_tbl_id` ";
	$sql .= "WHERE `role_tbls`.`sessionNo` = :sessionNo AND `role_tbls`.`role_kind` = :role_kind AND `role_tbls`.`class` = :class";
	$sql .= " AND `role_tbls`.`year` = '".$this_year."';";
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(":sessionNo", $_POST['sessionNo'], PDO::PARAM_INT);
	$stmt->bindValue(":role_kind", '2', pdo::PARAM_INT);
	$stmt->bindValue(":class", 'com', PDO::PARAM_STR);
	$stmt->execute();
	$moderators = $stmt->fetchAll(PDO::FETCH_ASSOC);	
	$moderator_list = '';
	foreach ($moderators as $moderator) {
		$moderator_list .= '<form class="form-inline" method="post" action="delete_role.php">';
		$moderator_list .= '<button type="submit" id="delete_role" /><i class="glyphicon glyphicon-remove-sign"></i></button>';
		$moderator_list .= '<input type="hidden" name="id" value="'.$moderator['id'].'" />';
		if (!isset($moderator['kanji_sirname'])||$moderator['kanji_sirname'] == "") {
			$moderator_list .= $moderator['english_sirname']." ".$moderator['english_firstname'];
			$moderator_list .= "(".$moderator['hp_name_english']."), ";
		} else {
			$moderator_list .= $moderator['kanji_sirname']." ".$moderator['kanji_firstname'];
			$moderator_list .= "(".$moderator['hp_name_japanese']."), ";		
		}
		$moderator_list .= '</form>';
	}
	$moderator_list = rtrim($moderator_list, ', ');
	
	$sql = "SELECT * FROM `doctor_tbls` INNER JOIN `role_tbls` ON `doctor_tbls`.`id` = `role_tbls`.`dr_tbl_id` ";
	$sql .= "WHERE `role_tbls`.`sessionNo` = :sessionNo AND `role_tbls`.`role_kind` = :role_kind AND `role_tbls`.`class` = :class";
	$sql .= " AND `role_tbls`.`year` = '".$this_year."';";
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(":sessionNo", $_POST['sessionNo'], PDO::PARAM_INT);
	$stmt->bindValue(":role_kind", '3', pdo::PARAM_INT);
	$stmt->bindValue(":class", 'com', PDO::PARAM_STR);
	$stmt->execute();
	$lecturers = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$lecturer_list = '';
	foreach ($lecturers as $lecturer) {
		$lecturer_list .= '<form class="form-inline" method="post" action="delete_role.php">';
		$lecturer_list .= '<button type="submit" id="delete_role" /><i class="glyphicon glyphicon-remove-sign"></i></button>';
		$lecturer_list .= '<input type="hidden" name="id" value="'.$lecturer['id'].'" />';
		if (!isset($lecturer['kanji_sirname'])||$lecturer['kanji_sirname'] == "") {
			$lecturer_list .= $lecturer['english_sirname']." ".$lecturer['english_firstname'];
			$lecturer_list .= "(".$lecturer['hp_name_english']."), ";
		} else {
			$lecturer_list .= $lecturer['kanji_sirname']." ".$lecturer['kanji_firstname'];
			$lecturer_list .= "(".$lecturer['hp_name_japanese']."), ";		
		}
		$lecturer_list .= '</form>';
	}
	$lecturer_list = rtrim($lecturer_list, ', ');
	
	$sql = "SELECT * FROM `doctor_tbls` INNER JOIN `role_tbls` ON `doctor_tbls`.`id` = `role_tbls`.`dr_tbl_id` ";
	$sql .= "WHERE `role_tbls`.`sessionNo` = :sessionNo AND `role_tbls`.`role_kind` = :role_kind AND `role_tbls`.`class` = :class";
	$sql .= " AND `role_tbls`.`year` = '".$this_year."';";
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(":sessionNo", $_POST['sessionNo'], PDO::PARAM_INT);
	$stmt->bindValue(":role_kind", '4', pdo::PARAM_INT);
	$stmt->bindValue(":class", 'com', PDO::PARAM_STR);
	$stmt->execute();
	$interpreters = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$interpreter_list = '';
	foreach ($interpreters as $interpreter) {
		$interpreter_list .= '<form class="form-inline" method="post" action="delete_role.php">';
		$interpreter_list .= '<button type="submit" id="delete_role" /><i class="glyphicon glyphicon-remove-sign"></i></button>';
		$interpreter_list .= '<input type="hidden" name="id" value="'.$interpreter['id'].'" />';
		if (!isset($interpreter['kanji_sirname'])||$interpreter['kanji_sirname'] == "") {
			$interpreter_list .= $interpreter['english_sirname']." ".$interpreter['english_firstname'];
			$lecturer_list .= "(".$interpreter['hp_name_english']."), ";
		} else {
			$interpreter_list .= $interpreter['kanji_sirname']." ".$interpreter['kanji_firstname'];
			$interpreter_list .= "(".$interpreter['hp_name_japanese']."), ";		
		}
		$interpreter_list .= '</form>';
	}
	$interpreter_list = rtrim($interpreter_list, ', ');
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
  <div class=" col-sm-12">
    <h1>Co-medicaセッション入力・修正フォーム</h1>
    <div class="row form-inline">
      <form name="come" method="post" action="comedical02n.php">
        <input type="hidden" name="id" value="<?= $row['id'] ?>" />
        <div class="form-group">
          <label for="sessionNo">session No</label>
          <input type="text" class="form-control" name="sessionNo" value="<?=$row['sessionNo'] ?>" readonly />
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
          <textarea class="form-control" name="description" rows="8" 
    placeholder="セッションの内容について記載してください"><?= _Q($row['description']); ?>
</textarea>
        </div>
        <div class="form-group">
          <label for="sessionContent">共催企業</label>
          <input type="text" class="form-control" name="cosponsor" placeholder="共催企業があれば、入力して下さい"
    value="<?php if (($row['cosponsor']) != '')  echo _Q($row['cosponsor']); ?>"  />
        </div>
        <input type="submit" class="btn btn-danger btn-lg" value="入力/修正/終了" />
      </form><br><br>
    </div>

    <div class="row form-group form-inline">
      <div class="col-sm-6">
        <div class="text-left">
          <form method="post" action="chair_mod_add01.php" class="form-inline text-left";>
            <button type="submit" class="btn btn-sm" name="session_tbl_id" value="<?= $row['id'] ?>">Chair追加</button>
            <input type="hidden" name="role_kind" value="1" />
            <input type="hidden" name="sessionNo" value="<?= _Q($row['sessionNo']); ?>" />
          </form>
          <div class="text-left">Chairs:
            <?= $chair_list ?>
          </div>
        </div>
        <div class="text-left">
          <form method="post" action="chair_mod_add01.php" class="form-inline text-left";>
            <button type="submit" class="btn btn-sm" name="session_tbl_id" value="<?= $row['id'] ?>">講師追加</button>
            <input type="hidden" name="role_kind" value="3" />
            <input type="hidden" name="sessionNo" value="<?= _Q($row['sessionNo']); ?>" />
          </form>
          <div class="text-left">講師:
            <?= $lecturer_list ?>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="text-right">
          <form method="post" action="chair_mod_add01.php" class="form-inline text-right";>
            <button type="submit" class="btn btn-sm" name="session_tbl_id" value="<?= $row['id'] ?>">Commentator追加</button>
            <input type="hidden" name="role_kind" value="2" />
            <input type="hidden" name="sessionNo" value="<?= _Q($row['sessionNo']); ?>" />
          </form>
          <div class="text-right">Commentator:
            <?= $moderator_list ?>
          </div>
        </div>
        <div class="text-right">
          <form method="post" action="chair_mod_add01.php" class="form-inline text-right";>
            <button type="submit" class="btn btn-sm" name="session_tbl_id" value="<?= $row['id'] ?>">カテ室画像診断追加</button>
            <input type="hidden" name="role_kind" value="3" />
            <input type="hidden" name="sessionNo" value="<?= _Q($row['sessionNo']); ?>" />
          </form>
          <div class="text-right">カテ室画像診断:
            <?= $interpreter_list ?>
          </div>
        </div>
      </div>
    </div>
  </div>
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
