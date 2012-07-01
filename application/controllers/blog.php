<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Blog_Controller extends Controller {
	public $model = null;
	public $data=array();
	public function __construct() {
		parent::__construct ();
		$this->model = new Blog_Model ();
		$this->data['arrBlogClass']= $this->model->showClassAll ();
	}
	public function indexAction() {
		$arrBlog = $this->model->showAll ();
		$this->data['arrBlog']=$arrBlog;
		echo $this->load_view('blog/index',$this->data);
	}
	public function createAction() {
		if (! empty ( $_POST ) && $post = $this->checkForm ( array ('title', 'content', 'class_id' ), $_POST )) {
			$post ['inputtime'] = time ();
			if ($this->model->create ( $post )) {
				echo 'seccess';
				exit ();
			} else {
				echo 'fail';
			}
		
		}
		echo $this->load_view('blog/create',$thisw->data);
	}
	public function editAction() {
		$id=!empty($_GET['id'])?$_GET['id']:0;
		
		$this->data['arrBlogInfo']=$this->model->show($id);
		$this->data['id']=$id;
		if (! empty ( $_POST ) && $post = $this->checkForm ( array ('title', 'content', 'class_id' ), $_POST )) {
			$post ['inputtime'] = time ();
			$post['id']=$id;
			var_dump($post);
			if(empty($this->data['arrBlogInfo'])){
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
		echo $this->load_view('blog/edit',$this->data);
	}
	public function deleteAction() {
	    if(empty($_GET['id']))
	        return;
	    if(!$this->model->delete($_GET['id']))
	        return;
	    echo 'sucess';    
	}
	public function showAction(){
		if(empty($_GET['id'])){
			return;
		}
		$id=$_GET['id'];
		$data=$this->model->show($id);
		echo json_encode($data);exit;
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
