<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <link rel="icon" href="favicon.ico"/>

    <script src="https://kit.fontawesome.com/d16b2c473e.js" crossorigin="anonymous"></script>

    <style>

      body::-webkit-scrollbar {
        display: none;
      }
      
      body {
        color: #777;
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
        scroll-behavior: smooth;
      }

      .nav-link {
        cursor: pointer;
      }

      
    </style>
    
    <title>MedDocs</title>
  </head>
  <body class="pb-5">
        
    <?php require_once "src/Core/Session.php"; ?>

    <?php include_once "src/Views/layouts/navbar.php"; ?>


    <?php 
  
      $error = Application::$app->session->getFlash('error'); 
      if(isset($error)) {
        include_once "src/Views/layouts/message.php";
      }
    ?>

    <div class="container mt-5">
      {{content}}
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="assets/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>