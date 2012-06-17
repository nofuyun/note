<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Blog_Controller extends Controller {
	public $model = null;
	public function __construct() {
		parent::__construct ();
		$this->model = new Blog_Model ();
	}
	public function indexAction() {
		$arrBlogClass = $this->model->showClassAll ();
		$arrBlog = $this->model->showAll ();
		$data['arrBlogClass']=$arrBlogClass;
		$data['arrBlog']=$arrBlog;
		echo $this->load_view('blog/index',$data);
	}
	public function createAction() {
		 $data['arrBlogClass']= $this->model->showClassAll ();
		if (! empty ( $_POST ) && $post = $this->checkForm ( array ('title', 'content', 'class_id' ), $_POST )) {
			$post ['inputtime'] = time ();
			if ($this->model->create ( $post )) {
				echo 'seccess';
				exit ();
			} else {
				echo 'fail';
			}
		
		}
		echo $this->load_view('blog/create',$data);
	}
	public function editAction() {
		$id=!empty($_GET['id'])?$_GET['id']:0;
		$data['arrBlogClass']= $this->model->showClassAll ();
		$data['arrBlogInfo']=$this->model->show($id);
		$data['id']=$id;
		if (! empty ( $_POST ) && $post = $this->checkForm ( array ('title', 'content', 'class_id' ), $_POST )) {
			$post ['inputtime'] = time ();
			$post['id']=$id;
			var_dump($post);
			if(empty($data['arrBlogInfo'])){
				echo 'fail1';
				exit;
			}
			if (!$this->model->edit ( $post )) {
				echo 'fail2';
				exit ;
			}  
			echo 'success';
			exit;
		}
		echo $this->load_view('blog/edit',$data);
	}
	public function deleteAction() {
	    if(empty($_GET['id']))
	        return;
	    if(!$this->model->delete($_GET['id']))
	        return;
	    echo 'sucess';    
	}
	
	public function createClassAction() {
		if(!empty($_POST)&&$post=$this->checkForm(array('name'),$_POST)){
	        if($this->model->createClass($post)){
	        	echo 'success';
	            exit;
	           }else{
	        	echo 'fail';
	        	exit;
	        }
		}
		echo 'show';
		
	}

}
?>
