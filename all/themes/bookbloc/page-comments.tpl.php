<?php
// $Id: page.tpl.php,v 1.0 11/06/2008 Jay Boodhun Exp $
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php print $language->language; ?>" xml:lang="<?php print $language->language; ?>">

<head>
	<title><?php print $head_title; ?></title>
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
</head>

<body class="<?php print $body_classes; ?> <?php echo $uri_parts['0'];?> page_comments">
	
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
							
							<?php if ($title): ?>
								<?php if($title == 'Create Word') { $title = 'Upload Word';}?>
								<h1 class="title"><?php print $title; ?></h1>
							<?php endif; ?>
							
							<div id="content-content">
								<?php print $content; ?>
							</div>
						
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
</body>
</html>
