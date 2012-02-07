<?php global $user;?>
<div id="login">
	<?php if($user->uid==0) { ?>
  	<a href="/user">Login to Bookbloc</a>
    <?php }else{?>
	Logged in as <a href="/<?php echo $user->name;?>"><strong><?php echo $user->name;?></strong></a> - <a href="/logout"><strong>Logout</strong></a>
	<?php }?>
</div>