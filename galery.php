
<?php 
session_start();

?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gallery</title>
    <link rel="stylesheet" href="./asset/css/style.css" />
  </head>

  <body>

  
    
    <header>
    <div id="logo">For you</div>

    <ul>
      <li><a href="./index.php"><button class="btn">Home</button></a></li>
      <?php if($_SESSION['user']!== 'public'){
        echo '<li><a href="./text.php"><button class="btn">Text</button></a></li>';
      }
        ?>
      <li><a href="./galery.php"><button class="btn">Gallery</button></a></li>

    </ul>
  </header>

  <aside>
    <nav class="nav">
      <div id="remove"></div>
      <ul>
        <li><a href="./index.php"><button class="btn">Home</button></a></li>
        <?php if($_SESSION['user']!== 'public'){
          echo '<li><a href="./text.php"><button class="btn">Text</button></a></li>';
        }
        ?>
        <li><a href="./galery.php"><button class="btn">Gallery</button></a></li>
      </ul>

    </nav>
  </aside> 

    <main>
      <div class="container" id="imageContainer">
        <div id="loading-spinner" class="loading">
          <div class="loader">
            <svg class="circular">
              <circle
                class="path"
                cx="50"
                cy="50"
                r="20"
                fill="none"
                stroke-width="2"
                stroke-miterlimit="10"
              />
            </svg>
          </div>
        </div>
      </div>
    </main>

    <script src="./asset/js/macy.js"></script>
    <script src="./asset/js/galery.js"></script>
  </body>
</html>
