<?php

// config.php

//// www.kamakuralive.net 用
	$db_host = '127.0.0.1'; 
	$db_user = 'kamuvnpqr';
	$db_password = 'cdEFWXWXQR';
	$site_url = 'https://www.kamakuralive.net/';

if ($_SERVER['SERVER_NAME'] === 'localhost') {
	// XAMPP用
	$db_host = 'localhost';	
	$db_user = 'root';
	$db_password = 'root';
	$site_url = 'http://localhost/KAMAKURA_Live_SSL/';
}

$db_name_sessions = 'kamakuralive_sessions';

$this_year = date('Y');

// site
$site_name = 'KAMAKURA LIVE';
$title = 'KAMAKURA LIVE DEMONSTRATION COURSE';
$support_mail = 'transradial@kamakuraheart.org';

// magic code
$admin_id = 'Dr_Radialist';
$magic_code = 'NAUSICA in KAMAKURA';

$hp_admin_id = 'KAMAKURA';
$hp_admin_pwd = 'Research Center';

$job_kinds = array(
	  "0"=>'医師 (Doctor)',
      "1"=>'看護師 (Nurse/Sister)',
      "2"=>'臨床工学士 (Clinical Engineer)',
      "3"=>'臨床放射線技師 (Radiology Engineer)',
      "4"=>'医療機器会社社員 (Medical Device Company)',
      "5"=>'医薬品会社社員 (Medical Pharmaceutical Company)',
      "6"=>'規制当局所属 (Officials/Authorities)',
      "7"=>'CRC (Crinical Research Coordinator)',
	  "8"=>'治験関連会社社員 (CRO/SMO)',
      "9"=>'上記以外 (Others)'
	  );

$member_kind = array(
	"1"=>'NPO社員',
	"2"=>'NPO年次社員',
	"3"=>'海外招聘',
	"4"=>'国内招聘',
	"5"=>'親善参加',
	"6"=>'Sd Faculty'
	);
	  
$hints = array(
	'1'=>'母親の旧姓',
	'2'=>'母親の生まれ故郷',
	'3'=>'未だ忘れ得ぬ人の名前',
	'4'=>'父親の生まれ故郷',
	'5'=>'あなたが心の故郷と思う街',
	'6'=>'あなたが最も尊敬する人',
	'7'=>'あなたの隠れた趣味',
	'8'=>'あなたの思い出の土地',
	'9'=>'あなたの大切な言葉'
	);
	
$machines = array(
	"0"=>'メーカーを選択して下さい',
	"1"=>'Siemens',
	"2"=>'Philips',
	"3"=>'Toshiba',
	"4"=>'GE',
	"5"=>'SHIMADZU', 
	"6"=>'Hitachi',
	"7"=>'その他'
	);
	
$protector_kinds = array(
	"0"=>'- プロテクタの種類を選択 -',
	"1"=>'エプロン・タイプ',
	"2"=>'コート・タイプ',
	"3"=>'セパレート・タイプ'
	);

$pb_thickness_kinds = array(
	"0"=>'- プロテクタ鉛当量の選択 -',
	"1"=>'0.25mmPb',
	"2"=>'0.35mmPb',
	"3"=>'0.5mmPb'
	);
	
$start_survey = '2014-10-01';

$role_kind = array(
	"1"=>'Chair',
	"2"=>'Discussant',
	"3"=>'lecturer',
	"4"=>'In-cathlab Commentator',
	"6"=>'Operator'
);
	

?>