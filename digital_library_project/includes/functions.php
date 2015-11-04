<?php

	/**
	 * This will redirect to new given location in param
	 * @author Amir Hamzeh
	 * @param  new_location where we will redirect from current location
	 */ 
	function redirect_to($new_location) {
	  header("Location: " . $new_location);
	  exit;
	}


	/**
	 * This will make string safe for db
	 * @author Amir Hamzeh
	 * @param  string to be given to make safe for db
	 * @return Status
	 */ 
	// comment
	function mysql_prep($string) {
		global $connection;
		
		$escaped_string = mysqli_real_escape_string($connection, $string);
		return $escaped_string;
	}
		// comment

	/**
	 * This will show if query return the result set.
	 * @author Amir Hamzeh
	 * @param result_set is a result against a query
	 */ 
	function confirm_query($result_set) {
		if (!$result_set) {
			die("Database query failed.");
		}
	}

	/**
	 * This will if any feild left empty or wrong 
	 * @author Amir Hamzeh
	 * @param  errors show the errors in array 
	 * @return to output
	 */ 
	function form_errors($errors=array()) {
		$output = "";
		if (!empty($errors)) {
		  $output .= "<div class=\"error\">";
		  $output .= "Please fix the following errors:";
		  $output .= "<ul>";
		  foreach ($errors as $key => $error) {
		    $output .= "<li>";
				$output .= htmlentities($error);
				$output .= "</li>";
		  }
		  $output .= "</ul>";
		  $output .= "</div>";
		}
		return $output;
	}
	

	/**
	 * This will select the data from db for the category
	 * @author Amir Hamzeh
	 */ 
	function find_all_category($public=true) {
		global $connection;
		
		$query  = "SELECT * ";
		$query .= "FROM yb_category ";
		if ($public) {
			$query .= "WHERE visible = 1 ";
		}
		$query .= "ORDER BY position ASC";
		$category_set = mysqli_query($connection, $query);
		confirm_query($category_set);
		return $category_set;
	}
	
	/**
	 * This will select and show the books in category using its id
	 * @param  category_id for all categories
	 * @return  to book_set 
	 */ 
	function find_books_for_category($category_id, $public=true) {
		global $connection;
		
		$safe_category_id = mysqli_real_escape_string($connection, $category_id);
		
		$query  = "SELECT * ";
		$query .= "FROM yb_books ";
		$query .= "WHERE category_id = {$safe_category_id} ";
		if ($public) {
			$query .= "AND visible = 1 ";
		}
		$book_set = mysqli_query($connection, $query);
		confirm_query($book_set);
		return $book_set;
	}
	
/**
	 * This will find all the users
	 * @return to user_set
	 */ 
	function find_all_users() {
		global $connection;
		
		$query  = "SELECT * ";
		$query .= "FROM yb_users ";
		$query .= "ORDER BY username ASC";
		$user_set = mysqli_query($connection, $query);
		confirm_query($user_set);
		return $user_set;
	}
	
	/**
	 * This will find the category by id
	 * @param  category_id for particular category
	 * @return to category or null
	 */ 
	function find_category_by_id($category_id, $public=true) {
		global $connection;
		
		$safe_category_id = mysqli_real_escape_string($connection, $category_id);
		
		$query  = "SELECT * ";
		$query .= "FROM yb_category ";
		$query .= "WHERE id = {$safe_category_id} ";
		if ($public) {
			$query .= "AND visible = 1 ";
		}
		$query .= "LIMIT 1";
		$category_set = mysqli_query($connection, $query);
		confirm_query($category_set);
		if($category = mysqli_fetch_assoc($category_set)) {
			return $category;
		} else {
			return null;
		}
	}

/**
	 * This will find the book by id
	 * @param  book_id for particualar books
	 * @return to book or null
	 */ 
	function find_book_by_id($book_id, $public=true) {
		global $connection;
		
		$safe_book_id = mysqli_real_escape_string($connection, $book_id);
		
		$query  = "SELECT * ";
		$query .= "FROM yb_books ";
		$query .= "WHERE id = {$safe_book_id} ";
		if ($public) {
			$query .= "AND visible = 1 ";
		}
		$query .= "LIMIT 1";
		$book_set = mysqli_query($connection, $query);
		confirm_query($book_set);
		if($book = mysqli_fetch_assoc($book_set)) {
			return $book;
		} else {
			return null;
		}
	}

/**
	 * This will find the user by id for ediiting or change the username in edit user page
	 * @param  user_id to be used in escape_string parameter to keep user db safe
	 * @return to user or null
	 */ 
	function find_user_by_id($user_id) {
		global $connection;
		
		$safe_user_id = mysqli_real_escape_string($connection, $user_id);
		
		$query  = "SELECT * ";
		$query .= "FROM yb_users ";
		$query .= "WHERE id = {$safe_user_id} ";
		$query .= "LIMIT 1";
		$user_set = mysqli_query($connection, $query);
		confirm_query($user_set);
		if($user = mysqli_fetch_assoc($user_set)) {
			return $user;
		} else {
			return null;
		}
	}

/**
	 * This will find_default_book_for_category
	 * @param  category_id ref to the default book for category
	 * @return book listing or null
	 */ 
	function find_default_book_for_category($category_id) {
		$book_set = find_books_for_category($category_id);
		if($first_book = mysqli_fetch_assoc($book_set)) {
			return $first_book;
		} else {
			return null;
		}
	}
	
	/**
	 * This will select data for the current book or current category  
	 * @param 
	 */ 
	function find_selected_book($public=false) {
		global $current_category;
		global $current_book;
		
		if (isset($_GET["category"])) {
			$current_category = find_category_by_id($_GET["category"], $public);
			if ($current_category && $public) {
				$current_book = find_default_book_for_category($current_category["id"]);
			} else {
				$current_book = null;
			}
		} elseif (isset($_GET["book"])) {
			$current_category = null;
			$current_book = find_book_by_id($_GET["book"], $public);
		} else {
			$current_category = null;
			$current_book = null;
		}
	}

	/**
	 * This navigation will shown to registered users
	 * @param  category_array where category list are shown in menu
	 * @param  book_array where category list are shown menu
	 * @return to output
	 */ 
	function navigation($category_array, $book_array) {
		$output = "<ul class=\"category\">";
		$category_set = find_all_category(false);
		while($category = mysqli_fetch_assoc($category_set)) {
			$output .= "<li";
			if ($category_array && $category["id"] == $category_array["id"]) {
				$output .= " class=\"selected\"";
			}
			$output .= ">";
			$output .= "<a href=\"manage_content.php?category=";
			$output .= urlencode($category["id"]);
			$output .= "\">";
			$output .= htmlentities($category["category_name"]);
			$output .= "</a>";
			
			$book_set = find_books_for_category($category["id"], false);
			$output .= "<ul class=\"books\">";
			while($book = mysqli_fetch_assoc($book_set)) {
				$output .= "<li";
				if ($book_array && $book["id"] == $book_array["id"]) {
					$output .= " class=\"selected\"";
				}
				$output .= ">";
				$output .= "<a href=\"manage_content.php?book=";
				$output .= urlencode($book["id"]);
				$output .= "\">";
				$output .= htmlentities($book["category_name"]);
				$output .= "</a></li>";
			}
			mysqli_free_result($book_set);
			$output .= "</ul></li>";
		}
		mysqli_free_result($category_set);
		$output .= "</ul>";
		return $output;
	}

	/**
	 * This navigation will shown to all website's visitors	 *
	 * @param  category_array showing the list of all categories list menu
	 * @param  book_array showing the list of all books list menu
	 * @return output
	 */ 
	function public_navigation($category_array, $book_array) {
		$output = "<ul class=\"category\">";
		$category_set = find_all_category();
		while($category = mysqli_fetch_assoc($category_set)) {
			$output .= "<li";
			if ($category_array && $category["id"] == $category_array["id"]) {
				$output .= " class=\"selected\"";
			}
			$output .= ">";
			$output .= "<a href=\"index.php?category=";
			$output .= urlencode($category["id"]);
			$output .= "\">";
			$output .= htmlentities($category["category_name"]);
			$output .= "</a>";
			
			if ($category_array["id"] == $category["id"] || 
					$book_array["category_id"] == $category["id"]) {
				$book_set = find_books_for_category($category["id"]);
				$output .= "<ul class=\"books\">";
				while($book = mysqli_fetch_assoc($book_set)) {
					$output .= "<li";
					if ($book_array && $book["id"] == $book_array["id"]) {
						$output .= " class=\"selected\"";
					}
					$output .= ">";
					$output .= "<a href=\"index.php?book=";
					$output .= urlencode($book["id"]);
					$output .= "\">";
					$output .= htmlentities($book["category_name"]);
					$output .= "</a></li>";
				}
				$output .= "</ul>";
				mysqli_free_result($book_set);
			}

			$output .= "</li>"; // end of the subject li
		}
		mysqli_free_result($category_set);
		$output .= "</ul>";
		return $output;
	}

/**
	 * This function will encrypted password
	 * @param  password of username to be encrypted in db
	 * @return hash value
	 */ 
	function password_encrypt($password) {
  	$hash_format = "$2y$10$";   // Tells PHP to use Blowfish with a "cost" of 10
	  $salt_length = 22; 					// Blowfish salts should be 22-characters or more
	  $salt = generate_salt($salt_length);
	  $format_and_salt = $hash_format . $salt;
	  $hash = crypt($password, $format_and_salt);
		return $hash;
	}
	
	/** 
	 * This will generate salt value for the password entered with given length
	 * @param  length specified length for password
	 * @return salt value
	 */ 
	function generate_salt($length) {
	  // Not 100% unique, not 100% random, but good enough for a salt
	  // MD5 returns 32 characters
	  $unique_random_string = md5(uniqid(mt_rand(), true));
	  
		// Valid characters for a salt are [a-zA-Z0-9./]
	  $base64_string = base64_encode($unique_random_string);
	  
		// But not '+' which is valid in base64 encoding
	  $modified_base64_string = str_replace('+', '.', $base64_string);
	  
		// Truncate string to the correct length
	  $salt = substr($modified_base64_string, 0, $length);
	  
		return $salt;
	}
	

/**
	 * find user by name for login page
	 * @param  string Username, will martch from page 
	 * @return to user or null
	 */ 
	function find_user_by_username($username) {
		global $connection;
		
		$safe_username = mysqli_real_escape_string($connection, $username);
		
		$query  = "SELECT * ";
		$query .= "FROM yb_users ";
		$query .= "WHERE username = '{$safe_username}' ";
		$query .= "LIMIT 1";
		$user_set = mysqli_query($connection, $query);
		confirm_query($user_set);
		if($user = mysqli_fetch_assoc($user_set)) {
			return $user;
		} else {
			return null;
		}
	}


	/**
	 * This will check password if is matched with hash or not	 *
	 * @param  password of username
	 * @param  existing_hash in db
	 */ 
	function password_check($password, $existing_hash) {
		// existing hash contains format and salt at start
	  $hash = crypt($password, $existing_hash);
	  if ($hash === $existing_hash) {
	    return true;
	  } else {
	    return false;
	  }
	}

/**
	 * This will attempt login with given credentials 
	 * @param  password & email as entered by user on form
	 */ 
	function attempt_login($username, $password) {
		$user = find_user_by_username($username);
		if ($user) {
			// found admin, now check password
			if (password_check($password, $user["hashed_password"])) {
				// password matches
				return $user;
			} else {
				// password does not match
				return false;
			}
		} else {
			// admin not found
			return false;
		}
	}
/**
	 * This will verfiy that user is login in 
	 */ 
	function logged_in() {
		return isset($_SESSION['user_id']);
	}
	
	/**
	 * This will redirect to login page if it is not login.
	 * @param  
	 */ 
	function confirm_logged_in() {
		if (!logged_in()) {
			redirect_to("login.php");
		}
	}

?>