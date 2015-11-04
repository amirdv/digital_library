<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>

<?php $layout_context = "user"; ?>
<?php include("../includes/layouts/header.php"); ?>
<?php find_selected_book(); ?>

<div id="main">
  <div id="navigation">
		<br />
		<a href="user.php">&laquo; Main menu</a><br />
		
		<?php echo navigation($current_category, $current_book); ?>
		<br />
		<a href="new_category.php">+ Add a category</a>
  </div>
  <div id="page">
		<?php echo message(); ?>
		<?php if ($current_category) { ?>
	    <h2>Manage Category</h2>
			Category name: <?php echo htmlentities($current_category["category_name"]); ?><br />
			Visible: <?php echo $current_category["visible"] == 1 ? 'yes' : 'no'; ?><br />
			Position: <?php echo $current_category["position"]; ?><br />
			<br />
			<a href="edit_category.php?category=<?php echo urlencode($current_category["id"]); ?>">Edit Category</a>
			
			<div style="margin-top: 2em; border-top: 1px solid #000000;">
				<h3>Books in this Category:</h3>
				<ul>
				<?php 
					$category_books = find_books_for_category($current_category["id"], false);
					while($book = mysqli_fetch_assoc($category_books)) {
						echo "<li>";
						$safe_book_id = urlencode($book["id"]);
						echo "<a href=\"manage_content.php?book={$safe_book_id}\">";
						echo htmlentities($book["category_name"]);
						echo "</a>";
						echo "</li>";
					}
				?>
				</ul>
				<br />
				+ <a href="new_book.php?category=<?php echo urlencode($current_category["id"]); ?>">Add a new book to this category</a>
			</div>

		<?php } elseif ($current_book) { ?>
			<h2>Manage Book</h2>
			Category name: <?php echo htmlentities($current_book["category_name"]); ?><br />
			Author Name: <?php echo htmlentities($current_book["author_name"]); ?><br />
			Release Date:<?php echo htmlentities($current_book["release_date"]); ?><br />
			Content:<br />
			<div class="view-content">
				<?php echo htmlentities($current_book["content"]); ?>
			</div>
			<br />
      <br />
      <a href="edit_book.php?book=<?php echo urlencode($current_book['id']); ?>">Edit book</a>
			
		<?php } else { ?>
			Please select a category or a book.
		<?php }?>
  </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
