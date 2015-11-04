<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_logged_in(); ?>

<?php find_selected_book(); ?>

<?php
	if (!$current_category) {
		// category ID was missing or invalid or 
		// category couldn't be found in database
		redirect_to("manage_content.php");
	}
?>

<?php
if (isset($_POST['submit'])) {
	// Process the form

	// validations
	$required_fields = array("category_name", "visible", "position");
	validate_presences($required_fields);
		
	if (empty($errors)) {
		
		// Perform Update

		$id = $current_category["id"];
		$category_name = mysql_prep($_POST["category_name"]);
		$visible = (int) $_POST["visible"];
		$position = (int) $_POST["position"];
	
		$query  = "UPDATE yb_category SET ";
		$query .= "category_name = '{$category_name}', ";
		$query .= "visible = {$visible}, ";
		$query .= "position = {$position} ";
		// last culom in the $query dosent get , at the end like {$position} in above 
		$query .= "WHERE id = {$id} ";
		$query .= "LIMIT 1";
		//echo $query;
		//exit;
		// we use echo $query only after last $query like above example,then copy the arry and past it on the table on mysql
		$result = mysqli_query($connection, $query);

		if ($result && mysqli_affected_rows($connection) >= 0) {
			// Success
			$_SESSION["message"] = "Category updated.";
			redirect_to("manage_content.php");
		} else {
			// Failure
			$message = "Category update failed.";
		}
	
	}
} else {
	// This is probably a GET request
	
} // end: if (isset($_POST['submit']))
   

?>

<?php $layout_context = "user"; ?>
<?php include("../includes/layouts/header.php"); ?>

<div id="main">
  <div id="navigation">
		<?php echo navigation($current_category, $current_book); ?>
  </div>
  <div id="page">
		<?php // $message is just a variable, doesn't use the SESSION
			if (!empty($message)) {
				echo "<div class=\"message\">" . htmlentities($message) . "</div>";
			}
		?>
		<?php echo form_errors($errors); ?>
		
		<h2>Edit category: <?php echo htmlentities($current_category["category_name"]); ?></h2>
		<form action="edit_category.php?category=<?php echo urlencode($current_category["id"]); ?>" method="post">
		  <p>Book name:
		    <input type="text" name="category_name" value="<?php echo htmlentities($current_category["category_name"]); ?>" />
		  </p>
		  <p>Position:
		    <select name="position">
				<?php
					$category_set = find_all_category(false);
					$category_count = mysqli_num_rows($category_set);
					for($count=1; $count <= $category_count; $count++) {
						echo "<option value=\"{$count}\"";
						if ($current_category["position"] == $count) {
							echo " selected";
						}
						echo ">{$count}</option>";
					}
				?>
		    </select>
		  </p>
		  <p>Visible:
		    <input type="radio" name="visible" value="0" <?php if ($current_category["visible"] == 0) { echo "checked"; } ?> /> No
		    &nbsp;
		    <input type="radio" name="visible" value="1" <?php if ($current_category["visible"] == 1) { echo "checked"; } ?>/> Yes
		  </p>
		  <input type="submit" name="submit" value="Edit Category" />
		</form>
		<br />
		<a href="manage_content.php">Cancel</a>
		&nbsp;
		&nbsp;
		<a href="delete_category.php?category=<?php echo urlencode($current_category["id"]); ?>" onclick="return confirm('Are you sure?');">Delete category</a>
		
	</div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
