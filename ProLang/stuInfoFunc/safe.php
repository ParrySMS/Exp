<?php

// 修改自 http://www.jb51.net/article/30079.htm



// 字符串过滤函数+去空格
     function strtrim_check($str)
    {

        $str = trim($str);
        $str = strip_tags($str);
        $str = $this->search_check($this->str_check($str));
        $str = preg_replace("/\r\n/", " ", $str);
        $str = str_replace("<", " ", $str);
        $str = str_replace(">", " ", $str);
        return $str;
    }

// 整型过滤函数
     function int_check($num)
    {

        if (is_null($num)) {// 判断是否为空
            throw new Exception("illegal numeric exception, null ", 400);
//            return null;
        } elseif (inject_check($num)) {
            //return null;
            throw new Exception("illegal numeric exception, $num ", 400);
        } elseif (!is_numeric($num)) {
            throw new Exception("illegal numeric exception, $num ", 400);
        }
        $num = intval($num);
        return $num;
    }

//数字过滤函数
     function num_check($num)
    {

        if (is_null($num)) {     // 判断是否为空
            return null;
        } elseif ( inject_check($num)) {
            return null;
        } elseif (!is_numeric($num)) {
            throw new Exception("illegal numeric exception, $num", 400);
        }
        return $num;
    }

// 数组过滤函数
     function sec(&$array)
    {

        //如果是数组，遍历数组，递归调用
        if (is_array($array)) {
            foreach ($array as $k => $v) {
                $array [$k] =  sec($v);
            }
        } else if (is_string($array)) {
            //使用addslashes函数来处理
            $array = addslashes($array);
        } else if (is_numeric($array)) {
            $array = intval($array);
        }
        return $array;
    }

    //检查是否为手机号
     function phone_check($phone)
    {

        if (preg_match("/^1[34578]\d{9}$/", $phone)) {
            return $phone;
        } else {
//            return -1;
            throw new Exception("PARAM_ERROR: invalid phone number,$phone", 400);
        }
    }

    //检查密码 数字字母+长度限制
     function password_check($pw)
    {

        if (!preg_match('/^[0-9a-zA-Z]{' . PW_MIN . ',' . PW_MAX . '}$/i', $pw)) {
            throw new Exception("PARAM_ERROR: password not allowed", 400);
        }
        return $pw;
    }

// 字符过滤函数
     function str_check($str)
    {

        if ( inject_check($str)) {
            throw new Exception("illegal argument exception, $str", 400);
            // die ('Illegal Argument Exception');
        }
        //注入判断
        $str = htmlspecialchars($str);
        //转换html
        return $str;
    }

// 替换字符的过滤函数
     function search_check($str)
    {

        //$str = str_replace("_", "\_", $str);
        //把"_"过滤掉
        $str = str_replace("%", "\%", $str);
        //把"%"过滤掉
        $str = htmlspecialchars($str);
        //转换html
        return $str;
    }

// 长度检查
      function len_check($str, $min, $max)
    {

        if (isset ($min) && mb_strlen($str) < $min) {
            throw new Exception("STRLEN_ERROR: min $min byte, $str", 400);
            //die ("min: $min byte");
        } else if (isset ($max) && mb_strlen($str) > $max) {
            throw new Exception("STRLEN_ERROR: max $max byte, $str", 400);
            //die ("max: $max byte");
        }
        return  stripslashes_array($str);
    }

// 防注入函数
      function inject_check($sql_str)
    {
//        return preg_match('/select|insert|update|delete|\'|\/\*|\*|\.\.\/|\.\/|UNION|into|load_file|outfile/', $sql_str);
        return preg_match('/select|insert|update|delete|\'|\/\*|\.\.\/|\.\/|UNION|into|load_file|outfile/', $sql_str);
        // 进行过滤，防注入
    }

    /** 删除反斜杠
     * @param $array
     * @return array|string
     */
     function stripslashes_array(&$array)
    {
        if (is_array($array)) {
            foreach ($array as $k => $v) {
                $array [$k] =  stripslashes_array($v);
            }
        } else if (is_string($array)) {
            $array = stripslashes($array);
        }
        return $array;
    }



?>