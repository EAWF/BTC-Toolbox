#On Locating getBTC.conf in PHP
* @Septem151 asked: ***Where exactly should the getBTC.conf file be located in relation to the getBTC.php file? I've been working under the assumption that they go in the same directory.***
* @EAWF Responded:

Yes, for testing, they locate in the same directory, but for security reasons, in production they should be placed in a directory below or to the side of the web docroot and along the Apache php include_path.

While the *include* or *require* statements automatically search the path for the .php file, this is not true for any other filetypes, so we're using the **fopen(stream_resolve_include_path("getBTC.conf")** statement to allow the httpd daemon(apache) to look along the php_include_path to locate the regular file getBTC.conf.

Note that both of these files need to be owned by domainuser:apache or root:apache in the case of apache and apache2, and permissions set to 660 to allow root and the server daemonID "apache" to read and/or (possibly) write them.

The include_path COULD be set using ***set_include_path()*** at the top of each program, but this is a PITA. 

Instead, root should set the **php include_path** in the servers */etc/httpd/conf/httpd.conf* or a virtual domain's */etc/httpd/vhosts/domain.conf* file using the configuration line: 
```php_value include_path .:/var/www/domain/php/:/var/www/php/```

I use CentOS7 Linux, Apache, and PHP for web hosting and always keep security utmost in mind, so I have my servers web domains structured, owned, and permissioned as follows:
- **/var/www/php/** - root:apache(660)
  - Server-wide PHP repository
  - ***Store getBTC.php here if you are using it for multiple domains***.
  - Note that root and apache/php are able access files in this directory.
- **/var/www/domain/** - userid:apache(660)
  - Domain Root - This, and everything below this, is owned by the domain userID
- **/var/www/domain/docroot/** - userid:apache(660)
  - DocRoot - where Apache reads the index.html and index.php files to deliver to the site visitors.
- **/var/www/domain/php/** - userid:apache(660)
  - Domain-only PHP repository
  - ***Store getBTC.conf here***
  - ***Store getBTC.php here if you are using it on a single domain***
  -  Note that only the userid and apache can access files in here so your getBTC.conf is secure.

If I am virtual hosting another domain, getBTC.conf gets stored in */var/www/domain2/* with the same set of subdirectories as the domain above. With the include path set in the domain.conf file, so it's easy to include its own getBTC.conf file and include the servers getBTC.php.
