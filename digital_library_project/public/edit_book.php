<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_logged_in(); ?>

<?php find_selected_book(); ?>

<?php
  // Unlike new_book.php, we don't need a category_id to be sent
  // We already have it stored in books.category_id.
  if (!$current_book) {
    // book ID was missing or invalid or 
    // book couldn't be found in database
    redirect_to("manage_content.php");
  }
?>

<?php
if (isset($_POST['submit'])) {
  // Process the form
  
  $id = $current_book["id"];
  $category_name = mysql_prep($_POST["category_name"]);
  $author_name = mysql_prep($_POST["author_name"]);
  $release_date = mysql_prep($_POST["release_date"]);
  $content = mysql_prep($_POST["content"]);

  // validations
  $required_fields = array("category_name", "author_name", "release_date", "content");
  validate_presences($required_fields);
  
  $fields_with_max_lengths = array("category_name" => 30);
  validate_max_lengths($fields_with_max_lengths);
  
  if (empty($errors)) {
    
    // Perform Update

    $query  = "UPDATE yb_books SET ";;
    $query .= "category_name = '{$category_name}', ";
    $query .= "author_name = '{$author_name}', ";
    $query .= "release_date = '{$release_date}', ";
    $query .= "content = '{$content}' ";
    $query .= "WHERE id = {$id} ";
    $query .= "LIMIT 1";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_affected_rows($connection) == 1) {
      // Success
      $_SESSION["message"] = "Book updated.";
      redirect_to("manage_content.php?book={$id}");
    } else {
      // Failure
      $_SESSION["message"] = "Book update failed.";
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
    <?php echo message(); ?>
    <?php echo form_errors($errors); ?>
    
    <h2>Edit Book: <?php echo htmlentities($current_book["category_name"]); ?></h2>
    <form action="edit_book.php?book=<?php echo urlencode($current_book["id"]); ?>" method="post">
      <p>Book name:
        <input type="text" name="category_name" value="<?php echo htmlentities($current_book["category_name"]); ?>" />
      </p>
    <p>Author Name:
        <input type="text" name="author_name" value="" />
      </p>
      <p>Release Date:
        <input type="date" name="release_date" value="" />
      </p>
    
      <p>Content:<br />
        <textarea name="content" rows="20" cols="80"><?php echo htmlentities($current_book["content"]); ?></textarea>
      </p>
      <input type="submit" name="submit" value="Edit Book" />
    </form>
    <br />
    <a href="manage_content.php?book=<?php echo urlencode($current_book["id"]); ?>">Cancel</a>
    &nbsp;
    &nbsp;
    <a href="delete_book.php?book=<?php echo urlencode($current_book["id"]); ?>" onclick="return confirm('Are you sure?');">Delete book</a>
    
  </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
