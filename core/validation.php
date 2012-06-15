<?php 
/**
 * 通用字符串验证类
 */
class Validation
{
    /**
     * 一次性验证多个规则
     *
     * @param <string> $str 待验证的字符串
     * @param <string> $patterns 多个规则组合
     * 
     * @uses  多个规则用 | 隔开，参数用($arg1, ...)不用传第一个$str参数,每个单独规则的第一个参数都是一样的 ，
     * 例如: alpha|max_length(10) 最大长度为10的字母
     *
     * @return <bool>
     */
    static public function validate($str, $patterns)
    {
        $pattern_segments = explode('|', $patterns);
        if(!$pattern_segments) return false;
        
        foreach ($pattern_segments as $pattern)
        {
            $methods = explode('(', $pattern);
            $method = $methods[0];
            $args = array();
            //规则有参数
            if( $methods[1] )
            {
                $args = str_replace(')', '', $methods[1]);
                $args = explode(',', $args);
            }
            //验证规则
            if( !call_user_func_array(array(self, $method), array_merge(array($str),$args)) )
            {
                return false;
            }
        }

        return true;
    }

    
    //------------------下面为单个验证规则，每个都可以单独使用-------------

    
	/**
	 * 至少有一个任意字符
     * @param <string> $str
     * @return <bool>
     */
	static public function required($str)
	{
        return (bool)strlen(trim($str));
	}
    
	/**
     * 字符最小长度
     * 
     * @param <string> $str
     * @param <int> $length
     * @return <bool>
     */
	static public function min_length($str, $length)
	{
        if(!preg_match("/^\d+$/i", $length)) return false;
        
		return (bool)(strlen($str) >= $length);
	}
	
	/**
	 * 字符最大长度
     *
     * @param <string> $str
     * @param <int> $length
     * @return <bool>
     */
	static public function max_length($str, $length)
	{
        if(!preg_match("/^\d+$/i", $length)) return false;
       
		return (bool)(strlen($str) <= $length);
	}

	/**
     * 字符串长度等于某值
     * @param <type> $str
     * @param <type> $val
     * @return <type>
     */
	static public function exact_length($str, $length)
	{
        if(!preg_match("/^\d+$/i", $length)) return false;
        
		return (bool)(strlen($str) == $length);
	}
	
	/**
	 * 验证是否为 email
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */	
	static public function email($str)
	{
		return (bool)preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str);
	}

	/**
	 * 验证是否是 IP 地址
	 *
	 * @param	string $ip
	 * @return	bool
	 */
	static public function ip($ip)
	{
		$ip_segments = explode('.', $ip);

		// Always 4 segments needed
		if (count($ip_segments) != 4)
		{
			return FALSE;
		}
		// IP can not start with 0
		if ($ip_segments[0][0] == '0')
		{
			return FALSE;
		}
		// Check each segment
		foreach ($ip_segments as $segment)
		{
			if ($segment == '' || preg_match("/[^0-9]/", $segment) || $segment > 255 || strlen($segment) > 3)
			{
				return FALSE;
			}
		}

		return TRUE;
	}
    
	/**
	 * 字符串为字母
     *
     * @param <string> $str
     * @return <bool>
     */
	static public function alpha($str)
	{
		return (bool)preg_match("/^([a-z])+$/i", $str);
	}
	
	/**
	 *  字符串为字母或数字
     *
     * @param <string> $str
     * @return <bool>
     */
	static public function alpha_numeric($str)
	{
		return (bool)preg_match("/^[a-z0-9]+$/i", $str);
	}

    /**
     * 字符串为字母数字和下划线横线

     */
    static public function alpha_dash($str)
	{
		return (bool)preg_match("/^[a-z0-9_-]+$/i", $str);
	}

	/**
	 * 字符串为带符号的数值, 整数或浮点数
	 * @param	string
	 */	
	static public function signedNumeric($str)
	{
		return (bool)preg_match( "/^[\-\+][0-9]+\.?[0-9]+$/", $str);
	}

    /** 字符串为无符号的数值, 整数或浮点数
     *
     * @param <type> $str 
     */
    static public function unsignedNumeric($str)
    {
        return (bool)preg_match( "/^[0-9]+\.?[0-9]+$/", $str);
    }

	/**
	 * 字符串为无符号整数
     *
     * @param <string> $str
     * @return <bool>
     */
	static public function unsignedInteger($str)
	{
		return (bool)preg_match( "/^[0-9]+$/", $str);
	}

    /**
     * 字符串为带符号的整数
     * @param <type> $str
     */
    static public function signedInteger($str)
    {
        return (bool)preg_match( "/^[\-\+][0-9]+$/", $str);
    }

    /**
     * 字符串为带符号的浮点数
     * @param <type> $str
     */
    static public function signedFloat($str)
    {
        return (bool)preg_match( "/^[\-\+][0-9]+\.[0-9]+$/", $str);
    }

    /**
     * 字符串为无符号的浮字符串为无符号的点数
     * @param <type> $str
     */
    static public function unsignedFloat($str)
    {
        return (bool)preg_match( "/^[0-9]+\.[0-9]+$/", $str);
    }

    /**
     * 字符串为 url 地址
     *
     * @param <string> $str
     */
    static public function url($str)
    {
        return (bool)preg_match("/^(http|https|ftp|file):[\/]+([\w\d]+\.?)+\/?.*$/i", $str) ;
    }
} 