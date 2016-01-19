<?php

$config = <<< END

rm -f /etc/nginx/sites-enabled/docs.nginx.conf
rm -f /etc/php-fpm.d/docs.php-fpm.conf
rm -f /etc/php-fpm.d/docs.php.fpm.ini

ln -sfn ${'docs_root_directory'}/autogen/nginx.conf /etc/nginx/sites-enabled/${'app_name'}.nginx.conf
ln -sfn ${'docs_root_directory'}/autogen/php-fpm.conf /etc/php-fpm.d/${'app_name'}.php-fpm.conf
ln -sfn ${'docs_root_directory'}/autogen/php.fpm.ini /etc/php-fpm.d/${'app_name'}.php.fpm.ini

END;

return $config;
