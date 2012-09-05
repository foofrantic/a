<?php
// $Id: page.tpl.php,v 1.1.2.3 2008/11/25 22:42:34 jwolf Exp $
$user_link = user_link($node->uid);
$comments = get_node_comments($node->nid);
$votes = get_node_votes($node->nid);
$votes_count = get_votes_count($node->nid);
//$publisher_votes = get_node_publisher_votes($node->nid);
//$publishers_votes_count = get_publishers_votes_count($node->nid);
$check_favorite = check_bookmark($node->nid);
$author = node_author($node->nid);
$tags = node_tags($node->nid);
$publisher_total_votes = get_publisher_totalvotes($node->nid);
//print_r($publisher_total_votes);
$pub_num_votes = get_publisher_numvotes($node->nid);
//print_r($pub_num_votes);
$average_pub_vote = 0;
if(!empty($pub_num_votes['0']['count(vote)']) && $pub_num_votes['0']['count(vote)'] > 0) {
  $average_pub_vote = floor($publisher_total_votes['0']['sum(vote)']/$pub_num_votes['0']['count(vote)']);
}
$publisher_votes = ($average_pub_vote/20);
$publisher_votes_count = get_publisher_uids($node->nid);

$publisher_votes_count = count($publisher_votes_count);

//$votes = $votes - $publisher_votes;

$votes_count = $votes_count - $publisher_votes_count;

// HACK // // HACK // // HACK // // HACK // // HACK // // HACK // // HACK // 
// Didn't add this in a preprocess fn as it's a raw node and wanted to keep all
// the hacks in one file. See <div class="content-node"> below.
$raw_node = node_load( $node->nid );

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php print $language->language; ?>" xml:lang="<?php print $language->language; ?>">

  <head>
    <title><?php print $head_title; ?></title>
    <?php print $head; ?>
    <?php print $styles; ?>
    <link rel="stylesheet" href="<?php print $base_path . $directory; ?>/styles/words.css" type="text/css">
    <!--[if IE 7]>
      <link rel="stylesheet" href="<?php print $base_path . $directory; ?>/styles/ie7-fixes.css" type="text/css">
    <![endif]-->
    <!--[if lte IE 6]>
      <link rel="stylesheet" href="<?php print $base_path . $directory; ?>/styles/ie6-fixes.css" type="text/css">
    <![endif]-->
  <?php require_once drupal_get_path('theme', 'bookbloc') .'/includes/style.php';?>
    <?php print $scripts; ?>
  </head>

  <body class="<?php print $body_classes; ?> words">
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
  
       <?php if ($sidebar): ?>
              <div id="sidebar">
                <?php print $sidebar; ?>
              </div><!-- /sidebar-first -->
         <?php endif; ?>
          
          <?php if ($breadcrumb): ?>
          <div id="breadcrumb">
            <?php print $breadcrumb; ?>
          </div><!-- /breadcrumb -->
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
              <?php if ($tabs):  ?>
                <div id="content-tabs">
                  <?php print $tabs; ?>
                </div>
        <div class="clear"></div>
              <?php  endif; ?>
            

              <div id="content-inner">
                <?php if ($title): ?>
                  <p class="title"><?php print $title; ?> <span>by <a href="/user/<?php echo $user_link['0']['uid'];?>">
          <?php echo $user_link['0']['name'];?></a></span></p>
                <?php endif; ?>
        <div class="clear"></div>
        
                <div id="content-content">
  
          <ul class="views">
            <li class="tag"><?php echo get_genre($node->nid);?> | </li>
            <li class="view"><?php echo get_node_count($node->nid);?> Views | </li>
            <li class="comments"><?php echo count($comments);?> Comments</li>
          </ul>
        
          <div class="clear"></div>
          <br/>
          <div id="tags">
          <div class="clear"></div>
          <?php foreach($tags as $tag):?>
          
            <div class="tag"><span><a href="/taxonomy/term/<?php echo $tag['tid'];?>"><?php echo $tag['name'];?></a></span></div>
          <?php endforeach;?>
          </div>
          <div class="clear"></div>
        
          <?php if ($node->field_cover[0] != ''): ?><?php print theme('imagecache', 'cover', $node->field_cover[0]['filepath'], $node->title, $node->title, array('class'=>'words-picture')) ?>
          <?php else: ?>  
          <?php print user_picture($node->uid);?>
          <?php endif; ?>
          <br/>
        
        
          <?php if($node->uid!=$user->uid):?>
          
          <?php global $user;
                if($user->uid != 0):?>
          <span id="rate">Rate this article</span>
        
          
          <div class="fivestar">
            <?php
                $fivestarwidget = fivestar_widget_form($node);
                print $fivestarwidget;
            ?>
          </div>
          <?php endif;?>
        
          <?php endif;?>
        
          <div id="user-panel">
          <ul>
            <li><a href="/user/<?php echo $node->uid;?>">Back to Profile</a></li>
            <li><a href="/report/&nid=<?php echo $node->nid;?>">Report this</a></li>
            <?php if($user->uid==0) { ?>
              <li><a href="/user/&destination=comment/reply/<?php echo $node->nid;?>">Add Comment</a></li>
            <?php } else { ?>
            <li><a href="/comment/reply/<?php echo $node->nid;?>">Add Comment</a></li>
            <?php if($check_favorite != $node->nid) { ?>
              <li><a href="/favorite_nodes/add/<?php echo $node->nid;?>">Add to favourites</a></li>
            <?php } ?>
            <?php if(is_publisher()):?>
              <li><a href="/node/add/review/<?php echo $node->nid;?>">Write a review</a></li>
            <?php endif;?>
            
            <?php } ?>
          </ul>
          </div>
        
          <?php //print $content; ?>


          <?php
            // HACK // HACK // HACK // HACK // HACK // HACK // HACK // HACK 
            // This section was not utilising the output of the node template
            // and I modified it in place. I found that the output of the node
            // template is printed in the comments section further below, and
            // all that output (other than the comments) is being hidden in CSS.
            //
            // Modifications here were part of a change from having the
            // chapter or poem available as a downloadable attachment to
            // including the full text of the chapter in the text (for SEO
            // purposes) and providing a link to generate a PDF version.
            // justin@3mules.coop
          ?>
          <div class="content-node">

            <?php if ( 0 < strlen( trim( $raw_node->body ) ) ): ?>

              <div class="field field-type-text field-field-body">
                <div class="field-label"><?php print t('Synopsis') ?>:</div>
                <div class="field-items">
                  <div class="field-item odd">
                    <?php print $raw_node->body; ?>
                  </div>
                </div>
              </div>

            <?php endif; ?>
            <?php if ( 0 < strlen( trim( $raw_node->field_word_full_text[0]['value'] ) ) ): ?>

              <div class="field field-type-text field-field-word-full-text">
                <div class="field-label"><?php print t('Full text') ?>:</div>
                <div class="field-items">
                  <div class="field-item odd">
                    <?php print $raw_node->field_word_full_text[0]['value']; ?>
                  </div>
                </div>
              </div>

            <?php endif; ?>

            <?php print _addtoany_create_button(menu_get_object()); ?>

            <div class="vote-message">
              <p><strong>Want to read more? Vote and make this successful.</strong></p>
            </div>
            
            <div class="rating-download-wrapper">

              <div class="download-panel">

                <div class="download-panel-item">
                  <strong>User rating </strong> <?php echo $votes;?> (<?php echo $votes_count;?> Votes)
                </div>
                <div class="download-panel-item">
                  <strong>Publisher rating</strong> <?php echo number_format(floor($publisher_votes),2);?> (<?php echo $publisher_votes_count;?> Votes) 
                </div>
                <div class="download-panel-item" id="download-pdf-version-container">
                <!--  <a id="download-pdf-version-link" href="/printpdf/<?php //echo $node->nid; ?>">Download PDF version</a> -->
                </div>

              </div> <!-- /download-panel -->

              <?php
                // $filesize = $node->field_upload['0']['filesize'];
                // $filesize = $filesize/1000000;
                // $filesize = number_format($filesize,2);
              ?>

              <?php if ( ! user_is_logged_in() ): ?>
                <div class="login-register-download">
                <?php
                  $destination = drupal_get_destination();
                  print t(
                    '<a href="@login">Login</a> or <a href="@register">register</a> to download',
                    array(
                      '@login' => url('user/login', array('query' => $destination)),
                      '@register' => url('user/register', array('query' => $destination)),
                  ) );
                ?>
                </div>

              <?php // else, does the node include anything in "Full Text" box? ?>
              <?php elseif ( 0 < strlen( trim( $raw_node->field_word_full_text[0]['value'] ) ) ): ?>
                <a id="download-orange" href="/printpdf/<?php echo $node->nid; ?>"> <?php print t('PDF version');?> </a>

              <?php // else, does node have an attached doument? ?>
              <?php elseif ( $node->field_upload['0']['filepath']): ?>
                <a id="download-orange" href="/<?php echo $node->field_upload['0']['filepath'];?>"> <?php print t('Download file');?> </a>

              <?php // else, make node available as PDF anyway ?>
              <?php else: ?>
                <a id="download-orange" href="/printpdf/<?php echo $node->nid; ?>"> <?php print t('PDF version');?> </a>

              <?php endif; ?>

            </div> <!-- /rating-download-wrapper -->

          </div> <!-- /content-node -->


          <div class="clear"></div>
        
          <div id="split"></div>
          <h5 style="float:left;width:auto">Comments about these words</h5>
          
          <div id="comments">
            <?php print $content;?>
          </div>
        
          <?php print $below_content ?>

          
                </div>
              </div><!-- /content-inner -->
            </div><!-- /content -->

          
          </div><!-- /content-wrapper --></div>
          

       

          <div class="clear"></div>
          
          <?php print $feed_icons; ?>


          <?php if ($footer_top || $footer || $footer_message): ?>
  <div class="clear"></div>
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
  </body>
</html>
