<?php
/**
 * 控制器基类
 * 
 * @author Zhong Qin
 *
 */
class Controller
{
	//request的控制器名称
	//public $controller_name = '';
	
	//request的控制器方法
	//public $method_name		= '';
	
	//request的get参数数组
	//public $uri_hash  		= array();	
	//public $uri_array 		= array();
	 
	public function __construct()
	{
		//$this->controller_name = Registry::get('controller_name');
		//$this->method_name = Registry::get('method_name');
		//$this->uri_hash = Registry::get('uri_hash');
		//$this->uri_array = Registry::get('uri_array');
	}
	
	/**
	 * 加载视图模板
	 * 
	 * @param string $template_file 模板文件
	 * @param array $value_array 传到视图的数据
	 * @param string $layout 是否使用层，及层的名字
	 * @param bool $output 是否输出，不输出则返回模板解析后的 html
	 */
	public function load_view($template_file, $value_array=array(), $layout='default', $output=true)
	{
		$view = new View();
                $value_array['imgServer'] = IMGSERVER;
                $value_array['version'] = VERSION;
		
		//解析模板
		return $view->render($template_file, $value_array, $layout, $output);
	}
}
?>