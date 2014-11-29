<?php
/**
* Crunch_HTML
* @author Shirley Kaiser skdesigns.com
* @date 26 January, 2008 - 2:55pm:
*/
class Crunch_HTML 
{
	protected static $instance;

	public static function minify($content){
		if(!self::$instance)
			self::$instance = new Crunch_HTML;
	    $content = self::stripwhitespace($content);

		return $content;
	}
	static function stripwhitespace($buffer){
		$pzcr = 0;
		$pzed = strlen($buffer) - 1;
		$rst = "";
		while($pzcr < $pzed){
			$t_poz_start = stripos($buffer, "<textarea", $pzcr);
			if($t_poz_start === false){
				$bufferstp = substr($buffer, $pzcr);
				$temp = self::stripBuffer($bufferstp);
				$rst .= $temp;
				$pzcr = $pzed;
			}else{
				$bufferstp = substr($buffer, $pzcr, $t_poz_start - $pzcr);
				$temp = self::stripBuffer($bufferstp);
				$rst .= $temp;
				$t_poz_end = stripos($buffer, "</textarea>", $t_poz_start);
				$temp = substr($buffer, $t_poz_start, $t_poz_end - $t_poz_start);
				$rst .= $temp;
				$pzcr = $t_poz_end;
			}
		}
		return $rst;
	}

	static function stripBuffer($buffer){
		/* carriage returns,  new lines */
		$buffer = str_replace(array("\r\r\r", "\r\r", "\r\n", "\n\r", "\n\n\n", "\n\n"), "\n", $buffer);
		/* tabs */
		$buffer = str_replace(array("\t\t\t", "\t\t", "\t\n", "\n\t"), "\t", $buffer);
		/* opening HTML tags */
		$buffer = str_replace(array(">\r<a", ">\r <a", ">\r\r <a", "> \r<a", ">\n<a", "> \n<a", "> \n<a", ">\n\n <a"), "><a", $buffer);
		$buffer = str_replace(array(">\r<b", ">\n<b"), "><b", $buffer);
		$buffer = str_replace(array(">\r<d", ">\n<d", "> \n<d", ">\n <d", ">\r <d", ">\n\n<d"), "><d", $buffer);
		$buffer = str_replace(array(">\r<f", ">\n<f", ">\n <f"), "><f", $buffer);
		$buffer = str_replace(array(">\r<h", ">\n<h", ">\t<h", "> \n\n<h"), "><h", $buffer);
		$buffer = str_replace(array(">\r<i", ">\n<i", ">\n <i"), "><i", $buffer);
		$buffer = str_replace(array(">\r<i", ">\n<i"), "><i", $buffer);
		$buffer = str_replace(array(">\r<l", "> \r<l", ">\n<l", "> \n<l", ">  \n<l", "/>\n<l", "/>\r<l"), "><l", $buffer);
		$buffer = str_replace(array(">\t<l", ">\t\t<l"), "><l", $buffer);
		$buffer = str_replace(array(">\r<m", ">\n<m"), "><m", $buffer);
		$buffer = str_replace(array(">\r<n", ">\n<n"), "><n", $buffer);
		$buffer = str_replace(array(">\r<p", ">\n<p", ">\n\n<p", "> \n<p", "> \n <p"), "><p", $buffer);
		$buffer = str_replace(array(">\r<s", ">\n<s"), "><s", $buffer);
		$buffer = str_replace(array(">\r<t", ">\n<t"), "><t", $buffer);
		/* closing HTML tags */
		$buffer = str_replace(array(">\r</a", ">\n</a"), "></a", $buffer);
		$buffer = str_replace(array(">\r</b", ">\n</b"), "></b", $buffer);
		$buffer = str_replace(array(">\r</u", ">\n</u"), "></u", $buffer);
		$buffer = str_replace(array(">\r</d", ">\n</d", ">\n </d"), "></d", $buffer);
		$buffer = str_replace(array(">\r</f", ">\n</f"), "></f", $buffer);
		$buffer = str_replace(array(">\r</l", ">\n</l"), "></l", $buffer);
		$buffer = str_replace(array(">\r</n", ">\n</n"), "></n", $buffer);
		$buffer = str_replace(array(">\r</p", ">\n</p"), "></p", $buffer);
		$buffer = str_replace(array(">\r</s", ">\n</s"), "></s", $buffer);
		/* other */
		$buffer = str_replace(array(">\r<!", ">\n<!"), "><!", $buffer);
		$buffer = str_replace(array("\n<div"), " <div", $buffer);
		$buffer = str_replace(array(">\r\r \r<"), "><", $buffer);
		$buffer = str_replace(array("> \n \n <"), "><", $buffer);
		$buffer = str_replace(array(">\r</h", ">\n</h"), "></h", $buffer);
		$buffer = str_replace(array("\r<u", "\n<u"), "<u", $buffer);
		$buffer = str_replace(array("/>\r", "/>\n", "/>\t"), "/>", $buffer);
		$buffer = preg_replace(" {2, }", ' ', $buffer);
		$buffer = preg_replace("  {3, }", '  ', $buffer);
		$buffer = str_replace("> <", "><", $buffer);
		$buffer = str_replace("  <", "<", $buffer);
		/* non-breaking spaces */
		$buffer = str_replace(" &nbsp;", "&nbsp;", $buffer);
		$buffer = str_replace("&nbsp; ", "&nbsp;", $buffer);
		/* Example of EXCEPTIONS where I want the space to remain
		between two form buttons at */ 
		/* <!-- http://websitetips.com/articles/copy/loremgenerator/ --> */
		/* name = "select" /> <input */
		$buffer = str_replace(array("name=\"select\" /><input"), "name=\"select\" /> <input", $buffer);

		return $buffer;
	}

}
?>