<?php
// $Id: page.tpl.php,v 1.0 11/06/2008 Jay Boodhun Exp $
$uid = $node->uid;
$twitter = twitter_username($uid);
if(!$uid) { $uid = $uri_parts['1'];}
$picture = user_picture($uid);
$username = user_username($uid);
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php print $language->language; ?>" xml:lang="<?php print $language->language; ?>">

<head>
	<?php if($head_title == 'Create Word | Bookbloc') { $head_title = 'Upload Word | Bookbloc';}?>
	<title><?php print $head_title; ?></title>
	<?php print $head; ?>
	<?php print $styles; ?>
	<link rel="stylesheet" href="<?php print $base_path . $directory; ?>/styles/profile.css" type="text/css">
	<link rel="stylesheet" href="<?php print $base_path . $directory; ?>/styles/comments.css" type="text/css">
	<link rel="stylesheet" href="<?php print $base_path . $directory; ?>/styles/publisher.css" type="text/css">
	<link rel="stylesheet" href="<?php print $base_path . $directory; ?>/styles/newpublisher.css" type="text/css">
	<!--[if IE 7]>
	<link rel="stylesheet" href="<?php print $base_path . $directory; ?>/styles/ie7-fixes.css" type="text/css">
	<![endif]-->
	<!--[if lte IE 6]>
	<link rel="stylesheet" href="<?php print $base_path . $directory; ?>/styles/ie6-fixes.css" type="text/css">
	<![endif]-->
	<?php require_once drupal_get_path('theme', 'bookbloc') .'/includes/style.php';?>
	<?php print $scripts; ?>
</head>

<body class="<?php print $body_classes; ?> <?php echo $uri_parts['0'];?> publisher blog_view">
	
	<div id="page" class="clearfix">
		
		<a name="top"></a>

		<div id="header">

			<div id="header-wrapper" class="clearfix">

				<?php require_once drupal_get_path('theme', 'bookbloc') .'/includes/login.php';?>

				<?php if ($logo): ?> 
					<div id="logo">
						<a href="<?php print $base_path ?>" title="<?php print t('Home') ?>">
							<img src="<?php print $logo ?>" alt="<?php print t('Home') ?>" />
						</a>
					</div>
				<?php endif; ?>

				<?php if($header):?>
					<?php print $header;?>
				<?php endif;?>

			</div><!-- /header-wrapper -->

		</div><!-- /header -->
		
		<!-- New Publisher reviews page September 2010 -->
		
		<div id="pubWrapper">

			<div id="pubRightSide">
				<div class="pubBox">
					<h2>Recent Publications</h2>
					<?php if(books_published_list($uid)) {
						echo books_published_list($uid);
						print '<a class="viewAll" href="/publications/&amp;uid='.$uid.'">View all publications</a>';
					} else {
						print '<p class="empty">Nothing published yet</p>';
					} ?>
				</div>
				<div class="pubBox">
					<h2>Forthcoming Publications</h2>
					<?php if(releases_list($uid)) {
						echo releases_list($uid);
						print '<a class="viewAll" href="/publications/&amp;uid='.$uid.'">View all publications</a>';
					} else {
						print '<p class="empty">No forthcoming publications</p>';
					} ?>
				</div>
				
				<?php if($twitter) { ?>
					<div class="pubBox">
						<h2>Twitter</h2>
						<ul id="twitter_update_list"></ul>
						<a class="viewAll" href="http://twitter.com/<?php echo $twitter;?>" id="twitter-link">Follow me</a>
						<script type="text/javascript" src="http://twitter.com/javascripts/blogger.js"></script>
						<script type="text/javascript" src="http://twitter.com/statuses/user_timeline/<?php echo $twitter;?>.json?callback=twitterCallback2&amp;count=5"></script>
					</div>
				<?php } ?>
				
			</div><!-- /#pubRightSide -->
		
			<div id="pubSidebar">
				<?php if(user_img($uid)):?>
				<div id="pubAvatar">
					<img src="/<?php echo user_img($uid);?>" />
				</div>
				<?php endif;?>
				<ul id="pubNav">
					<li <?php if($uri_parts['0'] == user_username($uid)) { echo 'class="active"';} ?>><a href="/<?php echo user_username($uid);?>">Profile</a></li>
					<li <?php if($uri_parts['0'] == 'publisher-review') { echo 'class="active"';} ?>><a href="/publisher-review/&amp;uid=<?php echo $uid;?>">Reviews</a></li>
					<li <?php if($uri_parts['0'] == 'publications' || $node->type == 'release' || $node->type == 'book_published') { echo 'class="active"';} ?>><a href="/publications/&amp;uid=<?php echo $uid;?>">Publications</a></li>
					<li <?php if($uri_parts['0'] == 'blog' || $uri_parts['0'] == 'blogs' || $uri_parts['0'] == 'archive' || $node->type=='blog') { echo 'class="active"';} ?>><a href="/blogs/<?php echo $uid;?>">Blog</a></li>
				</ul>
			</div><!-- /#pubsidebar -->
			
			<div id="pubContent">
				<?php if (user_access('administer nodes')): ?>
						<a href="<?php print '?q=node/'.$node->nid ?>/edit" class="editButton" title="<?php print t('Edit') ?>">Edit this entry</a>
				<?php endif; ?>
				<?php if ($title): ?>
					<?php if($title == 'Create Word') { $title = 'Upload Word';}?>
					<h1><?php print $title; ?></h1>
				<?php endif; ?>
				<div class="bodyContent">
					<?php print $content; ?>
					<?php if($node->comment_count!=0):?>
						</div>
					<?php endif;?>
				</div>
				
			</div><!-- /#pubContent -->
			
			<?php print $feed_icons; ?>

			<?php if ($footer || $footer_message): ?>
				<div id="footer" class="clearfix">
				<?php if ($footer): ?>
					<?php print $footer; ?>
				<?php endif; ?>
				<?php if ($footer_message): ?>
					<?php print $footer_message; ?>
				<?php endif; ?>
				</div><!-- /footer -->
			<?php endif; ?>
		
		</div><!-- /#pubWrapper -->
		
		<!-- /New Publisher Reviews page -->	
				
	</div><!-- /page -->
	
	<div id="hr"></div>
	<?php print $pre_closure; ?>
	<?php print $closure; ?>
</body>
</html>
