<?php

@include 'config.php';

session_start();

if (!isset($_SESSION['user_name'])) {
   header('location:file_test.php');
}

$email = '';
$email = $_SESSION['matri'];
$nomina = strstr($email, '@', true);

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="icon" type="image/png" href="tec.png">
   <link rel="stylesheet" href="TemplateData/style.css">
   <title>ECOA | Game</title>

   <link rel="stylesheet" href="user_page.css">
   <script src="timer.js"></script>

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
            <h3>Hola <span><?php echo $_SESSION['user_name'] ?></span></h3>
         </div>
         <div>
            <h3><span><a href="logout.php" class="btn">Salir</a></span></h3>
         </div>
      </div>
   </header>

   <div class="container">
      <div class="content">
         <h1>Bienvenido a la <span>ECOA</span></h1>
         <div class="game">
            <div id="unity-container" class="unity-desktop">
               <canvas id="unity-canvas" width=960 height=600></canvas>
               <div id="unity-loading-bar">
                  <div id="unity-logo"></div>
                  <div id="unity-progress-bar-empty">
                     <div id="unity-progress-bar-full"></div>
                  </div>
               </div>
               <div id="unity-warning"> </div>
               <div id="unity-footer">
                  <div id="unity-webgl-logo"></div>
                  <div id="unity-fullscreen-button"></div>
                  <div id="unity-build-title">ecoarqueria</div>
               </div>
            </div>
            <script>
               var container = document.querySelector("#unity-container");
               var canvas = document.querySelector("#unity-canvas");
               var loadingBar = document.querySelector("#unity-loading-bar");
               var progressBarFull = document.querySelector("#unity-progress-bar-full");
               var fullscreenButton = document.querySelector("#unity-fullscreen-button");
               var warningBanner = document.querySelector("#unity-warning");

               // Shows a temporary message banner/ribbon for a few seconds, or
               // a permanent error message on top of the canvas if type=='error'.
               // If type=='warning', a yellow highlight color is used.
               // Modify or remove this function to customize the visually presented
               // way that non-critical warnings and error messages are presented to the
               // user.
               function unityShowBanner(msg, type) {
                  function updateBannerVisibility() {
                     warningBanner.style.display = warningBanner.children.length ? 'block' : 'none';
                  }
                  var div = document.createElement('div');
                  div.innerHTML = msg;
                  warningBanner.appendChild(div);
                  if (type == 'error') div.style = 'background: red; padding: 10px;';
                  else {
                     if (type == 'warning') div.style = 'background: yellow; padding: 10px;';
                     setTimeout(function() {
                        warningBanner.removeChild(div);
                        updateBannerVisibility();
                     }, 5000);
                  }
                  updateBannerVisibility();
               }

               var buildUrl = "Build";
               var loaderUrl = buildUrl + "/wegl.loader.js";
               var config = {
                  dataUrl: buildUrl + "/wegl.data",
                  frameworkUrl: buildUrl + "/wegl.framework.js",
                  codeUrl: buildUrl + "/wegl.wasm",
                  streamingAssetsUrl: "StreamingAssets",
                  companyName: "DefaultCompany",
                  productName: "ecoarqueria",
                  productVersion: "1.0",
                  showBanner: unityShowBanner,
               };

               // By default Unity keeps WebGL canvas render target size matched with
               // the DOM size of the canvas element (scaled by window.devicePixelRatio)
               // Set this to false if you want to decouple this synchronization from
               // happening inside the engine, and you would instead like to size up
               // the canvas DOM size and WebGL render target sizes yourself.
               // config.matchWebGLToCanvasSize = false;

               if (/iPhone|iPad|iPod|Android/i.test(navigator.userAgent)) {
                  // Mobile device style: fill the whole browser client area with the game canvas:

                  var meta = document.createElement('meta');
                  meta.name = 'viewport';
                  meta.content = 'width=device-width, height=device-height, initial-scale=1.0, user-scalable=no, shrink-to-fit=yes';
                  document.getElementsByTagName('head')[0].appendChild(meta);
                  container.className = "unity-mobile";
                  canvas.className = "unity-mobile";

                  // To lower canvas resolution on mobile devices to gain some
                  // performance, uncomment the following line:
                  // config.devicePixelRatio = 1;

                  unityShowBanner('WebGL builds are not supported on mobile devices.');
               } else {
                  // Desktop style: Render the game canvas in a window that can be maximized to fullscreen:

                  canvas.style.width = "1000px";
                  canvas.style.height = "550px";
               }

               loadingBar.style.display = "block";

               var script = document.createElement("script");
               script.src = loaderUrl;
               script.onload = () => {
                  createUnityInstance(canvas, config, (progress) => {
                     progressBarFull.style.width = 100 * progress + "%";
                  }).then((unityInstance) => {
                     loadingBar.style.display = "none";
                     fullscreenButton.onclick = () => {
                        unityInstance.SetFullscreen(1);
                     };
                  }).catch((message) => {
                     alert(message);
                  });
               };
               document.body.appendChild(script);
            </script>

         </div>

         <div id="extra-info" class="extra-info">
            <h2>¿Sabías que?</h2>
            <p>Teus es la combinación de "Tec" y "Zeus", dios del rayo, de manera que significa "dios del rayo emprendedor". La señal del "rayo emprendedor" fue impulsada por David Noel Ramírez, exrector de la Institución.</p>
         </div>
         <div class="teus-logo">
            <img id="teus" src="teus.png">
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

</body>

</html>