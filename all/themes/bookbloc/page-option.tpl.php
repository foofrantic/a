<?php
// $Id: page.tpl.php,v 1.1.2.3 2008/11/25 22:42:34 jwolf Exp $
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
	<script src="/sites/all/themes/bookbloc/js/styleswitch.js" type="text/javascript"></script>

  </head>

  <body class="<?php print $body_classes; ?>">
    <div id="page" class="clearfix">
	<a name="top"></a>

      <div id="header">
        <div id="header-wrapper" class="clearfix">
	
		  <?php require_once drupal_get_path('theme', 'bookbloc') .'/includes/login.php';?>
          
          <?php if ($search_box): ?>
          <div id="search-box">
            <?php print $search_box; ?>
          </div><!-- /search-box -->
          <?php endif; ?>
  
            <?php if ($logo): ?> 
            <div id="logo">
              <a href="<?php print $base_path ?>" title="<?php print t('Home') ?>"><img src="<?php print $logo ?>" alt="<?php print t('Home') ?>" /></a>
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
              <?php //print $messages; ?>
            <?php endif; ?>

            <?php if ($content_top): ?>
            <div id="content-top">
              <?php print $content_top; ?>
            </div><!-- /content-top -->
            <?php endif; ?>
            
            <div id="content">
              <?php if ($tabs): ?>
              <div id="content-tabs">
                <?php print $tabs; ?>
              </div>
			  <div class="clear"></div>
              <?php endif; ?>
            
              <?php if (($sidebar_first) && ($sidebar_last)) : ?>
                <?php if ($sidebar_last): ?>
                <div id="sidebar-last">
                  <?php print $sidebar_last; ?>
                </div><!-- /sidebar_last -->
                <?php endif; ?>
              <?php endif; ?>

              <div id="content-inner">
                <?php if ($title): ?>
                <h1 class="title"><?php print $title; ?></h1>
                <?php endif; ?>
                <div id="content-content">
                  <?php //print $content; ?>
	<p>Having trouble viewing the text on bookbloc? choose a larger text size

				<ul>
					<li><a href="/viewing-options/&amp;font=small">Normal</a></li>
					<li><a href="/viewing-options/&amp;font=medium">Medium</a></li>
					<li><a href="/viewing-options/&amp;font=large">Large</a></li>
					<li><a href="/viewing-options/&amp;font=xlarge">X Large</a></li>
				</ul>
				
                </div>
              </div><!-- /content-inner -->
            </div><!-- /content -->

            <?php if ($content_bottom): ?>
            <div id="content-bottom">
              <?php print $content_bottom; ?>
            </div><!-- /content-bottom -->
            <?php endif; ?>
          </div><!-- /content-wrapper -->
          
          <?php if ((!$sidebar_first) && ($sidebar_last)) : ?>
            <?php if ($sidebar_last): ?>
            <div id="sidebar-last">
              <?php print $sidebar_last; ?>
            </div><!-- /sidebar_last -->
            <?php endif; ?>
          <?php endif; ?>

          <?php if ($postscript_first || $postscript_middle || $postscript_last): ?>
          <div id="postscript-wrapper" class="<?php print $postscripts; ?> clearfix">
            <?php if ($postscript_first): ?>
            <div id="postscript-first" class="column">
              <?php print $postscript_first; ?>
            </div><!-- /postscript-first -->
            <?php endif; ?>

            <?php if ($postscript_middle): ?>
            <div id="postscript-middle" class="column">
              <?php print $postscript_middle; ?>
            </div><!-- /postscript-middle -->
            <?php endif; ?>

            <?php if ($postscript_last): ?>
            <div id="postscript-last" class="column">
              <?php print $postscript_last; ?>
            </div><!-- /postscript-last -->
            <?php endif; ?>
          </div><!-- /postscript-wrapper -->
          <?php endif; ?>
          
          <?php print $feed_icons; ?>


          <?php if ($footer_top || $footer || $footer_message): ?>
          <div id="footer" class="clearfix">
            <?php if ($footer_top): ?>
            <?php print $footer_top; ?>
            <?php endif; ?>
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
