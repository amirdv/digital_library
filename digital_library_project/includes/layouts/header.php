<?php 
	if (!isset($layout_context)) {
		$layout_context = "public";
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
	<head>
		<title>Digital Library <?php if ($layout_context == "admin") { echo "Admin"; } ?></title>
		<link href="stylesheets/public.css" media="all" rel="stylesheet" type="text/css" />
	</head>
	<body>
    <div id="header">
      <h1>Digital Library <?php if ($layout_context == "admin") { echo "Admin"; } ?></h1>
       <div class="sign_up">
      <ul>
      <li><a href="login.php"><span>SIGN UP / LOGIN</span></a></li>
      </ul>
      </div>
    </div>
