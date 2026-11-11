<?php
if (isset($_POST['submit'])) {
  // Aquí iría el código para procesar el formulario enviado
  // ...
  echo "¡Gracias por llenar el formulario!";
  exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Formulario QR</title>
</head>
<body>
  <form method="post" action="">
    <input type="text" name="nombre" placeholder="Nombre" required><br>
    <input type="text" name="apellido" placeholder="Apellido" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="submit" name="submit" value="Enviar">
  </form>
  <br>
  <div id="qr-reader"></div>
  <script src="https://cdn.rawgit.com/LazarSoft/jsqrcode/master/src/qr_packed.js"></script>
  <script>
    function qrReader() {
      var reader = new QRCodeReader();
      reader.init("#qr-reader").then(function() {
        reader.scan().then(function(result) {
          var urlParams = new URLSearchParams(window.location.search);
          var nombre = urlParams.get('nombre');
          var apellido = urlParams.get('apellido');
          var email = urlParams.get('email');
          document.getElementsByName("nombre")[0].value = nombre;
          document.getElementsByName("apellido")[0].value = apellido;
          document.getElementsByName("email")[0].value = email;
          document.getElementsByName("submit")[0].click();
        });
      });
    }
    qrReader();
  </script>
</body>
</html>
