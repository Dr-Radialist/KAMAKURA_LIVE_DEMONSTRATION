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
	
	$stmt = $pdo->prepare("SELECT * FROM `doctor_tbls` WHERE `id` = :id  ORDER BY `english_sirname`, `english_firstname`, `kana_sirname`;");
	$stmt->bindValue(":id", $_POST['id'], PDO::PARAM_INT);
	$stmt->execute();
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
<link rel="shortcut icon" href="../../../../favicon.ico">
<title>KAMAKURA LIVE Faculty Registration</title>
<!-- Bootstrap core CSS -->
<link rel="stylesheet" type="text/css" href="../../../../bootstrap/css/bootstrap.css">
<!-- Custom styles for this template -->
<link rel="stylesheet" type="text/css" href="../../../../bootstrap/jumbotron/jumbotron.css">
<link rel="stylesheet" type="text/css" href="../../../2016top.css">
</head>

<body>
<div class="container">
  <div class=" col-lg-10">
    <h1>FacultyI入力・修正フォーム</h1>
    <div class="row">
      <form name="doctor" method="post" action="dr02.php">
        <input type="hidden" name="id" value="<?=_Q($row['id']); ?>" />
        <input type="hidden" name="new_old" value="<?=_Q($_POST['new_old']); ?>" />
        <div class="form-group">
          <label for="english_sirname">英語Sirname<span class="req">必須</span></label>
          <input type="text" class="form-control" name="english_sirname" value="<?= _Q($row['english_sirname']); ?>" 
          placeholder="英語のSirname(Last Name)を入力して下さい"  />
        </div>
        <div class="form-group">
          <label for="english_firstname">英語Firstname<span class="req">必須</span></label>
          <input type="text" class="form-control" name="english_firstname" value="<?= _Q($row['english_firstname']); ?>"  
          placeholder="英語のFirstnameを入力して下さい"  required/>
        </div>
        <div class="form-group">
          <label for="email">email<span class="req">必須</span></label>
          <input type="text" class="form-control" name="email" value="<?= _Q($row['email']); ?>"  
          placeholder="email addressを入力して下さい"  required />
        </div>
        <div class="form-group">
          <label for="phone">電話番号</label>
          <input type="text" class="form-control" name="phone" value="<?= _Q($row['phone']); ?>"  
          placeholder="電話番号を入力して下さい" />
        </div>
        <div class="form-group">
          <p class="form-inline"><b>性別</b></p>
          <div class="radio-inline">
            <input type="radio" value="1" name="is_male" id="man"
        <?php
            		if ($row['is_male'] == 1) echo " checked='checked'";
			?>
            />
            <label for="man">男性</label>
          </div>
          <div class="radio-inline">
            <input type="radio" value="0" name="is_male" id="woman"
        <?php
            		if ($row['is_male'] == 0) echo " checked='checked'";
			?>
            />
            <label for="woman">女性</label>
          </div>
        </div>
        <div class="form-group">
          <label for="kana_sirname">かな姓</label>
          <input type="text" class="form-control" name="kana_sirname" placeholder="かな姓を入力して下さい"
    value="<?php if (($row['kana_sirname']) != '')  echo _Q($row['kana_sirname']); ?>" />
        </div>
        <div class="form-group">
          <label for="kana_firstname">かな名</label>
          <input type="text" class="form-control" name="kana_firstname" placeholder="かな名を入力して下さい"
    value="<?php if (($row['kana_firstname']) != '')  echo _Q($row['kana_firstname']); ?>" />
        </div>
        <div class="form-group">
          <label for="kanji_sirname">漢字姓</label>
          <input type="text" class="form-control" name="kanji_sirname" placeholder="漢字姓を入力して下さい"
    value="<?php if (($row['kanji_sirname']) != '')  echo _Q($row['kanji_sirname']); ?>" />
        </div>
        <div class="form-group">
          <label for="kanji_firstname">漢字名</label>
          <input type="text" class="form-control" name="kanji_firstname" placeholder="漢字名を入力して下さい"
    value="<?php if (($row['kanji_firstname']) != '')  echo _Q($row['kanji_firstname']); ?>" />
        </div>
        <div class="form-group">
          <label for="hp_name_english">英語病院名</label>
          <input type="text" class="form-control" name="hp_name_english" placeholder="英語病院名を入力して下さい"
    value="<?php if (($row['hp_name_english']) != '')  echo _Q($row['hp_name_english']); ?>" />
        </div>
        <div class="form-group">
          <label for="hp_name_japanese">日本語病院名</label>
          <input type="text" class="form-control" name="hp_name_japanese" placeholder="日本語病院名を入力して下さい"
    value="<?php if (($row['hp_name_japanese']) != '')  echo _Q($row['hp_name_japanese']); ?>" />
        </div>
        <div class="form-group">
          <label for="nation">英語国名</label>
          <input type="text" class="form-control" name="nation" placeholder="英語国名を入力して下さい"
    value="<?php if (($row['nation']) != '')  echo _Q($row['nation']); ?>" />
        </div>
        <div class="form-group">
          <label for="hp_place_english">英語病院住所</label>
          <input type="text" class="form-control" name="hp_place_english" placeholder="英語病院住所を入力して下さい"
    value="<?php if (($row['hp_place_english']) != '')  echo _Q($row['hp_place_english']); ?>" />
        </div>
        <div class="form-group">
          <label for="hp_place_japanese">日本語病院住所</label>
          <input type="text" class="form-control" name="hp_place_japanese" placeholder="日本語病院住所を入力して下さい"
    value="<?php if (($row['hp_place_japanese']) != '')  echo _Q($row['hp_place_japanese']); ?>" />
        </div>
        <div class="form-group">
          <label for="selected">Faculty種別&nbsp;</label>
          <select class="custom-select" name="member_kind">
            <option value="1" <?php if ($row['member_kind'] == 1) echo "selected"; ?>>NPO社員</option>
            <option value="2" <?php if ($row['member_kind'] == 2) echo "selected"; ?>>NPO年次社員</option>
            <option value="3" <?php if ($row['member_kind'] == 3) echo "selected"; ?>>海外招聘</option>
            <option value="4" <?php if ($row['member_kind'] == 4) echo "selected"; ?>>国内招聘</option>
            <option value="5" <?php if ($row['member_kind'] == 5) echo "selected"; ?>>親善参加</option>
            <option value="6" <?php if ($row['member_kind'] == 6) echo "selected"; ?>>Sd (Sponsored) Faculty</option>
          </select>
        </div>
        <div class="form-group">
          <label for="description">その他</label>
          <textarea class="form-control" name="description" rows="4" 
    placeholder="その他何でも記載してください"><?= _Q($row['description']); ?>
</textarea>
        </div>
        <div class="form-group">
          <label for="sessionContent">スポンサー</label>
          <input type="text" class="form-control" name="sponsor" placeholder="スポンサーがあれば、入力して下さい"
    value="<?php if (($row['sponsor']) != '')  echo _Q($row['sponsor']); ?>"  />
        </div>
        <input type="submit" value="入力" class="btn btn-danger" />
      </form>
      <br><br><br>
      <form method="post" action="dr_delete.php">
        <button type="submit" id="dr_delete" name="dr_delete" value="<?= $_POST['id'] ?>">このFacultyを削除する</button>
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
