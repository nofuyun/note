<?php
/**
 * 数据库类
 *
 */
class Sqlite {
    private static $dbh;
    public static $counter=0;
    private $statement;
    public static $all_query;

    /**
     *
     * @param string $dbsetting 选择数据库配置文件里的指定的配置
     * @return object Database实例
     */
    static public function load($dbsetting='common.sqlite') {
        static $obj;
        if(!$obj)
            $obj = new Sqlite($dbsetting);
        return $obj;
    }

    private function __construct($dbsetting) {
        $this->connect($dbsetting);
    }

    /**
     *
     * @param array $dbconfig 数据库连接参数
     * @return object $this
     */
    private function connect($dbsetting) {
        if(self::$dbh)
            return $this;
        $dbconfig = Config::get($dbsetting);
        $dsn = "sqlite:".Db_PATH."testdrive.db";//{$dbconfig['host']}
        $dbh = new PDO($dsn, null, null, array(PDO::ATTR_PERSISTENT =>true));
        self::$dbh = $dbh;
    }

    /**
     * sql查询
     *
     * @param string $sql
     * @param array $prepare_array
     * @return bool $this
     */
    public function query($sql, $prepare_array=array()) {
        return $this->_query($sql, $prepare_array);
    }


    /**
     * 条件查询
     *
     * @param string $table 表名
     * @param string $select select字段
     * @param string $where where 语句
     * @param array $prepare
     * @param string $condition 附加条件, order by , limit 等
     * @return bool on execute result
     */
    public function select($table, $select='*', $where = '', $prepare = array(), $condition='') {
        $where = $where?("WHERE {$where}"):'';
        $sql = " SELECT {$select} FROM {$table} $where {$condition}";
        return $this->_query($sql, $prepare);
    }

    /**
     * 删除数据
     *
     *
     * @param string $table 表名
     * @param string $where where 语句，不能为空，避免删除全表数据，
     * @param array $prepare
     * @return none
     */
    public function delete($table, $where = '', $prepare = array()) {
        if (!$where)
            return false;
        $sql = "DELETE FROM {$table} WHERE {$where}";
        return $this->_query($sql, $prepare);
    }

    /**
     * 插入数据库
     *
     * @param string $table
     * @param array $arr
     * @return bool on execute result
     */
    public function insert($table, $array=array()) {
        $sql = " INSERT INTO {$table} ";
        $fields = array_keys($array);
        $values = array_values($array);
        $condition = array_fill(1, count($fields), '?');
        $sql .= "(`".implode('`,`', $fields)."`) VALUES (".implode(',', $condition).")";
        return $this->_query($sql, $values);
        //return self::$dbh->lastInsertId();
    }
    
    public function insertGetLastID($table, $array=array()) {
        $sql = " INSERT INTO {$table} ";
        $fields = array_keys($array);
        $values = array_values($array);
        $condition = array_fill(1, count($fields), '?');
        $sql .= "(`".implode('`,`', $fields)."`) VALUES (".implode(',', $condition).")";
        $this->_query($sql, $values);
        return self::$dbh->lastInsertId();
    }

    /**
     * 更新操作
     *
     * @param string $table 表名
     * @param array $array 更新的数据，键 值对
     * @param string $condition 条件
     * @return bool false on execute fail or rowcount on success;
     */
    //public function update($table, $array=array(), $condition=null)
    public function update($table, $set = '', $where = '', $prepare = array()) {
        if(!$where)
            return false;
        $sql = " UPDATE {$table} SET {$set} WHERE {$where}";
        return $this->_query($sql, $prepare);
    }

    /**
     * 取得多行记录集
     *
     * @return array 结果集
     */
    public function fetch_all() {
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * 取得单行记录
     *
     * @return array
     */
    public function fetch_row() {
        return $this->statement->fetch(PDO::FETCH_ASSOC);
    }

    public function rowcount() {
        return $this->statement->rowCount();
    }

    /**
     * 查询数据表,所有的数据表的查询操作，最终都到这里处理
     *
     * @param string $sql
     * @param array $prepare
     * @return $this
     */
    private function _query($sql, $prepare=array()) {
        $statement = self::$dbh->prepare($sql);
        if(!$statement->execute($prepare)) {
            log_message($statement->errorInfo());
            log_message($sql);
            return false;
        }
        $this->statement = $statement;
        return true;
    }

    public function beginTransaction() {
        self::$dbh->beginTransaction();
    }

    public function commitTransaction() {
        self::$dbh->commit();
    }

    public function rollBackTransaction() {
        self::$dbh->rollBack();
    }

    static public function profiler() {
        return array(
                'counter'	=> self::$counter
                ,'all_query'	=> self::$all_query
        );
    }
}
?>