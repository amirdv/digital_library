<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>

<?php
	$current_category = find_category_by_id($_GET["category"], false);
	if (!$current_category) {
		// category ID was missing or invalid or 
		// category couldn't be found in database
		redirect_to("manage_content.php");
	}
	
	$book_set = find_books_for_category($current_category["id"], false);
	if (mysqli_num_rows($books_set) > 0) {
		$_SESSION["message"] = "Can't delete a category with books.";
		redirect_to("manage_content.php?category={$current_category["id"]}");
	}
	
	$id = $current_category["id"];
	$query = "DELETE FROM yb_category WHERE id = {$id} LIMIT 1";
	$result = mysqli_query($connection, $query);

	if ($result && mysqli_affected_rows($connection) == 1) {
		// Success
		$_SESSION["message"] = "category deleted.";
		redirect_to("manage_content.php");
	} else {
		// Failure
		$_SESSION["message"] = "category deletion failed.";
		redirect_to("manage_content.php?category={$id}");
	}
	
?>
