<?php
$uri_path = trim($_SERVER['REQUEST_URI'], '/');
$uri_parts = explode('/', $uri_path);
$current_user = user_username($uid);
?>
<div id="publisher-sub">

	<ul id="publisher-subMenu" class="floatright">
		<li><a href="/<?php echo user_username($uid);?>" <?php if($uri_parts['0'] == $current_user) { echo 'class="active"';} ?>>Profile</a></li>
		<li><a href="/blogs/<?php echo $uid;?>" <?php if($uri_parts['0'] == 'blog' || $uri_parts['0'] == 'blogs' || $uri_parts['0'] == 'archive' || $node->type=='blog') { echo 'class="active"';} ?>>Blog</a></li>
		<li><a href="/publications/&amp;uid=<?php echo $uid;?>" <?php if($uri_parts['0'] == 'publications' || $node->type == 'release' || $node->type == 'book_published') { echo 'class="active"';} ?>>Publications</a></li>
		<li><a href="/publisher-review/&amp;uid=<?php echo $uid;?>" <?php if($uri_parts['0'] == 'publisher-review') { echo 'class="active"';} ?>>We Review</a></li>
	</ul>	
    <div class="clear"></div>
		<div id="publisher-id">
			<?php if(user_img($uid)):?>
			<img src="/<?php echo user_img($uid);?>" id="pub_image"/>
			<?php endif;?>
			<?php $banner = publisher_banner_file($uid);?>
		    <?php if($banner):?>
				<div id="pub_banner">
		    	<img src="/<?php echo $banner;?>"/>
		        </div>
		    <?php endif;?>
		 <div class="clear"></div>
		</div>	

</div><!-- /Publisher Sub -->