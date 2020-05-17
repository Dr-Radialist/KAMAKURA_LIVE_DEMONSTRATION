<?php
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
	
	$stmt = $pdo->prepare("SELECT * FROM `session_tbls`WHERE `class` = 'tri' AND `sessionNo` >= '0' ORDER BY `sessionNo` ASC;");
	$flag = $stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	if (!$flag) {
    		$infor = $stmt->errorInfo();
			exit($infor[2]);
	}

	$stmt = $pdo->prepare("SELECT MAX(`changed`) FROM `session_tbls`;");
	$stmt->execute();
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$latest = $row['MAX(`changed`)']; 
		
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
<link rel="stylesheet" type="text/css" href="../db_read/tri_session_table.css">
</head>

<body>
<span style="color:red; font-weight:bold; font-size:small;">&nbsp;&nbsp;最終更新日時:
<?= $latest ?>
</span>
<div class="container">
  <h1 class="text-center text-danger">KAMAKURA TRI (12/17 SAT)</h1>
  <div class="row">
    <div class="col-lg-12">
      <div  class="session_title">
        <form method="post" action="db_entry/tri/tri01n.php">
          <button type="submit" class="session_title" name="sessionNo" value="1">
          <div>
            <div class="fleft">&nbsp;
              <?= _Q(mb_substr($rows[1]['begin'], 0, 5)); ?>
              -
              <?= date("H:i" , strtotime($rows[1]['begin']) + $rows[1]['duration']*60); ?>
            </div>
            <div class="fright">
              <?= _Q($rows[1]['sessionTitle']); ?>
            </div>
            <div class="fclear">Session Co-Sponsor:
              <?= _Q($rows[1]['cosponsor']); ?>
            </div>
            <div>Venue:
              <?= _Q($rows[1]['venue']); ?>
            </div>
          </div>
          </button>
        </form>
        <div  class="col-lg-10 session_sub">
          <div class="subsession">
            <form method="post" action="db_entry/tri/tri01n.php">
              <button type="submit"  class="subsession_button" name="sessionNo" value="2">
              <div class="fleft">&nbsp;
                <?= _Q(mb_substr($rows[2]['begin'], 0, 5)); ?>
                -
                <?= date("H:i" , strtotime($rows[2]['begin']) +$rows[2]['duration']*60); ?>
              </div>
              <div class="fright">Session Subtitle:
                <?= _Q($rows[2]['sessionTitle']); ?>
              </div>
              <div class="fclear">Chair:
                <?= _Q($rows[2]['chair']); ?>
              </div>
              <div>Commentator::
                <?= _Q($rows[2]['moderator']); ?>
              </div>
              <div>In-Cathe Interpreter:
                <?= _Q($rows[2]['interpreter']); ?>
              </div>
              </button>
            </form>
            <form method="post" action="db_entry/tri/tri01n.php">
              <button type="submit" class="mini_lecture" name="sessionNo" value="3">
              <div>Mini-Lecture Speaker:
                <?= _Q($rows[3]['speaker']); ?>
              </div>
              <div>Chair:
                <?= _Q($rows[3]['chair']); ?>
              </div>
              <div>Title:
                <?= _Q($rows[3]['lectureTitle']); ?>
              </div>
              <div>Lecture Co-Sponsor:
                <?= _Q($rows[3]['cosponsor']); ?>
              </div>
              </button>
            </form>
          </div>
          <div class="subsession">
            <form method="post" action="db_entry/tri/tri01n.php">
              <button type="submit" class="subsession_button" name="sessionNo" value="4">
              <div class="fleft">&nbsp;
                <?= _Q(mb_substr($rows[4]['begin'], 0, 5)); ?>
                -
                <?= date("H:i" , strtotime($rows[4]['begin']) +$rows[4]['duration']*60); ?>
              </div>
              <div class="fright">Session Subtitle:
                <?= _Q($rows[4]['sessionTitle']); ?>
              </div>
              <div class="fclear">Chair:
                <?= _Q($rows[4]['chair']); ?>
              </div>
              <div>Commentator::
                <?= _Q($rows[4]['moderator']); ?>
              </div>
              <div>In-Cathe Interpreter:
                <?= _Q($rows[4]['interpreter']); ?>
              </div>
              </button>
            </form>
            <form method="post" action="db_entry/tri/tri01n.php">
              <button type="submit" class="mini_lecture" name="sessionNo" value="5">
              <div>Mini-Lecture Speaker:
                <?= _Q($rows[5]['speaker']); ?>
              </div>
              <div>Chair:
                <?= _Q($rows[5]['chair']); ?>
              </div>
              <div>Title:
                <?= _Q($rows[5]['lectureTitle']); ?>
              </div>
              <div>Lecture Co-Sponsor:
                <?= _Q($rows[5]['cosponsor']); ?>
              </div>
              </button>
            </form>
          </div>
          <div class="subsession">
            <form method="post" action="db_entry/tri/tri01n.php">
              <button type="submit" class="subsession_button" name="sessionNo" value="6">
              <div class="fleft">&nbsp;
                <?= _Q(mb_substr($rows[6]['begin'], 0, 5)); ?>
                -
                <?= date("H:i" , strtotime($rows[6]['begin']) +$rows[6]['duration']*60); ?>
              </div>
              <div class="fright">Session Subtitle:
                <?= _Q($rows[6]['sessionTitle']); ?>
              </div>
              <div class="fclear">Chair:
                <?= _Q($rows[6]['chair']); ?>
              </div>
              <div>Commentator::
                <?= _Q($rows[6]['moderator']); ?>
              </div>
              <div>In-Cathe Interpreter:
                <?= _Q($rows[6]['interpreter']); ?>
              </div>
              </button>
            </form>
          </div>
        </div>
      </div>
      <div  class="luncheon">
        <form method="post" action="db_entry/tri/tri01n.php">
          <button type="submit" class="luncheon" name="sessionNo" value="7">
          <div>
            <div class="fleft">&nbsp;
              <?= _Q(mb_substr($rows[7]['begin'], 0, 5)); ?>
              -
              <?= date("H:i" , strtotime($rows[7]['begin']) + $rows[7]['duration']*60); ?>
            </div>
            <div class="fright;">
              <?= _Q($rows[7]['sessionTitle']); ?>
            </div>
            <div class="fclear">Lecture Title:
              <?= _Q($rows[7]['lectureTitle']); ?>
            </div>
            <div>Speaker:
              <?= _Q($rows[7]['speaker']); ?>
            </div>
            <div>Chairs:
              <?= _Q($rows[7]['chair']); ?>
            </div>
            <div>Session Co-Sponsor:
              <?= _Q($rows[7]['cosponsor']); ?>
            </div>
            <div>Venue:
              <?= _Q($rows[7]['venue']); ?>
            </div>
          </div>
          </button>
        </form>
      </div>
      <div  class="session_title">
        <form method="post" action="db_entry/tri/tri01n.php">
          <button type="submit" class="session_title" name="sessionNo" value="8">
          <div>
            <div class="fleft">&nbsp;
              <?= _Q(mb_substr($rows[8]['begin'], 0, 5)); ?>
              -
              <?= date("H:i" , strtotime($rows[8]['begin']) + $rows[8]['duration']*60); ?>
            </div>
            <div class="fright;">
              <?= _Q($rows[8]['sessionTitle']); ?>
            </div>
            <div class="fclear">Session Co-Sponsor:
              <?= _Q($rows[8]['cosponsor']); ?>
            </div>
            <div>Venue:
              <?= _Q($rows[8]['venue']); ?>
            </div>
          </div>
          </button>
        </form>
        <div class="col-lg-10 session_sub">
          <div class="subsession">
            <form method="post" action="db_entry/tri/tri01n.php">
              <button type="submit" class="subsession_button" name="sessionNo" value="9">
              <div class="fleft">&nbsp;
                <?= _Q(mb_substr($rows[9]['begin'], 0, 5)); ?>
                -
                <?= date("H:i" , strtotime($rows[9]['begin']) +$rows[9]['duration']*60); ?>
              </div>
              <div class="fright">Session Subtitle:
                <?= _Q($rows[9]['sessionTitle']); ?>
              </div>
              <div class="fclear">Chair:
                <?= _Q($rows[9]['chair']); ?>
              </div>
              <div>Commentator::
                <?= _Q($rows[9]['moderator']); ?>
              </div>
              <div>In-Cathe Interpreter:
                <?= _Q($rows[9]['interpreter']); ?>
              </div>
              </button>
            </form>
            <form method="post" action="db_entry/tri/tri01n.php">
              <button type="submit" class="mini_lecture" name="sessionNo" value="10">
              <div>Mini-Lecture Speaker:
                <?= _Q($rows[10]['speaker']); ?>
              </div>
              <div>Chair:
                <?= _Q($rows[10]['chair']); ?>
              </div>
              <div>Title:
                <?= _Q($rows[10]['lectureTitle']); ?>
              </div>
              <div>Lecture Co-Sponsor:
                <?= _Q($rows[10]['cosponsor']); ?>
              </div>
              </button>
            </form>
          </div>
          <div  class="subsession">
            <form method="post" action="db_entry/tri/tri01n.php">
              <button type="submit" class="subsession_button" name="sessionNo" value="11">
              <div class="fleft">&nbsp;
                <?= _Q(mb_substr($rows[11]['begin'], 0, 5)); ?>
                -
                <?= date("H:i" , strtotime($rows[11]['begin']) +$rows[11]['duration']*60); ?>
              </div>
              <div class="fright">Session Subtitle:
                <?= _Q($rows[11]['sessionTitle']); ?>
              </div>
              <div class="fclear">Chair:
                <?= _Q($rows[11]['chair']); ?>
              </div>
              <div>Commentator::
                <?= _Q($rows[11]['moderator']); ?>
              </div>
              <div>In-Cathe Interpreter:
                <?= _Q($rows[11]['interpreter']); ?>
              </div>
              </button>
            </form>
            <form method="post" action="db_entry/tri/tri01n.php">
              <button type="submit" class="mini_lecture" name="sessionNo" value="12">
              <div>Mini-Lecture Speaker:
                <?= _Q($rows[12]['speaker']); ?>
              </div>
              <div>Chair:
                <?= _Q($rows[12]['chair']); ?>
              </div>
              <div>Title:
                <?= _Q($rows[12]['lectureTitle']); ?>
              </div>
              <div>Lecture Co-Sponsor:
                <?= _Q($rows[12]['cosponsor']); ?>
              </div>
              </button>
            </form>
          </div>
          <div  class="subsession">
            <form method="post" action="db_entry/tri/tri01n.php">
              <button type="submit" class="subsession_button" name="sessionNo" value="13">
              <div class="fleft">&nbsp;
                <?= _Q(mb_substr($rows[13]['begin'], 0, 5)); ?>
                -
                <?= date("H:i" , strtotime($rows[13]['begin']) +$rows[13]['duration']*60); ?>
              </div>
              <div class="fright">Session Subtitle:
                <?= _Q($rows[13]['sessionTitle']); ?>
              </div>
              <div class="fclear">Chair:
                <?= _Q($rows[13]['chair']); ?>
              </div>
              <div>Commentator::
                <?= _Q($rows[13]['moderator']); ?>
              </div>
              <div>In-Cathe Interpreter:
                <?= _Q($rows[13]['interpreter']); ?>
              </div>
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="container">
  <h1 class="text-center text-primary">KAMAKURA TRI (12/18 SUN)</h1>
  <div class="row">
    <div class="col-lg-11">
      <div>
        <div  class="session_title">
          <form method="post" action="db_entry/tri/tri01n.php">
            <button type="submit" class="session_title" name="sessionNo" value="14">
            <div>
              <div class="fleft">&nbsp;
                <?= _Q(mb_substr($rows[14]['begin'], 0, 5)); ?>
                -
                <?= date("H:i" , strtotime($rows[14]['begin']) + $rows[14]['duration']*60); ?>
              </div>
              <div class="fright">
                <?= _Q($rows[14]['sessionTitle']); ?>
              </div>
              <div class="fclear">Session Co-Sponsor:
                <?= _Q($rows[14]['cosponsor']); ?>
              </div>
              <div>Venue:
                <?= _Q($rows[14]['venue']); ?>
              </div>
            </div>
            </button>
          </form>
          <div  class="col-lg-10 session_sub">
            <div class="subsession">
              <form method="post" action="db_entry/tri/tri01n.php">
                <button type="submit"  class="subsession_button" name="sessionNo" value="15">
                <div class="fleft">&nbsp;
                  <?= _Q(mb_substr($rows[15]['begin'], 0, 5)); ?>
                  -
                  <?= date("H:i" , strtotime($rows[15]['begin']) +$rows[15]['duration']*60); ?>
                </div>
                <div class="fright">Session Subtitle:
                  <?= _Q($rows[15]['sessionTitle']); ?>
                </div>
                <div class="fclear">Chair:
                  <?= _Q($rows[15]['chair']); ?>
                </div>
                <div>Commentator::
                  <?= _Q($rows[15]['moderator']); ?>
                </div>
                <div>In-Cathe Interpreter:
                  <?= _Q($rows[15]['interpreter']); ?>
                </div>
                </button>
              </form>
              <form method="post" action="db_entry/tri/tri01n.php">
                <button type="submit" class="mini_lecture" name="sessionNo" value="16">
                <div>Mini-Lecture Speaker:
                  <?= _Q($rows[16]['speaker']); ?>
                </div>
                <div>Chair:
                  <?= _Q($rows[16]['chair']); ?>
                </div>
                <div>Title:
                  <?= _Q($rows[16]['lectureTitle']); ?>
                </div>
                <div>Lecture Co-Sponsor:
                  <?= _Q($rows[16]['cosponsor']); ?>
                </div>
                </button>
              </form>
            </div>
            <div class="subsession">
              <form method="post" action="db_entry/tri/tri01n.php">
                <button type="submit" class="subsession_button" name="sessionNo" value="17">
                <div class="fleft">&nbsp;
                  <?= _Q(mb_substr($rows[17]['begin'], 0, 5)); ?>
                  -
                  <?= date("H:i" , strtotime($rows[17]['begin']) +$rows[17]['duration']*60); ?>
                </div>
                <div class="fright">Session Subtitle:
                  <?= _Q($rows[17]['sessionTitle']); ?>
                </div>
                <div class="fclear">Chair:
                  <?= _Q($rows[17]['chair']); ?>
                </div>
                <div>Commentator::
                  <?= _Q($rows[17]['moderator']); ?>
                </div>
                <div>In-Cathe Interpreter:
                  <?= _Q($rows[17]['interpreter']); ?>
                </div>
                </button>
              </form>
              <form method="post" action="db_entry/tri/tri01n.php">
                <button type="submit" class="mini_lecture" name="sessionNo" value="18">
                <div>Mini-Lecture Speaker:
                  <?= _Q($rows[18]['speaker']); ?>
                </div>
                <div>Chair:
                  <?= _Q($rows[18]['chair']); ?>
                </div>
                <div>Title:
                  <?= _Q($rows[18]['lectureTitle']); ?>
                </div>
                <div>Lecture Co-Sponsor:
                  <?= _Q($rows[18]['cosponsor']); ?>
                </div>
                </button>
              </form>
            </div>
            <div class="subsession">
              <form method="post" action="db_entry/tri/tri01n.php">
                <button type="submit" class="subsession_button" name="sessionNo" value="19">
                <div class="fleft">&nbsp;
                  <?= _Q(mb_substr($rows[19]['begin'], 0, 5)); ?>
                  -
                  <?= date("H:i" , strtotime($rows[19]['begin']) +$rows[19]['duration']*60); ?>
                </div>
                <div class="fright">Session Subtitle:
                  <?= _Q($rows[19]['sessionTitle']); ?>
                </div>
                <div class="fclear">Chair:
                  <?= _Q($rows[19]['chair']); ?>
                </div>
                <div>Commentator::
                  <?= _Q($rows[19]['moderator']); ?>
                </div>
                <div>In-Cathe Interpreter:
                  <?= _Q($rows[19]['interpreter']); ?>
                </div>
                </button>
              </form>
            </div>
          </div>
        </div>
        <div  class="luncheon">
          <form method="post" action="db_entry/tri/tri01n.php">
            <button type="submit" class="luncheon" name="sessionNo" value="20">
            <div>
              <div class="fleft">&nbsp;
                <?= _Q(mb_substr($rows[20]['begin'], 0, 5)); ?>
                -
                <?= date("H:i" , strtotime($rows[20]['begin']) + $rows[20]['duration']*60); ?>
              </div>
              <div class="fright;">
                <?= _Q($rows[20]['sessionTitle']); ?>
              </div>
              <div class="fclear">Lecture Title:
                <?= _Q($rows[20]['lectureTitle']); ?>
              </div>
              <div>Speaker:
                <?= _Q($rows[20]['speaker']); ?>
              </div>
              <div>Chairs:
                <?= _Q($rows[20]['chair']); ?>
              </div>
              <div>Session Co-Sponsor:
                <?= _Q($rows[20]['cosponsor']); ?>
              </div>
              <div>Venue:
                <?= _Q($rows[20]['venue']); ?>
              </div>
            </div>
            </button>
          </form>
        </div>
        <div  class="session_title">
          <form method="post" action="db_entry/tri/tri01n.php">
            <button type="submit" class="session_title" name="sessionNo" value="21">
            <div>
              <div class="fleft">&nbsp;
                <?= _Q(mb_substr($rows[21]['begin'], 0, 5)); ?>
                -
                <?= date("H:i" , strtotime($rows[21]['begin']) + $rows[21]['duration']*60); ?>
              </div>
              <div class="fright;">
                <?= _Q($rows[21]['sessionTitle']); ?>
              </div>
              <div class="fclear">Session Co-Sponsor:
                <?= _Q($rows[21]['cosponsor']); ?>
              </div>
              <div>Venue:
                <?= _Q($rows[21]['venue']); ?>
              </div>
            </div>
            </button>
          </form>
          <div class="col-lg-10 session_sub">
            <div class="subsession">
              <form method="post" action="db_entry/tri/tri01n.php">
                <button type="submit" class="subsession_button" name="sessionNo" value="22">
                <div class="fleft">&nbsp;
                  <?= _Q(mb_substr($rows[22]['begin'], 0, 5)); ?>
                  -
                  <?= date("H:i" , strtotime($rows[22]['begin']) +$rows[22]['duration']*60); ?>
                </div>
                <div class="fright">Session Subtitle:
                  <?= _Q($rows[22]['sessionTitle']); ?>
                </div>
                <div class="fclear">Chair:
                  <?= _Q($rows[22]['chair']); ?>
                </div>
                <div>Commentator::
                  <?= _Q($rows[22]['moderator']); ?>
                </div>
                <div>In-Cathe Interpreter:
                  <?= _Q($rows[22]['interpreter']); ?>
                </div>
                </button>
              </form>
              <form method="post" action="db_entry/tri/tri01n.php">
                <button type="submit" class="mini_lecture" name="sessionNo" value="23">
                <div>Mini-Lecture Speaker:
                  <?= _Q($rows[23]['speaker']); ?>
                </div>
                <div>Chair:
                  <?= _Q($rows[23]['chair']); ?>
                </div>
                <div>Title:
                  <?= _Q($rows[23]['lectureTitle']); ?>
                </div>
                <div>Lecture Co-Sponsor:
                  <?= _Q($rows[23]['cosponsor']); ?>
                </div>
                </button>
              </form>
            </div>
            <div  class="subsession">
              <form method="post" action="db_entry/tri/tri01n.php">
                <button type="submit" class="subsession_button" name="sessionNo" value="24">
                <div class="fleft">&nbsp;
                  <?= _Q(mb_substr($rows[24]['begin'], 0, 5)); ?>
                  -
                  <?= date("H:i" , strtotime($rows[24]['begin']) +$rows[24]['duration']*60); ?>
                </div>
                <div class="fright">Session Subtitle:
                  <?= _Q($rows[24]['sessionTitle']); ?>
                </div>
                <div class="fclear">Chair:
                  <?= _Q($rows[24]['chair']); ?>
                </div>
                <div>Commentator::
                  <?= _Q($rows[24]['moderator']); ?>
                </div>
                <div>In-Cathe Interpreter:
                  <?= _Q($rows[24]['interpreter']); ?>
                </div>
                </button>
              </form>
              <form method="post" action="db_entry/tri/tri01n.php">
                <button type="submit" class="mini_lecture" name="sessionNo" value="25">
                <div>Mini-Lecture Speaker:
                  <?= _Q($rows[25]['speaker']); ?>
                </div>
                <div>Chair:
                  <?= _Q($rows[25]['chair']); ?>
                </div>
                <div>Title:
                  <?= _Q($rows[25]['lectureTitle']); ?>
                </div>
                <div>Lecture Co-Sponsor:
                  <?= _Q($rows[25]['cosponsor']); ?>
                </div>
                </button>
              </form>
            </div>
            <div  class="subsession">
              <form method="post" action="db_entry/tri/tri01n.php">
                <button type="submit" class="subsession_button" name="sessionNo" value="26">
                <div class="fleft">&nbsp;
                  <?= _Q(mb_substr($rows[26]['begin'], 0, 5)); ?>
                  -
                  <?= date("H:i" , strtotime($rows[26]['begin']) +$rows[26]['duration']*60); ?>
                </div>
                <div class="fright">Session Subtitle:
                  <?= _Q($rows[26]['sessionTitle']); ?>
                </div>
                <div class="fclear">Chair:
                  <?= _Q($rows[26]['chair']); ?>
                </div>
                <div>Commentator::
                  <?= _Q($rows[26]['moderator']); ?>
                </div>
                <div>In-Cathe Interpreter:
                  <?= _Q($rows[26]['interpreter']); ?>
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
