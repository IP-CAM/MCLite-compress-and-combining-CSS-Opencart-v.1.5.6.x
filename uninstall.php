<?php 
/**
* @author Shashakhmetov Talgat <talgatks@gmail.com>
*/
require_once "config.php";
$setup_sql[] = "DELETE FROM `". DB_PREFIX ."setting` WHERE `". DB_PREFIX ."setting`.`group` = 'mclite';";
$setup_sql[] = "DELETE FROM `". DB_PREFIX ."setting` WHERE `". DB_PREFIX ."setting`.`group` = 'mclite_cache';";

//If Use Mysql Database + cache
require_once(DIR_SYSTEM . 'library/cache.php');
$cache = new Cache();

require_once(DIR_SYSTEM . 'library/db.php');
// Database 
$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
foreach ($setup_sql as $key => $value) {
  $db->query($value);
}

$files = array(
	'admin/model/mclite/setting.php',
	'system/library/mclite/lib/Crunch_HTML.php',
	'system/library/mclite/mclite.class.php',
	'admin/controller/mclite/setting.php',
	'admin/view/template/mclite/setting.tpl',
	'admin/language/russian/mclite/setting.php',
	'system/library/mclite/lib/Crunch_CSS.php',
	'system/library/mclite/lib/HTMLMinRegex.php',
	'system/library/mclite/lib/YUICssCompressorPHPPort.php',
	'system/library/mclite/lib/CssMinRegex.php',
	'system/library/mclite/lib/canCSSMini.php',
	'system/library/mclite/lib/CssMin.php',
	'system/library/mclite/lib/Minify_HTML.php'
);

$dirs = array(
	'system/library/mclite/lib',
	'system/library/mclite',
	'admin/controller/mclite',
	'admin/model/mclite',
	'admin/view/template/mclite',
	'admin/language/russian/mclite'
);
foreach ($files as $key => $value) {
	@unlink($value);
}
foreach ($dirs as $key => $value) {
	@rmdir($value);
}
echo "<html><head><title>mclite database and files deleted.</title></head><body><h1>mclite database and files deleted.</h1></body></html>";
?>