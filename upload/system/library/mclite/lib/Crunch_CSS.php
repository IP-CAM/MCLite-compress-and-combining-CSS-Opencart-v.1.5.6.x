<?php
/**
* Crunch_CSS
* @author Shirley Kaiser skdesigns.com
* @date 26 January, 2008 - 2:55pm:
*/
class Crunch_CSS 
{
	protected static $instance;

	public static function minify($content){
		if(!self::$instance)
			self::$instance = new Crunch_CSS;
		
		/* remove comments */
	    $content = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $content);
		/* remove tabs, spaces, new lines, etc. */        
	    $content = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $content);
		/* remove unnecessary spaces */        
	    $content = str_replace('{ ', '{', $content);
	    $content = str_replace(' }', '}', $content);
	    $content = str_replace('; ', ';', $content);
	    $content = str_replace(', ', ',', $content);
	    $content = str_replace(' {', '{', $content);
	    $content = str_replace('} ', '}', $content);
	    $content = str_replace(': ', ':', $content);
	    $content = str_replace(' ,', ',', $content);
	    $content = str_replace(' ;', ';', $content);
	    
		return $content;
	}
}
?>