<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>

<?php
  $current_book = find_book_by_id($_GET["book"], false);
  if (!$current_book) {
    // book ID was missing or invalid or 
    // book couldn't be found in database
    redirect_to("manage_content.php");
  }
  
  $id = $current_book["id"];
  $query = "DELETE FROM yb_books WHERE id = {$id} LIMIT 1";
  $result = mysqli_query($connection, $query);

  if ($result && mysqli_affected_rows($connection) == 1) {
    // Success
    $_SESSION["message"] = "book deleted.";
    redirect_to("manage_content.php");
  } else {
    // Failure
    $_SESSION["message"] = "book deletion failed.";
    redirect_to("manage_content.php?book={$id}");
  }
  
?>
