<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_logged_in(); ?>

<?php find_selected_book(); ?>

<?php
  // Can't add a new book unless we have a category as a parent!
  if (!$current_category) {
    // category ID was missing or invalid or 
    // category couldn't be found in database
   //redirect_to("manage_content.php");
  }
?>

<?php
if (isset($_POST['submit'])) {
  // Process the form
  
  // validations
  $required_fields = array("category_name", "author_name", "release_date", "content" );
  validate_presences($required_fields);
  
  // $fields_with_max_lengths = array("category_name" => 30);
  // validate_max_lengths($fields_with_max_lengths);
  
  if (empty($errors)) {
    // Perform Create

    // make sure you add the category_id!
    $category_id = $current_category["id"];
    $category_name = mysql_prep($_POST["category_name"]);
    $author_name = mysql_prep($_POST["author_name"]);
    $release_date = "NOW()";
    // be sure to escape the content
    $content = mysql_prep($_POST["content"]);
 

  
    $query  = "INSERT INTO yb_books (";
    $query .= "  category_id, category_name, author_name, release_date, content";
    $query .= ") VALUES (";
    $query .= "  {$category_id}, '{$category_name}', '{$author_name}', {$release_date}, '{$content}'";
    $query .= ")";
    //echo $query;
    //exit;
    $result = mysqli_query($connection, $query);

    if ($result) {
      // Success
      $_SESSION["message"] = "Book created.";
      redirect_to("manage_content.php?category=" . urlencode($current_category["id"]));
    } else {
      // Failure
      $_SESSION["message"] = "Book creation failed.";
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
    
    <h2>Create Book</h2>
    <form action="new_book.php?category=<?php echo urlencode($current_category["id"]); ?>" method="post">
      <p>Book name:
        <input type="text" name="category_name" value="" />
      </p>
       <p>Author Name:
        <input type="text" name="author_name" value="" />
      </p>
      <p>Release Date:
        <input type="date" name="release_date" value="" />
      </p>



      <p>Summary:<br />
        <textarea name="content" rows="20" cols="80"></textarea>
      </p>
      <input type="submit" name="submit" value="Create Book" />
    </form>
    <br />
    <a href="manage_content.php?category=<?php echo urlencode($current_category["id"]); ?>">Cancel</a>
  </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
