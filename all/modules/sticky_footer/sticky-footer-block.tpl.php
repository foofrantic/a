<!-- Facebook style footer bar -->
	
	<div id="footpanel">
	
		<script	type="text/javascript" src="/sites/all/themes/bookbloc/js/jquery.tooltip.js"></script>
		<script type="text/javascript">
		
			$(document).ready(function() {
				$(".footerLeft li a").tooltip({
					showURL: false,
					fade: 250
				});		
			});
		
		</script>
		<style type="text/css">
		
		
		
		</style>
	
		<div id="footpanelInterior">
			<div class="footerLeft">
				<h6>Account Tools</h6>
				<ul>
					<?php foreach($items as $item): ?>
					<li><a href="<?php print $item['url'] ?>" title="<?php print $item['title'] ?>"><img src="<?php print base_path() . drupal_get_path('module', 'sticky_footer') ?>/images/<?php print $item['icon'] ?>" alt="<?php print $item['title'] ?>"></a></li>					
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="footerRight">
				<h6>Logged in as <a href="/<?php print $GLOBALS['user']->name ?>"><?php print $GLOBALS['user']->name ?></a></h6>
				<a href="/logout" title="Log out"><img src="<?php print base_path() . drupal_get_path('module', 'sticky_footer') ?>/images/fbLogout.gif" style="padding-top: 3px;" alt="Logout"></a>
			</div>
			
		</div>
	
	</div>