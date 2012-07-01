<script type="text/javascript">
$.extend({
	getBlogInfoById:function(id){
		$.ajax({
	        url:'/?action=show&id='+id,
	        type:'get',
	        dataType:'json',
	        success:function(data){
		        console.log(data.content);
	            $("#content_"+id).html(data.content);
	        }  
	    });
	}
});
$(function(){
	$("div[id^='record_']").toggle(
	    function(){
           var arrSplit=$(this).attr('id').split('_');
           var id=arrSplit[1];
           $.getBlogInfoById(id);
           $("#content_"+id).show();
        },
        function(){
        	var arrSplit=$(this).attr('id').split('_');
            var id=arrSplit[1];
            $("#content_"+id).hide();  
        }
    )
});
</script>
			<?php foreach ($arrBlog as $key=>$val):?>
				 <div id="record_<?php echo $val['id'];?>">
				 <h1><?php echo $val['id'].'.  '.$val['title'];?></h1>
				<p class="post-footer">					
<!--					<a href="index.html" class="readmore">Read more</a>-->
<!--					<a href="index.html" class="comments">Comments (7)</a>-->
					<span class="date"><?php echo date('Y-m-d H:i:s',$val['inputtime'])?></span>
					<a href="/?action=edit&id=<?php echo $val['id'];?>">编辑</a>	
				</p>
                 <div id="content_<?php echo $val['id']?>"></div>
				 </div>
			<?php endforeach;?>	
<!--				<h3>Example Form</h3>-->
<!--				<form action="#">			-->
<!--					<p>-->
<!--					<label>Name</label>-->
<!--					<input name="dname" value="Your Name" type="text" size="30" />-->
<!--					<label>Email</label>-->
<!--					<input name="demail" value="Your Email" type="text" size="30" />-->
<!--					<label>Your Comments</label>-->
<!--					<textarea rows="5" cols="5"></textarea>-->
<!--					<br />	-->
<!--					<input class="button" type="submit" />		-->
<!--					</p>					-->
<!--				</form>				-->		

           
		