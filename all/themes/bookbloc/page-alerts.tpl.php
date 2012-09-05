<?php
// $Id: page.tpl.php,v 1.0 11/06/2009 22:42:34 Jay Boodhun Exp $
$wall_comments = profile_comments_last_access();
$ideas_last = get_ideas_last_comment();
$last_friends = get_last_friends();
$uri_path = trim($_SERVER['REQUEST_URI'], '/');
$uri_parts = explode('/', $uri_path);
global $user;
$uid = $user->uid;
$twitter = twitter_username($uid);
$picture = user_picture($uid);
$username = user_username($uid);
$location ='23';
$details ='22';
$count = 20;
$pigeonhole = pigeonhole_new($uid,$count);
$comments = profile_comments($uid,$count);
$profile_comments = display_profile_comments_new($uid);
$fans = user_fans_reverse($uid);
$views = user_views($uid);
//$suggested_words = new_words();
//$suggested_words = suggested_words($user->nid);
$suggested_words = suggested_words(4);
$my_words = my_latest_words($user->uid);
$access = last_access();
$requests = new_requests();
$my_alerts = my_alerts();
$suggested_users = suggested_users($uid);
$number_of_words = number_of_words($uid);
$total_views = get_users_total_views($uid);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php print $language->language; ?>" xml:lang="<?php print $language->language; ?>">

<head>
	<title><?php print $username; ?></title>
	<?php print $head; ?>
	<?php print $styles; ?>
	<link rel="stylesheet" href="<?php print $base_path . $directory; ?>/styles/profile.css" type="text/css">
	<link rel="stylesheet" href="<?php print $base_path . $directory; ?>/styles/comments.css" type="text/css">
	<link rel="stylesheet" href="<?php print $base_path . $directory; ?>/styles/alerts.css" type="text/css">
	<?php if(is_publisher()):?>
		<link rel="stylesheet" href="<?php print $base_path . $directory; ?>/styles/newpublisher.css" type="text/css">
	<?php endif; ?>
	<!--[if IE 7]>
	<link rel="stylesheet" href="<?php print $base_path . $directory; ?>/styles/ie7-fixes.css" type="text/css">
	<![endif]-->
	<!--[if lte IE 6]>
	<link rel="stylesheet" href="<?php print $base_path . $directory; ?>/styles/ie6-fixes.css" type="text/css">
	<![endif]-->
	<?php require_once drupal_get_path('theme', 'bookbloc') .'/includes/style.php';?>
	<?php print $scripts; ?>
	<script type="text/javascript">
	
		$(document).ready(function() {
		
			//Messy code for the pigeon hole-comments slidey lists 
				
			$(".profileComments").css("display","none");
			
			$(".pigeonHoleNav li#phTab").click(function() {
				$(".profileComments").hide(), $(".pigeonHoleListings").show(); 
				$("#pcTab").removeClass("active"), $(this).addClass("active");
			});
			$(".pigeonHoleNav li#pcTab").click(function() {
				$("#phTab").removeClass("active"), $(this).addClass("active");
				
				$(".pigeonHoleListings").hide(), 
				$(".profileComments").show(), 				
				$(function() {
	    			$(".profileComments .scrollListContainer").jCarouselLite({
	        		btnNext: ".profileComments .showMore",
	        		btnPrev: ".profileComments .showPrevious",
	        		vertical: true,
	        		visible: 6,
	        		speed: 700,
	        		scroll: 6,
	        		circular: false
	    			});
				});
			});
		
			$(function() {
	    		$(".pigeonHoleListings .scrollListContainer").jCarouselLite({
	        	btnNext: ".pigeonHoleListings .showMore",
	        	btnPrev: ".pigeonHoleListings .showPrevious",
	        	vertical: true,
	        	visible: 6,
	        	speed: 700,
	        	scroll: 6,
	        	circular: false
	    		});
			});
			
			// Hide show newer by default
			$(".pigeonHoleListings a.showPrevious, .profileComments a.showPrevious").css("display","none");
			$(".pigeonHoleListings a.showMore").click(function() { $(".pigeonHoleListings a.showPrevious").show(); });
			$(".profileComments a.showMore").click(function() { $(".profileComments a.showPrevious").show(); });
					
		});
		
	</script>
</head>

<body class="<?php print $body_classes; ?> alerts">
	
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


		<div id="main">
			
			
			
			<div id="main-wrapper" class="clearfix">
				<?php if (is_publisher()):?>
					<?php if(user_img($uid)):?>
					<div id="pubHomeAvatar">
						<img src="/<?php echo user_img($uid);?>" />
					</div>
					<?php endif;?>
					<div id="pubHomeTitle">
						<h2 class="mainHeader">Welcome back <?php print $username ?></h2>
						<h3 class="subHeader"><a href="/user/<?php print $uid ?>/edit">Edit my account</a></h3>
					</div>
				<?php else:?>
					<h2 class="mainHeader">Welcome back <?php print $username ?></h2>
					<h3 class="subHeader">So far you have uploaded <?php print $number_of_words . ' ' . (($number_of_words==1) ? 'chapter' : 'chapters') ?> that have been viewed <?php print $total_views ?> times</h3>
				<?php endif;?>

				<div style="width:100%">
					<?php print $above_content; ?>
				</div>

				<?php if ($breadcrumb): ?>		
					<!--
					<div id="breadcrumb">
						<?php print $breadcrumb; ?>
					</div>--><!-- /breadcrumb -->					
				<?php endif; ?>

				<?php if (is_publisher()):?>
					<div id="pubRightSide">
						<!-- Publisher account tools -->
						<div id="sidebar" class="pubHomeSide">
							<div id="block_25">
								<div class="block">
									<h2>Account Tools</h2>
									<div class="block_content">
										<ul>
											<li class="view-icon"><a href="/<?php print $username ?>">View my profile</a></li>
											<li class="add_blog"><a href="/node/add/blog">Add Blog</a></li>
											<li class="add_author"><a href="/node/add/supported-author">Add Supported Author</a></li>
											<li class="add_book"><a href="/node/add/book-published">Add Book Published</a></li>
											<li class="add_release"><a href="/node/add/release">Add forthcoming release</a></li>
											<li class="add_event"><a href="/node/add/event">Add Event</a></li>
											<li class="edit_account"><a href="/user/<?php print $uid ?>/edit">Edit my Account</a></li>
											<li class="pass"><a href="/user/<?php print $uid ?>/edit">Change my password</a></li>
											<li class="alerts"><a href="/alerts">My alerts</a></li>
											<li class="friends"><a href="/relationships/1">My friends</a></li>
										</ul>
									</div>
								</div>
							</div>
						</div><!-- end Publisher account tools -->									
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
				<?php else:?>
					<?php if ($sidebar): ?>
						<div id="sidebar">
							<?php print $sidebar; ?>
						</div><!-- /sidebar-first -->
					<?php endif; ?>
				<?php endif; ?>
				
				<div id="content-wrapper">
					
					<?php if ($help): ?>
						<?php print $help; ?>
					<?php endif; ?>
					
					<?php if ($messages): ?>
						<?php print $messages; ?>
					<?php endif; ?>

					<?php if ($content_top): ?>
					<div id="content-top">
						<?php print $content_top; ?>
					</div><!-- /content-top -->
					<?php endif; ?>

					<div id="content">
						
						<?php if($alerts):?>
							<div class="messages">
								<?php print $alerts;?>
							</div>
						<?php endif;?>
						
						<?php if ($tabs): ?>
							<div id="content-tabs">
								<?php print $tabs; ?>
							</div>
							<div class="clear"></div>
						<?php endif; ?>

						<div id="content-inner">

							<div id="content-content">

								<!-- New pigeonhole here -->
								
								<ul class="pigeonHoleNav">
									<li id="phTab" class="active"><a>Pigeonhole</a></li>
									<li id="pcTab"><a>Profile comments</a></li>
								</ul>
								<div class="phContainer pigeonHoleListings">
									<div class="scrollListContainer">
										<ul class="pigeonHole">
											<?php
											if ($pigeonhole['count']>0) {
												print $pigeonhole['output'] ;
											} else {
												print '<li>There are no notifications to display.</li>';
											}
											?>
											<li></li>
										</ul>
									</div><!-- end scrollListContainer -->
									<?php if($pigeonhole['count']>6): ?>
									<a class="showPrevious">View newer messages</a>
									<a class="showMore">View older messages</a>
									<?php endif; ?>
								</div><!-- end phContainer -->
								
								<div class="phContainer profileComments">
									<div class="scrollListContainer">
										<ul class="pigeonHole">
											<?php
											if ($profile_comments['count']>0) {
												print $profile_comments['output'] ;
											} else {
												print '<li>There are no comments to display.</li>';
											}
											?>
											<li></li>											
										</ul>
									</div><!-- end scrollListContainer -->
									<?php if($profile_comments['count']>6): ?>
									<a class="showPrevious">View newer messages</a>
									<a class="showMore">View older messages</a>
									<?php endif; ?>
								</div><!-- end phContainer -->
								
								<div class="clear"></div>
			
																
								<div class="suggestedChapters">
									<h3>Suggested Chapters</h3>
									<ul class="suggestedChaptersList">
										
										<?php foreach ($suggested_words as $suggested_chapter): ?>
										<!-- TESTING -->										
										
										<li><a href="<?php print drupal_get_path_alias('node/'.$suggested_chapter->nid) ?>" title="<?php print $suggested_chapter->title ?>"><div class="scThumb"><?php if ($suggested_chapter->field_cover[0] != ''): ?><?php print theme('imagecache', 'small_cover', $suggested_chapter->field_cover[0]['filepath'], $node->title) ?><?php endif; ?></div></a>
											<img class="scRating" src="<?php print base_path() . path_to_theme() ?>/images/scRating<?php print get_rating($suggested_chapter->nid) ?>.jpg" alt="<?php print get_rating($suggested_chapter->nid) ?> star" />
											<h4><a href="<?php print drupal_get_path_alias('node/'.$suggested_chapter->nid) ?>" title="<?php print $suggested_chapter->title ?>"><?php print $suggested_chapter->title ?></a></h4>
											<span class="scAuthor">by <a href="<?php print drupal_get_path_alias('user/'.$suggested_chapter->uid) ?>"><?php print $suggested_chapter->name ?></a></span>											
											<span class="scMeta">
												<?php
												$number_of_tags = count($suggested_chapter->taxonomy);
												if ($number_of_tags) {
													$i = 0;
													foreach ($suggested_chapter->taxonomy as $term) {													
													?>
												
												<a href="<?php print drupal_get_path_alias('taxonomy/'.$term->tid) ?>"><?php print $term->name ?></a><?php print (($i <= $count) ? ', ' : ' ') ?> 
												<?php
													$i++;
													}
												?>
												<br />
												<?php } ?>												
												added <?php print date('jS F Y',$suggested_chapter->created) ?>
											</span>
										</li>
										<?php endforeach; ?>										
									
									</ul>
								</div><!-- end suggestedChapters -->
								
								<div class="suggestedFriends">
									<h3>Suggested Friends</h3>
									<ul>
										<?php
												//$members = new_members();
										for($i=0;$i<10;$i++) {
											echo '<li><a href="/'.user_username($suggested_users[$i]['uid']).'" title="'.user_username($suggested_users[$i]['uid']).'">'; 
											echo user_picture_alerts($suggested_users[$i]['uid']);
											echo '</a></li>';
										}
										?>										
									
									</ul>
									<?php if(genres_of_interest()):?>
										<h3 style="padding-top: 20px;">Genres of Interest</h3>
										<?php echo genres_of_interest($uid); ?>
									<?php else:?>
										<p class="empty">No genres of interest chosen</p>
									<?php endif;?>
								
								</div>

							</div><!-- /content-content -->
						
						</div><!-- /content-inner -->
						
						<?php if(is_publisher()):?>
						
							<div id="pubContent" class="pubHomeContent">
							
								<div class="pubBoxHomeLeft">
									<ul class="pubFeeds">
										<li class="pubBlogFeed">
											<h2>Blog</h2>
											<p>Latest blog article here</p>
										</li>
										<li class="pubReviewsFeed">
											<h2>Reviews</h2>
											<?php if(pub_reviews_overview($uid)) {
												echo pub_reviews_overview($uid);
											} else {
												print '<p class="empty">No Reviews yet</p>';
											} ?>
										</li>
									</ul>				
								</div><!-- /blog, reviews -->
								
								<div class="pubBoxHomeRight">
										<?php $friends = profile_friends($uid);?>
										<div class="pubFriends">
											<h2>My Friends (<?php echo count($friends);?>)</h2>
											<?php foreach($friends as $friend) { //print_r($friend);?>
											<a href="/<?php echo user_username($friend['requester_id']);?>" title="<?php echo user_username($friend['requester_id']);?>">
												<img src="/<?php echo user_img($friend['requester_id']);?>" alt="<?php echo user_username($friend['requester_id']);?>" />
											</a>	
											<?php } ?>
											<p><a href="/relationships/<?php echo $uid;?>">View all friends</a></p>
										</div>
																				
										<h2>My Favourite Words</h2>
										<?php if(publisher_favorite_words($uid)) {
											echo publisher_favorite_words($uid);
										} else {
											print '<p class="empty">No Favourite Words yet</p>';
										} ?>
								</div><!-- /friends and words -->
								
							</div><!-- /#pubContent -->
						<?php endif;?>
					
					</div><!-- /content -->

				</div><!-- /content-wrapper -->	

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

			</div><!-- /main-wrapper -->
		
		</div><!-- /main -->
	
	</div><!-- /page -->
	
	<div id="hr"></div>
	<?php print $pre_closure; ?>
	<?php print $closure; ?>
</body>
</html>
