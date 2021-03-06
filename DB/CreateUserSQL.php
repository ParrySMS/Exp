<?php
define('PASS_PREFIX','123');
define('GRANT_OPTION',
'DROP,CREATE,ALTER,SELECT,INSERT,UPDATE,DELETE,INDEX,EXECUTE,EVENT,REFERENCES,RELOAD,SHOW VIEW,SHOW DATABASES,LOCK TABLES'
);

/**
 * OPTION LIST: https://dev.mysql.com/doc/refman/5.7/en/grant.html
 */
 
$users = [
	'user1',
	'user2'
];

$sql = '';
$sql .= 'flush privileges;'.PHP_EOL;  
foreach($users as $u){
	$sql .= "CREATE User '$u'@'%' IDENTIFIED BY '".PASS_PREFIX.$u."';".PHP_EOL;
	$sql .=	'GRANT '.GRANT_OPTION." ON *.* TO '$u'@'%';".PHP_EOL;
//  $sql .= "Delete FROM mysql.user Where User = '$u' and Host= '%';".PHP_EOL;
}
$sql .= 'flush privileges;'.PHP_EOL; 
echo $sql;
