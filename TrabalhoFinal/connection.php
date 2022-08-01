<?php
  
  $link = mysqli_connect(
      "localhost",
      "ElectionAdmin",
      "12345",
      "ELECTION"
  );

  if (mysqli_connect_error()) {
      die("Database Connection Error");
  }

?>