<?php

@include 'config.php';

session_start();

if(!isset($_SESSION['profesor_name'])){
   header('location:file_test.php');
} 

$nomina = ''; 
$nomina = $_SESSION['nomina'];
$short = strstr($nomina, '@', true);

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="icon" type="image/png" href="tec.png">
   <title>ECOA | Profesor</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="profesor_page.css">

</head>

<body>
   <header>
      <div class="header-left">
         <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <img src="ecoa-removebg-preview.png" alt="ECOA">
         </a>
      </div>
      <div class="header-right">
         <div>
            <h3>Hola <span><?php echo $_SESSION['profesor_name'] ?></span></h3>
         </div>
         <div>
            <h3><span><a href="logout.php" class="btn">Salir</a></span></h3>
         </div>
      </div>
   </header>

   <div class="container">
      <div class="content">
         <h1>Página de <span>Profesores</span></h1>

         <div style="height: 600px; overflow-y: scroll;">
            <table class="p_disponibles">
               <tr class="first_row">
                  <td>Semestral</td>
                  <td>Region</td>
                  <td>Campus</td>
                  <td>Clave UdF</td>
                  <td>Nombre UdF</td>
                  <td>Nomina</td>
                  <td>Alumnos Candidatos</td>
                  <td>Alumnos que opinaron</td>
                  <td>Participacion</td>
                  <td>01DOM</td>
                  <td>02RET</td>
                  <td>03REC</td>
                  <td>05ACE</td>
                  <td>05MET</td>
                  <td>Tipo de UdF</td>
                  <td>Periodo</td>
                  <td>Semanas</td>
                  <td>Term</td>
               </tr>

               <tr>
               <?php

               @include 'config.php';

               $select = "SELECT * FROM tabla_resumen WHERE Nomina = '$short'";
               $result = mysqli_query($conn, $select);

               if (mysqli_num_rows($result) > 0) {
                  while($row = mysqli_fetch_assoc($result)){ ?>
                     <td><?php echo $row['Ejercicio_Academico'] ?></td>
                     <td><?php echo $row['Region'] ?></td>
                     <td><?php echo $row['Campus'] ?></td>
                     <td><?php echo $row['Clave_Materia'] ?></td>
                     <td><?php echo $row['Nombre_Materia'] ?></td>
                     <td><?php echo $row['Nomina'] ?></td>
                     <td><?php echo $row['Alumnos_Candidatos'] ?></td>
                     <td><?php echo $row['Alumnos_Opinaron'] ?></td>
                     <td><?php echo $row['Participacion'] ?></td>
                     <td><?php echo $row['01DOM_Prom'] ?></td>
                     <td><?php echo $row['02RET_Prom'] ?></td>
                     <td><?php echo $row['03REC_Prom'] ?></td>
                     <td><?php echo $row['05ASE_Prom'] ?></td>
                     <td><?php echo $row['05MET_Prom'] ?></td>
                     <td><?php echo $row['TipodeUdF'] ?></td>
                     <td><?php echo $row['Periodo'] ?></td>
                     <td><?php echo $row['Semanas'] ?></td>
                     <td><?php echo $row['Term'] ?></td>
                     </tr>

                     <?php
                  }
               } else {
                  echo '<script>alert("No hay resultados disponibles");</script>';
               }
               ?>

            </table>
         </div>

         <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <button>Actualizar Resultados</button>
         </a>

      </div>
   </div>

   <footer>
      <div class="footer-content">
         <div class="footer-item">Necesitas ayuda contacta TecServices</div>
         <div class="footer-item"><span>Teléfono:</span> +52 81 8358 2000</div>
         <div class="footer-item"><span>Email:</span> tecservices@servicios.tec.mx</div>
         <div class="footer-item"><span>copyright &#169; </span><a href="https://tec.mx/es" target="_blank">Instituto Tecnológico y de Estudios Superiores de Monterrey</a></div>
      </div>
   </footer>

</body>

</html>