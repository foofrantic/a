<?php
// $Id: page.tpl.php,v 1.0 11/06/2009 22:42:34 Jay Boodhun Exp $
$url = $_GET['q'];
$url = explode('/',$url);
$path = $_SERVER['REQUEST_URI'];
if(!$url['1']) {
	$url['1'] = user_userid($url['0']);
}
$roles = get_user_roles($url['1']);
// Check if a user is a publisher and redirect to publisher template.
if(strpos($path,'edit')) {
	include 'page-default.tpl.php';
	return;
}
if($roles):
foreach($roles as $role) {
	if($role['rid']=='4') {
		$rid = 'publisher';
		include 'page-publisher.tpl.php';
		return;
	}
}
endif;
$uri_path = trim($_SERVER['REQUEST_URI'], '/');
$uri_parts = explode('/', $uri_path);
if(substr($_GET['q'],0,4)=='user') {
	$uid = substr($_GET['q'],5);
} else {
	$uid = user_userid($_GET['q']);
}
$twitter = twitter_username($uid);
$picture = user_picture($uid);
$username = user_username($uid);
//Details Keys
$location ='23';
$details ='22';
//print_r($user_details);
$pigeonhole = pigeonhole_new($uid,$count);
//print_r($pigeonhole);
$comments = profile_comments($uid);
$profile_comments = display_profile_comments($uid);
$fans = user_fans_reverse($uid);
//print_r($latest_words);
$views = user_views($uid);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php print $language->language; ?>" xml:lang="<?php print $language->language; ?>">
<head>
  <title><?php print $username; ?></title>
  <?php print $head; ?>
  <?php print $styles; ?>
  <link rel="stylesheet" href="<?php print $base_path . $directory; ?>/styles/profile.css" type="text/css">
  <link rel="stylesheet" href="<?php print $base_path . $directory; ?>/styles/comments.css" type="text/css">
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
  
			$(function() {
	    		$("#profile_pigeonhole .scrollListContainer").jCarouselLite({
	        	btnNext: ".pigeonHoleShowMore",
	        	btnPrev: ".pigeonHoleShowPrevious",
	        	vertical: true,
	        	visible: 5,
	        	speed: 700,
	        	scroll: 5,
	        	circular: false
	    		});
			});
			
		});
	</script>
  
</head>

<body class="<?php print $body_classes; ?>">
	
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

				<?php if ($breadcrumb): ?>
					<div id="breadcrumb">
						<?php print $breadcrumb; ?>
					</div><!-- /breadcrumb -->
				<?php endif; ?>

				<?php if ($sidebar): ?>
					<div id="sidebar">
						<?php print $sidebar; ?>
					</div><!-- /sidebar-first -->
				<?php endif; ?>

				<div id="content-wrapper">
					
					<?php if ($help): ?>
						<?php print $help; ?>
					<?php endif; ?>
					
					<?php if ($messages): ?>
						<?php print $messages; ?>
					<?php endif; ?>
		
					<div id="content">
						
						<?php if ($tabs): ?>
						<div id="content-tabs">
						<?php print $tabs; ?>
						</div>
						<div class="clear"></div>
						<?php endif; ?>

						<div id="content-inner">

							<div id="content-content">
		
								<?php if($uri_parts['2']=='edit' || $uri_parts['2']=='guestbook' || $_GET['destination'] ||  $uri_parts['1']=='register' || $uri_parts['1'] == 'password' || $uri_parts['1'] =='reset' || ($uri_parts['0']=='user' && $uri_parts['1']=='')) { ?>
									<?php print $content; ?>
								<?php } else { ?>
								<?php if($_GET['q'] =='user/reset') { ?>
									<?php print $content;?>
								<?php } elseif(!$_GET['destination']) { ?>
									
								<div id="main_panel">
									
									<div id="column1">
										<?php echo $picture;?>
									</div><!-- /Column 1 -->
									
									<div id="column2">
										
										<div class="title">
											<?php echo $username;?>
											<span class="user_location">, <?php print user_detail($uid,$location);?></span>
											<span class="url"><a href="/<?php echo clean_user($username);?>">www.bookbloc.com/<?php echo clean_user($username);?></a></span>
										</div><!-- /Title -->
									
										<div id="inner_panel">
										
											<ul class="views">
												<li class="fans"><?php echo count(profile_friends($uid));?> Fans&nbsp;|&nbsp;</li>
												<li class="view"><?php echo count($views);?> Views&nbsp;|&nbsp;</li>
												<li class="comments"><?php echo count(profile_comments($uid));?> Comments</li>
											</ul>
										
											<?php echo user_detail($uid,$details);?>

											<p><a href="#" class="readmore">Read more about this user</a></p>

											<div class="extended_bio">
												<?php echo extended_bio($uid);?>
												<div class="clear"></div>
												<a href="#" class="close_bio">Close extended Bio</a>
											</div><!-- /Extended Bio -->

										</div><!-- /Inner panel -->
									
										<div id="inner_panel2">
											
											<div id="user-panel">
												
												<ul>
													<?php if($user->uid!=0 && $user->uid != $uid) {?>
														<?php if(!check_friend($user->uid,$uid)):?>
															<li><a class="user_relationships_popup_link" href="/relationship/<?php echo $uid;?>/request/1?destination=user/<?php echo $uid;?>">Add as friend</a></li>
														<?php endif;?>
													<?php } ?>


													<?php if($user->uid!=0) { ?>
													<li><a href="/user/<?php echo $uid;?>/guestbook">Add comment</a></li>
													<?php }else {?>
													<li><a href="/user&amp;destination=user/<?php echo $uid;?>/guestbook">Add comment</a></li>
													<?php }?>	
												</ul>
											
											</div><!-- /User Panel -->
											<div class="clear"></div>
											<?php print friend_user($uid);?>
											
										    <div class="clear"></div><br/>
										</div><!-- /Inner Panel 2 -->
										
										<div class="clear"></div>
									</div><!-- /Column 2 -->
									
									<div class="clear"></div>
								
								</div><!-- /Main Panel -->
								
								<div class="clear"></div>

								<div id="bottom_panel">
									
									<div id="column1">
										
										<div id="profile_tab">
											<ul>
												<li><a href="#tab" class="pigeonhole">Pigeonhole</a></li>
												<li><a href="#tab" class="comments">Profile comments</a></li>
												<li><a href="#tab" class="twitter">Twitter Updates</a></li>
											</ul>
											<a name="tab"></a>
										</div><!-- /Profile Tab -->
									
										<h3><i>What are your friends up to?</i></h3>
										<div id="profile_pigeonhole">
											<div class="scrollListContainer">
												<ul id="pigeonHoleList">
													<?php
													if ($pigeonhole['count']>0) {
														print $pigeonhole['output'] ;
													} else {
														print '<li>There are no notifications to display.</li>';
													}													
													?>
													<li></li>
												</ul>
											</div>
											<a class="pigeonHoleShowPrevious">View newer messages</a>
											<a class="pigeonHoleShowMore">View older messages</a>
										</div><!-- /Pigeonhole -->
									
										<div id="profile_comments">
											<ul>
											<?php
											if ($profile_comments['count']>0) {
												print $profile_comments['output'] ;
											} else {
												print '<li>There are no comments to display.</li>';
											}
											?>
											<li></li>
											</ul>
										</div>
										
										<div id="profile_twitter">
											<?php if($twitter) { ?>
											<!-- TWITTER UPDATES-->
											<div id="twitter_div">
											<img src="/sites/all/themes/bookbloc/images/tweet.jpg" alt="Follow me"/>
											<ul id="twitter_update_list"></ul>
											<a href="http://twitter.com/<?php echo $twitter;?>" id="twitter-link" style="display:block;text-align:right;"><img src="/sites/all/themes/bookbloc/images/follow_me.jpg" alt="Follow me"/></a>
											</div>
											<script type="text/javascript" src="http://twitter.com/javascripts/blogger.js"></script>
											<script type="text/javascript" src="http://twitter.com/statuses/user_timeline/<?php echo $twitter;?>.json?callback=twitterCallback2&amp;count=15"></script>

											<!-- //TWITTER UPDATES-->
											<?php } else { ?>
												<p>Sorry no twitter feeds available.</p>
											<?php } ?>
										</div>
										
							    	</div><!-- /Column 1 -->
								
									<div id="column2">
									
										<h5>User's friends</h5>
									
										<?php
										$friends = profile_friends($uid);
										foreach($friends as $friend) {
											echo '<a href="/'.user_username($friend['requester_id']).'" title="'.user_username($friend['requester_id']).'">'; 
											echo user_picture($friend['requester_id']);
											echo '</a>';
										}
										?>
										<div class="clear hr"></div>
									
										<h5>User's words</h5>
									
										<?php
										$user_words = user_words($uid);
										if($user_words):
											foreach($user_words as $word) {
											?>
												<h4><a href="/node/<?php echo $word['nid'];?>"><?php echo $word['title'];?></a></h4>
												<strong><?php echo date('d F Y',$word['created']);?></strong>
												<span class="body"><?php echo neat_trim(get_revision($word['nid']),'100','...');?></span>
											<?php } ?>
										<?php endif;?>

									</div><!-- /Column 2 -->
								
									<div class="clear"></div>
								
								</div><!-- /Bottom Panel -->
								
								<?php } ?>


								<?php } ?><!-- /if uri_parts['2] -->


							<?php print $below_content ?>
							</div><!-- /content-content -->
							
						</div><!-- /content-inner -->
						
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
	<?php require_once drupal_get_path('theme', 'bookbloc') .'/includes/analytics.php';?>
</body>
</html>