<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>

<?php $layout_context = "user"; ?>
<?php include("../includes/layouts/header.php"); ?>
<?php find_selected_book(); ?>

<div id="main">
  <div id="navigation">
		<?php echo navigation($current_category, $current_book); ?>
  </div>
  <div id="page">
		<?php echo message(); ?>
		<?php $errors = errors(); ?>
		<?php echo form_errors($errors); ?>
		
		<h2>Create Category</h2>
		<form action="create_category.php" method="post">
		  <p>Category name:
		    <input type="text" name="category_name" value="" />
		  </p>
		  <p>Position:
		    <select name="position">
				<?php
					$category_set = find_all_category(false);
					$category_count = mysqli_num_rows($category_set);
					for($count=1; $count <= ($category_count + 1); $count++) {
						echo "<option value=\"{$count}\">{$count}</option>";
					}
				?>
		    </select>
		  </p>
		  <p>Visible:
		    <input type="radio" name="visible" value="0" /> No
		    &nbsp;
		    <input type="radio" name="visible" value="1" /> Yes
		  </p>
		  <input type="submit" name="submit" value="Create Category" />
		</form>
		<br />
		<a href="manage_content.php">Cancel</a>
	</div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
