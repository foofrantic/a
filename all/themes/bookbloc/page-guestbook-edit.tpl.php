<?php
// Need to  check if user is owner of this guestbok or set message and redirect to referer page
$recipient = guestbook_recipient($_GET['id']);
if($user->uid != $recipient && !in_array('Administrator',$user->roles)) {
	drupal_set_message('You are not allowed to edit this comment.');
	drupal_goto('user');
}
if($_POST) {
	//modify guestbook
	$form = $_POST;
	update_guestbook($form);
}
// $Id: page.tpl.php,v 1.1.2.3 2008/11/25 22:42:34 jwolf Exp $
$uri_path = trim($_SERVER['REQUEST_URI'], '/');
// Split up the remaining URI into an array, using '/' as delimiter.
$uri_parts = explode('/', $uri_path);
$message = get_guestbook($_GET['id']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php print $language->language; ?>" xml:lang="<?php print $language->language; ?>">

<head>
	<title>Guestbook</title>
	<?php print $head; ?>
	<?php print $styles; ?>
	<!--[if IE 7]>
	<link rel="stylesheet" href="<?php print $base_path . $directory; ?>/styles/ie7-fixes.css" type="text/css">
	<![endif]-->
	<!--[if lte IE 6]>
	<link rel="stylesheet" href="<?php print $base_path . $directory; ?>/styles/ie6-fixes.css" type="text/css">
	<![endif]-->
	<?php require_once drupal_get_path('theme', 'bookbloc') .'/includes/style.php';?>
	<?php print $scripts; ?>
	<?php require_once drupal_get_path('theme', 'bookbloc') .'/includes/editor.php';?>
</head>

<body class="<?php print $body_classes; ?> <?php echo $uri_parts['0'];?>">
	
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
						
						<div id="content-inner">
							
							<?php if ($title): ?>
								<h1 class="title"><?php print $title;?></h1>
							<?php endif; ?>
							
							<div id="content-content">
								<?php print $content; ?>
								
								<form action=""  accept-charset="UTF-8" method="post" id="comment-form">
									<div>

									<div class="form-item" id="edit-comment-wrapper">
									 <label for="edit-comment">Comment: <span class="form-required" title="This field is required.">*</span></label>
									 <textarea cols="60" rows="15" class="form-textarea" id="edit-comment" name="comment"><?php echo $message;?></textarea>
									</div>

									 <div class="description"><ul class="tips"><li>Web page addresses and e-mail addresses turn into links automatically.</li><li>Allowed HTML tags: &lt;a&gt; &lt;em&gt; &lt;strong&gt; &lt;cite&gt; &lt;code&gt; &lt;ul&gt; &lt;ol&gt; &lt;li&gt; &lt;dl&gt; &lt;dt&gt; &lt;dd&gt;</li><li>Lines and paragraphs break automatically.</li></ul></div>

									</div>

									<input type="hidden" name="id" value="<?php echo $_GET['id'];?>"  />
									<input type="hidden" name="form_id" id="edit-comment-form" value="comment_form"  />
									<input type="submit" name="op" id="edit-preview" value="Save"  class="form-submit" />

									</div>
								
								</form>
								
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
