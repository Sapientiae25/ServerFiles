<?php
  $servername = "localhost";
  $username = "root";
  $password = "Nelldestroyer25";
  $port = 3307;
  $database = "saloon";

  $conn = new mysqli($servername, $username, $password, $database, $port);

  // $servername = "eu-cdbr-west-01.cleardb.com";
  // $username = "bcc470549cd3b0";
  // $password = "377f4836ee7b442";
  // $database = "heroku_1c20248e9cac64c";

  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
