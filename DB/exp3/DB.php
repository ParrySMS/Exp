<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-11-23
 * Time: 9:23
 */

class DB
{

    private $dbms = DATABASE_TYPE;     //数据库类型
    private $host = SERVER; //数据库主机名
    private $dbName = DATABASE_NAME;    //使用的数据库
    private $user = USERNAME;      //数据库连接用户名
    private $pass = PASSWORD;          //对应的密码
    private $dsn;

    /**
     * Pdo constructor.
     */
    public function __construct()
    {
        $this->dsn = "$this->dbms:host=$this->host;dbname=$this->dbName";
        $this->connect();

    }

    public function connect()
    {


        try {
            $dbh = new PDO($this->dsn, $this->user, $this->pass); //初始化一个PDO对象
//            echo "连接成功<br/>";
            /*你还可以进行一次搜索操作
            foreach ($dbh->query('SELECT * from FOO') as $row) {
                print_r($row); //你可以用 echo($GLOBAL); 来看到这些值
            }
            */
//            $dbh = null;
        } catch (PDOException $e) {
            die ("Error!: " . $e->getMessage() . "<br/>");
        }
//默认这个不是长连接，如果需要数据库长连接，需要最后加一个参数：array(PDO::ATTR_PERSISTENT => true) 变成这样：
//        $db = new PDO($dsn, $user, $pass, array(PDO::ATTR_PERSISTENT => true));

    }
}