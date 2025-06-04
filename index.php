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
  <style>
    body {
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
    }
  </style>
</head>
<body>
<!-- <div id="pago">Esperando pagos...</div> -->
<div id="pago">
    <span style="">💸 Esperando el primer pago en vivo...</span>
    <span style="animation: blink 1s infinite;">⚡</span>
</div>

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