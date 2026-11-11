<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, user-scalable=no">
<title>Subir Imagen</title>
      <link rel="stylesheet" href="../../css/bootstrap.min.css">
      <link rel="stylesheet" href="../../css/bootstrap.min.css">
</head>

<body>
<script src="../../js/bootstrap.js"></script>
<script src="../../js/bootstrap.min.js"></script>
<script src="../../js/jquery-1.10.2.js"></script>
<script src="../../js/jquery.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="../../js/jquery-ui-1.9.2.custom.js"></script>


<?php if ((isset($_POST["enviado2"])) && ($_POST["enviado2"] == "form2")) {
  
  $nombre_archivo = $_FILES['userfile2']['name'];

  move_uploaded_file($_FILES['userfile2']['tmp_name'], "../imagenes/".$nombre_archivo);
  
  ?>
    <script>
    opener.document.form1.imagen2.value="<?php echo $nombre_archivo; ?>";
    self.close();
  </script>
    <?php
}
else
{?>

<div class="container">

  <div class="row">
    <div class="col-md-12"><br />

    <label for="">Seleccione un archivo para cargarlo a nuestro sistema..!</label>

      <form action="gestionimagen2.php" method="post" enctype="multipart/form-data" id="form1">
        <p>
          <!--<input name="userfile" type="file" />-->
        <input type="file" name="userfile2">
        </p>
        <p>
          <input type="submit" name="button2" id="button2" value="Subir Imagen" />

        </p>
        <input type="hidden" name="enviado2" value="form2" />          

      </form>
      <?php }?>
    </div>
  </div>
</div> 

</body>
</html>