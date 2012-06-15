<?php
class View {
    public function __construct() {

    }

    /**
     * @param string $template_file 模板文件
     * @param array $value_array 控制器传到模板中的变量值
     * @param string $layout_file 布局文件
     */
    static public function render($template_file,$value_array,$layout_file) {
        $template_file = TEMPLATE_PATH.$template_file;
        if(!file_exists($template_file)) {
            return;
        }

        $layout_file = TEMPLATE_PATH.'layouts/'.$layout_file;
        if($layout_file and !file_exists($layout_file)) {
            return;
        }

        ob_start();
        extract($value_array);
        include $layout_file;
        return ob_get_clean();
    }
}
?>