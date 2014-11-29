<?php 
/**
* @author Shashakhmetov Talgat <talgatks@gmail.com>
*/
require_once "config.php";
$setup_sql = "INSERT INTO `". DB_PREFIX ."setting` (`store_id`, `group`, `key`, `value`, `serialized`) VALUES
(0, 'mclite_cache', 'mclite_cache_list', '', 0),
(0, 'mclite', 'mclite_css_not_include_base64_images_list', '', 0),
(0, 'mclite', 'mclite_css_include_once_base64_images_list', '', 0),
(0, 'mclite', 'mclite_css_include_base64_images_max_size', '4', 0),
(0, 'mclite', 'mclite_css_include_base64_images_into_css', '1', 0),
(0, 'mclite', 'mclite_cssmin_filter_RemoveLastDelarationSemiColon', '0', 0),
(0, 'mclite', 'mclite_cssmin_filter_Variables', '0', 0),
(0, 'mclite', 'mclite_cssmin_filter_ConvertLevel3Properties', '0', 0),
(0, 'mclite', 'mclite_cssmin_filter_RemoveEmptyRulesets', '0', 0),
(0, 'mclite', 'mclite_cssmin_filter_RemoveEmptyAtBlocks', '0', 0),
(0, 'mclite', 'mclite_cssmin_filter_RemoveComments', '1', 0),
(0, 'mclite', 'mclite_cssmin_plugin_CompressExpressionValues', '0', 0),
(0, 'mclite', 'mclite_cssmin_plugin_CompressUnitValues', '1', 0),
(0, 'mclite', 'mclite_cssmin_plugin_CompressColorValues', '1', 0),
(0, 'mclite', 'mclite_cssmin_plugin_ConvertNamedColors', '1', 0),
(0, 'mclite', 'mclite_cssmin_plugin_ConvertRgbColors', '1', 0),
(0, 'mclite', 'mclite_cssmin_plugin_ConvertHslColors', '1', 0),
(0, 'mclite', 'mclite_cssmin_plugin_ConvertFontWeight', '1', 0),
(0, 'mclite', 'mclite_cssmin_plugin_Variables', '0', 0),
(0, 'mclite', 'mclite_css_minimize_library', 'CssMin', 0),
(0, 'mclite', 'mclite_css_stay_position_list', '', 0),
(0, 'mclite', 'mclite_css_not_minimize_list', '', 0),
(0, 'mclite', 'mclite_css_minimize', '1', 0),
(0, 'mclite', 'mclite_css_not_merge_list', '', 0),
(0, 'mclite', 'mclite_css_merge', '2', 0),
(0, 'mclite', 'mclite_css_not_processing_list', '', 0),
(0, 'mclite', 'mclite_dir_cache_css', 'system/cache', 0),
(0, 'mclite', 'mclite_css_processing', '0', 0),
(0, 'mclite', 'mclite_debug_mode', '0', 0),
(0, 'mclite', 'mclite_cdn_cssurl', '0', 0),
(0, 'mclite', 'mclite_cdn_imgs', '0', 0),
(0, 'mclite', 'mclite_cdn_css', '0', 0),
(0, 'mclite', 'mclite_cdn_addr', '', 0),
(0, 'mclite', 'mclite_html_minimize_library', 'Minify_HTML', 0),
(0, 'mclite', 'mclite_minify_html', '0', 0),
(0, 'mclite', 'mclite_use_ultra_cache', '0', 0),
(0, 'mclite', 'mclite_use_static_gzip', '0', 0);";
//If Use Mysql Database + cache
require_once(DIR_SYSTEM . 'library/cache.php');
$cache = new Cache();
require_once(DIR_SYSTEM . 'library/db.php');
// Database 
$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$db->query($setup_sql);
unlink(__FILE__);
echo "<html><head><title>mclite database installation complete</title></head><body><h1><b>mclite database query complete</h1></body></html> ";
?>