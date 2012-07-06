<?php if(!empty($arrBlogInfo)){?>
<div>
<form action="?action=edit&id=<?php echo $arrBlogInfo['id']; ?>" method="post">
标题：<input type="text" name="title" id="title" value="<?php echo $arrBlogInfo['title']; ?>"><br/>
类别：<select name="class_id" id="class_id">
<?php foreach ($arrBlogClass as $val):?>
<option value="<?php echo $val['id']?>" <?php if($val['id']==$arrBlogInfo['class_id'])echo 'selected';?>><?php echo $val['name']?></option>
<?php endforeach;?>
</select><br/>

内容：<textarea name="content" id="content" style="width: 510px;height: 300px;"><?php echo $arrBlogInfo['content']; ?></textarea><br/>
  <link rel="stylesheet" href="/editor/skins/default.css" />
       <script charset="utf-8" src="/editor/kindeditor.js"></script>
       <script>
    	KE.show({
			id : 'content',
		});
       </script>
<input type="submit" value="Submit"/>
</form>
</div>
<?php }else{ ?>
<div>
该条记录不存在！
</div>
<?php }?>