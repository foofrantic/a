<?php
global $user;
// $Id: comment.tpl.php,v 1.1 2008/10/01 03:26:19 jwolf Exp $
?>

<!-- start comment.tpl.php -->

<div class="comment <?php print $comment_classes;?> clear-block comment_item">
  <?php //print_r($comment);
  $role = get_user_roles($comment->uid);
  $role = $role['0']['rid'];
  $username = user_username($comment->uid);
  ?>
  <?php if($role!='4') { ?>
  <div class="user_picture <?php if($role == '5') { ?>green_left<?php } ?>">
	<?php if(user_picture($comment->uid)):?>
	<a href="/user/<?php print $comment->uid ?>"><?php print user_picture($comment->uid); ?></a>
	<?php endif; ?>
  </div>

  <div class="comment_area <?php if($role == '5') { ?>green<?php } ?>">

  <?php if($picture) { print $picture;} ?>
  
  
  
  <div class="content">
	<?php print $content ?>
    <span class="author"><?php echo $username;?> says on - <?php echo date('d F Y',$comment->timestamp);?></span>
	 <?php if($node->type=='blog'):?>
	 	<p><a href="/comment/reply/<?php echo $comment->nid;?>" class="action">Edit</a> | <a href="/comment/delete/<?php echo $comment->cid;?>" class="action">Delete</a></p>
	 <?php endif;?>
  </div>
	<div class="comment_bottom">
	</div>
  </div>

  <?php } else { ?>


	<div class="user_picture align_right">
		<?php if(user_picture($comment->uid)):?>
		<a href="/user/<?php print $comment->uid ?>"><?php print user_picture($comment->uid); ?></a>
		<?php endif; ?>
	  </div>

	  <div class="comment_area align_left">

	  <?php if($picture) { print $picture; } ?>
	  <?php if ($comment->new): ?>
	  <a id="new"></a>
	  <span class="new"><?php print $new ?></span>
	  <?php endif; ?>
	  

	  <div class="content">
	    <?php print $content ?>
	   
	  <span class="author"><?php echo $username;?> says on - <?php echo date('d F Y',$comment->timestamp);?></span>
	
	  	 <?php if($node->type=='blog'):?>
		 	<p><a href="/comment/reply/<?php echo $comment->nid;?>" class="action">Edit</a> | <a href="/comment/delete/<?php echo $comment->cid;?>" class="action">Delete</a></p>
		 <?php endif;?>
	  </div>
		<div class="comment_bottom"></div>
	  </div>

   <?php } ?>
<div class="clear"></div>
</div>
<!-- /end comment.tpl.php -->
