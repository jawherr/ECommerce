<?php
 require_once $_SERVER['DOCUMENT_ROOT'].'/PhpProject1/ECommerce/core/init.php';
	if (!is_logged_in()) {
		login_error_redirect();
	}
 include 'includes/head.php';
 include 'includes/navigation.php';

 $sql="SELECT * FROM categories WHERE parent = 0";
 $result = $db->query($sql);
 $errors = array();
 $categorie = '';
 $post_parent = '';

 //Edit Categorie
 if(isset($_GET['edit']) && !empty($_GET['edit'])){
 	$edit_id = (int)$_GET['edit'];
 	$edit_id = sanitize($edit_id);
 	$edit_sql = "SELECT * FROM categories WHERE id = '$edit_id'";
 	$edit_result = $db->query($edit_sql);
 	$edit_categorie = mysqli_fetch_assoc($edit_result);
 }

 //Deletet categorie
 if (isset($_GET['delete']) && !empty($_GET['delete'])) {
 	$delete_id = (int)$_GET['delete'];
 	$delete_id = sanitize($delete_id);
 	$sql = "SELECT * FROM categories WHERE id = $delete_id";
 	$result = $db->query($sql);
 	$categorie = mysqli_fetch_assoc($result);
 	if($categorie['parent'] == 0){
 		$sql = "DELETE FROM categories WHERE parent = '$delete_id'";
 		$db->query($sql);
 	}
 	$dsql = "DELETE FROM categories WHERE id = '$delete_id'";
 	$db->query($dsql);
 	header('Location: categories.php');
 }

 //Process Form
 if(isset($_POST) && !empty($_POST)){
 	$post_parent = sanitize($_POST['parent']);
 	$categorie = sanitize($_POST['categorie']);
 	$sqlform = "SELECT * FROM categories WHERE categorie = '$categorie' 
 	AND parent = '$post_parent'";
 	if(isset($_GET['edit'])){
 		$id = $edit_categorie['id'];
 		$sqlform = "SELECT * FROM categories WHERE categorie = '$categorie' AND parent = 
 		'$post_parent' AND id != '$id'";
 	}
 	$fresult = $db->query($sqlform);
 	$count = mysqli_num_rows($fresult);
 	//if categorie is blank
 	if($categorie == ''){
 		$errors[] .= 'The categorie cannot be left bleank.';
 	}
 	//If exists in databse
 	if ($count > 0){
 		$errors[] .= $categorie.' already exists. Please choose a new categorie.';
 	}
 	//Display Errors or Update Database
 	if(!empty($errors)){
 		//display errors
 		$display = display_errors($errors);?>
 	<script>
 		jQuery('document').ready(function(){
 			jQuery('#errors').html('<?=$display; ?>');
 		});
 	</script>
 	<?php }else{
 		//update database
 		$updatesql = "INSERT INTO categories (categorie, parent) VALUES ('$categorie',
 		'$post_parent')";
 		if(isset($_GET['edit'])){
 			$updatesql = "UPDATE categories SET categorie = '$categorie', 
 			parent= '$post_parent' WHERE id = '$edit_id'";
 		}
 		$db->query($updatesql);
 		header('Location: categories.php');
 	}
 }
 $categorie_value = '';
 $parent_value = 0;
 if(isset($_GET['edit'])){
 	$categorie_value = $edit_categorie['categorie'];
 	$parent_value = $edit_categorie['parent'];
 }else{
 	if(isset($_POST)){
 		$categorie_value= $categorie;
 		$parent_value = $post_parent;
 	}
 }
 ?>
<h2 class="text-center">Categories</h2><hr>
<div class="row">

	<!-- Form -->
	<div class="col-md-6">
	<form class="form" action="categories.php<?=((isset($_GET['edit']))?'?edit='.$edit_id:'');?>" method="post">
		<legend><?=((isset($_GET['edit']))?'Edit':'Add A');?> Categorie</legend>
		<div id="errors"></div>
		<div class="form-group">
			<label for="parent">Parent</label>
			<select class="form-control" name="parent" id="parent">
				<option value="0"<?=(($parent_value == 0)?' selected="selected"':'');?>>Parent
				</option>
				<?php while($parent = mysqli_fetch_assoc($result)) : ?>
					<option value="<?=$parent['id'];?>"<?=(($parent_value == $parent['id'])?'selected="selected"':'');?>><?=$parent['categorie'];?></option>
				<?php endwhile; ?>
			</select>
		</div>
		<div class="form-group">
			<label for="categorie">Category</label>
			<input type="text" class="form-control" id="categorie" name="categorie" 
			value="<?=$categorie_value;?>">
		</div>
		<div class="form-group">
			<input type="submit" value="<?=((isset($_GET['edit']))?'Edit':'Add');?> categorie" class="btn btn-success">
		</div>
	</form>
</div>
	<!-- Categorie Table -->
	<div class="col-md-6">
		<table class="table table-bordered">
			<thead>
				<th>Categorie</th><th>Parent</th><th></th>
			</thead>
			<tbody>
				<?php
				 $sql="SELECT * FROM categories WHERE parent = 0";
				 $result = $db->query($sql);
				 while($parent = mysqli_fetch_assoc($result)): 
					$parent_id = $parent['id'];
					$sql2 = "SELECT * FROM categories WHERE parent = '$parent_id'";
					$cresult = $db->query($sql2);
				?>
				<tr class="bg-primary">
					<td><?=$parent['categorie'];?></td>
					<td>Parent</td>
					<td>
						<a href="categories.php?edit=<?=$parent['id'];?>" class="btn btn-xs btn-default">
							<span class="glyphicon glyphicon-pencil"></span>
						</a>
						<a href="categories.php?delete=<?=$parent['id'];?>" class="btn btn-xs btn-default">
							<span class="glyphicon glyphicon-remove-sign"></span>
						</a>
					</td>
				</tr>
				<?php while($child = mysqli_fetch_assoc($cresult)): ?>
				<tr class="bg-info">
					<td><?=$child['categorie'];?></td>
					<td><?=$parent['categorie'];?></td>
					<td>
						<a href="categories.php?edit=<?=$child['id'];?>" class="btn btn-xs btn-default">
							<span class="glyphicon glyphicon-pencil"></span>
						</a>
						<a href="categories.php?delete=<?=$child['id'];?>" class="btn btn-xs btn-default">
							<span class="glyphicon glyphicon-remove-sign"></span>
						</a>
					</td>
				</tr>
				<?php endwhile;?>
				<?php endwhile;?>
			</tbody>
		</table>
	</div>
</div>


<?php
	include 'includes/footer.php';?>