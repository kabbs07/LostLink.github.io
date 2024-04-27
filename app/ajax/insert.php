<?php 

session_start();

# check if the user is logged in
if (isset($_SESSION['username'])) {

	if (isset($_POST['message']) &&
        isset($_POST['to_id'])) {
	
	# database connection file
	include '../db.conn.php';

	# get data from XHR request and store them in var
	$message = $_POST['message'];
	$to_id = $_POST['to_id'];

	# get the logged in user's username from the SESSION
	$from_id = $_SESSION['user_id'];

	$sql = "INSERT INTO 
	       chats (from_id, to_id, message) 
	       VALUES (?, ?, ?)";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("iis", $from_id, $to_id, $message);
	$res  = $stmt->execute();
    
    # if the message inserted
    if ($conn->affected_rows > 0) {
    	/**
       check if this is the first
       conversation between them
       **/
       $sql2 = "SELECT * FROM conversations
               WHERE (user_1=? AND user_2=?)
               OR    (user_2=? AND user_1=?)";
       $stmt2 = $conn->prepare($sql2);
	   $stmt2->bind_param("iiii", $from_id, $to_id, $from_id, $to_id);
	   $stmt2->execute();

	   $result = $stmt2->get_result();

	    // setting up the time Zone
		// It Depends on your location or your P.c settings
		define('TIMEZONE', 'Africa/Addis_Ababa');
		date_default_timezone_set(TIMEZONE);

		$time = date("h:i:s a");

		if ($result->num_rows == 0 ) {
			# insert them into conversations table 
			$sql3 = "INSERT INTO 
			         conversations(user_1, user_2)
			         VALUES (?,?)";
			$stmt3 = $conn->prepare($sql3); 
			$stmt3->bind_param("ii", $from_id, $to_id);
			$stmt3->execute();
		}
		?>

		<p class="rtext align-self-end
		          border rounded p-2 mb-1">
		    <?=$message?>  
		    <small class="d-block"><?=$time?></small>      	
		</p>

    <?php 
     }
  }
}else {
	header("Location: ../../index.php");
	exit;
}
?>
