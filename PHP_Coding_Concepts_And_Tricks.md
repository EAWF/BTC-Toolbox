# PHP Coding Concepts & Tricks
There are many ways to do dynamic sites built with PHP. The method used in this site may be different, but makes sense to many.
* For each page:
  - Use the php_include_path to keep secure information safe.
    - These files are stored ***OUTSIDE*** the web site *DocumentRoot*, which is **NOT** accessable by the public.
  - Do the PHP programming work first.
  - Use PHP to dynamically build/send the HTML to the web server.
  - The web server will send the html/css/javascript to the customer browser
* Here's an example:
  - Directory Layout
    - /var/www/html           - directory where www.yourdomain.com/index.php is located
    - /var/www/php            - directory where supporting php and other more secure files are located
    - /var/www/php/init.php   - an example of where you might set up constants, classes, and functions that you want to use on EVERY page of the site, ex header.php, footer.php, nav.php, etc.
    - /var/www/php/qrcode.js  - an example of where you might store a javascript file if you want to keep it outside of the docroot, in other words, no one can just grab it from your site, but it can be sent easily to their browser.  
    - Note that one can easily separate the HTML from the php code by putting the "print <<<END END;" statement in a separate file outside the docroot and *include* or *require* it from the PHP include_path, thus keeping the PHP and HTML code separate.    
  ```php
  <?PHP
   set_include_path ('.:/var/www/php');  // Search this directory(.) else /var/www/php directory, else fail.
   require_once 'init.php';
   $qrsrc = stream_resolve_include_path('qrcode.js');
   $testvar1 = "Hello World!";
   $testvar2 = "This is a demonstration of how to use php vars in HTML by using the print <<<END END; tags in PHP.";
   $testvar3 = "Use HTML characters &quot;quote&apos;s&quot; and apostrophe&apos;s or your page will fail without displaying an error to the browser.";
  print <<<END
   <html>
    <head>
     <title>$testvar1</title>
     <script type-'javascript' src='$qrsrc'></script>
    <head>
    <body>
     <h1>$testvar1<h1>
     <p>$testvar2</p>
     <p>$testvar3</p>
    <body>
   </html>
  END;
  ?>
  ```
