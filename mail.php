<?php

$passSave = "sendEmail";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (preg_match("#^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$#", $_POST["name"])) {
    $name = $_POST["name"];
  }
  if (preg_match("#^[a-zA-Z0-9.-_]+[@]{1}[a-zA-Z0-9.-_]+[.]{1}[a-z]{2,10}$#", $_POST["mail"])) {
    $mail = $_POST["mail"];
  }

  $pass = $_POST["password"];

  if ($pass === $passSave) {

    $data = "./data/jsonLoger.json";
    
    if (isset($data)) {

      $datajson = file_get_contents($data);
      mail($mail, 'dataLoger', $datajson);
      echo $datajson;
    } else {
      $datajson = "Vide";
      mail($mail, 'dataLoger', $datajson);
    }
    
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>mail</title>

  <style>
    .container {
      display: flex;
      padding: 5px 4px;
      border: solid 1px black;
      border-radius: 10px;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: fit-content;
    }

    .container input {
      border: solid 1px black;
      margin: 10px 5px;
      height: 20px;
      width: 200px;
    }

    .container div {
      text-align: center;
    }

    .container button {
      cursor: pointer;
      padding: 10px;
    }
  </style>
</head>

<body>
  <div class="container">
    <form action="" method="post">
      <div>
        <label for="name">Name</label> <br>
        <input type="text" name="name" />
      </div>

      <div>
        <label for="mail">Email</label> <br>
        <input type="email" name="mail" />
      </div>

      <div>
        <label for="password">Password</label> <br>
        <input type="password" name="password" />
      </div>

      <div>
        <button>Envoyer</button>
      </div>
    </form>
  </div>
</body>

</html>