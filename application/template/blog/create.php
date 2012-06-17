<div>
<form action="?action=create" method="post">
标题：<input type="text" name="title" id="title" value=""><br/>
类别：<select name="class_id" id="class_id">
<?php foreach ($arrBlogClass as $val):?>
<option value="<?php echo $val['id']?>"><?php echo $val['name']?></option>
<?php endforeach;?>
</select><br/>

内容：<textarea rows="5" cols="10" name="content" id="content"></textarea><br/>
<input type="submit" value="Submit"/>
</form>
</div>