<?php
session_start();
session_regenerate_id( true );
require_once( '../../../../utilities/config.php' );
require_once( '../../../../utilities/lib.php' );
charSetUTF8();
//print_r($_POST['sessionNo']); exit;
//接続
try {
	// MySQLサーバへ接続
	$pdo = new PDO( "mysql:host=$db_host;dbname=$db_name_sessions;charset=utf8", $db_user, $db_password );
	// 注意: 不要なspaceを挿入すると' $db_host'のようにみなされ、エラーとなる
} catch ( PDOException $e ) {
	die( $e->getMessage() );
}

$sql = "SELECT * FROM `session_tbls2018` WHERE `id` = :id;";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(":id", $_POST['id'], PDO::PARAM_INT);

try {
	$pdo->beginTransaction();
	$flag = $stmt->execute();
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	if ( !$flag ) {
		$infor = $stmt->errorInfo();
		exit( $infor[ 2 ] );
	}
	$pdo->commit();
} catch ( Exception $e ) {
	$pdo->rollBack();
	echo "Failed to update Database" . $e->getMessage();
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
	<title>KAMAKURA LIVE Faculty TimeTable</title>
	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" type="text/css" href="../../../../bootstrap/css/bootstrap.css">
	<!-- Custom styles for this template -->
	<link rel="stylesheet" type="text/css" href="../../../../bootstrap/jumbotron/jumbotron.css">
	<link rel="stylesheet" type="text/css" href="../../../2016top.css">
</head>

<body>
	<div class="container">
		<div class="col-sm-1"><br>
		</div>
		
		<div class=" col-sm-8">
			<h3>鎌倉ライブ<?=$this_year; ?>　TRI Session 時間割修正プログラム</h3>
			<div class="row">
				<form name="doctor" method="post" action="tri_db_mod01.php">
					<input type="hidden" name="id" value="<?=_Q($row['id']); ?>"/>
					<input type="hidden" name="new_old" value="<?=_Q($_POST['new_old']); ?>"/>
					<div class="form-group">
						<label for="sessionNo">sessionNo<span class="req">必須</span></label>
						<input type="text" class="form-control" name="sessionNo" id="sessionNo" value="<?=_Q($row['sessionNo']);?>" />
					</div>
					<div class="form-group">
						<label for="beginDate">開始日時刻<span class="req">必須</span></label>
						<input type="text" class="form-control" name="beginDate" id="beginDate" value="<?=_Q($row['beginDate']);?>"/>
					</div>
					<div class="form-group">
						<label for="duration">持続時間(分)<span class="req">必須</span></label>
						<input type="text" class="form-control" name="duration" id="duration" value="<?=_Q($row['duration']);?>"/>
					</div>
					<div class="form-group">
						<label for="sessionTitle">セッション概念</label>
						<input type="text" class="form-control" name="sessionTitle" id="sessionTitle" value="<?=_Q($row['sessionTitle']);?>"/>
					</div>
					<div class="form-group">
						<label for="cosponsor">共催会社名</label>
						<input type="text" class="form-control" name="cosponsor" id="cosponsor" value="<?=_Q($row['cosponsor']);?>"/>
					</div>
					<div class="form-group">
						<label for="lectureTitle">演題名/ライブ名</label>
						<input type="text" class="form-control" name="lectureTitle" id="lectureTitle" value="<?=_Q($row['lectureTitle']);?>"/>
					</div>
					<div class="form-group">
						<label for="description">説明</label>
						<input type="text" class="form-control" name="description" id="description" value="<?=_Q($row['description']);?>">
					</div>
					<div class="form-group">
						<label for="venue">会場</label>
						<input type="text" class="form-control" name="venue" id="venue" value="HAMAGIN Hall" readonly/>
					</div>
					<div class="form-group">
						<label for="class">クラス</label>
						<input type="text" class="form-control" name="class" id="class" value="tri" readonly/>
					</div>
					<div class="form-group">
						<label for="year">年次</label>
						<input type="text" class="form-control" name="year" id="year" value="<?=$this_year;?>" readonly/>
					</div>
					<input type="submit" value="入力" class="btn btn-danger"/>
				</form>

			</div>
			<hr>
			<footer>
				<p>&copy; 2013 - 2018 by NPO International TRI Network & KAMAKURA LIVE</p>
			</footer>
		</div>
		<div class="col-sm-3"><br>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha256-Sk3nkD6mLTMOF0EOpNtsIry+s1CsaqQC1rVLTAy+0yc= sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
	<script>
		if ( !window.jQuery ) {
			document.write( '<script src="../../../../bootstrap/jquery-2.1.4.min.js"><\/script><script src="../../../../bootstrap/js/bootstrap.min.js"><\/script>' );
		}
	</script>
	<script src="../../../../bootstrap/docs-assets/javascript/extension.js"></script>
	<script src="../../../../bootstrap/docs-assets/javascript/jglycy-1.0.js"></script>
	<script src="../../../../bootstrap/docs-assets/javascript/jtruncsubstr.js"></script>
	<script src="../../../index2016.js"></script>
	<script type="text/javascript">
		jQuery( function () {
			$( "#chair_non_determine" ).click( function () {
				if ( $( this ).is( ":checked" ) ) {
					$( "#chair_req" ).hide();
					$( "#input_chair" ).removeAttr( 'required' );
					$( "#input_chair" ).val( "" );
				} else {
					$( "#chair_req" ).show();
					$( "#input_chair" ).addAttr( 'required' );
				}
			} );
		} );
	</script>
</body>
</html>