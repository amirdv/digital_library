<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_logged_in(); ?>

<?php
if (isset($_POST['submit'])) {
	// Process the form
	
	$category_name = mysql_prep($_POST["category_name"]);
	$visible = (int) $_POST["visible"];
	$position = (int) $_POST["position"];
	
	
	// validations
	$required_fields = array("category_name", "visible", "position");
	validate_presences($required_fields);
	
	$fields_with_max_lengths = array("category_name" => 30);
	validate_max_lengths($fields_with_max_lengths);
	
	if (!empty($errors)) {
		$_SESSION["errors"] = $errors;
		redirect_to("new_category.php");
	}
	
	$query  = "INSERT INTO yb_category (";
	$query .= "  category_name, visible, position";
	$query .= ") VALUES (";
	$query .= "  '{$category_name}', {$visible}, {$position}";
	$query .= ")";
	$result = mysqli_query($connection, $query);

	if ($result) {
		// Success
		$_SESSION["message"] = "Category created.";
		redirect_to("manage_content.php");
	} else {
		// Failure
		$_SESSION["message"] = "Category creation failed.";
		redirect_to("new_category.php");
	}
	
} else {
	// This is probably a GET request
	redirect_to("new_category.php");
}

?>


<?php
	if (isset($connection)) { mysqli_close($connection); }
?>
