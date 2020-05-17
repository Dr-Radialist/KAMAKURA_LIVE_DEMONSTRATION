<?php // lib.php

function auth_dr() {
	global $magic_code;
	if ( ( $_SERVER[ 'SERVER_NAME' ] === 'localhost' ) && isset( $_SESSION[ 'dr_name' ] ) ) return TRUE; // debug用	
	// 60 * 10秒 (= 10分)タイムアウトしていればログアウト処理
	if ( !isset( $_SESSION[ "last_time" ] ) || ( time() - $_SESSION[ "last_time" ] > 60 * 10 ) ) {
		session_unset(); //$_SESSION = array();でも可？
		//クッキーからセッションID削除
		if ( isset( $_COOKIE[ "PHPSESSID" ] ) ) {
			setcookie( "PHPSESSID", '', time() - 42000, '/' );
		}
		//セッション削除
		session_destroy();
		if ( $_SERVER[ 'SERVER_NAME' ] == 'http://www.tri-international.org' ) {
			header( 'Location: https://www.tri-international.org/J-WINC-R/index/timeout_page.php' );
			exit();
		} else {
			header( 'Location: http://localhost/J-WINC-R/index/timeout_page.php' );
			exit();
		}
	} else {
		$_SESSION[ 'last_time' ] = time(); // session timeoutのための変数を再設定する
	}

	if ( !isset( $_SESSION[ 'email' ] ) || !isset( $_SESSION[ 'auth_dr_code' ] ) ) return FALSE;
	if ( hash( "sha512", $magic_code . $_SESSION[ 'email' ] ) == $_SESSION[ 'auth_dr_code' ] ) {
		return TRUE;
	} else {
		$_SESSION = array();
		setcookie( session_name(), '', time() - 42000, '/' );
		session_destroy();
		return FALSE;
	}
}

function auth_dr_long() { // 2時間後にタイムアウトする
	global $magic_code;
	//タイムアウトしていればログアウト処理
	if ( !isset( $_SESSION[ "last_time" ] ) || ( time() - $_SESSION[ "last_time" ] > 60 * 60 * 2 ) ) {
		session_unset(); //$_SESSION = array();でも可？
		//クッキーからセッションID削除
		if ( isset( $_COOKIE[ "PHPSESSID" ] ) ) {
			setcookie( "PHPSESSID", '', time() - 42000, '/' );
		}
		//セッション削除
		session_destroy();
		if ( $_SERVER[ 'SERVER_NAME' ] == 'http://www.tri-international.org' ) {
			header( 'Location: https://www.tri-international.org/J-WINC-R/index/timeout_page.php' );
			exit();
		} else {
			header( 'Location: http://localhost/J-WINC-R/index/timeout_page.php' );
			exit();
		}
	} else {
		$_SESSION[ 'last_time' ] = time(); // // session timeoutのための変数を再設定する
	}
	//		if ($_SERVER['SERVER_NAME'] === 'localhost') return TRUE;		// debug用	
	if ( !isset( $_SESSION[ 'email' ] ) || !isset( $_SESSION[ 'auth_dr_code' ] ) ) return FALSE;
	if ( hash( "sha512", $magic_code . $_SESSION[ 'email' ] ) == $_SESSION[ 'auth_dr_code' ] ) {
		return TRUE;
	} else {
		$_SESSION = array();
		setcookie( session_name(), '', time() - 42000, '/' );
		session_destroy();
		return FALSE;
	}
}

function auth_admin() {
	global $magic_code;
	global $admin_id;
	if ( !isset( $_SESSION[ 'auth_admin_code' ] ) && ( $_SERVER[ 'SERVER_NAME' ] == 'http://www.tri-international.org' ) ) return FALSE;
	if ( ( $_SERVER[ 'SERVER_NAME' ] == 'http://www.tri-international.org' ) || ( hash( "sha512", $admin_id . $magic_code ) != $_SESSION[ 'auth_admin_code' ] ) ) {
		return FALSE;
	} else {
		return TRUE;
	}
}

function auth_admin_general() {
	global $magic_code;
	if ( $_SERVER[ 'SERVER_NAME' ] == 'localhost' ) return TRUE;
	if ( !isset( $_SESSION[ 'auth_admin_general' ] ) && ( $_SERVER[ 'SERVER_NAME' ] == 'http://www.tri-international.org' ) ) return FALSE;
	if ( ( $_SERVER[ 'SERVER_NAME' ] == 'http://www.tri-international.org' ) || ( hash( "sha512", $magic_code . 'facc' ) != $_SESSION[ 'auth_admin_genral' ] ) ) {
		return FALSE;
	} else {
		return TRUE;
	}
}

function check_auth_admin_general() {
	if ( !auth_admin_general() ) {
		echo "<body bgcolor='black'>";
		echo "<h1 align='center'><font color='red'><br/><br/>Illegal Access Denied!</font></h1>";
		echo "</body>";
		session_destroy();
		exit();
	}
}

function auth_index() { // ちゃんとトップページから入ってきたか
	// さらにuser_agentをチェックしてセッション・ハイジャックを防ぐ
	global $magic_code;
	if ( !isset( $_SESSION[ 'user_agent' ] ) )$_SESSION[ 'user_agent' ] = $_SERVER[ 'HTTP_USER_AGENT' ];
	if ( $_SERVER[ 'HTTP_USER_AGENT' ] != $_SESSION[ 'user_agent' ] ) return false;
	if ( $_SERVER[ 'SERVER_NAME' ] == 'localhost' ) return TRUE;
	if ( !isset( $_SESSION[ 'index_key' ] ) || ( $_SESSION[ 'index_key' ] != hash( "sha512", $magic_code ) ) ) {
		return FALSE;
	} else {
		return TRUE;
	}
}

function check_auth_index() {
	if ( !auth_index() ) {
		echo "<body bgcolor='black'>";
		echo "<h1 align='center'><font color='red'><br/><br/>Illegal Access Denied!</font></h1>";
		echo "</body>";
		session_destroy();
		exit();
	}
}

// 拡張子でMIME-typeを判定してみる例 

// 必要に応じて、自分が利用したいMIME-typeを追加してください 
$aContentTypes = array(
	'txt' => 'text/plain',
	'htm' => 'text/html',
	'html' => 'text/html',
	'jpg' => 'image/jpeg',
	'jpeg' => 'image/jpeg',
	'gif' => 'image/gif',
	'png' => 'image/png',
	'bmp' => 'image/x-bmp',
	'ai' => 'application/postscript',
	'psd' => 'image/x-photoshop',
	'eps' => 'application/postscript',
	'pdf' => 'application/pdf',
	'swf' => 'application/x-shockwave-flash',
	'lzh' => 'application/x-lha-compressed',
	'zip' => 'application/x-zip-compressed',
	'sit' => 'application/x-stuffit',
	'doc' => 'application/msword',
	'docx' => 'application/msword',
	'xlsx' => 'application/vnd.ms-excel',
	'xls' => 'application/msexcel',
	'ppt' => 'application/mspowerpoint'
);

// 拡張子からMimeTypeを設定 
function getMimeType( $filename ) {
	global $aContentTypes;
	$sContentType = 'application/octet-stream';

	if ( ( $pos = strrpos( $filename, "." ) ) !== false ) {
		// 拡張子がある場合 
		$ext = strtolower( substr( $filename, $pos + 1 ) );
		if ( strlen( $ext ) ) {
			return $aContentTypes[ $ext ] ? $aContentTypes[ $ext ] : $sContentType;
		}
	}
	return $sContentType;
};

// 文字コードのセット
function charSetUTF8() {
	mb_language( "Japanese" );
	mb_internal_encoding( "UTF-8" );
	mb_http_output( 'UTF-8' );
};

// HTML出力時のQuoting関数
function _Q( $argv ) {
	return htmlentities( $argv, ENT_QUOTES, 'UTF-8' );
}

function incMonth( $present_month ) {
	// yyyy-mm形式の$present_monthから一ヶ月後の月を yyyy-mm形式で戻す
	$p_time = strtotime( $present_month );
	$p_m = date( "m", $p_time );
	$p_y = date( "Y", $p_time );
	if ( $p_m < 12 ) {
		$p_m += 1;
	} else {
		$p_y += 1;
		$p_m = 1;
	}
	return $p_y . "-" . sprintf( "%02d", $p_m );
}

function decMonth( $present_month ) {
	// yyyy-mm形式の$present_monthから一ヶ月前の月を yyyy-mm形式で戻す
	$p_time = strtotime( $present_month );
	$p_m = date( "m", $p_time );
	$p_y = date( "Y", $p_time );
	if ( $p_m != 1 ) {
		$p_m -= 1;
	} else {
		$p_y -= 1;
		$p_m = 12;
	}
	return $p_y . "-" . sprintf( "%02d", $p_m );
}

function diffMonth( $begin_month, $end_month ) {
	// yyyy-mm-01形式の $end_monthと $begin_monthの差の月数を返す
	$b_m = new DateTime( $begin_month );
	$e_m = new DateTime( $end_month );
	$interval = $e_m->diff( $b_m );
	$result = $interval->y * 12;
	$result += $interval->m;
	return $result;
}

function nameToMessage( $row_name ) {
	// $row_nameを受け取り、CAG/PCI/EVTや、radial/brachial/femoralあるいは第1/2術者に切り分ける
	if ( strlen( $row_name ) == 7 ) {
		$proc_kind = strtoupper( substr( $row_name, 0, 3 ) );
		$proc_side = substr( $row_name, 4, 1 );
		if ( $proc_side = 'r' )$proc_side = "右";
		else $proc_side = "左";
		$proc_site = substr( $row_name, 5, 1 );
		if ( $proc_site == 'r' ) {
			$proc_site = "橈骨動脈";
		} else {
			if ( $proc_site == 'b' ) {
				$proc_site = "肘動脈";
			} else {
				$proc_site = "大腿動脈";
			}
		}
		$proc_no = substr( $row_name, 6, 1 );
		return $proc_kind . "/" . $proc_side . $proc_site . "/第" . $proc_no . "術者";
	} else {
		return;
	}
}

function checkAuthorizedEmail( $email ) { // 管理者メルアドであれば true
	if ( !auth_dr() ) return false;
	if ( ( $email == 'transradial@kamakuraheart.org' ) ||
		( $email == 'hone-circ@umin.ac.jp' ) ||
		( $email == 'saeko@kamakuraheart.org' ) )
		return true;
	else return false;
}

function trimBothEndSpace( $str ) { // 単語の語頭および語末の全角・半角スペースを削除して戻す
	// 行頭の半角、全角スペースを、空文字に置き換える
	$str = preg_replace( '/^[ 　]+/u', '', $str );
	// 末尾の半角、全角スペースを、空文字に置き換える
	$str = preg_replace( '/[ 　]+$/u', '', $str );
	return $str;
}

function makeComeList( $pdo, $sessionNo, $role_kind ) { // Comeセッションでの$sessionNoのセッションのChairリストを戻す
	// $role_kind: 1 = Chair, 2 = Moderator, 3 = Lecturer, 4 = In-cathe Interpreter
	// database接続子の $pdoが必要
	$roler_list = '';
	$sql = "SELECT * FROM `doctor_tbls` INNER JOIN `role_tbls` ON `doctor_tbls`.`id` = `role_tbls`.`dr_tbl_id` ";
	$sql .= "WHERE `role_tbls`.`sessionNo` = :sessionNo AND `role_tbls`.`role_kind` = :role_kind AND `role_tbls`.`class` = :class;";
	$stmt = $pdo->prepare( $sql );
	$stmt->bindValue( ":sessionNo", $sessionNo, PDO::PARAM_INT );
	$stmt->bindValue( ":role_kind", $role_kind, PDO::PARAM_INT );
	$stmt->bindValue( ":class", 'com', PDO::PARAM_STR );
	$stmt->execute();
	$rolers = $stmt->fetchAll( PDO::FETCH_ASSOC );
	$roler_list = '';
	foreach ( $rolers as $roler ) {
		if ( ( !isset( $roler[ 'kanji_sirname' ] ) || $roler[ 'kanji_sirname' ] == '' ) ) {
			$roler_list .= $roler[ 'english_sirname' ] . ' ' . $roler[ 'english_firstname' ] . ' (' . $roler[ 'hp_name_english' ] . '), ';
		} else {
			$roler_list .= $roler[ 'kanji_sirname' ] . ' ' . $roler[ 'kanji_firstname' ] . ' (' . $roler[ 'hp_name_japanese' ] . '), ';
		}
	}
	$roler_list = rtrim( $roler_list, ', ' );
	return $roler_list;
}

function makeComeList2017( $pdo, $sessionNo, $role_kind, $class, $this_year ) { // Comeセッションでの$sessionNoのセッションのChairリストを戻す
	// $role_kind: 1 = Chair, 2 = Moderator, 3 = Lecturer, 4 = In-cathe Interpreter
	// database接続子の $pdoが必要
	$roler_list = '';
	$sql = "SELECT * FROM `doctor_tbls` INNER JOIN `role_tbls` ON `doctor_tbls`.`id` = `role_tbls`.`dr_tbl_id` ";
	$sql .= "WHERE `role_tbls`.`sessionNo` = :sessionNo AND `role_tbls`.`role_kind` = :role_kind AND `role_tbls`.`class` = :class ";
	$sql .= "AND `role_tbls`.`year` = :year;";
	$stmt = $pdo->prepare( $sql );
	$stmt->bindValue( ":sessionNo", $sessionNo, PDO::PARAM_INT );
	$stmt->bindValue( ":role_kind", $role_kind, PDO::PARAM_INT );
	$stmt->bindValue( ":class", $class, PDO::PARAM_STR );
	$stmt->bindValue( ":year", $this_year, PDO::PARAM_STR );
	$stmt->execute();
	$rolers = $stmt->fetchAll( PDO::FETCH_ASSOC );
	$roler_list = '';
	foreach ( $rolers as $roler ) {
		if ( ( !isset( $roler[ 'kanji_sirname' ] ) || $roler[ 'kanji_sirname' ] == '' ) ) {
			$roler_list .= $roler[ 'english_sirname' ] . ' ' . $roler[ 'english_firstname' ] . ', ';
		} else {
			$roler_list .= $roler[ 'kanji_sirname' ] . ' ' . $roler[ 'kanji_firstname' ] . ', ';
		}
	}
	$roler_list = rtrim( $roler_list, ', ' );
	return $roler_list;
}

//function makeEvtList($pdo, $sessionNo, $role_kind) {		// EVTセッションでの$sessionNoのセッションのChairリストを戻す
function makeCommonSessionList( $pdo, $sessionNo, $role_kind, $class, $this_year ) { // EVTセッションでの$sessionNoのセッションのChairリストを戻す
	// $role_kind: 1 = Chair, 2 = Moderator, 3 = Lecturer, 4 = In-cathe Interpreter, 5 = Operator
	$roler_list = '';
	$sql = "SELECT * FROM `doctor_tbls` INNER JOIN `role_tbls` ON `doctor_tbls`.`id` = `role_tbls`.`dr_tbl_id` ";
	$sql .= "WHERE `role_tbls`.`sessionNo` = :sessionNo AND `role_tbls`.`role_kind` = :role_kind AND ";
	$sql .= "`role_tbls`.`class` = :class AND `role_tbls`.`year` = :year;";
	$stmt = $pdo->prepare( $sql );
	$stmt->bindValue( ":sessionNo", $sessionNo, PDO::PARAM_INT );
	$stmt->bindValue( ":role_kind", $role_kind, PDO::PARAM_INT );
	$stmt->bindValue( ":class", $class, PDO::PARAM_STR );
	$stmt->bindValue( ":year", $this_year, PDO::PARAM_STR );
	$stmt->execute();
	$rolers = $stmt->fetchAll( PDO::FETCH_ASSOC );
	$roler_list = '';
	foreach ( $rolers as $roler ) {
		if ( ( !isset( $roler[ 'kanji_sirname' ] ) || $roler[ 'kanji_sirname' ] == '' ) ) {
			$roler_list .= $roler[ 'english_sirname' ] . ' ' . $roler[ 'english_firstname' ] . ' (' . $roler[ 'hp_name_english' ] . '), ';
		} else {
			$roler_list .= $roler[ 'kanji_sirname' ] . ' ' . $roler[ 'kanji_firstname' ] . ' (' . $roler[ 'hp_name_japanese' ] . '), ';
		}
	}
	$roler_list = rtrim( $roler_list, ', ' );
	return $roler_list;
}

function makeCommonSessionListTRI( $pdo, $sessionNo, $role_kind, $class, $this_year ) {
	// TRIセッションでの$sessionNoのセッションの英語のChairリストを戻す
	// $role_kind: 1 = Chair, 2 = Commentator, 3 = Lecturer, 4 = In-cathe Interpreter
	$roler_list = '';
	$sql = "SELECT * FROM `doctor_tbls` INNER JOIN `role_tbls` ON `doctor_tbls`.`id` = `role_tbls`.`dr_tbl_id` WHERE `role_tbls`.`sessionNo` = :sessionNo AND `role_tbls`.`role_kind` = :role_kind AND `role_tbls`.`class` = :class AND `role_tbls`.`year` = :year;";
	$stmt = $pdo->prepare( $sql );
	$stmt->bindValue( ":sessionNo", $sessionNo, PDO::PARAM_INT );
	$stmt->bindValue( ":role_kind", $role_kind, PDO::PARAM_INT );
	$stmt->bindValue( ":class", $class, PDO::PARAM_STR );
	$stmt->bindValue( ":year", $this_year, PDO::PARAM_STR );
	$flag = $stmt->execute();
	if ( !$flag ) {
		$infor = $stmt->errorInfo();
		exit( $infor[ 2 ] );
	}
	$rolers = $stmt->fetchAll( PDO::FETCH_ASSOC );
	$roler_list = '';
	foreach ( $rolers as $roler ) {
		$roler_list .= $roler[ 'english_sirname' ] . ' ' . $roler[ 'english_firstname' ];
		if ( $roler[ 'hp_name_english' ] != "-" ) {
			$roler_list .= ' (' . $roler[ 'hp_name_english' ] . '), ';
		} else {
			$roler_list .= ', ';
		}
	}
	$roler_list = rtrim( $roler_list, ', ' );
	return $roler_list;
}

function makeCommonSessionListTRIJ( $pdo, $sessionNo, $role_kind, $class, $this_year ) { // 日本語表記
	// TRIセッションでの$sessionNoのセッションの英語のChairリストを戻す
	// $role_kind: 1 = Chair, 2 = Commentator, 3 = Lecturer, 4 = In-cathe Interpreter
	$roler_list = '';
	$sql = "SELECT `doctor_tbls`.`id` AS `dr_id`, `kanji_sirname`, `kanji_firstname`, `kana_sirname`, `kana_firstname`, `hp_name_japanese`, `hp_name_english`, `english_sirname`, `english_firstname` FROM `doctor_tbls` INNER JOIN `role_tbls` ON `doctor_tbls`.`id` = `role_tbls`.`dr_tbl_id` WHERE `role_tbls`.`sessionNo` = :sessionNo AND `role_tbls`.`role_kind` = :role_kind AND `role_tbls`.`class` = :class AND `role_tbls`.`year` = :year;";
	$stmt = $pdo->prepare( $sql );
	$stmt->bindValue( ":sessionNo", $sessionNo, PDO::PARAM_INT );
	$stmt->bindValue( ":role_kind", $role_kind, PDO::PARAM_INT );
	$stmt->bindValue( ":class", $class, PDO::PARAM_STR );
	$stmt->bindValue( ":year", $this_year, PDO::PARAM_STR );
	$flag = $stmt->execute();
	if ( !$flag ) {
		$infor = $stmt->errorInfo();
		exit( $infor[ 2 ] );
	}
	$rolers = $stmt->fetchAll( PDO::FETCH_ASSOC );
	$roler_list = '';
	foreach ( $rolers as $roler ) {
		$roler_list .= _Q( $roler[ 'kanji_sirname' ] . ' ' . $roler[ 'kanji_firstname' ] );
		if ( $roler[ 'hp_name_japanese' ] != "" ) {
			$roler_list .= ' (' . _Q( $roler[ 'hp_name_japanese' ] ) . '), ';
		} else {
			$roler_list .= ', ';
		}
	}
	$roler_list = rtrim( $roler_list, ', ' );
	return $roler_list;
}

function makeCommonSessionListTRIJ2( $pdo, $sessionNo, $role_kind, $class, $this_year ) { // 日本語表記
	// TRIセッションでの$sessionNoのセッションの英語のChairリストを戻す
	// $role_kind: 1 = Chair, 2 = Commentator, 3 = Lecturer, 4 = In-cathe Interpreter
	$roler_list = '';
	$sql = "SELECT `doctor_tbls`.`id` AS `dr_id`, `kanji_sirname`, `kanji_firstname`, `kana_sirname`, `kana_firstname`, `hp_name_japanese`, `hp_name_english`, `english_sirname`, `english_firstname` FROM `doctor_tbls` INNER JOIN `role_tbls` ON `doctor_tbls`.`id` = `role_tbls`.`dr_tbl_id` WHERE `role_tbls`.`sessionNo` = :sessionNo AND `role_tbls`.`role_kind` = :role_kind AND `role_tbls`.`class` = :class AND `role_tbls`.`year` = :year;";
	$stmt = $pdo->prepare( $sql );
	$stmt->bindValue( ":sessionNo", $sessionNo, PDO::PARAM_INT );
	$stmt->bindValue( ":role_kind", $role_kind, PDO::PARAM_INT );
	$stmt->bindValue( ":class", $class, PDO::PARAM_STR );
	$stmt->bindValue( ":year", $this_year, PDO::PARAM_STR );
	$flag = $stmt->execute();
	if ( !$flag ) {
		$infor = $stmt->errorInfo();
		exit( $infor[ 2 ] );
	}
	$rolers = $stmt->fetchAll( PDO::FETCH_ASSOC );
	$roler_list = '';
	foreach ( $rolers as $roler ) {
		$roler_list .= '<form class="inline-form" method="post" action="../each_dr_roles_list.php">';
		$roler_list .= '<input type="hidden" name="dr_tbl_id" value="'.$roler['dr_id'].'">';
		$roler_list .= '<button type="submit" class="btn-name">';
		$roler_list .= _Q( $roler[ 'kanji_sirname' ] . ' ' . $roler[ 'kanji_firstname' ] );
		if ( $roler[ 'hp_name_japanese' ] != "" ) {
			$roler_list .= ' (' . _Q( $roler[ 'hp_name_japanese' ] ) . ')';
		} 
		$roler_list .= '</button>';
		$roler_list .= '</form>';
	}
	$roler_list = rtrim( $roler_list, ', ' );
	return $roler_list;
}

function makeCommonSessionListTRIJ2print( $pdo, $sessionNo, $role_kind, $class, $this_year ) { // 印刷用
	// TRIセッションでの$sessionNoのセッションの英語のChairリストを戻す
	// $role_kind: 1 = Chair, 2 = Commentator, 3 = Lecturer, 4 = In-cathe Interpreter
	$roler_list = '';
	$sql = "SELECT `doctor_tbls`.`id` AS `dr_id`, `kanji_sirname`, `kanji_firstname`, `kana_sirname`, `kana_firstname`, `hp_name_japanese`, `hp_name_english`, `english_sirname`, `english_firstname` FROM `doctor_tbls` INNER JOIN `role_tbls` ON `doctor_tbls`.`id` = `role_tbls`.`dr_tbl_id` WHERE `role_tbls`.`sessionNo` = :sessionNo AND `role_tbls`.`role_kind` = :role_kind AND `role_tbls`.`class` = :class AND `role_tbls`.`year` = :year;";
	$stmt = $pdo->prepare( $sql );
	$stmt->bindValue( ":sessionNo", $sessionNo, PDO::PARAM_INT );
	$stmt->bindValue( ":role_kind", $role_kind, PDO::PARAM_INT );
	$stmt->bindValue( ":class", $class, PDO::PARAM_STR );
	$stmt->bindValue( ":year", $this_year, PDO::PARAM_STR );
	$flag = $stmt->execute();
	if ( !$flag ) {
		$infor = $stmt->errorInfo();
		exit( $infor[ 2 ] );
	}
	$rolers = $stmt->fetchAll( PDO::FETCH_ASSOC );
	$roler_list = '';
	foreach ( $rolers as $roler ) {
		//$roler_list .= '<form class="inline-form" method="post" action="../each_dr_roles_list.php">';
		//$roler_list .= '<input type="hidden" name="dr_tbl_id" value="'.$roler['dr_id'].'">';
		$roler_list .= '<button type="submit" class="btn-name">';
		$roler_list .= _Q( $roler[ 'kanji_sirname' ] . ' ' . $roler[ 'kanji_firstname' ] );
		if ( $roler[ 'hp_name_japanese' ] != "" ) {
			$roler_list .= ' (' . _Q( $roler[ 'hp_name_japanese' ] ) . ')';
		} 
		$roler_list .= '</button>';
		//$roler_list .= '</form>';
	}
	$roler_list = rtrim( $roler_list, ', ' );
	return $roler_list;
}

function makeEvtList2( $pdo, $sessionNo, $role_kind ) { // Comeセッションでの$sessionNoのセッションのChairリストを戻す
	// $role_kind: 1 = Chair, 2 = Moderator, 3 = Lecturer, 4 = In-cathe Interpreter
	// database接続子の $pdoが必要
	$roler_list = '';
	$sql = "SELECT * FROM `doctor_tbls` INNER JOIN `role_tbls` ON `doctor_tbls`.`id` = `role_tbls`.`dr_tbl_id` ";
	$sql .= "WHERE `role_tbls`.`sessionNo` = :sessionNo AND `role_tbls`.`role_kind` = :role_kind AND `role_tbls`.`class` = :class;";
	$stmt = $pdo->prepare( $sql );
	$stmt->bindValue( ":sessionNo", $sessionNo, PDO::PARAM_INT );
	$stmt->bindValue( ":role_kind", $role_kind, PDO::PARAM_INT );
	$stmt->bindValue( ":class", 'zagaku', PDO::PARAM_STR );
	$stmt->execute();
	$rolers = $stmt->fetchAll( PDO::FETCH_ASSOC );
	$roler_list = '';
	foreach ( $rolers as $roler ) {
		if ( ( !isset( $roler[ 'kanji_sirname' ] ) || $roler[ 'kanji_sirname' ] == '' ) ) {
			$roler_list .= $roler[ 'english_sirname' ] . ' ' . $roler[ 'english_firstname' ] . ', ';
		} else {
			$roler_list .= $roler[ 'kanji_sirname' ] . ' ' . $roler[ 'kanji_firstname' ] . ', ';
		}
	}
	$roler_list = rtrim( $roler_list, ', ' );
	return $roler_list;
}

function makeTriList( $pdo, $sessionNo, $role_kind, $class, $this_year ) { // TRIセッションでの$sessionNoのセッションのChairリストを戻す
	// $role_kind: 1 = Chair, 2 = Moderator, 3 = Lecturer, 4 = In-cathe Interpreter
	$roler_list = '';
	$sql = "SELECT * FROM `doctor_tbls` INNER JOIN `role_tbls` ON `doctor_tbls`.`id` = `role_tbls`.`dr_tbl_id` ";
	$sql .= "WHERE `role_tbls`.`sessionNo` = :sessionNo AND `role_tbls`.`role_kind` = :role_kind AND `role_tbls`.`class` = :class";
	$sql .= " AND `role_tbls`.`year` ='" . $this_year . "';";
	$stmt = $pdo->prepare( $sql );
	$stmt->bindValue( ":sessionNo", $sessionNo, PDO::PARAM_INT );
	$stmt->bindValue( ":role_kind", $role_kind, PDO::PARAM_INT );
	$stmt->bindValue( ":class", 'tri', PDO::PARAM_STR );
	$stmt->execute();
	$rolers = $stmt->fetchAll( PDO::FETCH_ASSOC );
	$roler_list = '';
	foreach ( $rolers as $roler ) {
		if ( ( !isset( $roler[ 'kanji_sirname' ] ) || $roler[ 'kanji_sirname' ] == '' ) ) {
			$roler_list .= $roler[ 'english_sirname' ] . ' ' . $roler[ 'english_firstname' ] . ' (' . $roler[ 'hp_name_english' ] . '), ';
		} else {
			$roler_list .= $roler[ 'kanji_sirname' ] . ' ' . $roler[ 'kanji_firstname' ] . ' (' . $roler[ 'hp_name_japanese' ] . '), ';
		}
	}
	$roler_list = rtrim( $roler_list, ', ' );
	return $roler_list;
}

function makeTriList2( $pdo, $sessionNo, $role_kind ) { // Comeセッションでの$sessionNoのセッションのChairリストを戻す
	// $role_kind: 1 = Chair, 2 = Moderator, 3 = Lecturer, 4 = In-cathe Interpreter
	// database接続子の $pdoが必要
	$roler_list = '';
	$sql = "SELECT * FROM `doctor_tbls` INNER JOIN `role_tbls` ON `doctor_tbls`.`id` = `role_tbls`.`dr_tbl_id` ";
	$sql .= "WHERE `role_tbls`.`sessionNo` = :sessionNo AND `role_tbls`.`role_kind` = :role_kind AND `role_tbls`.`class` = :class;";
	$stmt = $pdo->prepare( $sql );
	$stmt->bindValue( ":sessionNo", $sessionNo, PDO::PARAM_INT );
	$stmt->bindValue( ":role_kind", $role_kind, PDO::PARAM_INT );
	$stmt->bindValue( ":class", 'tri', PDO::PARAM_STR );
	$stmt->execute();
	$rolers = $stmt->fetchAll( PDO::FETCH_ASSOC );
	$roler_list = '';
	foreach ( $rolers as $roler ) {
		if ( ( !isset( $roler[ 'kanji_sirname' ] ) || $roler[ 'kanji_sirname' ] == '' ) ) {
			$roler_list .= $roler[ 'english_sirname' ] . ' ' . $roler[ 'english_firstname' ] . ', ';
		} else {
			$roler_list .= $roler[ 'kanji_sirname' ] . ' ' . $roler[ 'kanji_firstname' ] . ', ';
		}
	}
	$roler_list = rtrim( $roler_list, ', ' );
	return $roler_list;
}


function session_display_basic( $pdo, $row, $serial_no_of_session, $class, $this_year ) {
	// セッション時間表表示のサブ
	// 入力: $pdo - テータ接続子
	// 入力2: $row; これに関しては本体で呼んでいる
	// $serial_no_of_session: セッション番号
	//$class: "zagaku"," luncheon", "tri", "com", "oct"
	echo '<div class=' . $class . '_each>';
	echo '  <form method="post" action="common_sessions.php">';
	echo '   <input type="hidden" name="class" value=' . $class . '>';
	echo '   <input type="hidden" name="year" value=' . $this_year . '>';
	echo '   <button type="submit" name="sessionNo" value=' . $serial_no_of_session . '>詳細 </button>';
	echo '	</form>';
	echo '      <div class="fleft">&nbsp;';
	echo _Q( mb_substr( $row[ 'begin' ], 0, 5 ) );
	echo " - ";
	echo date( "H:i", strtotime( $row[ 'begin' ] ) + $row[ 'duration' ] * 60 );
	echo '      </div>';
	echo '      <div class="fright">';
	echo _Q( $row[ 'sessionTitle' ] );
	echo '      </div>';
	echo '      <div class="fclear"><h3>テーマ:';
	echo _Q( $row[ 'lectureTitle' ] );
	echo '      </h3></div>';
	echo '      <h4>座長:';
	echo _Q( makeCommonSessionList( $pdo, $serial_no_of_session, 1, $class, $this_year ) );
	echo '      </h4>';
	/*
   echo '		 <h4>モデレーター: ';
	echo 		 _Q(makeCommonSessionList($pdo, $serial_no_of_session, 2, $class, $this_year));
   echo '      </h4>';
   */
	echo '		<h3>演者:';
	echo _Q( makeCommonSessionList( $pdo, $serial_no_of_session, 3, $class, $this_year ) );
	echo '      </h3>';
	echo '      <div>共催会社:';
	echo _Q( $row[ 'cosponsor' ] );
	echo '      </div>';
	echo ' </div>';
}

function session_modify( $pdo, $row, $serial_no_of_session, $class, $this_year ) {
	// セッション時間表表示のサブ
	// 入力: $pdo - テータ接続子
	// 入力2: $row; これに関しては本体で呼んでいる
	// $serial_no_of_session: セッション番号
	//$class: "zagaku"," luncheon", "tri", "com", "oct"
	echo '<div class=' . $class . '_each>';
	echo '  <form method="post" action="db_entry/evt/evt01n.php">';
	echo '   <input type="hidden" name="class" value=' . $class . '>';
	echo '   <input type="hidden" name="year" value=' . $this_year . '>';
	echo '   <button type="submit" name="sessionNo" value=' . $serial_no_of_session . '>修正/変更 </button>';
	echo '	</form>';
	echo '      <div class="fleft">&nbsp;';
	echo _Q( mb_substr( $row[ 'begin' ], 0, 5 ) );
	echo " - ";
	echo date( "H:i", strtotime( $row[ 'begin' ] ) + $row[ 'duration' ] * 60 );
	echo '      </div>';
	echo '      <div class="fright">';
	echo _Q( $row[ 'sessionTitle' ] );
	echo '      </div>';
	echo '      <div class="fclear"><h3>テーマ:';
	echo _Q( $row[ 'lectureTitle' ] );
	echo '      </h3></div>';
	echo '      <h4>座長:';
	echo _Q( makeCommonSessionList( $pdo, $serial_no_of_session, 1, $class, $this_year ) );
	echo '      </h4>';
	echo '		 <h4>モデレーター: ';
	echo _Q( makeCommonSessionList( $pdo, $serial_no_of_session, 2, $class, $this_year ) );
	echo '      </h4>';
	echo '		<h4>演者:';
	echo _Q( makeCommonSessionList( $pdo, $serial_no_of_session, 3, $class, $this_year ) );
	echo '      </h4>';
	echo '      <div>共催会社:';
	echo _Q( $row[ 'cosponsor' ] );
	echo '      </div>';
	echo ' </div>';
}



?>