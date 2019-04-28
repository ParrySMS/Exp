<?php
/**
 * Created by PhpStorm.
 * User: L
 * Date: 2018-8-20
 * Time: 10:41
 */




class Action extends BaseDao
{

    protected $table;

    public function __construct()
    {
        parent::__construct();
//        $this->table = DB_PREFIX.'_action';
        $this->table = $this::$T_ACTION;
    }

    /**插入记录 并且返回id
     * @param $uid
     * @param $ip
     * @param $agent
     * @param $uri
     * @param $method
     * @param $error_code
     * @param null $content
     * @param null $time
     * @return int|mixed|string
     */
    public function insert($uid,$ip,$agent,$uri,$method,$error_code,$content = null,$time = null)
    {
        //秒级时间
        if ($time === null) {
            $time = date(DB_TIME_FORMAT);
        }

        $pdo = $this->database->insert($this->table,[
            'uid'=>$uid,
            'agent'=>$agent,
            'ip'=>$ip,
            'uri'=>$uri,
            'method'=>$method,
            'error_code'=>$error_code,
            'content'=>$content,
            'time'=>$time,
            'visible'=>VISIBLE_NORMAL
        ]);
        $id = $this->database->id();
        //因为可能是在catch块里的记录 所以不适用throw报错
        if (!is_numeric($id) || $id < 1) {
//          var_dump($this->database->error());
            echo '<br/>'.__CLASS__ . '->' . __FUNCTION__ . '(): error';
//            throw new Exception(__CLASS__ . '->' . __FUNCTION__ . '(): error', 500);
        }
        return $id;
    }


    /** 判断是否超过请求次数
     * @param $uid
     * @param $uri
     * @param string $method
     * @return bool|int|mixed
     * @throws Exception
     */
    public function countLog($uid,$uri,$method = 'GET'){
        $times = $this->getDatabase()->count($this->table,[
            'uid'=>$uid,
            'uri' => $uri,
            'method'=>$method,
            'error_code' => null,
            'time[<>]'=>[//between
                date('Y-m-d',time()), //today
                date(DB_TIME_FORMAT)
            ],
            'visible'=>VISIBLE_NORMAL
        ]);

        if(!is_numeric($times)){
            throw new Exception(__CLASS__ . '->' . __FUNCTION__ . '(): error', 500);
        }
        return $times;
    }

}