<?php
/**
 * Created by PhpStorm.
 * User: L
 * -- NEED PHP 7 --
 */


define('REPOSITORIES_LOCAL_PATH', 'D:/Dev');

/**
 *   It is a default config that the local branch is set-upstream-to origin with same name.
 * eg.
 *   master    --> remotes/origin/master
 *   develop_A --> remotes/origin/develop_A
 *
 *   Branch 'A' set up to track remote branch 'A' from 'origin'.
 *   So this bat is able to pull by branch name
 *
 *   The definition of REPOSITORIES_WITH_LOCAL_BRANCH and REPOSITORIES_WITH_ORIGIN_BRANCH is important.
 *   It means that you want to keep your REPOSITORIES_WITH_LOCAL_BRANCH following the REPOSITORIES_WITH_ORIGIN_BRANCH.
 *
 * eg.
 *   [ develop_A --> remotes/origin/develop_A ] ===> keep being up to date with [remotes/origin/develop-QA]
 *
 *   So the definition should be:
 *
 *   define('REPOSITORIES_WITH_LOCAL_BRANCH',  ['repos_name' => 'develop_A'];
 *   define('REPOSITORIES_WITH_ORIGIN_BRANCH', ['repos_name' => 'develop-QA'];
 *
 */

define('REPOSITORIES_WITH_LOCAL_BRANCH', [
    'economic' => 'master',
    'Exp' => 'master',
    'CodewarKata'=> 'master',
    'DesignPatterns'=> 'master',
    'MysqlNotes'=> 'master',
    'web-'=> 'master',
    'CSharpDemo'=> 'master',
    'JavaDemo'=> 'master',
]);

define('REPOSITORIES_WITH_ORIGIN_BRANCH', [
    'economic' => 'master',
    'Exp' => 'master',
    'CodewarKata'=> 'master',
    'DesignPatterns'=> 'master',
    'MysqlNotes'=> 'master',
    'web-'=> 'master',
    'CSharpDemo'=> 'master',
    'JavaDemo'=> 'master',
]);

define('BAT_FILE_NAME','updateRepos.bat');

$bat_file = fopen('./' . BAT_FILE_NAME, 'w');
$cmd = '';

$disk_char = strtolower(dirname(__FILE__)[0]);
if($disk_char != strtolower(REPOSITORIES_LOCAL_PATH[0])){
    $cmd .= REPOSITORIES_LOCAL_PATH[0] .':'.PHP_EOL;
}
$cmd .= 'cd '.REPOSITORIES_LOCAL_PATH.PHP_EOL;

foreach (REPOSITORIES_WITH_LOCAL_BRANCH as $repos => $local_branch){
    $cmd .= "cd ./$repos".PHP_EOL;
    $cmd .= 'git fetch'.PHP_EOL;

    if($local_branch == REPOSITORIES_WITH_ORIGIN_BRANCH[$repos]){
        $cmd .= 'git pull'.PHP_EOL;
    }else{
        $cmd .= 'git checkout '.$local_branch.PHP_EOL;
        $cmd .= 'git merge origin/'.REPOSITORIES_WITH_ORIGIN_BRANCH[$repos].PHP_EOL;
        $cmd .= 'git push'.PHP_EOL;
    }

    $cmd .= 'cd ../'.PHP_EOL;
}

$cmd .= 'pause';

fwrite($bat_file, $cmd);
fclose($bat_file);
echo 'bat_file: '.BAT_FILE_NAME.' have been created!';
