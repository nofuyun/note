<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Blog_Controller extends Controller{
        public $model=null;
        public function __construct(){
            parent::__construct();
            $this->model=new Blog_Model();
                }
        public  function indexAction(){
//                  $post=array('class_id'=>$_POST['class_id'],'content'=>$_POST['content'],'inputtime'=>time());
//                  var_dump($this->model->create($post));exit;
//                 echo "<pre>";
//                   var_dump($this->model->showAll());
//                 echo $this->model->delete(80);
                   $arrBlogClass=$this->model->showClassAll();
                   $arrBlog=$this->model->showAll();
        }
        public function createAction(){
             if($_POST){
                     
             }
        }
        public function editAction(){}
        public function deleteAction(){}
        
        public function createClassAction(){}
        
        
}
?>
