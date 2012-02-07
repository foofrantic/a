<?php
// $Id: page.tpl.php,v 1.1.2.3 2008/11/25 22:42:34 jwolf Exp $
?>
<?php
if($_POST['category'] == 'author') {
	$dest = '/author/'.$_POST['keyword'].'';
	drupal_goto($dest);
}
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
	<style type="text/css">@import "/sites/all/themes/bookbloc/styles/default.css";</style>

		<script type="text/javascript" src="/sites/all/themes/bookbloc/js/jquery-latest.js"></script>
		<script type="text/javascript" src="/sites/all/themes/bookbloc/js/jquery.metadata.js"></script>
		<script type="text/javascript" src="/sites/all/themes/bookbloc/js/jquery.tablesorter.js"></script>

		<script type="text/javascript">

		$(function() {
			$("table").tablesorter();
		});

	</script>
  </head>

  <body class="<?php print $body_classes; ?> search <?php if($_GET['type']) { echo $_GET['type']; } else { echo 'popular';}?>">
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
                 
			        <div id="search_tabs">
			        	<ul>
							<li class="popular"><a href="/search">Most Popular</a></li>
							<li class="title"><a href="/search/?type=title">Title</a></li>
							<li class="genre"><a href="/search/?type=genre">Genre</a></li>
							<!--<li class="author"><a href="/search/?type=author">Author</a></li>-->
				        </ul>
			        </div>
					<div id="search-box" style="*width:570px;">
					    
						<form method="get" action="/results/" id="searchBig">
							<input type="text" size="18" name="keyword" id="searchInputBig" onfocus="this.value='';" value="<?php echo $_GET['keyword'];?>"/>
							
							<div id="dropdown-bg">
							<?php /*?>
								<select name="type" id="category_select">
								<option value="0">Search for? : </option>
								<option value="author" selected="selected">Author</option>
								<option value="title" >Title</option>
								<option value="genre" >Genre</option>
								<option value="all" >Most popular</option>

								</select>
							<?php */ ?>
							    <input type="hidden" name="type" value="<?php echo $_GET['type'];?>"/>
								<input type="hidden" name="mod" value="search" />
							</div>

							<input type="submit" class="form-submit" value="Filter Search" style="position:relative;margin-top:10px;margin-left:20px;"/>
						</form>
						<div class="clear"></div>
					</div>
					
				    <?php if(!$_GET['type']) { ?>
					
					 <?php print $content; ?>
					
					<?php }else {?>
						
						<br/>
				    
						<table id="myTable">
							
						<?php if($_GET['type']!='author') { ?>
				
						<thead>
					    	<tr>
							<th class="itemlong header">Title</th>
							<th class="item header">Author</th>
							<th class="item header">Date</th>
							<th class="item header">Views&nbsp;</th>
							<th class="item header">Comments&nbsp;</th>
							<th class="item header">Rating&nbsp;</th>
						    </tr>
						</thead>
						
						<?php } else {  ?>
						<thead>
					    	<tr>
							<th class="item header" style="width:180px;overflow:hidden">Username</th>							
							<th class="item header" style="width:180px">Location</th>
						
							<th class="item header" style="width:60px">Joined</th>
						    </tr>
						</thead>
						<?php } ?>
						
						
					    </tbody>
						
						</div class="clear"></div>
						
						<?php if($_GET['type']=='author') { ?>
							<?php
							$results = search_author($_GET['keyword']);
							//print_r($results);
							?>
						
							<?php if($results):?>
							<div class="view-content">
								  
									<?php for($i=0;$i<count($results);$i++) { ?>
									<?php $author = user_load($results[$i]['uid']);//print_r($author);?>
							        <tr class="views-row-<?php if($i%2) { echo 'even';} else { echo 'odd';}?>">
							                <span class="field-content">
												<td class="item" style="overflow:hidden"><a href="/<?php echo user_username($results[$i]['uid']);?>"><?php echo user_username($results[$i]['uid']);?></a></td>												
												<td class="item"><?php print $author->location;?></td>
											
												<td class="item"><?php print date('d/m/y',$author->created);?></td>
											</span>
							        </tr>
							        <?php  } ?>
							  </div>
							  <div class="clear"></div>
							</tbody>
							</div>
							<?php endif;?>
							<div class="clear"></div>
							
						<?php } ?>
					
						
						<?php if($_GET['type']=='title') { ?>
							<?php
							$results = search_title($_GET['keyword']);
							//print_r($results);
							?>
						
							<?php if($results):?>
							<div class="view-content">
								  
									<?php for($i=0;$i<count($results);$i++) { ?>
							        <tr class="views-row-<?php if($i%2) { echo 'even';} else { echo 'odd';}?>">
							                <span class="field-content">
												<td class="itemlong"><a href="/node/<?php echo $results[$i]['nid'];?>"><?php echo node_title($results[$i]['nid']);?></a></td>
												<td class="item"><a href="/<?php echo user_username(node_author($results[$i]['nid']));?>"><?php echo user_username(node_author($results[$i]['nid']));?></a></td>
												<td class="item"><?php echo date('d F Y', $results[$i]['created']);?></td>
												<td class="item"><?php echo get_node_count($results[$i]['nid']);?></td><td class="item"><?php echo count(get_node_comments($results[$i]['nid']));?></td><td class="item"><?php echo get_node_votes($results[$i]['nid']);?></td>
											</span>
							        </tr>
							        <?php  } ?>
							  </div>
							  <div class="clear"></div>
							</tbody>
							</div>
							<?php endif;?>
							<div class="clear"></div>
							
						<?php } ?>
						
						<?php if($_GET['type']=='genre') { ?>
							<?php
							$results = search_genre($_GET['keyword']);
							//print_r($results);
							if(!$results) { $results = search_count();}
							?>
						
							<?php if($results):?>
							<div class="view-content">
								  
									<?php for($i=0;$i<count($results);$i++) { ?>
									<?php if($results[$i]['nid']):?>
							        <tr class="views-row-<?php if($i%2) { echo 'even';} else { echo 'odd';}?>">
							                <span class="field-content">
												<td class="itemlong"><a href="/node/<?php echo $results[$i]['nid'];?>"><?php echo node_title($results[$i]['nid']);?></a></td>
												<td class="item"><a href="/<?php echo user_username(node_author($results[$i]['nid']));?>"><?php echo user_username(node_author($results[$i]['nid']));?></a></td>
												<td class="item"><?php echo date('d F Y', $results[$i]['created']);?></td>
												<td class="item"><?php echo get_node_count($results[$i]['nid']);?></td><td class="item"><?php echo count(get_node_comments($results[$i]['nid']));?></td><td class="item"><?php echo get_node_votes($results[$i]['nid']);?></td>
											</span>
							        </tr>
							        <?php endif;?>
							        <?php  } ?>
							  </div>
							  <div class="clear"></div>
							</tbody>
							</div>
							<?php endif;?>
							<div class="clear"></div>
							
						<?php } ?>
						
						
						<?php if($_GET['type']=='all') { ?>
							<?php
							$results = search_count();
							//print_r($results);
							?>
						
							<?php if($results):?>
							<div class="view-content">
								  
									<?php for($i=0;$i<count($results);$i++) { ?>
							        <tr class="views-row-<?php if($i%2) { echo 'even';} else { echo 'odd';}?>">
							                <span class="field-content">
												<td class="itemlong"><a href="/node/<?php echo $results[$i]['nid'];?>"><?php echo node_title($results[$i]['nid']);?></a></td>
												<td class="item"><a href="/<?php echo user_username(node_author($results[$i]['nid']));?>"><?php echo user_username(node_author($results[$i]['nid']));?></a></td>
												<td class="item"><?php echo date('d F Y', $results[$i]['created']);?></td>
												<td class="item"><?php echo get_node_count($results[$i]['nid']);?></td><td class="item"><?php echo count(get_node_comments($results[$i]['nid']));?></td><td class="item"><?php echo get_node_votes($results[$i]['nid']);?></td>
											</span>
							        </tr>
							        <?php  } ?>
							  </div>
							  <div class="clear"></div>
							</tbody>
							</div>
							<?php endif;?>
							<div class="clear"></div>
							
						<?php } ?>
						
						
						
						
						</table>
						
						
						
						
						
					<?php } ?>



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
