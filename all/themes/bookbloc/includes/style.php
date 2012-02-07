<style type="text/css">
<?php 
	if($_SESSION['font']=='small') {
		$size = '100%';
	} elseif($_SESSION['font']=='medium') {
		$size = '110%';
	} elseif($_SESSION['font']=='large') {
		$size = '120%';
	} elseif($_SESSION['font']=='xlarge') {
		$size = '130%';
	}
?>
#main {
	font-size:<?php echo $size;?>;
}
</style>
<meta name="google-site-verification" content="0L24NPXu12bxqXQ1ImATuTXrffO-U3rnZBKPudfNwgQ" />