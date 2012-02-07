<?php
/**
 * Note
 *
 * $tabs is an array, each item being a named array with the name of the tab, whether it is active, and
 * the items (nodes) that should go into that tab.
 *
 * LW - here I'm working on the assumption each tab is contained within <ul class="scrollFrame">
 * -- this should be pretty easy to change if, say, we need an extra DIV
 */
?>
			<div class="<?php print $class ?>">
				<ul class="bookshelfNav">
					<?php
					$i = 1;
					if (count($tabs)>0):
						foreach ($tabs as $tab): ?>
						<li id="bookshelfTab-<?php print $i ?>"><?php print $tab['name'] ?></li>
						<?php
						$i++;
						endforeach;
					endif;
					?>					
				</ul>
				
				<div class="scrollContentContainer">
					<a class="scrollContentBtnLeft disabled"><img src="<?php print base_path() . drupal_get_path('module', 'bookshelf') ?>/images/scrollLeft.png" alt="" /></a>
					<?php
					$i = 1;
					foreach ($tabs as $tab): ?>
					<div class="scrollContent" id="bookshelf-<?php print $i ?>">				   				 		
						<ul class="scrollFrame">					
							<?php
							if (count($tab['items']>0)):
							foreach ($tab['items'] as $node): ?>							
							<li>
								<span class="bsComments"><?php print $node->comment_count ?></span>
								<span class="bsStars"><?php print $node->rating ?></span>
								<?php if ($node->field_cover[0] != ''): ?><?php print theme('imagecache', 'cover', $node->field_cover[0]['filepath'], $node->title, $node->title, array('class'=>'bsCover')) ?><?php endif; ?>
								<div class="bsPopup">
									<a class="bsTitle" href="/node/<?php print $node->nid ?>"><?php print $node->title ?></a>
									<br />
									<a class="bsName" href="/user/<?php print $node->uid ?>"><?php print $node->name ?></a>
								</div>
							</li>							
							<?php endforeach;
							endif;
							?>						
						</ul>
						<?php //endforeach; ?>
					</div><!-- /scrollContent -->
					<?php
					$i++;
					endforeach; ?>
								
					<a class="scrollContentBtnRight"><img src="<?php print base_path() . drupal_get_path('module', 'bookshelf') ?>/images/scrollRight.png" alt="" /></a>			
				</div><!-- /scrollContentContainer -->
				
							
				
			</div><!-- /Bookshelf -->
