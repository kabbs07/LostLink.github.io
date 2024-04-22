<?php

$conn = mysqli_connect("localhost", "root", "", "bbcdb");

if (!$conn) {
    echo "Connection Failed";
}