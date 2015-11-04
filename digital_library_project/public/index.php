<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php $layout_context = "public"; ?>
<?php include("../includes/layouts/header.php"); ?>
<?php find_selected_book(true); ?>

<div id="main">
  <div id="navigation">
		<?php echo public_navigation($current_category, $current_book); ?>
  </div>
  <div id="page">
		<?php if ($current_book) { ?>
			
			<h2><?php echo htmlentities($current_book["category_name"]); ?></h2>
			<?php echo nl2br(htmlentities($current_book["content"])); ?>
			
		<?php } else { ?>
			
			<p>Welcome!</p>
			
		<?php }?>
  </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
