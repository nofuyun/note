<div>
<form action="?action=create" method="post">
标题：<input type="text" name="title" id="title" value=""><br/>
类别：<select name="class_id" id="class_id">
<?php foreach ($arrBlogClass as $val):?>
<option value="<?php echo $val['id']?>"><?php echo $val['name']?></option>
<?php endforeach;?>
</select><br/>

内容：<textarea name="content" id="content" style="width: 510px;height: 300px;"></textarea><br/>
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