<?php
session_start();
session_regenerate_id( true );
require_once( '../../utilities/config.php' );
require_once( '../../utilities/lib.php' );
charSetUTF8();
//接続
try {
	// MySQLサーバへ接続
	$pdo = new PDO( "mysql:host=$db_host;dbname=$db_name_sessions;charset=utf8", $db_user, $db_password );
	// 注意: 不要なspaceを挿入すると' $db_host'のようにみなされ、エラーとなる
} catch ( PDOException $e ) {
	die( $e->getMessage() );
}

$stmt = $pdo->prepare( "SELECT * FROM `session_tbls`WHERE `class` = 'tri' AND `sessionNo` >= '0' AND `year` = '" . $this_year . "' ORDER BY `sessionNo` ASC;" );
$flag = $stmt->execute();
$rows = $stmt->fetchAll( PDO::FETCH_ASSOC );

if ( !$flag ) {
	$infor = $stmt->errorInfo();
	exit( $infor[ 2 ] );
}

$stmt = $pdo->prepare( "SELECT MAX(`changed`) FROM `session_tbls`;" );
$stmt->execute();
$row1 = $stmt->fetch( PDO::FETCH_ASSOC );
$stmt = $pdo->prepare( "SELECT MAX(`created`) FROM `role_tbls`;" );
$stmt->execute();
$row2 = $stmt->fetch( PDO::FETCH_ASSOC );
$latest = max( $row1[ 'MAX(`changed`)' ], $row2[ 'MAX(`created`)' ] );
$class = 'tri';

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
		<h1 class="text-center text-danger">KAMAKURA TRI (12/09 SAT)</h1>
		<div class="row">
			<div class="col-lg-12">
				<div class="session_title">
					<form method="post" action="db_entry/tri/tri01n.php">
						<button type="submit" class="subsession_button" name="sessionNo" value="1">Modify</button>
					</form>
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
					<div class="col-lg-10 session_sub">
						<div class="subsession">
							<form method="post" action="db_entry/tri/tri01n.php">
								<button type="submit" class="subsession_button" name="sessionNo" value="2">Modify</button>
							</form>
							<div class="fleft">&nbsp;
								<?= _Q(mb_substr($rows[2]['begin'], 0, 5)); ?>
								-
								<?= date("H:i" , strtotime($rows[2]['begin']) +$rows[2]['duration']*60); ?>
							</div>
							<div class="fright">Session Subtitle:
								<?= _Q($rows[2]['sessionTitle']); ?>
							</div>
							<div class="fclear">Chair:
								<?= _Q(makeTriList($pdo, 2, 1, $class, $this_year)); ?>
							</div>
							<div>Commentator::
								<?= _Q(makeTriList($pdo, 2, 2, $class, $this_year)); ?>
							</div>
							<div>In-Cathe Interpreter:
								<?= _Q(makeTriList($pdo, 2, 4, $class, $this_year)); ?>
							</div>
						</div>
						<div class="subsession">
							<form method="post" action="db_entry/tri/tri01n.php">
								<button type="submit" class="mini_lecture btn" name="sessionNo" value="3">Modify</button>
							</form>
							<div>Mini-Lecture Speaker:
								<?= _Q(makeTriList($pdo, 3, 3, $class, $this_year)); ?>
							</div>
							<div>Chair:
								<?= _Q(makeTriList($pdo, 3, 1, $class, $this_year)); ?>
							</div>
							<div>Lecture Title:
								<?= _Q($rows[3]['lectureTitle']); ?>
							</div>
							<div class="description">Description:
								<?= _Q($rows[3]['description']); ?>
							</div>
							<div>Lecture Co-Sponsor:
								<?= _Q($rows[3]['cosponsor']); ?>
							</div>
						</div>
						<div class="subsession">
							<form method="post" action="db_entry/tri/tri01n.php">
								<button type="submit" class="subsession_button" name="sessionNo" value="4">Modify</button>
							</form>
							<div class="fleft">&nbsp;
								<?= _Q(mb_substr($rows[4]['begin'], 0, 5)); ?>
								-
								<?= date("H:i" , strtotime($rows[4]['begin']) +$rows[4]['duration']*60); ?>
							</div>
							<div class="fright">Session Subtitle:
								<?= _Q($rows[4]['sessionTitle']); ?>
							</div>
							<div class="fclear">Chair:
								<?= _Q(makeTriList($pdo, 4, 1, $class, $this_year)); ?>
							</div>
							<div>Commentator::
								<?= _Q(makeTriList($pdo, 4, 2, $class, $this_year)); ?>
							</div>
							<div>In-Cathe Interpreter:
								<?= _Q(makeTriList($pdo, 4, 4, $class, $this_year)); ?>
							</div>
						</div>
					</div>
				</div>

				<div class="luncheon">
					<form method="post" action="db_entry/tri/tri01n.php">
						<button type="submit" class="subsession_button" name="sessionNo" value="5">Modify
						</button>
					</form>
					<div>Luncheon Speaker:
						<?= _Q(makeTriList($pdo, 5, 3, $class, $this_year)) ?>
					</div>
					<div>Chair:
						<?= _Q(makeTriList($pdo, 5, 1, $class, $this_year)); ?>
					</div>
					<div>Luncheon Title:
						<?= _Q($rows[5]['lectureTitle']); ?>
					</div>
					<div class="description">Description:
						<?= _Q($rows[5]['description']); ?>
					</div>
					<div>Lecture Co-Sponsor:
						<?= _Q($rows[5]['cosponsor']); ?>
					</div>
				</div>

				<div class="session_title">
					<form method="post" action="db_entry/tri/tri01n.php">
						<button type="submit" class="subsession_button" name="sessionNo" value="6">Modify
						</button>
					</form>
					<div>
						<div class="fleft">&nbsp;
							<?= _Q(mb_substr($rows[6]['begin'], 0, 5)); ?>
							-
							<?= date("H:i" , strtotime($rows[6]['begin']) + $rows[6]['duration']*60); ?>
						</div>
						<div class="fright">
							<?= _Q($rows[6]['sessionTitle']); ?>
						</div>
						<div class="fclear">Session Co-Sponsor:
							<?= _Q($rows[6]['cosponsor']); ?>
						</div>
						<div>Venue:
							<?= _Q($rows[6]['venue']); ?>
						</div>
					</div>

					<div class="col-lg-10 session_sub">
						<div class="subsession">
							<form method="post" action="db_entry/tri/tri01n.php">
								<button type="submit" class="subsession_button btn" name="sessionNo" value="7">Modify
								</button>
							</form>
							<div class="fleft">&nbsp;
								<?= _Q(mb_substr($rows[7]['begin'], 0, 5)); ?>
								-
								<?= date("H:i" , strtotime($rows[7]['begin']) +$rows[7]['duration']*60); ?>
							</div>
							<div class="fright">Session Subtitle:
								<?= _Q($rows[7]['sessionTitle']); ?>
							</div>
							<div class="fclear">Chair:
								<?= _Q(makeTriList($pdo,7, 1, $class, $this_year)); ?>
							</div>
							<div>Commentator::
								<?= _Q(makeTriList($pdo, 7, 2, $class, $this_year)); ?>
							</div>
							<div>In-Cathe Interpreter:
								<?= _Q(makeTriList($pdo, 7, 4, $class, $this_year)); ?>
							</div>

							<div class="subsession">
								<form method="post" action="db_entry/tri/tri01n.php">
									<button type="submit" class="mini_lecture btn" name="sessionNo" value="8">Modify
								</button>
								</form>
								<div>Mini-Lecture Speaker:
									<?= _Q(makeTriList($pdo, 8, 3, $class, $this_year)); ?>
								</div>
								<div>Chair:
									<?= _Q(makeTriList($pdo, 8, 1, $class, $this_year)); ?>
								</div>
								<div>Title:
									<?= _Q($rows[8]['lectureTitle']); ?>
								</div>
								<div class="description">Description:
									<?= _Q($rows[8]['description']); ?>
								</div>
								<div>Lecture Co-Sponsor:
									<?= _Q($rows[8]['cosponsor']); ?>
								</div>


							</div>
							<div class="subsession">
								<form method="post" action="db_entry/tri/tri01n.php">
									<button type="submit" class="subsession_button btn" name="sessionNo" value="9">Modify
								</button>
								</form>
								<div class="fleft">&nbsp;
									<?= _Q(mb_substr($rows[9]['begin'], 0, 5)); ?>
									-
									<?= date("H:i" , strtotime($rows[9]['begin']) +$rows[9]['duration']*60); ?>
								</div>
								<div class="fright">Session Subtitle:
									<?= _Q($rows[9]['sessionTitle']); ?>
								</div>
								<div class="fclear">Chair:
									<?= _Q(makeTriList($pdo, 9, 1, $class, $this_year)); ?>
								</div>
								<div>Commentator::
									<?= _Q(makeTriList($pdo, 9, 2, $class, $this_year)); ?>
								</div>
								<div>In-Cathe Interpreter:
									<?= _Q(makeTriList($pdo, 9, 4, $class, $this_year)); ?>
								</div>

							</div>

							<form method="post" action="db_entry/tri/tri01n.php">
								<button type="submit" class="mini_lecture btn" name="sessionNo" value="10">Modify
							</button>
							</form>
							<div>Mini-Lecture Speaker:
								<?= _Q(makeTriList($pdo, 10, 3, $class, $this_year)); ?>
							</div>
							<div>Chair:
								<?= _Q(makeTriList($pdo, 10, 1, $class, $this_year)); ?>
							</div>
							<div>Title:
								<?= _Q($rows[10]['lectureTitle']); ?>
							</div>
							<div class="description">Description:
								<?= _Q($rows[10]['description']); ?>
							</div>
							<div>Lecture Co-Sponsor:
								<?= _Q($rows[10]['cosponsor']); ?>
							</div>

							<div class="subsession">
								<form method="post" action="db_entry/tri/tri01n.php">
									<button type="submit" class="subsession_button btn" name="sessionNo" value="11">Modify
								</button>
								</form>
								<div class="fleft">&nbsp;
									<?= _Q(mb_substr($rows[11]['begin'], 0, 5)); ?>
									-
									<?= date("H:i" , strtotime($rows[11]['begin']) +$rows[11]['duration']*60); ?>
								</div>
								<div class="fright">Session Subtitle:
									<?= _Q($rows[11]['sessionTitle']); ?>
								</div>
								<div class="fclear">Chair:
									<?= _Q(makeTriList($pdo,11, 1, $class, $this_year)); ?>
								</div>
								<div>Commentator::
									<?= _Q(makeTriList($pdo, 11, 2, $class, $this_year)); ?>
								</div>
								<div>In-Cathe Interpreter:
									<?= _Q(makeTriList($pdo, 11, 4, $class, $this_year)); ?>
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="luncheon">
			<form method="post" action="db_entry/tri/tri01n.php">
				<button type="submit" class="subsession_button" name="sessionNo" value="21">Modify
						</button>
			</form>
			<div>
				<?= _Q(mb_substr($rows[21]['begin'], 0, 5)); ?>
				-
				<?= date("H:i" , strtotime($rows[21]['begin']) +$rows[21]['duration']*60); ?>
			</div>
			<div>Speaker:
				<?= _Q(makeTriList($pdo, 21, 3, $class, $this_year)) ?>
			</div>
			<div>Chair:
				<?= _Q(makeTriList($pdo, 21, 1, $class, $this_year)); ?>
			</div>
			<div>Title:
				<?= _Q($rows[21]['lectureTitle']); ?>
			</div>
			<div class="description">Description:
				<?= _Q($rows[21]['description']); ?>
			</div>
			<div>Co-Sponsor:
				<?= _Q($rows[21]['cosponsor']); ?>
			</div>
		</div>
	</div>

	<div class="container" id="day2">
		<h1 class="text-center text-primary">KAMAKURA TRI (12/10 SUN)</h1>
		<div class="row">
			<div class="col-lg-12">
				<div class="session_title">
					<form method="post" action="db_entry/tri/tri01n.php">
						<button type="submit" class="subsession_button" name="sessionNo" value="12">Modify
						</button>
					</form>
					<div>
						<div class="fleft">&nbsp;
							<?= _Q(mb_substr($rows[12]['begin'], 0, 5)); ?>
							-
							<?= date("H:i" , strtotime($rows[12]['begin']) + $rows[12]['duration']*60); ?>
						</div>
						<div class="fright">
							<?= _Q($rows[12]['sessionTitle']); ?>
						</div>
						<div class="fclear">Session Co-Sponsor:
							<?= _Q($rows[12]['cosponsor']); ?>
						</div>
						<div>Venue:
							<?= _Q($rows[12]['venue']); ?>
						</div>
					</div>

					<div class="col-lg-10 session_sub">
						<div class="subsession">
							<form method="post" action="db_entry/tri/tri01n.php">
								<button type="submit" class="subsession_button btn" name="sessionNo" value="13">Modify
								</button>
							</form>
							<div class="fleft">&nbsp;
								<?= _Q(mb_substr($rows[13]['begin'], 0, 5)); ?>
								-
								<?= date("H:i" , strtotime($rows[13]['begin']) +$rows[13]['duration']*60); ?>
							</div>
							<div class="fright">Session Subtitle:
								<?= _Q($rows[13]['sessionTitle']); ?>
							</div>
							<div class="fclear">Chair:
								<?= _Q(makeTriList($pdo, 13, 1, $class, $this_year)); ?>
							</div>
							<div>Commentator::
								<?= _Q(makeTriList($pdo, 13, 2, $class, $this_year)); ?>
							</div>
							<div>In-Cathe Interpreter:
								<?= _Q(makeTriList($pdo, 13, 4, $class, $this_year)); ?>
							</div>

							<div class="subsession">
								<form method="post" action="db_entry/tri/tri01n.php">
									<button type="submit" class="mini_lecture btn" name="sessionNo" value="14">Modify
								</button>
								</form>
								<div>Mini-Lecture Speaker:
									<?= _Q(makeTriList($pdo, 14, 3, $class, $this_year)); ?>
								</div>
								<div>Chair:
									<?= _Q(makeTriList($pdo, 14, 1, $class, $this_year)); ?>
								</div>
								<div>Title:
									<?= _Q($rows[14]['lectureTitle']); ?>
								</div>
								<div class="description">Description:
									<?= _Q($rows[14]['description']); ?>
								</div>
								<div>Lecture Co-Sponsor:
									<?= _Q($rows[14]['cosponsor']); ?>
								</div>

							</div>
							<div class="subsession">
								<form method="post" action="db_entry/tri/tri01n.php">
									<button type="submit" class="subsession_button btn" name="sessionNo" value="15">Modify
								</button>
								</form>
								<div class="fleft">&nbsp;
									<?= _Q(mb_substr($rows[15]['begin'], 0, 5)); ?>
									-
									<?= date("H:i" , strtotime($rows[15]['begin']) +$rows[15]['duration']*60); ?>
								</div>
								<div class="fright">Session Subtitle:
									<?= _Q($rows[15]['sessionTitle']); ?>
								</div>
								<div class="fclear">Chair:
									<?= _Q(makeTriList($pdo, 15, 1, $class, $this_year)); ?>
								</div>
								<div>Commentator::
									<?= _Q(makeTriList($pdo, 15, 2, $class, $this_year)); ?>
								</div>
								<div>In-Cathe Interpreter:
									<?= _Q(makeTriList($pdo, 15, 4, $class, $this_year)); ?>
								</div>

							</div>
						</div>
					</div>
				</div>

				<div class="luncheon">
					<form method="post" action="db_entry/tri/tri01n.php">
						<button type="submit" class="subsession_button" name="sessionNo" value="16">Modify
						</button>
					</form>
					<div> Speaker:
						<?= _Q(makeTriList($pdo, 16, 3, $class, $this_year)) ?>
					</div>
					<div>Chair:
						<?= _Q(makeTriList($pdo, 16, 1, $class, $this_year)); ?>
					</div>
					<div>Luncheon Title:
						<?= _Q($rows[16]['lectureTitle']); ?>
					</div>
					<div class="description">Description:
						<?= _Q($rows[16]['description']); ?>
					</div>
					<div>Lecture Co-Sponsor:
						<?= _Q($rows[16]['cosponsor']); ?>
					</div>
				</div>
				<div class="session_title">
					<form method="post" action="db_entry/tri/tri01n.php">
						<button type="submit" class="subsession_button" name="sessionNo" value="17">Modify
						</button>
					</form>
					<div>
						<div class="fleft">&nbsp;
							<?= _Q(mb_substr($rows[17]['begin'], 0, 5)); ?>
							-
							<?= date("H:i" , strtotime($rows[17]['begin']) + $rows[17]['duration']*60); ?>
						</div>
						<div class="fright">
							<?= _Q($rows[17]['sessionTitle']); ?>
						</div>
						<div class="fclear">Session Co-Sponsor:
							<?= _Q($rows[17]['cosponsor']); ?>
						</div>
						<div>Venue:
							<?= _Q($rows[17]['venue']); ?>
						</div>
					</div>
					<div class="col-lg-10 session_sub">
						<div class="subsession">
							<form method="post" action="db_entry/tri/tri01n.php">
								<button type="submit" class="subsession_button btn" name="sessionNo" value="18">Modify
								</button>
							</form>
							<div class="fleft">&nbsp;
								<?= _Q(mb_substr($rows[18]['begin'], 0, 5)); ?>
								-
								<?= date("H:i" , strtotime($rows[18]['begin']) +$rows[18]['duration']*60); ?>
							</div>
							<div class="fright">Session Subtitle:
								<?= _Q($rows[18]['sessionTitle']); ?>
							</div>
							<div class="fclear">Chair:
								<?= _Q(makeTriList($pdo,18, 1, $class, $this_year)); ?>
							</div>
							<div>Commentator::
								<?= _Q(makeTriList($pdo, 18, 2, $class, $this_year)); ?>
							</div>
							<div>In-Cathe Interpreter:
								<?= _Q(makeTriList($pdo, 18, 4, $class, $this_year)); ?>
							</div>
							<div class="subsession">
								<form method="post" action="db_entry/tri/tri01n.php">
									<button type="submit" class="mini_lecture btn" name="sessionNo" value="19">Modify
								</button>
								</form>
								<div>Mini-Lecture Speaker:
									<?= _Q(makeTriList($pdo, 19, 3, $class, $this_year)); ?>
								</div>
								<div>Chair:
									<?= _Q(makeTriList($pdo, 19, 1, $class, $this_year)); ?>
								</div>
								<div>Title:
									<?= _Q($rows[19]['lectureTitle']); ?>
								</div>
								<div class="description">Description:
									<?= _Q($rows[19]['description']); ?>
								</div>
								<div>Lecture Co-Sponsor:
									<?= _Q($rows[19]['cosponsor']); ?>
								</div>
							</div>
							<div class="subsession">
								<form method="post" action="db_entry/tri/tri01n.php">
									<button type="submit" class="subsession_button btn" name="sessionNo" value="20">Modify
								</button>
								</form>
								<div class="fleft">&nbsp;
									<?= _Q(mb_substr($rows[20]['begin'], 0, 5)); ?>
									-
									<?= date("H:i" , strtotime($rows[20]['begin']) +$rows[20]['duration']*60); ?>
								</div>
								<div class="fright">Session Subtitle:
									<?= _Q($rows[20]['sessionTitle']); ?>
								</div>
								<div class="fclear">Chair:
									<?= _Q(makeTriList($pdo, 20, 1, $class, $this_year)); ?>
								</div>
								<div>Commentator:
									<?= _Q(makeTriList($pdo, 20, 2, $class, $this_year)); ?>
								</div>
								<div>In-Cathe Interpreter:
									<?= _Q(makeTriList($pdo, 20, 4, $class, $this_year)); ?>
								</div>
							</div>
						</div>
					</div>
					<hr>
					<footer>
						<p>&copy; 2013 - 2017 by NPO International TRI Network & KAMAKURA LIVE</p>
					</footer>
				</div>
			</div>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha256-Sk3nkD6mLTMOF0EOpNtsIry+s1CsaqQC1rVLTAy+0yc= sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
	<script>
		if ( !window.jQuery ) {
			document.write( '<script src="../../bootstrap/jquery-2.1.4.min.js"><\/script><script src="../../bootstrap/js/bootstrap.min.js"><\/script>' );
		}
	</script>
	<script src="../../bootstrap/docs-assets/javascript/extension.js"></script>
	<script src="../../bootstrap/docs-assets/javascript/jglycy-1.0.js"></script>
	<script src="../../bootstrap/docs-assets/javascript/jtruncsubstr.js"></script>
	<script src="../index2016.js"></script>
</body>

</html>