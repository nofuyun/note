<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>

<title>SimpleBlog</title>

<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
<meta name="author" content="Erwin Aligam - styleshout.com" />
<meta name="description" content="Site Description Here" />
<meta name="keywords" content="keywords, here" />
<meta name="robots" content="index, follow, noarchive" />
<meta name="googlebot" content="noarchive" />
<script type="text/javascript" src="<?php echo APP_URL?>js/jquery-1.7.1.min.js"></script>
<link href="<?php echo APP_URL?>css/public.css" rel="stylesheet" type="text/css" />

</head>

<body>
<!-- Wrap -->
<div id="wrap">
		
		<!-- Header -->
		<div id="header">
					
			<h1 id="logo">Simple<span class="gray">Blog</span></h1>
			<h2 id="slogan">Put your site slogan here...</h2>			
		
			<div id="searchform">	
				<form method="post" class="search" action="#" >
					<p><input name="search_query" class="textbox" type="text" />
  					<input name="search" class="button" type="submit" value="search" /></p>
				</form>
			</div>
			
		</div>
		
		<!-- menu -->
		<div id="menu">
			<ul>
				<li <?php if($nowMenu=='blog'){ echo 'id="current"';}?>><a href="/"><span>技术博客</span></a></li>
			</ul>
		</div>
				<!--Content Wrap -->
		<div id="content-wrap">
		<div id="main"><?php include_once $template_file;?></div>
		 <div id="sidebar">

					<?php if($nowMenu=='blog'):?>
					<h1>技术分类</h1>
					<ul class="sidemenu">
						<?php foreach ($arrBlogClass as $key=>$value):?>
						<li><a href=""><?php echo $value['name'];?></a></li>
						<?php endforeach;?>
					</ul>
					
					<?php endif;?>

<!--					<h1>Sponsors</h1>-->
<!--                    <ul class="sidemenu">-->
<!--                        <li><a href="#" title="Website Templates">DreamTemplate</a></li>-->
<!--                        <li><a href="#" title="WordPress Themes">ThemeLayouts</a></li>-->
<!--                        <li><a href="#" title="Website Hosting">ImHosted.com</a></li>-->
<!--                        <li><a href="#" title="Stock Photos">DreamStock</a></li>-->
<!--                        <li><a href="#" title="Website Builder">Evrsoft</a></li>-->
<!--                        <li><a href="#" title="Web Hosting">Web Hosting</a></li>-->
<!--                    </ul>-->
<!--					<h1>Wise Words</h1>-->
<!--					<p>&quot;Be not afraid of life. Believe that life is worth living,-->
<!--					and your belief will help create the fact.&quot; </p>-->
<!---->
<!--					<p class="align-right">- William James</p>-->
<!---->
<!--					<h1>Support Styleshout</h1>-->
<!--					<p>If you are interested in supporting my work and would like to contribute, you are-->
<!--					welcome to make a small donation through the-->
<!--					<a href="http://www.cssmoban.com/">donate link</a> on my website - it will-->
<!--					be a great help and will surely be appreciated.</p>-->

			</div>
		
		<!--End content-wrap-->
		</div>
		<!-- Footer -->
		<div id="footer">
		
			<p>   			
			&copy; 2010 Your Company &nbsp;&nbsp;
			<a href="#" title="Website Templates">website templates</a> from <a href="#">网站模板</a>

			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			
			<a href="index.html">Home</a> |
   		    <a href="index.html">Sitemap</a> |
   		    <a href="index.html">RSS Feed</a> |
            <a href="http://validator.w3.org/check/referer">XHTML</a> |
			<a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a>
			</p>
			
		</div>	
			
<!-- END Wrap -->
</div>

</body>
</html>

		