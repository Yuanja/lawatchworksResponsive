# lawatch works based on osticket-v1.10
-- After cloning it you will have lawatchworks/upload folder and that's the base folder for the app.  Next steps are to prep it so that apache can serve it under http://localhost/lawatchworks
0) git clone https://github.com/Yuanja/lawatchworksResponsive lawatchworks

1) Make sure everyone can read it the files: chmod uog+r -R lawatchworks

2) edit /etc/apache2/httpd.conf and fine the line "Include /private/etc/apache2/extra/httpd-vhosts.conf" and ensure it's uncommented.

3) edit /etc/apache2/extra/httpd-vhosts.conf and add the following, assuming ur folder is at: 
"/Users/jyuan/Documents/eku/lawatchworks/upload/"

Add the text under <VirtualHost>:

    Alias /osticket/ /Users/jyuan/Documents/eku/lawatchworks/upload/
    
    <Directory "/Users/jyuan/Documents/eku/lawatchworks/upload/">
    
        Options Indexes
    
        DirectoryIndex index.php
    
        AllowOverride None
    
        Order allow,deny
    
        Allow from all
    
        Require all granted
    
    </Directory>
    
5) restart apache 'sudo apachectl restart'

6) Now logon to your mysql instance: mysql -u root -p 

7) Create a database called osticket: drop database lawatchworks; create database lawatchworks;

8) Make copy of the sample osticket's config file: cd upload/include; cp ost-sample-config.php ost-config.php

9) point the browser to http://localhost/lawatchworks and installation page will show up.  Follow the instructions in the wizard and when it's prompting you for database connection information just ensure the instance is called "lawatchworks" and user name password is root/{whatever ur passwd is}
