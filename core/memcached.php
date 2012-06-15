<?php
/**
 * memcached
 *
 */
class Memcached {
    private static $connectionarray = array();

    private static function getconnect($mcsetting) {
        if(!array_key_exists($mcsetting,self::$connectionarray)) {
            $mcservers = Config::get($mcsetting);
            $memcache = new Memcache();
            foreach($mcservers as $mcserver){
//                if (!$memcache->connect($mcserver['host'],$mcserver['port']))
//                {
//                }
                $memcache->addServer($mcserver['host'], $mcserver['port'],FALSE);
            }
            self::$connectionarray[$mcsetting] = $memcache;
        }
        return self::$connectionarray[$mcsetting];
    }

    public static function close($mcsetting = 'local.memcache') {
        $obj = self::getconnect($mcsetting);
        if($obj) {
            $obj->close();
        }
    }

    /**
     * memcache
     *
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public static function set($key, $value, $expire = 0, $mcsetting = 'common.memcache') {
            $obj = self::getconnect($mcsetting);
            if($obj and is_string($key)) {
				if($value!=null)
                {
                    $value=serialize($value);
                }
                $result = $obj->replace($key, $value, false, $expire);
                if(!$result) {
                    $result = $obj->set($key, $value, false, $expire);
                }
                return $result;
            }

    }

    /**
     * memcache
     *
     * @param string $key
     * @return mixed
     */
    public static function get($key, $mcsetting = 'common.memcache') {
            $obj = self::getconnect($mcsetting);           
            if($obj and is_string($key)) {
                $result = $obj->get($key);
				$result=unserialize($result);
                return $result;
            }
    }

    /**
     * memcache
     *
     * @param string $key
     * @return bool
     */
    public static function delete($key, $mcsetting = 'common.memcache') {
        $obj = self::getconnect($mcsetting);
        if($obj and $key) {
            $result=$obj->delete($key);
            return $result;
        }
    }

    /**
     * memcache increment a value
     * if key not exist, set the value
     *
     * @param string $key
     * @return bool
     */
    public static function increment($key, $start, $expire, $mcsetting = 'common.memcache') {
        $obj = self::getconnect($mcsetting);
        if($obj and is_string($key)) {
            $result = $obj->increment($key);
            if ( $result === false ) {
                $result = $obj->set($key, $start, false, $expire);
            }
            return $result;
        }
    }

    /**
     * memcache decrement a value
     * if key not exist, set the value
     *
     * @param string $key
     * @return bool
     */
    public static function decrement($key, $start, $expire, $mcsetting = 'common.memcache') {
        $obj = self::getconnect($mcsetting);
        if($obj and is_string($key)) {
            $result = $obj->decrement($key);
            if ( $result === false ) {
                $result = $obj->set($key, $start, false, $expire);
            }
            return $result;
        }
    }

    /**
     * Acquire a semaphore
     *
     * @param string $key
     * @return bool
     */
    public static function lock($key, $expire = 30, $mcsetting = 'common.memcache') {
        $obj = self::getconnect($mcsetting);
        return $obj->add($key,0,false,$expire);
    }

    /**
     * Release a semaphore
     *
     * @param string $key
     * @return bool
     */
    public static function unlock($key, $mcsetting = 'common.memcache') {
        $obj = self::getconnect($mcsetting);
        return $obj->delete($key);
    }

    public static function getStats($mcsetting = 'common.memcache') {
        $obj = self::getconnect($mcsetting);
        return $obj->getStats();
    }

    
}
?>