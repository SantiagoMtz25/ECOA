<?php

@include 'config.php';

session_start();

if(!isset($_SESSION['admin_name'])){
   header('location:file_test.php');
   //exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type = "image/png" href="Logo_del_tec.png"/>
    <link rel="stylesheet" href="admin_page1.css"/>
    <script defer src="admin_js.js"></script>
    <title>ECOA | Admin</title>
</head>
<body>
    <h1 class="encabezado">Sistema de Encuestas</h1>
    <div class="Todo_Contenido">
        <!--Opciones-->
        <div class="Seccion_opciones">
            <div class="perfil">
                <div class="foto_usuario">
                    <img class="imagen" src="Logo_del_tec.png" />
                </div>
                <div style="height: 20px;"></div>
                <div class="nombre_usuario">Hola <span><?php echo $_SESSION['admin_name'] ?></span></div>
            </div>
            <div class="boton "><div class="nombre_bottons"></div><div class="nombre_bottons">Preguntas</div></div>
            <div class="boton "><div class="nombre_bottons"></div><div class="nombre_bottons">Encuestas</div></div>
            <a href="logout.php"><div class="cerrar_sesion"><div class="nombre_bottons"></div>Salir</div></a>
            
        </div>
        <!--Contenido-->
        <div class="Seccion_Contenidos">

            <!-- Seccion Preguntas-->
            <div class="tab activo">
            
                <div class="encabezado_encuestas">
                    <div class="nombre_bottons"></div>
                    <div class="titulo_encuestas">Preguntas Disponibles</div>
                </div>
                <div class="table_preg">
                    <table class="zona_pregs">
                        <tr class="first_row">
                            <td>Siglas</td>
                            <td>Preguntas</td>
                            <td>Tipo Pregunta</td>
                        </tr>

                        <tr>
                        <?php 

                        @include 'config.php';

                        $sql = "SELECT PK_ID_pregunta, pregunta, tipo_pregunta FROM preguntas";
                        $result = mysqli_query($conn, $sql);

                        // Display the results
                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) { ?>
                                    <td><?php echo $row['PK_ID_pregunta'] ?></td>
                                    <td><?php echo $row['pregunta'] ?></td>
                                    <td><?php echo $row['tipo_pregunta'] ?></td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo 'No hay preguntas disponibles';
                        }

                        ?>

                    </table>
                </div>
                <div class="espacio_boton">
                    <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                        <button>Actualizar Preguntas</button>
                    </a>
                </div>
                <div class="division-2">
                    <div class="box form-container">
                        <form action="" method="post">
                            <input type="text" name="id" required placeholder="Ingresa Las Siglas:">
                            <input type="text" name="nump" required placeholder="Número de Pregunta:">
                            <input type="text" name="pregunta" required placeholder="Ingresa la Pregunta: ">
                            <select name="tipo_pregunta" type="text" required placeholder="Tipo de Pregunta: ">
                                <option value="Uni_for">Uni_for</option>
                                <option value="Profesor">Profesor</option>
                            </select>
                            <input type="submit" name="submit" value="Agregar" class="form-btn">
                        </form>   
                    </div>

                    <?php 

                    @include 'config.php';

                    if(isset($_POST['submit'])){
                        $id = $_POST['id'];
                        $nump = $_POST['nump'];
                        $question = $_POST['pregunta'];
                        $tipo_pregunta = $_POST['tipo_pregunta'];

                        $select = "INSERT INTO preguntas (PK_ID_pregunta, no_pregunta, pregunta, tipo_pregunta) VALUES ('$id', '$nump', '$question', '$tipo_pregunta')";
                        $result = mysqli_query($conn, $select);

                        if (!$result) {
                            // Catch the error with mysqli_error()
                            $error = mysqli_error($conn);
                        }  
                        
                    }

                    ?>
                    
                    <div class="box form-container">
                        <form action="" method="post">
                            <input type="text" name="id_cambiar" required placeholder="Ingresa las Siglas:">
                            <input type="text" name="nueva_p" required placeholder="Ingresa el cambio:">
                            <input type="submit" name="submit2" value="Cambiar" class="form-btn">
                        </form> 
                    </div>

                    <?php 
                
                    @include 'config.php';

                    if(isset($_POST['submit2'])){
                        $id_cambiar = $_POST['id_cambiar'];
                        $nueva_p = $_POST['nueva_p'];

                        $select = "UPDATE preguntas SET pregunta = '$nueva_p' WHERE PK_ID_pregunta = '$id_cambiar'";
                        $result = mysqli_query($conn, $select);
                        
                        if (!$result) {
                            // Catch the error with mysqli_error()
                            $error = mysqli_error($conn);
                        }
                    }

                    ?>


                    <div class="box1 form-container">
                        <form action="" method="post">
                            <input type="text" name="id_borrar" required placeholder="Ingresa las Siglas:">
                            <input type="submit" name="submit1" value="Borrar" class="form-btn">
                        </form>   
                    </div>


                    <?php 

                    @include 'config.php';

                    if(isset($_POST['submit1'])){
                        $id_borrar = mysqli_real_escape_string($conn, $_POST['id_borrar']);

                        $select1 = "DELETE FROM pregunta_encuesta WHERE FK_ID_pregunta = '$id_borrar'";
                        $result2 = mysqli_query($conn, $select1);
                        $select = "DELETE FROM preguntas WHERE PK_ID_pregunta = '$id_borrar'";
                        $result = mysqli_query($conn, $select);

                        if (!$result && !$result2) {
                            // Catch the error with mysqli_error()
                            $error = mysqli_error($conn);
                        }

                    }

                    ?>
                </div> 
           
            </div>
            <!-- Seccion Encuestas-->
            <div class="tab ">
                <div class="encabezado_encuestas">
                    <div class="nombre_bottons"></div>
                    <div class="titulo_encuestas">Encuestas Disponibles</div>
                </div>
                <div class="table_preg">
                        <table class="zona_enc">
                            <tr class="first_row">
                                <td>No. Encuesta</td>
                                <td>Siglas</td>
                                <td>Fecha Inicio</td>
                                <td>Fecha Fin</td>
                            </tr>
                            
                            <?php 

                            @include 'config.php';

                            $sql = "SELECT FK_ID_encuesta, FK_ID_pregunta, fecha_inicio, fecha_fin FROM encuestas 
                                    INNER JOIN pregunta_encuesta ON encuestas.PK_ID_encuesta = pregunta_encuesta.FK_ID_encuesta
                                    ORDER BY FK_ID_encuesta ASC";
                            $result = mysqli_query($conn, $sql);

                            // Display the results
                            if (mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)) { ?>
                                    <tr>
                                        <td><?php echo $row['FK_ID_encuesta'] ?></td>
                                        <td><?php echo $row['FK_ID_pregunta'] ?></td>
                                        <td><?php echo $row['fecha_inicio'] ?></td>
                                        <td><?php echo $row['fecha_fin'] ?></td>
                                    </tr>
                                <?php
                                }
                            } else {
                                echo 'No hay encuestas disponibles';
                            }

                            ?>
                            
                        </table>      
                </div>
                <div class="espacio_boton">
                    <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                        <button>Actualizar Encuestas</button>
                    </a>
                </div>
                <div class="espacio"></div>
                <div class="division-2">
                    <div class="box form-container">
                        <form action="" method="post">
                            <input type="text" name="id_enc" required placeholder="No. de Encuesta:">
                            <!--<input type="text" name="fecha" required placeholder="Fecha Nueva:">
                            <select name="iof" type="text" required placeholder="Agregar o borrar: ">
                                <option value="fecha_inicio">Activar</option>
                                <option value="fecha_fin">Fecha Fin</option>
                            </select>-->
                            <input type="submit" name="submit_fake" value="Activar" class="form-btn">
                        </form>   
                    </div>

                    <div class="box form-container">
                        <form action="" method="post">
                            <input type="text" name="id_encuesta" required placeholder="No. de Encuesta:">
                            <input type="text" name="siglas" required placeholder="Siglas de la Pregunta:">
                            <select name="aob" type="text" required placeholder="Agregar o borrar: ">
                                <option value="agregar">Agregar</option>
                                <option value="borrar">Borrar</option>
                            </select>
                            <input type="submit" name="submit3" value="Enviar" class="form-btn">
                        </form>   
                    </div>
                   
                    <?php
                
                    @include 'config.php';

                    if(isset($_POST['submit3'])){
                        $id_encuesta = $_POST['id_encuesta'];
                        $siglas = $_POST['siglas'];
                        $aob = $_POST['aob'];

                        try {
                            if($aob == "agregar"){
                                $select = "INSERT INTO pregunta_encuesta (FK_ID_encuesta, FK_ID_pregunta) values ('$id_encuesta','$siglas');";
                                $result = mysqli_query($conn, $select);
                                
                                if (!$result) {
                                    throw new Exception('Error al agregar la pregunta a la encuesta.');
                                }

                            } else {
                                $select = "DELETE FROM pregunta_encuesta WHERE FK_ID_pregunta = '$siglas' AND FK_ID_encuesta = '$id_encuesta'";
                                $result = mysqli_query($conn, $select);

                                if (!$result) {
                                    throw new Exception('Error al borrar la pregunta de la encuesta.');
                                }

                            } 
                        } catch (Exception $e) {
                            // Display the error message in a pop-up
                            echo "<script>alert('No se ha podido ejecutar tu petición.');</script>";
                        }
                    } 

                    ?>
            
                
                    <div class="box form-container">
                        <form action="" method="post">
                            <input type="text" name="id_encuesta1" required placeholder="No. de Encuesta:">
                            <input type="text" name="fecha" required placeholder="Fecha Nueva:">
                            <select name="iof" type="text" required placeholder="Agregar o borrar: ">
                                <option value="fecha_inicio">Fecha Inicio</option>
                                <option value="fecha_fin">Fecha Fin</option>
                            </select>
                            <input type="submit" name="submit4" value="Enviar" class="form-btn">
                        </form>   
                    </div>
             
                    <?php 

                    @include 'config.php';

                    if(isset($_POST['submit4'])) {
                        $id_encuesta1 = $_POST['id_encuesta1'];
                        $fecha = $_POST['fecha'];
                        $iof = $_POST['iof'];

                        if($iof == "fecha_inicio"){
                            $select = "UPDATE encuestas SET fecha_inicio = '$fecha' WHERE PK_ID_encuesta = '$id_encuesta1'";
                            $result = mysqli_query($conn, $select);

                            if (!$result) {
                                $error = mysqli_error($conn);
                            }

                        } else {
                            $select = "UPDATE encuestas SET fecha_fin = '$fecha' WHERE PK_ID_encuesta = '$id_encuesta1'";
                            $result = mysqli_query($conn, $select);

                            if (!$result) {
                                $error = mysqli_error($conn);
                            }

                        }
                        
                    }

                    ?>
    
                </div>
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
    </div>
</body>
</html>


