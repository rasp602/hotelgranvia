<?php
include('../../bd/mysql.php');
$sql = "SELECT h.nombreHotel, COUNT(e.nombreEmpresa) AS total, e.nombreEmpresa
FROM hospedaje ho INNER JOIN persona p ON ho.idPersona = p.idPersona
INNER JOIN empresa e ON p.idEmpresa = e.idEmpresa
INNER JOIN hotel h ON ho.idHotel = h.idHotel
WHERE ho.estado = 'A'
GROUP BY ho.idHotel, e.nombreEmpresa
ORDER BY e.idEmpresa, h.nombreHotel  ASC";

$header = '';
$body = '';



$hoteles = [];

$sql2 = "SELECT idHotel, nombreHotel FROM hotel ORDER BY idHotel ASC;";
        
if($result2 = mysqli_query($conn, $sql2))
{
    while($row2 = mysqli_fetch_assoc($result2)) {
        $header .= '            
            <th style="color: #FFFFFF" scope="col">'. $row2['nombreHotel'] .'</th>            
        ';        
        $hoteles[] = $row2['idHotel'];
    }
}

$tds = '';
$num_h = count($hoteles);
$count_total = 0;

$suma_vertical = [];
for ($i=0; $i < count($hoteles); $i++) { 
    $suma_vertical[$i] = 0;
}
$sql2 = "SELECT idEmpresa, nombreEmpresa FROM empresa ORDER BY idEmpresa ASC;";        
if($result2 = mysqli_query($conn, $sql2))
{
    while($row2 = mysqli_fetch_assoc($result2)) {
        $sql3 = '
        SELECT h.idHotel, COUNT(e.nombreEmpresa) AS total, e.nombreEmpresa
            FROM hospedaje ho INNER JOIN persona p ON ho.idPersona = p.idPersona
            INNER JOIN empresa e ON p.idEmpresa = e.idEmpresa
            INNER JOIN hotel h ON ho.idHotel = h.idHotel
            WHERE ho.estado = "A" AND e.idEmpresa = '. $row2['idEmpresa'] .'
            GROUP BY ho.idHotel, e.nombreEmpresa
            ORDER BY e.idEmpresa, h.idHotel  ASC';
            $tds = '';
            $num_h = count($hoteles);
            $cont = 0;
            $sum_hor = 0;
            $bol = false;
            $hotel_sql = [];
            $total_sql = [];
            if($result3 = mysqli_query($conn, $sql3))
            { 
                $tds = '';
                while($row3 = mysqli_fetch_assoc($result3)) {
                    $hotel_sql[] = $row3['idHotel'];
                    $total_sql[] = $row3['total'];
                    
                }
                $j = 0;                  
                for($i = 0; $i < count($hoteles); $i++) {                     
                    $found = array_search($hoteles[$i], $hotel_sql);                    
                    if($found !== false){       

                        $tds .= '<td>'. $total_sql[$j] .'</td>'; 
                        $suma_vertical[count($hoteles) - $num_h] += $total_sql[$j];
                        $sum_hor += $total_sql[$j];        
                        $num_h--;
                        $j++;
                       
                    }else{
                        $tds .= '<td></td>';  
                       
                        $num_h--;
                                
                    } 
                }
                
                if($tds == ''){
                    
                    for($i = 0; $i < count($hoteles); $i++) {                                        
                        $tds .= '<td></td>';     
                        $num_h--;                           
                    }                    
                }
                if($num_h > 0){
                    for($i = 0; $i < $num_h; $i++) {                                        
                        $tds .= '<td></td>';     
                                 
                    }  
                }
            }
        
        $vert = '<td></td>';
        for ($i=0; $i < count($hoteles); $i++) { 
            $vert .='
                <td style="color: #DC0000">'. $suma_vertical[$i] .'</td>
            ';    
        }

        $count_total += $sum_hor;
        $body .= '
        <tr class="text-center">
            <th scope="col">'. $row2['nombreEmpresa'] .'</th>
            '. $tds .'
            <td style="color: #DC0000">'. $sum_hor .'</td>
        </tr>
        ';        
    }
}

$tabla_grande = '
<table class="table table-bordered border-dark m-2 table-striped text-center table-hover">    
        <thead>
            <tr style="color: #FFFFFF; background-color: #0081C9;" class="text-center">
                <th scope="col"></th>
                    '. $header .'
                <th style="color: #FFFFFF" scope="col">TOTAL</th>      
            </tr>
        </thead>
        <tbody>
            '. $body .'
            <tr class="text-center">
                '. $vert .'
                <td style="color: #000; font-weight: bold; background-color: #FFE162">'. $count_total .'</td>
            </tr>
        </tbody>
    </table>
';



$body_ch = '';
$capacidad_total = 0;
$numrows1 = 0;

$sql2 = "SELECT idHotel, nombreHotel, capacidadHotel FROM hotel ORDER BY idHotel ASC;";        
if($result2 = mysqli_query($conn, $sql2))
{
    while($row2 = mysqli_fetch_assoc($result2)) {
        $body_ch .= ' 
        <tr>
            <th scope="col">'. $row2['nombreHotel'] .'</th>                                    
            <td scope="col">'. $row2['capacidadHotel'] .'</td>
        ';        

        $sql3 = "SELECT hotel.idHotel, hotel.nombreHotel,hotel.capacidadHotel,
                count(*) AS numrows1 FROM hotel
                INNER JOIN habitacion ON hotel.idHotel = habitacion.idHotel
                INNER JOIN cama ON habitacion.idHabitacion = cama.idHabitacion
                WHERE cama.estadoCama = 'I' AND hotel.idHotel = ". $row2['idHotel'] ." GROUP BY hotel.idHotel";

        $tds = '';
        
        if($result3 = mysqli_query($conn, $sql3))
        { 
            $tds = '';
            while($row3 = mysqli_fetch_assoc($result3)) {                                                          
                    $found = array_search($row3['idHotel'], $hoteles);
                    if($found !== false){                                                                        
                        $tds .= '<td>'. $row3['numrows1'] .'</td>'; 
                        $tds .= '<td>'. (intval($row3['capacidadHotel']) - intval($row3['numrows1'])) .'</td>'; 
                        $numrows1 += $row3['numrows1'];
                        $capacidad_total += $row3['capacidadHotel'];    
               
                        break;
                    }else{
                        $tds .= '<td>0</td>';  
                        $tds .= '<td>'. $row3['capacidadHotel'] .'</td>';  
                        $capacidad_total += $row3['capacidadHotel'];
                        break;         
                    
                }
            }
            if($tds == ''){                                
                $tds .= '<td>0</td>';     
                $tds .= '<td>'. $row2['capacidadHotel'] .'</td>';    
                $capacidad_total += $row2['capacidadHotel'];                                                         
            }

        }

        $body_ch .= $tds .'</tr>'; 
    }
}


$tabla_chica = '
<table class="table table-striped table-hover m-2">
    <thead>
        <tr style="text-align: center; font-weight: bold; background-color: #0081C9;" >
            <th style="color: #fff" colspan="4">CAPACIDAD TOTAL</th>
        </tr>
        <tr style="background-color: #0081C9;">
            <th style="color: #fff">HOTELES</th>
            <th style="color: #fff">CAPACIDAD</th>
            <th style="color: #fff">OCUPADOS</th>
            <th style="color: #fff">DISPONIBLES</th>
        </tr>
    </thead>
    <tbody class="fontt">
        '.  $body_ch .'
        <tr>
            <td>TOTAL</td>
            <td style="color: #DC0000">'. $capacidad_total .'</td>
            <td style="color: #DC0000">'. $numrows1 .'</td>
            <td style="color: #DC0000">'. ($capacidad_total - $numrows1) .'</td>
        </tr>
    </tbody>
</table><br>';

$tabla_html = '
<form id="form" action="../hospedaje/reportes/tabla_pdf.php" target="_blank" method="post">
    '. $tabla_chica .'    
    <button type="submit" class="btn btn-primary m-2">Imprimir pdf</button>
</form>

';

$tabla_pdf = $tabla_chica . $tabla_grande;


?>
