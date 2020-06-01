#MCLite

 MCLite this free module for OpenCart, which is designed to automatically compress and combining CSS files.

 ## How does MCLite

 Before you send a page to the client, it scans the code, finding in it all CSS files and processes them in accordance with the configuration and settings of the whole bunch (and libraries to minimize).  After processing, it retains the new (compressed) CSS files into a temporary folder.  Then substitute minimized links to CSS files in the page code.  Thus the original CSS files remain intact.  After sending this style file for the page deals with the server, rather than PHP.  Compressed and transmitted only the styles that are used on the visited page.

 ## Features MCLite

     The presence of several libraries to minimize CSS
     The ability to insert in the Picture Style files encoded in base64, regardless of the chosen minimizer (benefits)
     Packing style files gzip algorithm when creating the file.  Those.  not to spend time compression "on the fly"
     The ability to use Domain CDN to return CSS and images
     There is a function to optimize database
     Multiple file association modes
     The possibility to exclude certain files from the processing / association / minimize
     An HTML compression feature (on the fly, without caching)
     The presence of several libraries to compress HTML
     minimum file
     Convenient cache manager statistics compression
     The presence uninstaller (removes with the files and records of the module)

 ##Resources

 In the MCLite used open source projects, such as

     CSSMin Joe Scylla
     CSSMin Regex Shashakhmetov Talgat
     YUI CSS Compressor php port Tubal Martin
     CanCSSMini andi
     Crunch CSS Shirley Kaiser
     Minify HTML Stephen Clay
     HTMLMin Regex Shashakhmetov Talgat
     Crunch HTML Shirley Kaiser

 ## Supported versions

 All versions starting from 1.5.1 to 1.5.6.4 inclusive.

 ## Installation

 ### Step 1: Copy files

 Copy the contents of the folder "upload" to the root directory of the site.

 ### Step 2. Edit files

 In the file "index.php" before the line $ response-> output ();  (At the end of file)

 // MCLite
 if (preg_match ( '/ head> / im', $ response-> output) &&! defined ( 'DIR_CATALOG')) {
     $ Loader-> library ( 'mclite / mclite.class');
     $ Mclite = new mclite ($ registry, $ response-> output);
     $ Response-> output = $ mclite-> output;
 }

 The file "system / library / response.php" line

 private $ output;

 replaced by

 public $ output;

 ### Step 3: Adding entries to the database

 Copy the file to the root directory "install.php".  Run it through your browser.  Example, http: //adres-sayta/install.php.  He adds the new values ​​into the database.  After performing necessary to delete the file !!!

 ### Step 4: Configure privileges OpenCart

 In the administrative panel of the site go to "System-> Polzovateli-> User Groups'.  Next to the line "Chief Administrator" click "Edit."  The lists of "Approved view" and "allow for changes" tick "mcj / setting", or click "Select All".  Save.

 ### Step 5: Configuring .htaccess

 To use the static file compression in the .htaccess file, you must add:

 AddType text / css .css .cssgz
 AddEncoding x-gzip .cssgz

-----------

#MCLite

MCLite бесплатный это модуль для OpenCart, который предназначен для автоматического сжатия и объединения CSS файлов. 

##Как работает MCLite

Перед тем как послать страницу клиенту он сканирует ее код, находя в нем все CSS файлы, и обрабатывает их в соответствии с настройками, а настроек этих целая куча (как и библиотек для минимизации). После обработки он сохраняет новые (сжатые) CSS файлы во временную папку. Затем подменяет ссылки на минимизированные CSS файлы в коде страницы. Таким образом оригинальные CSS файлы остаются нетронутыми. После этого отправкой файлов стилей для страницы занимается сервер, а не PHP. Сжимаются и передаются только те стили, которые используются на посещаемой странице.

##Возможности MCLite
- Наличие нескольких библиотек для минимизации CSS
- Возможность вставлять в файлы стилей изображения в кодировке base64, вне зависимости от выбранного минимизатора (преимущества)
- Упаковка файлов стилей алгоритмом gzip во время создания файла. Т.е. не будет тратится время на сжатие "на лету"
- Возможность использовать Domain CDN для отдачи CSS и изображений
- Имеется функция оптимизации базы данных
- Несколько режимов объединения файлов
- Возможность исключить определенные файлы из обработки/объединения/минимизации
- Имеется функция сжатия HTML (на лету, без кэширования)
- Наличие нескольких библиотек для сжатия HTML
- Минимум файлов
- Удобный менеджер кэша со статистикой сжатия
- Наличие деинсталлятора (удаляет вместе с файлами и записями модуля)

##Ресурсы

В работе MCLite используются проекты с открытым исходным кодом, такие как
* [CSSMin] Joe Scylla
* [CSSMin Regex] Shashakhmetov Talgat
* [YUI CSS Compressor php port] Tubal Martin
* [CanCSSMini] andi
* [Crunch CSS] Shirley Kaiser
* [Minify HTML] Stephen Clay
* [HTMLMin Regex] Shashakhmetov Talgat
* [Crunch HTML] Shirley Kaiser

##Поддерживаемые версии

Все версии, начиная от 1.5.1 до 1.5.6.4 включительно.

##Установка

###Шаг 1. Копирование файлов

Скопировать содержимое папки "upload" в корневую директорию сайта.


###Шаг 2. Редактирование файлов

В файле "index.php" перед строкой $response-&gt;output(); (в самом конце файла)
добавить:
```php
//MCLite
if (preg_match('/head>/im', $response->output) && !defined('DIR_CATALOG')) {
    $loader->library('mclite/mclite.class');
    $mclite = new mclite($registry, $response->output);
    $response->output = $mclite->output;
}
```
В файле "system/library/response.php" строку 
```php
private $output; 
```
заменить на 
```php
public $output;
```

###Шаг 3. Добавление записей в базу данных

Скопировать в корневую директорию файл "install.php". Выполнить его через адресную строку браузера. Например, http://адрес-сайта/install.php. Он добавит новые значения в базу данных.
После выполнения обязательно удалить файл!!!


###Шаг 4. Настройка привилегий в OpenCart

В административной панели сайта перейти в "Система-&gt;Пользователи-&gt;Группы пользователей". Напротив строки "Главный администратор" нажать "изменить".
В списках "Разрешен просмотр" и "Разрешено внесение изменений" поставить галочку напротив "mcj/setting", либо нажать "Выделить все". Сохранить.


###Шаг 5. Настройка .htaccess

Для использования статического сжатия файлов в файл .htaccess необходимо добавить:
```
AddType text/css .css .cssgz
AddEncoding x-gzip .cssgz
```
[CSSMin]:https://github.com/natxet/CssMin
[CSSMin Regex]:http://halfhope.ru/
[YUI CSS Compressor php port]:https://github.com/tubalmartin/YUI-CSS-compressor-PHP-port
[CanCSSMini]:http://google.com/
[Crunch CSS]:http://websitetips.com/articles/optimization/css/crunch/
[Minify HTML]:https://github.com/mrclay/minify
[HTMLMin Regex]:http://halfhope.ru/
[Crunch HTML]:http://websitetips.com/articles/optimization/html/crunch/
[jQuery]:http://jquery.com
