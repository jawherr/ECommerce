<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/PhpProject1/ECommerce/core/init.php';
$parentID = (int)$_POST['parentID'];
$selected = sanitize($_POST['selected']);
$childQuery = $db->query("SELECT * FROM categories WHERE parent = '$parentID' ORDER BY categorie");
ob_start(); ?>
	<option value=""></option>
	<?php while($child = mysqli_fetch_assoc($childQuery)): ?>
		<option value="<?=$child['id'];?>"<?=(($selected == $child['id'])?' selected':'');?>>
			<?=$child['categorie'];?>
		</option>
	<?php endwhile; ?>
<?php echo ob_get_clean();?>