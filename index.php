<?php
if (!empty($_GET['id'])):
    $id = preg_replace('/[^a-zA-Z0-9_\-]/', '', $_GET['id']);
    $archivoJson = $id . '.json';

    if (!file_exists($archivoJson)) {
        file_put_contents($archivoJson, "💸 Esperando el primer pago en vivo...\n"); // crea archivoJson vacío
    }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <style>
    body {
      background: transparent;
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
      display: flex;
      align-items: center;
      justify-content: center;
      height: auto;
      margin: 0;
    }

    .notification {
      width: 90%;
      max-width: 400px;
      background: #fff;
      border-radius: 20px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.15);
      padding: 12px 16px;
      display: flex;
      gap: 12px;
      align-items: center;
    }

    .icon {
      width: 40px;
      height: 40px;
      border-radius: 10px;
      background: #8b2cf5;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .icon img {
      width: 40px;
      height: 40px;
    }

    .content {
      flex-grow: 1;
    }

    .title {
      font-weight: bold;
      font-size: 14px;
      color: #111;
    }

    .message {
      font-size: 13px;
      color: #333;
    }

    .time {
      font-size: 11px;
      color: #888;
    }

    /* base css */
    /* body {
      margin: 0;
      background: transparent;
      color: white;
      font-size: 24px;
      font-family: sans-serif;
    }
    #pago {
      padding: 20px;
      background: rgba(0, 0, 0, 0.6);
      border-radius: 10px;
    } */
  </style>
</head>
<body>
  <div class="notification">
    <div class="icon">
      <img src="yape.png" alt="Yape" />
    </div>
    <div class="content">
      <div class="title">Confirmación de Pago</div>
      <!-- <div class="message" id="pago">Yape! Alex Ramirez T. te envió un pago por S/ 30</div> -->
      <div class="message" id="pago">💸 Esperando el primer pago en vivo...</div>
      <div class="time">now</div>
    </div>
  </div>

<!-- 
  <div id="pagox">
      <span style="">💸 Esperando el primer pago en vivo...</span>
      <span style="animation: blink 1s infinite;">⚡</span>
  </div>
-->

  <script>
      let lineas = [];         // líneas actuales del archivo
      let indiceActual = 0;    // línea mostrada actualmente

      function cargarPagos() {
          fetch('<?php echo $archivoJson; ?>?_=' + new Date().getTime()) // evitar caché
              .then(response => response.text())
              .then(data => {
                  console.log('data');
                  console.log(data);
                  const nuevasLineas = data.trim().split('\n');

                  // const nuevasLineas = data.trim().split('\n').filter(Boolean); // elimina líneas vacías
                  // if (nuevasLineas.length === 0) {
                  //     document.getElementById('pago').innerHTML = `
                  //         <span style="">💸 Esperando el primer pago en vivo...</span>
                  //         <span style="animation: blink 1s infinite;">⚡</span>
                  //     `;
                  //     return;
                  // }
                  
                  if (nuevasLineas.length > lineas.length) {
                      lineas = nuevasLineas;
                  }

                  // Si hay una línea nueva por mostrar
                  if (indiceActual < lineas.length) {
                      document.getElementById('pago').textContent = lineas[indiceActual];
                      indiceActual++;
                  }

                  // Si no hay nuevas, simplemente no haces nada (esperas)
              })
              .catch(error => console.error("Error cargando pagos:", error));
      }

      // Ejecutar cada 3 segundos
      setInterval(cargarPagos, 3000);
  </script>
  <style type="text/css">
  @keyframes blink {
    0%, 100% { opacity: 1; }
    50% { opacity: 0; }
  }
  </style>
  </body>
</html>
<?php else: ?>
  <p>Page not found</p>
<?php endif; ?>