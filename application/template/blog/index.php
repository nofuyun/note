<div id="container">
  <div id="header"><h1>技术日志</h1></div>
  <div id="menu">This is the Menu</div>
  <div id="mainContent">
    <div id="sidebar">
    <ul>       
<?php foreach ($arrBlogClass as $key=>$val): ?>
<li>
<a href="<?php echo ''?>"><?php echo $val['name'];?></a>
</li>
<?php endforeach;?>
        </ul> 
    </div>
    <div id="content">
    <?php foreach ($arrBlog as $key=>$val):?>
<?php $i=$key+1;?>
<dl>
<dd  id="<?php echo $val['id'];?>"><span class="left"><?php echo $i.'.  '.$val['title'];?></span><span 

class="right"><?php echo date('Y-m-d H:i:s',$val['inputtime'])?></span>
<a>编辑</a>
</dd>
<dt  id="<?php echo $val['id'];?>"></dt>
</dl>
<?php endforeach;?>
    </div>
  </div>
</div>