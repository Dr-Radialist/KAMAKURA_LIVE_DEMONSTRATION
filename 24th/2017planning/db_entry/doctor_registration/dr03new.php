<?php
	session_start();
	session_regenerate_id(true);
	require_once('../../../../utilities/config.php');
	require_once('../../../../utilities/lib.php');	
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
  <h2 class="text-center text-info">Faculty入力確認画面</h2>
  <div class="container">
    <div class="row">
      <form name="doctor" method="post" action="dr04new.php">
        <?= "<h4>英語Sirname:　　"._Q($_SESSION['english_sirname'])."</h4>"; ?>
        <?= "<h4>英語Firstname:　　"._Q($_SESSION['english_firstname'])."</h4>"; ?>
        <?= "<h4>Email Addresse:　　"._Q($_SESSION['email'])."</h4>"; ?>
        <?= "<h4>電話番号:　　"._Q($_SESSION['phone'])."</h4>"; ?>
        <?= "<h4>性別:　　"; ?>
        <?php
		 	if ($_SESSION['is_male'] == 1) {
				echo "男性";
			} else {
				echo "女性";
			}
		?>
        <?= "</h4>"; ?>
        <?= "<h4>かな姓:　　"._Q($_SESSION['kana_sirname'])."</h4>"; ?>
        <?= "<h4>かな名:　　"._Q($_SESSION['kana_firstname'])."</h4>"; ?>
        <?= "<h4>漢字姓:　　"._Q($_SESSION['kanji_sirname'])."</h4>"; ?>
        <?= "<h4>漢字名:　　"._Q($_SESSION['kanji_firstname'])."</h4>"; ?>       
        <?= "<h4>英語病院名:　　"._Q($_SESSION['hp_name_english'])."</h4>"; ?>
        <?= "<h4>日本語病院名:　　"._Q($_SESSION['hp_name_japanese'])."</h4>"; ?>
        <?= "<h4>英語国名:　　"._Q($_SESSION['nation'])."</h4>"; ?>
        <?= "<h4>英語住所:　　"._Q($_SESSION['hp_place_english'])."</h4>"; ?>
        <?= "<h4>国名:　　"._Q($_SESSION['nation'])."</h4>"; ?>
        <?= "<h4>日本語住所:　　"._Q($_SESSION['hp_place_japanese'])."</h4>"; ?>
        <?= "<h4>メンバー種別:　　"; ?>
        <?php
		 	if ($_SESSION['member_kind'] < 1) {
					echo "不正です";
			} elseif ($_SESSION['member_kind'] == 1) {
				echo "NPO社員";
			} elseif ($_SESSION['member_kind'] == 2) {
				echo "NPO年次社員";
			} elseif ($_SESSION['member_kind'] == 3) {
				echo "海外招聘";
			} elseif ($_SESSION['member_kind'] == 4) {
				echo "国内招聘";
			} elseif ($_SESSION['member_kind'] == 5) {
				echo "親善参加";
			} elseif ($_SESSION['member_kind'] == 6) {
				echo "Sd (Sponsored) Faculty";
			} else {
				echo "それ以外";
			}
		?>
        <?= "</h4>"; ?>
        <?= "<h4>スポンサー:　　"._Q($_SESSION['sponsor'])."</h4>"; ?>
        <?= "<h4>特記事項:　　"._Q($_SESSION['description'])."</h4>"; ?>
        
           
        </div>
        <input type="hidden" name="id" value="<?= $_SESSION['id'] ?>" />
        <input type="hidden" name="english_sirname" value="<?=$_SESSION['english_sirname']; ?>" />
        <input type="hidden" name="english_firstname" value="<?= _Q($_SESSION['english_firstname']); ?>"  />
        <input type="hidden" name="email" value="<?= _Q($_SESSION['email']); ?>" />
        <input type="hidden" name="phone" value="<?= _Q($_SESSION['phone']); ?>"  />
        <input type="hidden" name="is_male" value="<?= _Q($_SESSION['is_male']); ?>" />
        <input type="hidden" name="kana_sirname" value="<?= _Q($_SESSION['kana_sirname']); ?>" />
        <input type="hidden" name="kana_firstname" value="<?= _Q($_SESSION['kana_firstname']); ?>" />
        <input type="hidden" name="kanji_sirname" value="<?= _Q($_SESSION['kanji_sirname']); ?>" />
        <input type="hidden" name="kanji_firstname" value="<?= _Q($_SESSION['kanji_firstname']); ?>" />
        <input type="hidden" name="hp_name_japanese" value="<?= _Q($_SESSION['hp_name_japanese']); ?>" />
        <input type="hidden" name="hp_name_english" value="<?= _Q($_SESSION['hp_name_english']); ?>" />
        <input type="hidden" name="hp_place_english" value="<?= _Q($_SESSION['hp_place_english']); ?>" />
        <input type="hidden" name="hp_place_japanese" value="<?= _Q($_SESSION['hp_place_japanese']); ?>" />
        <input type="hidden" name="member_kind" value="<?= _Q($_SESSION['member_kind']); ?>" />
        <input type="hidden" name="sponsor" value="<?= _Q($_SESSION['sponsor']); ?>" />
        <input type="hidden" name="description" value="<?= _Q($_SESSION['description']); ?>" />
        <input type="hidden" name="nation" value="<?= _Q($_SESSION['nation']); ?>" />
        <input type="hidden" name="new_old" value="<?=_Q($_SESSION['new_old']); ?>" />
        <input type="submit" value="これで良いです" class="btn btn-primary" /><br>
      </form>
    </div>
    <div><br><br></div>
    <form method="post" action="dr01new.php">
      <input type="hidden" name="id" value="<?= $_SESSION['id']; ?>" />
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
<script src="../../../index2016.js"></script>
</body>
</html>
