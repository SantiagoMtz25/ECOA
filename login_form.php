<?php

//Login vijo file_test es el actualizado
@include 'config.php';

session_start();

if(isset($_POST['submit'])){

   // $name = mysqli_real_escape_string($conn, $_POST['name']);
   $name = isset($_POST['name']) ? mysqli_real_escape_string($conn, $_POST['name']) : '';
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = md5($_POST['password']);
   //$cpass = md5($_POST['cpassword']);
   $cpass = isset($_POST['cpassword']) ? md5($_POST['cpassword']) : '';
   //$user_type = $_POST['user_type'];
   $user_type = isset($_POST['user_type']) ? $_POST['user_type'] : '';

   $select = " SELECT * FROM user_form WHERE email = '$email' && password = '$pass' ";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){

      $row = mysqli_fetch_array($result);

      if($row['user_type'] == 'admin'){

         $_SESSION['admin_name'] = $row['name'];
         header('location:admin_page.php');

      }elseif($row['user_type'] == 'user'){

         $_SESSION['user_name'] = $row['name'];
         header('location:user_page.php');

      }elseif($row['user_type'] == 'profesor'){

         $_SESSION['profesor_name'] = $row['name'];
         header('location:profesor_page.php');

      }
     
   }else{
      $error[] = 'Correo o Contraseña Incorrectos';
   }

};
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