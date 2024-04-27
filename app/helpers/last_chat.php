<?php 

function lastChat($id_1, $id_2, $conn){
   
   $sql = "SELECT * FROM chats
           WHERE (from_id=? AND to_id=?)
           OR    (to_id=? AND from_id=?)
           ORDER BY chat_id DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id_1, $id_2, $id_1, $id_2]);

    $chat = $stmt->fetch(); // Fetch the chat directly

    if (is_array($chat)) { // Check if $chat is an array
        return $chat['message'];
    } else {
        return '';
    }
}
?>
