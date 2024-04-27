<?php 

function getConversation($user_id, $conn){
  /**
    Getting all the conversations 
    for current (logged in) user
  **/
  $sql = "SELECT * FROM conversations
          WHERE user_1=? OR user_2=?
          ORDER BY conversation_id DESC";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ii", $user_id, $user_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
      $conversations = $result->fetch_all(MYSQLI_ASSOC);

      /**
        Creating an empty array to 
        store the user conversation
      **/
      $user_data = [];
      
      # Looping through the conversations
      foreach ($conversations as $conversation) {
          # Fetching user data based on user_1 or user_2
          $target_user_id = ($conversation['user_1'] == $user_id) ? $conversation['user_2'] : $conversation['user_1'];
          
          $sql2  = "SELECT *
                    FROM users WHERE user_id=?";
          $stmt2 = $conn->prepare($sql2);
          $stmt2->bind_param("i", $target_user_id);
          $stmt2->execute();
          $userData = $stmt2->get_result()->fetch_assoc();
          
          if ($userData) {
              # Pushing the data into the array 
              array_push($user_data, $userData);
          }
      }
  
      return $user_data;
  } else {
      $conversations = [];
      return $conversations;
  }
}
