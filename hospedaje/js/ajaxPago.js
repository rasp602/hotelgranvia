function reportePDF1()
{
    var descripcion = $('#descripcion').val();
    var idHotel = $('#idHotel').val();
    var idHabitacion = $('#idHabitacion').val();
    var idCama = $('#idCama').val();
    var estado = $('#estado').val();
    var desde = $('#desde').val();
    var hasta = $('#hasta').val();
    var idEmpresa = $('#idEmpresa').val();

window.open('hospedaje/reportes_pdf/HistorialHospedajeDiario.php?idEmpresa='+idEmpresa+'&idHotel='+idHotel+'&descripcion='+descripcion+'&estado='+estado+'&desde='+desde+'&hasta='+hasta+'&idHabitacion='+idHabitacion+'&idCama='+idCama);
}

function resumenPago()
{
   
    var dia_ini = $('#dia_ini').val();
    var dia_fin = $('#dia_fin').val();
    var idEmpresa = $('#idEmpresa').val();

window.open('hospedaje/reportes_pdf/pdfx.php?idEmpresa='+idEmpresa+'&dia_ini='+dia_ini+'&dia_fin='+dia_fin);
}


function resumenPagoExcel()
{
   
    var dia_ini = $('#dia_ini').val();
    var dia_fin = $('#dia_fin').val();
    var idEmpresa = $('#idEmpresa').val();

window.open('hospedaje/reportes_pdf/excelx.php?idEmpresa='+idEmpresa+'&dia_ini='+dia_ini+'&dia_fin='+dia_fin);
}

function reporteExcel()
{
    var descripcion = $('#descripcion').val();
    var idHotel = $('#idHotel').val();
    var idHabitacion = $('#idHabitacion').val();
    var idCama = $('#idCama').val();
    var estado = $('#estado').val();
    var desde = $('#desde').val();
    var hasta = $('#hasta').val();
    var idEmpresa = $('#idEmpresa').val();
    
window.open('hospedaje/excel/ReporteExcelDiario.php?idEmpresa='+idEmpresa+'&idHotel='+idHotel+'&descripcion='+descripcion+'&estado='+estado+'&desde='+desde+'&hasta='+hasta+'&idHabitacion='+idHabitacion+'&idCama='+idCama);
}


function cargaExcel()
{
var nombresPersona = $('#nombresPersona').val();
var id_user = $('#id_user').val();
var rutPersona = $('#rutPersona').val();
var desde = $('#desde').val();
var hasta = $('#hasta').val();
var idEmpresa = $('#idEmpresa').val();

window.open('hospedaje/excel/cargaExcel.php?nombresPersona='+nombresPersona+'&id_user='+id_user+'&rutPersona='+rutPersona+'&desde='+desde+'&hasta='+hasta+'&idEmpresa='+idEmpresa);
}


