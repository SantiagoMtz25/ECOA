<?php

@include 'config.php';

session_start();

if(isset($_POST['submit'])){

   // Retrieve the email and password from the table
   $name = isset($_POST['name']) ? mysqli_real_escape_string($conn, $_POST['name']) : '';
   $email = mysqli_real_escape_string($conn, $_POST['email']); // Replace with the email input field name
   $pass = $_POST['password']; // Replace with the password input field name
    
   $FK_ID_user = isset($_POST['FK_ID_user']) ? $_POST['FK_ID_user'] : '';
   $short_email = strstr($email, '@', true);

   $select = "SELECT * FROM credenciales WHERE email = '$email' && password = '$pass'";
   $result = mysqli_query($conn, $select);

   // Check if the email exists in the table
   if (mysqli_num_rows($result) > 0) {

      $row = mysqli_fetch_assoc($result);

      if($row['FK_ID_user'] == 3){

         $_SESSION['admin_name'] = $row['name'];
         sleep(1);
         header('location:admin_page1.php');

      } elseif ($row['FK_ID_user'] == 1){

         // Negarle acceso si no tiene encuestas disponibles
         $store_procedure = "CALL crn_Activo_Por_matricula('$short_email')";
         $result1 = mysqli_query($conn, $store_procedure);

         if (mysqli_num_rows($result1) >= 1) {
            $ruta_archivo = "mi_archivo.txt";
            file_put_contents($ruta_archivo, $short_email);

            $_SESSION['user_name'] = $row['name'];
            $_SESSION['matri'] = $row['email'];
        
            //$select_matri = "UPDATE login_matri SET login = 1 WHERE matri_log = '$short_email'"; 
            //$result_matri = mysqli_query($conn, $select_matri);
            sleep(1);
            //header("location:user_page.php?matricula=$short_email");
            header("location:user_page.php");
            
         } else {
            $error[] = 'No tienes encuestas disponibles, intente más tarde';
            
            /*$message = "No tienes encuestas disponibles, intenta más tarde.";
            echo "<script>alert('$message');</script>";
            header('location:file_test.php');*/
         }

         /*if ($result1) {
            $_SESSION['user_name'] = $row['name'];
            header('location:user_page.php');

         } else {
            echo "<script>alert('No tienes encuestas disponibles para realizar, vuelve más tarde.');</script>";
            header('location:file_test.php');

         }*/

      } elseif ($row['FK_ID_user'] == 2){

         $_SESSION['profesor_name'] = $row['name'];
         $_SESSION['nomina'] = $row['email'];
         sleep(1);
         header('location:profesor_page.php');

      }
      
   } else {
      $error[] = 'Correo o Contraseña Incorrectos';
   }
}

?> 

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login | ECOA</title>
   <link rel="icon" type="image/png" href="tec.png">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="login_form.css">

</head>
<body>
   
   <div class="form-container">

      <form action="" method="post">
         <h3>Bienvenido a la ECOA</h3>
         <h3>Iniciar Sesión</h3>
         <?php
         if(isset($error)){
            foreach($error as $error){
               echo '<span class="error-msg">'.$error.'</span>';
            };
         };
         ?>
         <input type="email" name="email" required placeholder="Ingresa tu correo">
         <input type="password" name="password" required placeholder="Ingresa tu constraseña">
         <input type="submit" name="submit" value="Inicia Sesión" class="form-btn">
         <!--<p>don't have an account? <a href="register_form.php">register now</a></p>-->
      </form>

      <div class="footer-bottom">
         <p>copyright &#169; <a href="https://tec.mx/es" target="_blank">Instituto Tecnológico y de Estudios Superiores de Monterrey</a></p>
      </div>

   </div>

</body>
</html>