<?php

// solo para intenar mandar matricula al juego
function redirect_to_another_page() {
  session_start();

  if (!isset($_SESSION['user_name']) || !isset($_SESSION['matri'])) {
    header('location:file_test.php');
  }
  
  // Check if the function has already been executed to avoid infinite loops
  static $executed = false;
  if (!$executed) {
    $executed = true;
    
    // Do any necessary operations here
    header('Content-Type: application/json');

    $email = '';
    $email = $_SESSION['matri'];
    $nomina = strstr($email, '@', true);

    $response = array(
        'value' => $nomina
    );

    echo json_encode($response);

    sleep(5);
    // Redirect to another PHP page
    header('location:user_page.php');
    exit;
  }
}

// Call the function to execute it
redirect_to_another_page();

?>