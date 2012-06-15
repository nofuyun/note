<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Blog_Model extends Model {

    public $dbconnect = null;

    public function __construct() {
        $this->dbconnect = Sqlite::load();
    }

    public function create($post) {
        $table = 'blog';
        $return_id = $this->dbconnect->insertGetLastID($table, $post);
        return $return_id;
    }

    public function edit($post) {
        $table = 'blog';
        $set = "title=:title,class_id=:class_id,content=:content";
        $where = "`id`=:id";
        $flag = $this->dbconnect->update($table, $set, $where, $post);
        return $flag;
    }

    public function delete($id) {
        $table = 'blog';
        $where = "`id`=:id";
        $flag = $this->dbconnect->delete($table, $where, array('id' => $id));
        return $flag;
    }

    public function showAll() {
        $sql = "select b.id,b.title,b.inputtime,b.class_id,c.name from blog b,blog_class c where b.class_id=c.id order by inputtime desc";
        $this->dbconnect->query($sql);
        return $this->dbconnect->fetch_all();
    }

    public function show($id) {
        $sql = "select b.id,b.title,b.inputtime,b.content,b.class_id,c.name from blog b,blog_class c where b.class_id=c.id and b.id=:id";
        $this->dbconnect->query($sql, array('id' => $id));
        return $this->dbconnect->fetch_all();
    }

    public function createClass() {
        $table = 'blog_class';
        $return_id = $this->dbconnect->insertGetLastID($table, $post);
        return $return_id;
    }

    public function editClass() {
        $table = 'blog_class';
        $set = "`name`=:name";
        $where = "`id`=:id";
        $flag = $this->dbconnect->update($table, $set, $where, $post);
        return $flag;
    }

    public function deleteClass() {
        $table = 'blog_class';
        $where = "`id`=:id";
        $flag = $this->dbconnect->delete($table, $where, array('id' => $id));
        return $flag;
    }

    public function showClassAll() {
        $sql = "select * from blog_class";
        $this->dbconnect->query($sql);
        return $this->dbconnect->fetch_all();
    }

}

?>
