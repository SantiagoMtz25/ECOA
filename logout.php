<?php

@include 'config.php';

session_start();

$email = '';
$email = $_SESSION['matri'];
$nomina = strstr($email, '@', true);

$select = "UPDATE alumno_responde SET terminada = 1 WHERE FK_ID_matricula = '$nomina'";
$result = mysqli_query($conn, $select);

if (!$result) {
    // Catch the error with mysqli_error()
    $error = mysqli_error($conn);
} 

$select1 = "CALL insertar_en_folio('$nomina')";
$result1 = mysqli_query($conn, $select1);


if (!$result1) {
    // Catch the error with mysqli_error()
    $error = mysqli_error($conn);
} 

sleep(1);

session_unset();
session_destroy();

header('location:file_test.php');

?>