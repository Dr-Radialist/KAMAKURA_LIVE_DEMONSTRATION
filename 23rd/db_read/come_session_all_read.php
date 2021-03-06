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
<link rel="stylesheet" type="text/css" href = "come_session_table.css">
</head>
<!-- <body onLoad="init();"> -->
<body>
<span style="color:red; font-weight:bold; font-size:small;">&nbsp;&nbsp;最終更新日時:
<?= $latest ?>
</span>
<div class="container">
  <h2 class="text-center text-danger">コメディカル・セッション 12/18 (SUN)</h2>
  <div class="row">
    <div class="col-lg-11">
      <div  class="session_title">
        <form method="post" action="comedical_sessions.php">
          <button type="submit" class="session_title" name="sessionNo" value="1">
          <div class="fleft">&nbsp;
            <?= _Q(mb_substr($rows[1]['begin'], 0, 5)); ?>
            -
            <?= date("H:i" , strtotime($rows[1]['begin']) +$rows[1]['duration']*60); ?>
          </div>
          <div class="fright">
            <?= _Q($rows[1]['sessionTitle']); ?>
          </div>
          <div class="fclear">座長:
            <?= _Q(makeComeList($pdo, 1, 1)); ?>
          </div>
          <div class="mid_left_align">内容:
            <?=_Q($rows[1]['description']); ?>
          </div>
          </button>
        </form>
        <div  class="col-lg-10 session_sub">
          <div class="subsession">
            <form method="post" action="comedical_sessions.php">
              <button type="submit"  class="mini_lecture" name="sessionNo" value="2">
              <div class="fleft">&nbsp;
                <?= _Q(mb_substr($rows[2]['begin'], 0, 5)); ?>
                -
                <?= date("H:i" , strtotime($rows[2]['begin']) +$rows[2]['duration']*60); ?>
              </div>
              <div class="fright">種別:
                <?= _Q($rows[2]['sessionTitle']); ?>
              </div>
              <div class="fclear">講演演題名:
                <?= _Q($rows[2]['lectureTitle']); ?>
              </div>
              <div>講師:
                <?= _Q(makeComeList($pdo, 2, 3)); ?>
              </div>
              <div class="small_left_align">内容:
                <?=_Q($rows[2]['description']); ?>
              </div>
              </button>
            </form>
            <form method="post" action="comedical_sessions.php">
              <button type="submit" class="mini_lecture" name="sessionNo" value="3">
              <div class="fleft">&nbsp;
                <?= _Q(mb_substr($rows[3]['begin'], 0, 5)); ?>
                -
                <?= date("H:i" , strtotime($rows[3]['begin']) +$rows[3]['duration']*60); ?>
              </div>
              <div class="fright">種別:
                <?= _Q($rows[3]['sessionTitle']); ?>
              </div>
              <div class="fclear">講演演題名:
                <?= _Q($rows[3]['lectureTitle']); ?>
              </div>
              <div>講師:
                <?= _Q(makeComeList($pdo, 3, 3)); ?>
              </div>
              <div class="small_left_align">内容:
                <?=_Q($rows[3]['description']); ?>
              </div>
              </button>
            </form>
          </div>
        </div>
      </div>
      <div class="session_title">
        <div class="subsession">
          <form method="post" action="comedical_sessions.php">
            <button type="submit" class="session_title" name="sessionNo" value="4">
            <div class="fleft">&nbsp;
              <?= _Q(mb_substr($rows[4]['begin'], 0, 5)); ?>
              -
              <?= date("H:i" , strtotime($rows[4]['begin']) +$rows[4]['duration']*60); ?>
            </div>
            <div class="fright">
              <?= _Q($rows[4]['sessionTitle']); ?>
            </div>
            <div class="fclear">座長:
              <?= _Q(makeComeList($pdo, 4, 1)); ?>
            </div>
            <div class="mid_left_align">内容:
              <?=_Q($rows[4]['description']); ?>
            </div>
            </button>
          </form>
          <form method="post" action="comedical_sessions.php">
            <button type="submit" class="mini_lecture" name="sessionNo" value="5">
            <div class="fleft">&nbsp;
              <?= _Q(mb_substr($rows[5]['begin'], 0, 5)); ?>
              -
              <?= date("H:i" , strtotime($rows[5]['begin']) +$rows[5]['duration']*60); ?>
            </div>
            <div class="fright">
              <?= _Q($rows[5]['sessionTitle']); ?>
            </div>
            <div class="fclear">トピック:
              <?= _Q($rows[5]['lectureTitle']); ?>
            </div>
            <div>講師:
              <?= _Q(makeComeList($pdo, 5, 3)); ?>
            </div>
            <div class="small_left_align">内容:
              <?=_Q($rows[5]['description']); ?>
            </div>
            </button>
          </form>
          <form method="post" action="comedical_sessions.php">
            <button type="submit" class="mini_lecture" name="sessionNo" value="6">
            <div class="fleft">&nbsp;
              <?= _Q(mb_substr($rows[6]['begin'], 0, 5)); ?>
              -
              <?= date("H:i" , strtotime($rows[6]['begin']) +$rows[6]['duration']*60); ?>
            </div>
            <div class="fright">
              <?= _Q($rows[6]['sessionTitle']); ?>
            </div>
            <div class="fclear">トピック:
              <?= _Q($rows[6]['lectureTitle']); ?>
            </div>
            <div>講師:
              <?= _Q(makeComeList($pdo, 6, 3)); ?>
            </div>
            <div class="small_left_align">内容:
              <?=_Q($rows[6]['description']); ?>
            </div>
            </button>
          </form>
          <form method="post" action="comedical_sessions.php">
            <button type="submit" class="mini_lecture" name="sessionNo" value="7">
            <div class="fleft">&nbsp;
              <?= _Q(mb_substr($rows[7]['begin'], 0, 5)); ?>
              -
              <?= date("H:i" , strtotime($rows[7]['begin']) +$rows[7]['duration']*60); ?>
            </div>
            <div class="fright">
              <?= _Q($rows[7]['sessionTitle']); ?>
            </div>
            <div class="fclear">トピック:
              <?= _Q($rows[7]['lectureTitle']); ?>
            </div>
            <div>講師:
              <?= _Q(makeComeList($pdo, 7, 3)); ?>
            </div>
            <div class="small_left_align">内容:
              <?=_Q($rows[7]['description']); ?>
            </div>
            </button>
          </form>
        </div>
      </div>
      <div  class="luncheon">
        <form method="post" action="comedical_sessions.php">
          <button type="submit" class="luncheon" name="sessionNo" value="8">
          <div>
            <div class="fleft">&nbsp;
              <?= _Q(mb_substr($rows[8]['begin'], 0, 5)); ?>
              -
              <?= date("H:i" , strtotime($rows[8]['begin']) + $rows[8]['duration']*60); ?>
            </div>
            <div class="fright">
              <?= _Q($rows[8]['sessionTitle']); ?>
            </div>
            <div class="fclear">演題:
              <?= _Q($rows[8]['lectureTitle']); ?>
            </div>
            <div>演者:
              <?= _Q(makeComeList($pdo, 8, 3)); ?>
            </div>
            <div>座長:
              <?= _Q(makeComeList($pdo, 8, 1)); ?>
            </div>
            <div>共催会社:
              <?= _Q($rows[8]['cosponsor']); ?>
            </div>
            <div>内容:
              <?= _Q($rows[8]['description']); ?>
            </div>
          </div>
          </button>
        </form>
      </div>
      <div  class="session_title">
        <form method="post" action="comedical_sessions.php">
          <button type="submit" class="session_title" name="sessionNo" value="9">
          <div class="fleft">&nbsp;
            <?= _Q(mb_substr($rows[9]['begin'], 0, 5)); ?>
            -
            <?= date("H:i" , strtotime($rows[9]['begin']) +$rows[9]['duration']*60); ?>
          </div>
          <div class="fright">
            <?= _Q($rows[9]['sessionTitle']); ?>
          </div>
          <div class="fclear">座長:
            <?= _Q(makeComeList($pdo, 9, 1)); ?>
          </div>
          <div class="mid_left_align">内容:
            <?=_Q($rows[9]['description']); ?>
          </div>
          </button>
        </form>
        <div class="col-lg-10 session_sub">
          <div class="subsession">
            <form method="post" action="comedical_sessions.php">
              <button type="submit" class="mini_lecture" name="sessionNo" value="10">
              <div class="small">モデレーター: 
        		<?= _Q(makeComeList($pdo, 10, 2)) ?>
         </div>
              <div>演者:
                <?= _Q(makeComeList($pdo, 10, 3)); ?>
              </div>
              <div>謳い文句:
                <?= _Q($rows[10]['lectureTitle']); ?>
              </div>
              <div class="mid_left_align">内容:
                <?=_Q($rows[10]['description']); ?>
              </div>
              </button>
            </form>
          </div>
        </div>
      </div>
      <div class="session_title">
        <div  class="subsession">
          <form method="post" action="comedical_sessions.php">
            <button type="submit" class="session_title" name="sessionNo" value="11">
            <div class="fleft">&nbsp;
              <?= _Q(mb_substr($rows[11]['begin'], 0, 5)); ?>
              -
              <?= date("H:i" , strtotime($rows[11]['begin']) +$rows[11]['duration']*60); ?>
            </div>
            <div class="fright">
              <?= _Q($rows[11]['sessionTitle']); ?>
            </div>
            <div class="fclear">座長:
              <?= _Q(makeComeList($pdo, 11, 1)); ?>
            </div>
            <div class="mid_left_align">内容:
              <?=_Q($rows[11]['description']); ?>
            </div>
            </button>
          </form>
          <form method="post" action="comedical_sessions.php">
            <button type="submit" class="mini_lecture" name="sessionNo" value="12">
            <div>演者:
              <?= _Q(makeComeList($pdo, 12, 3)); ?>
            </div>
            <!--
            <div>謳い文句:
             <?php
             // echo _Q($rows[12]['lectureTitle']); 
			 ?>
            </div>
            -->
            <div class="mid_left_align">内容:
              <?=_Q($rows[12]['description']); ?>
            </div>
            </button>
          </form>
        </div>
      </div>
      <div  class="session_title">
        <div class="subsession">
          <form method="post" action="comedical_sessions.php">
            <button type="submit" class="session_title" name="sessionNo" value="13">
            <div class="fleft">&nbsp;
              <?= _Q(mb_substr($rows[13]['begin'], 0, 5)); ?>
              -
              <?= date("H:i" , strtotime($rows[13]['begin']) +$rows[13]['duration']*60); ?>
            </div>
            <div class="fright">
              <?= _Q($rows[13]['sessionTitle']); ?>
            </div>
            <div class="fclear">座長:
              <?= _Q(makeComeList($pdo, 13, 1)); ?>
            </div>
            <div class="mid_left_align">内容:
              <?=_Q($rows[13]['description']); ?>
            </div>
            </button>
          </form>
          <form method="post" action="comedical_sessions.php">
            <button type="submit" class="mini_lecture" name="sessionNo" value="14">
            <div>演者:
              <?= _Q(makeComeList($pdo, 14, 3)); ?>
            </div>
            <div>謳い文句:
              <?= _Q($rows[14]['lectureTitle']); ?>
            </div>
            <div class="mid_left_align">内容:
              <?=_Q($rows[14]['description']); ?>
            </div>
            </button>
          </form>
          <form method="post" action="comedical_sessions.php">
            <button type="submit" class="mini_lecture" name="sessionNo" value="15">
            <div>演者:
              <?= _Q(makeComeList($pdo, 15, 3)); ?>
            </div>
            <div>謳い文句:
              <?= _Q($rows[15]['lectureTitle']); ?>
            </div>
            <div class="mid_left_align">内容:
              <?=_Q($rows[15]['description']); ?>
            </div>
            </button>
          </form>
          <form method="post" action="comedical_sessions.php">
            <button type="submit" class="mini_lecture" name="sessionNo" value="16">
            <div>演者:
              <?= _Q(makeComeList($pdo, 16, 3)); ?>
            </div>
            <div>謳い文句:
              <?= _Q($rows[16]['lectureTitle']); ?>
            </div>
            <div class="mid_left_align">内容:
              <?=_Q($rows[16]['description']); ?>
            </div>
            </button>
          </form>
          <form method="post" action="comedical_sessions.php">
            <button type="submit" class="mini_lecture" name="sessionNo" value="17">
            <div>演者:
              <?= _Q(makeComeList($pdo, 17, 3)); ?>
            </div>
            <div>謳い文句:
              <?= _Q($rows[17]['lectureTitle']); ?>
            </div>
            <div class="mid_left_align">内容:
              <?=_Q($rows[17]['description']); ?>
            </div>
            </button>
          </form>
          <form method="post" action="comedical_sessions.php">
            <button type="submit" class="mini_lecture" name="sessionNo" value="18">
            <div>演者:
              <?= _Q(makeComeList($pdo, 18, 3)); ?>
            </div>
            <div>謳い文句:
              <?= _Q($rows[18]['lectureTitle']); ?>
            </div>
            <div class="mid_left_align">内容:
              <?=_Q($rows[18]['description']); ?>
            </div>
            </button>
          </form>
        </div>
      </div>
      <div  class="session_title">
        <div class="subsession">
          <form method="post" action="comedical_sessions.php">
            <button type="submit" class="session_title" name="sessionNo" value="19">
            <div class="fleft">&nbsp;
              <?= _Q(mb_substr($rows[19]['begin'], 0, 5)); ?>
              -
              <?= date("H:i" , strtotime($rows[19]['begin']) +$rows[19]['duration']*60); ?>
            </div>
            <div class="fright">
              <?= _Q($rows[19]['sessionTitle']); ?>
            </div>
            <div class="fclear">座長:
              <?= _Q(makeComeList($pdo, 19, 1)); ?>
            </div>
            <div class="mid_left_align">内容:
              <?=_Q($rows[19]['description']); ?>
            </div>
            </button>
          </form>
        </div>
      </div>
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
		document.write('<script src="../../../bootstrap/jquery-2.1.4.min.js"><\/script><script src="../../../bootstrap/js/bootstrap.min.js"><\/script>');
	}
</script> 
<script src="../../bootstrap/docs-assets/javascript/extension.js"></script> 
<script src="../../bootstrap/docs-assets/javascript/jglycy-1.0.js"></script> 
<script src="../../bootstrap/docs-assets/javascript/jtruncsubstr.js"></script> 
<script src="../index2016.js"></script>
</body>
</html>