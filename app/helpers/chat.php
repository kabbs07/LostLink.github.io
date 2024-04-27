<?php 

function getChats($id_1, $id_2, $conn){
   
   $sql = "SELECT * FROM chats
           WHERE (from_id=? AND to_id=?)
           OR    (to_id=? AND from_id=?)
           ORDER BY chat_id ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiii", $id_1, $id_2, $id_1, $id_2);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $chats = $result->fetch_all(MYSQLI_ASSOC);
        return $chats;
    } else {
        $chats = [];
        return $chats;
    }
}
?>
