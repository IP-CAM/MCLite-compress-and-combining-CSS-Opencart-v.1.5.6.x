<?php
/**
* Минимизатор css-кода
*
* Удаляет несущественные данные, тем самым уменьшая конечный размер переданных
* данных. Если код содержит конструкции типа expression, то с очень большой
* долей вероятности такой код после минимизации работать НЕ БУДЕТ.
*
* @author       andi <ab@cdef.ru>
* @copyright    © Centurys ent., 2007
* @link         http://a-panov.ru/
* @since        0.9.6
* @package      public scripts
* @access       public
*/

/**
* cCSSMini
*/
class canCSSMini {
    /**
    * Возвращает содержимое css-файла, пропущенного через минимизатор
    *
    * @param string $file_name имя файла
    * @result string|boolean обработанная строка, либо false в случае ошибки
    */
    static function ClearFile($file_name) {
        if (file_exists($file_name) || preg_match('!^https?://!', $file_name)) {
            $str = file_get_contents($file_name);
            return self::_Go($str);
        }
        return false;
    }
    
    /**
    * Возвращает css-строку, пропущенную через минимизатор
    *
    * @param string $str строка для обработки
    * @result string|boolean обработанная строка, либо false в случае ошибки
    */
    public static function minify($str) {
        return self::_Go($str);
    }
    
    /**
    * Возвращает минимизированную css-строку
    *
    * Непосредственно функция, отвечающая за минимизацию css-строки.
    *
    * @param string $str строка для обработки
    * @result string|boolean минимизированная строка либо false, если исходная строка пуста
    * @access private
    */
    static private function _Go($str) {
        if ($str) {
            // удаление комментариев
            $str = preg_replace('!/\*.*?\*/!s', '', $str);
            
            // удаление группы пробельных символов
            $str = preg_replace('/[\\x00-\\x20]+/', ' ', $str);
            
            // замена возможной последовательности « ; » на ;
            $str = preg_replace('/[\\x20]?;[\\x20]?/', ';', $str);
            
            // замена возможной последовательности « : » на :
            $str = preg_replace('/[\\x20]?:[\\x20]?/', ':', $str);
            
            // замена возможной последовательности «; }» на }
            $str = preg_replace('/;?[\\x20]?}[\\x20]?/', '}', $str);
            
            // замена возможной последовательности «, » на ,
            $str = preg_replace('/,[\\x20]/', ',', $str);
            
            // замена возможной последовательности « { » на {
            $str = preg_replace('/[\\x20]?{[\\x20]?/', '{', $str);
            
            // замена 0px, 0em и т. д. на 0
            $str = preg_replace('/(:|\\x20)-?0(px|em|ex|in|cm|mm|pt|pc|%)/', '${1}0', $str);
            
            // удаление пустых определений
            $str = preg_replace('/}[^{]+{}/', '}', $str);
            
        } else $str = false;
        return $str;
    }
}
?>