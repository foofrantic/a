<?php
$uri_path = trim($_SERVER['REQUEST_URI'], '/');
$uri_parts = explode('/', $uri_path);
//$uid = $node->uid;
$uid = $node->uid;
//$uid = substr($_GET['q'],5);
$twitter = twitter_username($uid);
$picture = user_picture($uid);
$username = user_username($uid);
//Details Keys
$location ='23';
$details ='22';
//print_r($user_details);
// $Id: page.tpl.php,v 1.1.2.3 2008/11/25 22:42:34 jwolf Exp $
$count = 10;
$pigeonhole = pigeonhole($uid,$count);
$comments = profile_comments($uid);
$profile_comments = display_profile_comments($uid,$count);
$fans = user_fans_reverse($uid);
//print_r($latest_words);
$views = user_views($uid);
$reviews = publisher_reviews($uid);
$favorite_authors = favorite_authors($id);
$genres = user_genres($uid);
//print_r($genres);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php print $language->language; ?>" xml:lang="<?php print $language->language; ?>">

  <head>
    <title>Publications</title>
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

<body class="<?php print $body_classes; ?> <?php echo $uri_parts['0'];?> publisher">
	
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
		
		<!-- New Publisher Publications page September 2010 -->
		
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
					<h1><?php print $title; ?></h1>
				<?php endif; ?>
				<div class="bodyContent">
					<?php print $content; ?>
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
		
		<!-- /New Publisher Publications page -->

	</div><!-- /page -->
	
	<div id="hr"></div>
	<?php print $pre_closure; ?>
	<?php print $closure; ?>
</body>
</html>
