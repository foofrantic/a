<?php
// $Id: comment-wrapper.tpl.php,v 1.1 2008/10/01 03:26:19 jwolf Exp $

/**
 * @file comment-wrapper.tpl.php
 * Default theme implementation to wrap comments.
 *
 * Available variables:
 * - $content: All comments for a given page. Also contains sorting controls
 *   and comment forms if the site is configured for it.
 *
 * The following variables are provided for contextual information.
 * - $node: Node object the comments are attached to.
 * The constants below the variables show the possible values and should be
 * used for comparison.
 * - $display_mode
 *   - COMMENT_MODE_FLAT_COLLAPSED
 *   - COMMENT_MODE_FLAT_EXPANDED
 *   - COMMENT_MODE_THREADED_COLLAPSED
 *   - COMMENT_MODE_THREADED_EXPANDED
 * - $display_order
 *   - COMMENT_ORDER_NEWEST_FIRST
 *   - COMMENT_ORDER_OLDEST_FIRST
 * - $comment_controls_state
 *   - COMMENT_CONTROLS_ABOVE
 *   - COMMENT_CONTROLS_BELOW
 *   - COMMENT_CONTROLS_ABOVE_BELOW
 *   - COMMENT_CONTROLS_HIDDEN
 *
 * @see template_preprocess_comment_wrapper()
 * @see theme_comment_wrapper()
 */
?>
<?php if($node->type=='blog'):?>
	<p class="utilities" style="margin-top:-30px;margin-left:-20px;margin-bottom:20px;"><span class="comment_add"><a href="/comment/reply/<?php echo $node->nid;?>">Add a Comment</a></span>
<?php endif;?>
<?php if ($content) : ?>
<div id="comments" class="block rounded-block">
<h2 class="comments"><?php print t('Comments'); ?></h2>
	<div id="comment_template">
	<?php print $content; ?>
	</div>
<?php endif; ?>

<?php if($node->type=='word'):?>
<div id="other_words">
	<?php 
	global $user;
	$author = node_author($node->nid);
	$other_words = other_words($author,$node->nid);
	?>
	<?php if($other_words):?>
		<h5 style="float:right;width:auto;">Users other words</h5>
		<?php foreach($other_words as $item) { ?>
			<h4><a href="/node/<?php echo $item['nid'];?>"><?php echo $item['title'];?></a></h4>
			<strong><?php echo date('d F Y',$item['created']);?></strong>
			<span class="body"><?php echo neat_trim(get_revision($item['nid']),80,'...');?></span>
		<?php } ?>
		
	<?php endif;?>

</div>
<?php endif;?>
<div class="clear"></div>
