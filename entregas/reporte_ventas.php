

<?php
include_once "encabezado.php";
include_once "navbar.php";
include_once "funciones.php";

if(empty($_SESSION['usuario'])) header("location: login.php");

if(isset($_POST['buscar'])){
    if(empty($_POST['inicio']) || empty($_POST['fin'])) header("location: reporte_ventas.php");
}

if(isset($_POST['buscarPorUsuario'])){
    if(empty($_POST['idUsuario'])) header("location: HistorialVentas.php");

}

if(isset($_POST['buscarPorCliente'])){
    if(empty($_POST['idCliente'])) header("location: reporte_ventas.php");
}

$fechaInicio = (isset($_POST['inicio'])) ? $_POST['inicio'] : null;
$fechaFin = (isset($_POST['fin'])) ? $_POST['fin'] : null;
$usuario = (isset($_POST['idUsuario'])) ? $_POST['idUsuario'] : null;
$cliente = (isset($_POST['idCliente'])) ? $_POST['idCliente'] : null;

$ventas = obtenerVentas($fechaInicio, $fechaFin, $cliente, $usuario);

$cartas = [
    ["titulo" => "No. ventas", "icono" => "fa fa-shopping-cart", "total" => count($ventas), "color" => "#A71D45"],
    ["titulo" => "Total ventas", "icono" => "fa fa-money-bill", "total" => "$".calcularTotalVentas($ventas), "color" => "#2A8D22"],
    ["titulo" => "Productos vendidos", "icono" => "fa fa-box", "total" =>calcularProductosVendidos($ventas), "color" => "#223D8D"],
    ["titulo" => "Ganancia", "icono" => "fa fa-wallet", "total" => "$". obtenerGananciaVentas($ventas), "color" => "#D55929"],
];

$clientes = obtenerClientes();
$usuarios = obtenerUsuarios();
?>
<div class="container">
    <h2>Reporte de ventas : 
        <?php 
        if(empty($fechaInicio)) echo HOY;
        if(isset($fechaInicio) && isset($fechaFin)) echo $fechaInicio ." al ". $fechaFin;
        ?>
    </h2>
    <form class="row mb-3" method="post">
        <div class="col-3">
            <label for="inicio" class="form-label">Fecha busqueda inicial</label>
            <input type="date" name="inicio" class="form-control" id="inicio" >
        </div>
        <div class="col-3">
            <label for="fin" class="form-label">Fecha busqueda final</label>
            <input type="date" name="fin" class="form-control" id="fin" >
        </div>
        <div class="col">
    <input type="submit" name="buscar" value="Buscar" class="btn btn-primary mt-4">
    
    <button type="button" class="btn btn-secondary mt-4 ms-2" onclick="downloadPDF()">Descargar PDF Usuarios</button>
    <button type="button" class="btn btn-secondary mt-4 ms-2" onclick="downloadPDFTodos()">Descargar PDF Todos</button>
    <button type="button" class="btn btn-secondary mt-4 ms-2" onclick="downloadPDFHoy()">Descargar PDF Hoy</button>
  


</div>
    </form>
    <div class="row mb-2">
        <div class="col">
            <form action="" method="post" class="row">
                <div class="col-6">
                <select class="form-select" aria-label="Default select example" name="idUsuario" id="idUsuario">
                    <option selected value="">Selecciona un usuario</option>
                    <?php foreach($usuarios as $usuario) {?>
                    <option value="<?= $usuario->idUsuario?>"><?= $usuario->usuario?></option>
                    <?php }?>
                </select>
                </div>
                <div class="col-1">
                    <input type="submit" name="buscarPorUsuario" value="Buscar por usuario" class="btn btn-secondary">
                </div>
            </form>
        </div>
        <div class="row">
            <!--
        <div class="col-3">
     
                        <select class="form-select" name="mesa" id="mesa" required>
                                  
                            <option selected value="">Seleccione una mesa</option>
                            <option value="1">Mesa 1</option>
                            <option value="2">Mesa 2</option>
                            <option value="3">Mesa 3</option>
                            <option value="4">Mesa 4</option>
                            <option value="5">Mesa 5</option>
                            <option value="6">Mesa 6</option>
                            <option value="7">Mesa 7</option>
                            <option value="8">Mesa 8</option>
                            <option value="9">Mesa 9</option>
                            <option value="10">Mesa 10</option>                
                            <option value="11">Mesa 11</option>
                            <option value="12">Mesa 12</option>
                            <option value="13">Mesa 13</option>
                            <option value="14">Mesa 14</option>
                            <option value="15">Mesa 15</option>
                            <option value="16">Mesa 16</option>
                            <option value="17">Mesa 17</option>
                            <option value="18">Mesa 18</option>
                            <option value="19">Mesa 19</option>
                            <option value="20">Mesa 20</option>
                            <option value="21">Mesa 21</option>
                            <option value="22">Mesa 22</option>
                            <option value="23">Mesa 23</option>
                            <option value="24">Mesa 24</option>
                            <option value="25">Mesa 25</option>
                            <option value="26">Mesa 26</option>
                            <option value="27">Mesa 27</option>
                            <option value="28">Mesa 28</option>
                            <option value="29">Mesa 29</option>
                            <option value="30">Mesa 30</option>
                            <option value="31">Mesa 31</option>
                            <option value="32">Mesa 32</option>
                            <option value="33">Mesa 33</option>
                            <option value="34">Mesa 34</option>
                            <option value="35">Mesa 35</option>
                            <option value="36">Mesa 36</option>
                            <option value="37">Mesa 37</option>
                            <option value="38">Mesa 38</option>
                            <option value="39">Mesa 39</option>
                            <option value="40">Mesa 40</option>
                            <option value="41">Mesa 41</option>
                            <option value="42">Mesa 42</option>
                            <option value="43">Mesa 43</option>
                            <option value="44">Mesa 44</option>
                            <option value="45">Mesa 45</option>
                            <option value="46">Mesa 46</option>
                            <option value="47">Mesa 47</option>
                            <option value="48">Mesa 48</option>
                            <option value="49">Mesa 49</option>
                            <option value="50">Mesa 50</option>
                            

                        </select>
                    </div>
                    <div class="col-4">
                    <input type="submit" name="buscarPorMesa" value="Buscar por mesa" class="btn btn-secondary">
                </div>
                    </div>


    </div>-->

    <?php include_once "cartas_totales.php"?>
    <?php if(count($ventas) > 0){?>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Total</th>
                <th>Usuario</th>
                <th>Productos</th>
                <th>Tipo Pago</th>
                <th>Ganancia</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($ventas as $venta) {?>
                <tr><!--<input type="button" value="<?php echo $venta->id; ?>" id="idVenta">-->
                    <td><?= $venta->id;?></td>
                    <td><?= $venta->fecha;?></td>
                    <td><?= $venta->cliente;?></td>
                    <td>$<?= $venta->total;?></td>
                    <td><?= $venta->usuario;?></td>
                    <td>
                        <table class="table">
                            <?php foreach($venta->productos as $producto) {?>
                                <tr>
                                    <td><?= $producto->nombre;?></td>
                                    <td><?= $producto->cantidad;?></td>
                                    <td> X </td>
                                    <td>$<?=  $producto->precio ;?></td>
                                    <th>$<?= $producto->cantidad * $producto->precio ;?></th>
                                </tr>
                                <?php }?>
                        </table>
                    </td>
                    <td><?= $venta->tipoPago;?></td>
                    <td>$<?= $venta->gananciaG;?></td>
                </tr>
            <?php }?>
        </tbody>
    </table>
    <?php }?>
    <?php if(count($ventas) < 1){?>
        <div class="alert alert-warning mt-3" role="alert">
            <h1>No se han encontrado ventas</h1>
        </div>
    <?php }?>
</div>
<script src="jquery-3.1.1.min.js"></script>
<script>
    $(document).ready(function(){
        $('#idVenta').click(function(){

        var idVenta = $("#idVenta").val();
   
        var parametros = {"idVenta":idVenta}; 
           $.ajax({
               url: 'gethint1.php',
               type: 'POST',
               data: parametros, 


               success: function(data){
                   if(data==1){
                       alert('Imprimiendo....');

                   }else{
                          location.reload();
                   }
               }
           }); 
        });
    });


</script>

<script>
function downloadPDF() {
    // Lógica para descargar el archivo PDF
    window.location.href = 'HistorialVentas.php'; // Ajusta la ruta al archivo PDF
}

function downloadPDFTodos() {
    // Lógica para descargar el archivo PDF
    window.location.href = 'HistorialVentasTodos.php'; // Ajusta la ruta al archivo PDF
}

function downloadExcel() {
    // Lógica para descargar el archivo Excel
    window.location.href = 'excel/ReporteExcel.php'; // Ajusta la ruta al archivo Excel
}

function downloadPDFHoy() {
    // Lógica para descargar el archivo Excel
    window.location.href = 'HistorialVentasHoy.php'; // Ajusta la ruta al archivo Excel
}
</script>