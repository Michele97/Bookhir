<?php
include '../connection.php';
$title = $_POST['title'];
$email = $_GET['email'];
$oggi = date('d-m-Y');
$scadenza = date('d-m-Y', strtotime('+1 month', strtotime($oggi)));
// Query the database


$sql1 = "SELECT * FROM libri WHERE titolo LIKE '{$title}' && quantita > 0";
$result1 = mysqli_query($conn, $sql1);

$sql2 = "UPDATE libri SET quantita=quantita-1 WHERE titolo LIKE '{$title}'";
$result2 = mysqli_query($conn, $sql2);

$sql3 = "INSERT INTO noleggi (emailUtente, titoloLibro, data_noleggio, data_scadenza) VALUES ('{$email}', '{$title}', '{$oggi}', '{$scadenza}');";
$result3 = mysqli_query($conn, $sql3);

$sql4 ="SELECT * FROM libri LIMIT 4";
$result4 = mysqli_query($conn, $sql1);


?>

<!-- supponiamo che il nostro utente possa affittare un solo libro e non puo' ricaricare la pagina  -->

<!DOCTYPE html>
<html lang="en">
 
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../indexPage/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-light bg-light container-fluid">
    <img class="logo d-inline-block align-top" src="../assets/logo_libro.png" alt="Logo">
    <div class="container">
      <a class="navbar-brand" href="index.php">Bookhir</a>
    </div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  </nav>
  <br>

  <div class="container">


    <div class="center column">
      <?php


      if (mysqli_num_rows($result1) > 0) {
        // Iterate through the results and output the data
        
        while ($row = mysqli_fetch_assoc($result1)) {
          echo "<div class='boxBook center'>";
          echo "<div class='imgBook'>";
          echo "<img src='{$row["linkImmagine"]}'>";
          echo "</div>";
          echo "<h4>", $row["titolo"], "</h4>";
          echo "<h5>", $row["descrizione"], "</h5>";
          echo "</div>";

        }
        echo "<div>";
        echo "<h4> Grazie per aver nolleggiato questo libro </h4>";
        echo "</div>";
        header("refresh: 3; url=rent.php");

      } else {
        echo "<h1>Nessun risultato trovato. <h1>";
        header("refresh: 1; url=rent.php"); // the redirect goes here
        exit;
      }

      // Close the connection
      mysqli_close($conn);

      ?>
    </div>

  </div>



  <footer class="footer expand-lg bg-light container-fluid">
    <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
    </section>
    <section class="">
      <div class="container text-center text-md-start mt-5">
        <div class="row mt-3">
          <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
            <h6 class="text-uppercase fw-bold mb-4">
              <i class="fas fa-gem me-3 text-secondary"></i>Company name
            </h6>
            <p>
              Here you can use rows and columns to organize your footer content. Lorem ipsum
              dolor sit amet, consectetur adipisicing elit.
            </p>
          </div>
          <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
            <!-- Links -->
            <h6 class="text-uppercase fw-bold mb-4">
              Latest Books
            </h6>
            <?php 
           
            
            while ($row1=mysqli_fetch_assoc($result4)) {
             
              echo "<p>", $row1["titolo"], "</p>";
              
            }
            ?>
            
          </div>
          <!-- Grid column -->
<!-- Grid column -->
          <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
            <!-- Links -->
            <h6 class="text-uppercase fw-bold mb-4">
              Social media links
            </h6>
            <p>
              <a href="#!" class="text-reset">Linkedln</a>
            </p>
            <p>
              <a href="#!" class="text-reset">Instgram</a>
            </p>
            <p>
              <a href="#!" class="text-reset">Facebook</a>
            </p>
            <p>
              <a href="#!" class="text-reset">Github</a>
            </p>
          </div>
          <!-- Grid column -->

          <!-- Grid column -->
          <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
            <!-- Links -->
            <h6 class="text-uppercase fw-bold mb-4">Contact</h6>
            <p><i class="fas fa-home me-3 text-secondary"></i> Rome, Rm 12345, IT
          </p>
            <p>
              <i class="fas fa-envelope me-3 text-secondary"></i>
              bookhim@example.com
            </p>
            <p><i class="fas fa-phone me-3 text-secondary"></i> + 01 234 567 88</p>
            <p><i class="fas fa-print me-3 text-secondary"></i> + 01 234 567 89</p>
          </div>
          <!-- Grid column -->
        </div>
        <!-- Grid row -->
      </div>
    </section>
    <!-- Section: Links  -->

    <!-- Copyright -->
    <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.025);">
      © 2021 Copyright  Bookhir
    </div>
    <!-- Copyright -->

  </footer>
</body>

</html>