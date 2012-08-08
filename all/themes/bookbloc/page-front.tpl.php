<?php
global $user;
if($user->uid != 0) {
	header("location:/alerts");
}
// $Id: page.tpl.php,v 1.0 Jay Boodhun 11/06/2008 $
$genres = get_genres();
$latest_news = latest_news();
$members = all_members();
$words = all_words();
$popular = most_popular();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php print $language->language; ?>" xml:lang="<?php print $language->language; ?>">

<head>
	<title><?php print $head_title; ?></title>
	<?php print $head; ?>
	<?php print $styles; ?>
	<link href="/sites/all/themes/bookbloc/styles/home.css" rel="stylesheet" type="text/css" media="all">
	<!--[if IE 7]>
	<link rel="stylesheet" href="<?php print $base_path . $directory; ?>/styles/ie7-fixes.css" type="text/css">
	<![endif]-->
	<!--[if lte IE 6]>
	<link rel="stylesheet" href="<?php print $base_path . $directory; ?>/styles/ie6-fixes.css" type="text/css">
	<![endif]-->
	<?php require_once drupal_get_path('theme', 'bookbloc') .'/includes/style.php';?>
	<?php print $scripts; ?>
</head>

<body class="<?php print $body_classes; ?> front">
	
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
				<?php endif;?>

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


				<div id="content-wrapper">
					
					<?php if ($help): ?>
						<?php print $help; ?>
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
								
								<!--
								==============================================
								* TOP REGION
								==============================================
								 -->
								
								<!-- Top Container -->
								<div id="top_container">
									
									<?php if ($messages): ?>
										<?php print $messages; ?>
									<?php endif; ?>
									
									<div id="column1">
										<img src="/sites/all/themes/bookbloc/images/welcome-to-bookbloc.jpg" alt=""/><br/>
										<div class="body">
											<?php print $node->body;?>
										</div>
									</div><!-- /Column 1 -->
									
									<div id="column2">
										<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" WIDTH="546" HEIGHT="274" id="Yourfilename" ALIGN="">
										<PARAM NAME=movie VALUE="/sites/all/themes/bookbloc/images/homepage-flash.swf"> <PARAM NAME=quality VALUE=high> <PARAM NAME=bgcolor VALUE=#FFFFFF> <EMBED src="sites/all/themes/bookbloc/images/homepage-flash.swf" quality=high bgcolor=#FFFFFF WIDTH="546" HEIGHT="274" NAME="Yourfilename" ALIGN="" TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer"></EMBED> </OBJECT>
									</div><!-- /Column 2 -->

									<div class="clear"></div>
								
								</div><!-- /Top Container -->
								
								<div class="clear"></div>
								
								
								<!--
								==============================================
								* BOTTOM REGION
								==============================================
								 -->
								
								<!-- Bottom Container -->
								<div id="bottom_container">
									
									<div id="column1">
										
										<?php echo genre_list();?>
										<div class="clear"></div>

										<div id="news">
											<span class="date"></span>
											<?php echo $latest_news['body'];?>
										</div><!-- /News -->
									
									</div><!-- /Column 1 -->

									<div id="column2">
										
										<ul class="new_tab">
											<li><a href="#" class="popular">Popular</a></li>
											<li><a href="#" class="users">New Users</a></li>
											<li><a href="#" class="words">New Words</a></li>
										</ul>
										
										<div class="clear"></div>
										
										<div id="popular">
											
											<ul class="list">
												<?php for($i=0;$i<15;$i++) { ?>
												<li><a href="/node/<?php echo $popular[$i]['nid'];?>"><?php echo node_title($popular[$i]['nid']);?></a></li>
												<?php } ?>
											</ul>
										
										</div><!-- /Popular -->
										
										<div id="users">
											
											<ul class="list">
												<?php for($i=0;$i<15;$i++) { ?>
													<?php if(user_username($members[$i])!='The_Standen_Literary_Agency') { ?>
														<li><a href="/<?php echo clean_user(user_username($members[$i]['uid']));?>"><?php echo user_username($members[$i]['uid']);?></a></li>
														<?php } else { ?>
														<li><a href="/<?php echo user_username($members[$i]['uid']);?>"><?php echo user_username($members[$i]['uid']);?></a></li>
													<?php } ?>
												<?php } ?>
											</ul>
										
										</div><!-- /Users -->
										
										<div id="words">
											
											<ul class="list">
												<?php for($i=0;$i<15;$i++) { ?>
													<li><a href="/node/<?php echo $words[$i]['nid'];?>"><?php echo node_title($words[$i]['nid']);?></a></li>
												<?php } ?>
											</ul>
											
										</div><!-- /Words -->
									
									</div><!-- /Column 2 -->

									<div id="column3">
										
										<ul class="featuresList">
											<li class="featureBlog"><a href="http://bookbloc.posterous.com/" target="_blank">Keep up-to-date with our blog</a></li>
											<li class="featureTwitter"><a href="http://twitter.com/bookbloc" target="_blank" title="Follow us on Twitter">Bookbloc is on twitter, follow us</a></li>
											<li class="featureRegister"><a href="/user/register">Register now as a bookbloc member</a></li>
										</ul>
									
									</div><!-- /column 3 -->
									
									<div class="clear"></div>
								
								</div><!-- /Bottom Container -->

							</div><!-- /content-content -->
							
						</div><!-- /content-inner -->
						
					</div><!-- /content -->

				</div><!-- /content-wrapper -->

				<?php print $feed_icons; ?>
				<div class="clear"></div>

				<div id="footer" class="clearfix">

					<?php if ($footer): ?>
						<?php print $footer; ?>
					<?php endif; ?>
					<?php print $footer_message;?>

				</div><!-- /footer -->

			</div><!-- /main-wrapper -->
			
		</div><!-- /main -->
	
	</div><!-- /page -->
	
	<div id="hr"></div>
	<?php print $pre_closure; ?>
	<?php print $closure; ?>
    <?php require_once drupal_get_path('theme', 'bookbloc') .'/includes/analytics.php';?>
</body>
</html>
