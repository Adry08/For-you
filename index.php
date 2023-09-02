<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // $nomStocke = "NomStocke"; // Remplacez par le nom stocké
  // $prenomStocke = "PrenomStocke"; // Remplacez par le prénom stocké
  // $dateStocke = "DateStocke"; // Remplacez par la date d'anniversaire stockée (au format yyyy-mm-dd)
  // $mdpStocke = "MotDePasseStocke"; // Remplacez par le mot de passe stocké

  $phoneStocke = "0323658131";

  if (preg_match("#^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$#", $_POST["name"])) {
    $name = $_POST["name"];
  }
  if (preg_match("#^[a-zA-Z0-9.-_]+[@]{1}[a-zA-Z0-9.-_]+[.]{1}[a-z]{2,10}$#", $_POST["email"])) {
    $email = $_POST["email"];
  }
  if (preg_match("#^[0-9]*$#", $_POST["phone"])) {
    $phone = $_POST["phone"];
  }


  $dossierJson = './data/';

  $data = "./data/jsonLoger.json";

  if (isset($data)) {

    $datajson = file_get_contents($data);

    // echo $datajson;

    $loger =  json_decode($datajson, JSON_PRETTY_PRINT);
  } else {
    $logers = [];


  }


  $loger[] = [
    'name' => $name,
    'email' => $email,
    'phone' => $phone,
    'date' => date('Y-m-d H:i:s'),
  ];

  $jsonLoger = json_encode($loger, JSON_PRETTY_PRINT);

  $cheminFichierJsonLoger = $dossierJson.'jsonLoger.json';

  if (!is_dir($dossierJson)) {
    mkdir($dossierJson, 0777, true);
  }

  file_put_contents($cheminFichierJsonLoger, $jsonLoger);


  if ($phone === $phoneStocke) {
    session_start();
    $_SESSION['user'] = $name;

    header("Location: text.php");
    exit();
  } else {
    session_start();
    $_SESSION['user'] = 'public';

    header("Location: galery.php");
    exit();
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>Page d'accueil</title>
</head>

<style>
  /* @import url("https://fonts.googleapis.com/css?family=Fjalla+One&display=swap"); */

  * {
    margin: 0;
    padding: 0;
  }

  body {
    background: url("./asset/indexBg.webp") center center no-repeat;
    background-size: cover;
    width: 100vw;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .container {
    background: #f8f4e5;
    padding: 50px 100px;
    border: 2px solid black;
    box-shadow: 15px 15px 1px #ffa580, 15px 15px 1px 2px black;
    min-height: 200px;
    min-width: 200px;
  }

  .input {
    margin-bottom: 40px;
  }

  input {
    display: block;
    width: 100%;
    font-size: x-large;
    line-height: 1.5rem;
    font-family: "Courier New", Courier, monospace;
    border: none;
    border-bottom: 5px solid black;
    background: #f8f4e5;
    min-width: 150px;
    padding-left: 5px;
    outline: none;
    color: black;
  }

  input:focus {
    border-bottom: 5px solid #ffa580;
  }

  button {
    display: block;
    margin: 0 auto;
    line-height: 28px;
    padding: 0 20px;
    background: #ffa580;
    letter-spacing: 2px;
    transition: 0.2s all ease-in-out;
    outline: none;
    border: 1px solid black;
    box-shadow: 3px 3px 1px 1px #95a4ff, 3px 3px 1px 2px black;
    cursor: pointer;
  }

  button:hover {
    background: black;
    color: white;
    border: 1px solid black;
  }

  ::selection {
    background: #ffc8ff;
  }

  input:-webkit-autofill,
  input:-webkit-autofill:hover,
  input:-webkit-autofill:focus {
    border-bottom: 5px solid #95a4ff;
    -webkit-text-fill-color: #2a293e;
    box-shadow: 0 0 0px 1000px #f8f4e5 inset;
    -webkit-box-shadow: 0 0 0px 1000px #f8f4e5 inset;
    transition: background-color 5000s ease-in-out 0s;
  }

  @media (max-width: 500px) {
    .container {
      padding: 25px 50px;
      min-width: 100px;
      margin: 10px;
    }
  }

  @media (max-width: 300px) {
    .container {
      padding: 12.5px 25px;
      min-width: 50px;
      margin: 5px;
    }
  }

  .input small {
    visibility: hidden;
    color: red;
  }
</style>

<body>
  <main>
    <div class="container">
      <form method="post" id="login">
        <div class="input">
          <input placeholder="Name" required="" type="text" name="name" />
          <small>Incorect Name</small>
        </div>
        <div class="input">
          <input name="email" placeholder="Email" type="email" />
          <small>Incorect email</small>
        </div>
        <div class="input">
          <input name="phone" placeholder="Phone" type="tel" />
          <small>Incorect Number</small>
        </div>

        <button type="submit">SIGN UP</button>
      </form>
    </div>
  </main>

  <script>
    const form = document.querySelector("#login");
    form.addEventListener('submit', (e) => {
      e.preventDefault();
      if (valideName(form.name) && valideEmail(form.email) && validePhone(form.phone)) {
        form.submit();
      }
    })
    form.name.addEventListener("change", function() {
      valideName(this);
    });
    const valideName = (name) => {
      let nameRegExp = new RegExp(/^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$/, "g");
      let testName = nameRegExp.test(name.value);
      let small = name.nextElementSibling;
      if (testName) {
        small.style.visibility = "hidden";
        return true;
      } else {
        small.style.visibility = "visible";
        return false;
      }
    }
    form.email.addEventListener("change", function() {
      valideEmail(this)
    });
    const valideEmail = (email) => {
      let emailRegExp = new RegExp(/^[a-zA-Z0-9.-_]+[@]{1}[a-zA-Z0-9.-_]+[.]{1}[a-z]{2,10}$/, "g");
      let testEmail = emailRegExp.test(email.value);
      let small = email.nextElementSibling;
      if (testEmail) {
        small.style.visibility = "hidden";
        return true
      } else {
        small.style.visibility = "visible";
        return false
      }
    }
    form.phone.addEventListener("change", function() {
      validePhone(this);
    });
    const validePhone = (phone) => {
      let numberRegExp = new RegExp(/^[0-9]*$/, "g")
      let testNumber = numberRegExp.test(phone.value)
      let small = phone.nextElementSibling;
      if (testNumber) {
        small.style.visibility = "hidden";
        return true;
      } else {
        small.style.visibility = "visible";
        return false;
      }
    }
  </script>
</body>

</html>