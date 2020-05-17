<?php
/*
これは公開用のdoctor role findingである
まずフロントエンドとして alphabetical nameにより候補を検索する
これにより候補doctorのリスト表示すれるので　それを選択すれば
role一覧出力する
*/

session_start();
session_regenerate_id( true );
require_once( '../utilities/config.php' );
require_once( '../utilities/lib.php' );
charSetUTF8();

//print_r($_POST);

//接続
try {
	// MySQLサーバへ接続
	$pdo = new PDO( "mysql:host=$db_host;dbname=$db_name_sessions;charset=utf8", $db_user, $db_password );
	// 注意: 不要なspaceを挿入すると' $db_host'のようにみなされ、エラーとなる
} catch ( PDOException $e ) {
	die( $e->getMessage() );
}


$stmt_dr = $pdo->prepare( "SELECT MAX(`changed`) FROM `doctor_tbls`;" );
$stmt_dr->execute();
$row_dr = $stmt_dr->fetch( PDO::FETCH_ASSOC );
$stmt_session = $pdo->prepare( "SELECT MAX(`changed`) FROM `session_tbls2018`;" );
$stmt_session->execute();
$row_session = $stmt_session->fetch( PDO::FETCH_ASSOC );
$stmt_role = $pdo->prepare( "SELECT MAX(`created`) FROM `role_tbls`;" );
$stmt_role->execute();
$row_role = $stmt_role->fetch( PDO::FETCH_ASSOC );
$latest = max( $row_dr[ 'MAX(`changed`)' ], $row_session[ 'MAX(`changed`)' ], $row_role[ 'MAX(`created`)' ] );
//$latest = mb_substr( $latest, 0, 10 );

// Kiemenij先生の doctor_tbl_id = 46
// role_tbl_id = 400, 438, 456, 415, 428, 443, 562
// session_tbls_i = 

$sql = "SELECT * FROM `session_tbls2019` INNER JOIN `role_tbls` ON  `session_tbls2019`.`sessionNo` = `role_tbls`.`sessionNo` AND `session_tbls2019`.`class` = `role_tbls`.`class` AND `session_tbls2019`.`year` = `role_tbls`.`year` WHERE `role_tbls`.`dr_tbl_id` = :id AND `role_tbls`.`year` = '" . $this_year . "' ORDER BY `beginDate` ASC;";

$stmt = $pdo->prepare( $sql );
$stmt->bindValue( ":id", $_POST[ 'dr_tbl_id' ], PDO::PARAM_INT );
$flag = $stmt->execute();
$rows = $stmt->fetchAll( PDO::FETCH_ASSOC );

$stmt = $pdo->prepare( "SELECT * FROM `doctor_tbls` WHERE `id` = :id" );
$stmt->bindValue( ":id", $_POST[ 'dr_tbl_id' ], PDO::PARAM_INT );
$stmt->execute();
$row_dr = $stmt->fetch( PDO::FETCH_ASSOC );

$search_results = '';
$search_results .= '<table class="table table-striped">';
$search_results .= '<thead>';
$search_results .= '<tr>';
$search_results .= '<th class="smf sm">#</th>';
$search_results .= '<th class="smf">DATE/種別</th>';
$search_results .= '<th class="smf">TIME</th>';
$search_results .= ' <th class="smf">Sessioin Title</th>';
$search_results .= '<th class="smf">Role</th>';
$search_results .= '</tr>';
$search_results .= '</thead>';
$search_results .= '<tbody>';

$i = 1;
foreach ( $rows as $row ) {
	/*
		  ここで <form></form>を <td></td>の間に挟まないとイベントが発生しない!!
		  */
	$search_results .= '<tr><td class="smf">';
	$search_results .= $i;
	$search_results .= '</td>';
	if ( $row[ 'day' ] == '2019-12-14' ) {
		$search_results .= '<td class="small_left_align red">';
	} else {
		$search_results .= '<td class="small_left_align">';
	}
	if ( $row[ 'class' ] == 'zagaku' ) {
		$search_results .= '12/14 ZAGAKU (インタベ座学)';
	} else if ( $row[ 'class' ] == 'com' ) {
		$search_results .= '12/15 Comedical (コメディカル・セッション)';
	} else if ( ( $row[ 'day' ] == '2019-12-14' ) && ( $row[ 'class' ] == 'tri' ) ) {
		$search_results .= '12/14 TRI Session';
	} else {
		$search_results .= '12/15 TRI Session';
	}
	$search_results .= '</td>';
	$search_results .= '<td class="small_left_align">' . _Q( mb_substr( $row[ 'begin' ], 0, 5 ) ) . ' - ' . date( "H:i", strtotime( $row[ 'begin' ] ) + $row[ 'duration' ] * 60 ) . '</td>';
	$search_results .= '<td class="small_left_align">' . _Q( trimBothEndSpace( $row[ 'sessionTitle' ] ) ) . '</td>';
	$search_results .= '<td class="small_left_align">';
	if ( $row[ 'role_kind' ] === '1' ) {
		$search_results .= 'Chair (座長)';
	} else if ( $row[ 'role_kind' ] === '2' ) {
		$search_results .= 'Discussant (コメンテーター)';
	} else if ( $row[ 'role_kind' ] === '3' ) {
		$search_results .= 'Lecturer (講師/演者)';
	} else if ( $row[ 'role_kind' ] === '4') {
		$search_results .= 'In Cathlabo Commentator (カテ室コメンテーター)';
	} else if ( $row[ 'role_kind' ] === '6' ) {
		$search_results .= 'Operator (術者)';
	}
	$search_results .= '</td>';
	$search_results .= '</tr>';
	$i++;
}

$search_results .= ' </tbody>';
$search_results .= '</table>';



?>

<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="shortcut icon" href="../favicon.ico">
	<title>KAMAKURA LIVE Faculty Registration</title>
	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.css">
	<!-- Custom styles for this template -->
	<link rel="stylesheet" type="text/css" href="../bootstrap/jumbotron/jumbotron.css">
	<link rel="stylesheet" type="text/css" href="2017top.css">
	<link rel="stylesheet" type="text/css" href="db_read/tri_session_table.css">
</head>

<body>
	<div class="container">
		<div class="row col-md-12 text-center">
			<h3 class="text-center text-success">Warm Thanks to <?= $row_dr['kanji_sirname']." ".$row_dr['kanji_firstname']."&nbsp;様&nbsp;"; ?>
			<?php
				if ($row_dr['hp_name_japanese'] != "") {
					echo "("._Q($row_dr['hp_name_japanese']).")";
				} 
			?>
			</h3>
			<h3 class="text-center text-danger">Mr/Ms/Dr. <?= $row_dr['english_firstname']." ".$row_dr['english_sirname']; ?>'s Role List</h3>
			<span class="red_bold_sm text-danger">Last Updated:&nbsp;<?= $latest; ?></span>
			</h3>
			<div class="col-md-12">
				<div class="small">
					<div id="search_results">
						<?= $search_results ?>
					</div>
				</div>
			</div>
			<div class="col-sm-12">
				<p><a class="btn btn-danger" id="return" href="../index.php">Return</a></p>
			</div>
		</div>
		<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha256-Sk3nkD6mLTMOF0EOpNtsIry+s1CsaqQC1rVLTAy+0yc= sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
		<script>
			if ( !window.jQuery ) {
				document.write( '<script src="../../bootstrap/jquery-2.1.4.min.js"><\/script><script src="../../bootstrap/js/bootstrap.min.js"><\/script>' );
			}
		</script>
		<script src="../bootstrap/docs-assets/javascript/extension.js"></script>
		<script src="../bootstrap/docs-assets/javascript/jglycy-1.0.js"></script>
		<script src="../bootstrap/docs-assets/javascript/jtruncsubstr.js"></script>
		<script src="index2016.js"></script>
	</div>
</body>

</html>