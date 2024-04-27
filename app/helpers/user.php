<?php

function getUser($username, $conn)
{
        $sql = "SELECT * FROM users 
                WHERE username=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();
                return $user;
        } else {
                $user = [];
                return $user;
        }
}
