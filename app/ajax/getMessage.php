<?php 

session_start();

# check if the user is logged in
if (isset($_SESSION['username'])) {

    if (isset($_POST['id_2'])) {
        # database connection file
        include '../db.conn.php';

        $id_1  = $_SESSION['user_id'];
        $id_2  = $_POST['id_2'];
        $opend = 0;

        $sql = "SELECT * FROM chats
                WHERE to_id=?
                AND   from_id= ?
                ORDER BY chat_id ASC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $id_1, $id_2);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $chats = $result->fetch_all(MYSQLI_ASSOC);

            # looping through the chats
            foreach ($chats as $chat) {
                if ($chat['opened'] == 0) {

                    $opened = 1;
                    $chat_id = $chat['chat_id'];

                    $sql2 = "UPDATE chats
                             SET opened = ?
                             WHERE chat_id = ?";
                    $stmt2 = $conn->prepare($sql2);
                    $stmt2->bind_param("ii", $opened, $chat_id);
                    $stmt2->execute();

                    ?>
                    <p class="ltext border 
					        rounded p-2 mb-1">
					    <?=$chat['message']?> 
					    <small class="d-block">
					    	<?=$chat['created_at']?>
					    </small>      	
				  </p>        
                    <?php
                }
            }
        }
    }

} else {
    header("Location: ../../index.php");
    exit;
}
?>
