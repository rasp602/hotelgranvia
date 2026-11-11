<?php
	error_reporting(E_ERROR | E_PARSE); // Desactiva la notificación y warnings de error en php.
?>

<!-- Include Date Range Picker -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

<script>
function subirimagen()
{
  self.name = 'opener';
  remote = open('actividad/vista/gestionimagen.php', 'remote', 'width=600,height=200,location=no,scrollbars=yes,menubars=no,toolbars=no,resizable=yes,fullscreen=yes, status=yes');
  remote.focus();
  }
  function subirimagen2()
{
  self.name = 'opener';
  remote = open('actividad/vista/gestionimagen2.php', 'remote', 'width=600,height=200,location=no,scrollbars=yes,menubars=no,toolbars=no,resizable=yes,fullscreen=yes, status=yes');
  remote.focus();
  }
</script>

<script>
    $(document).ready(function(){
        var date_input=$('input[name="fechaT"]'); //our date input has the name "date"
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        date_input.datepicker({
            format: 'yyyy/mm/dd',
            container: container,
            todayHighlight: true,
            autoclose: true,
        })
    })
</script>       

<div class="container-fluid fondoInscripcion">
  <?php include_once 'menu_principal/vista/Menu_Usuarios.php'; ?>   
  <?php $cliente=$usuario->id_user;?>        

              <div class="col-md-12">
                  <form id="form1" action="?c=actividad&a=Guardar" name="form1" method="post" enctype="multipart/form-data">
                    <input type="hidden" class="form-control" id="idActividad" name="idActividad" value="<?php echo $vte->idActividad;?>"> 
                    <input type="hidden" class="form-control" id="fechaA" name="fechaA" placeholder="fechaA" value="<?php echo date("Y-m-d");?>">
                    <input type="hidden" class="form-control" id="horaA" name="horaA" placeholder="fechaA" value="<?php echo date("g:i a");?>">
                    <input type="hidden" class="form-control" id="id_user" name="id_user" value="<?php echo $cliente;?>"> 
                    <input type="hidden" class="form-control" id="statusA" name="statusA" value="Pendiente">   
                    
                    <input type="hidden" name="idMaquina" value="<?php echo $vte->idMaquina;?>">
                    
                    <h4 align="center" class="titulos">Actualizar activida: </h4>

                    <label>Linea:</label>
                          <label><?php echo $vte->nLinea;?></label><br>
                    <label>Maquina:</label>
                          <label><?php echo $vte->nMaquina;?></label>
                  

                    <div class="row">
                      <div class="col-md-12 titulos2"><label>Seleccione una Fecha</label>
                        <div class="input-group">
                         <input class="form-control input-xs" id="fechaA" name="fechaA" placeholder="MM/DD/YYY" type="text" value="<?php echo $vte->fechaA;?>" required />
                                  <div class="input-group-addon">
                                 <i class="fa fa-calendar"></i>
                               </div>
                           </div>
                      </div>  
                    </div>
                    <div class="row">
                      <div class="col-md-12 titulos2"><label for="">Seleccione una Actividad:</label>
                          <select name="tipoA" id="tipoA" class="col-md-2 form-control" required="">
                            <option value="<?php echo $vte->tipoA;?>"><?php echo $vte->tipoA;?></option>
                            <option value="GPS">GPS</option>
                            <option value="CAMARAS">CAMARAS</option>  
                            <option value="SISTEMAS">SISTEMAS</option>                               
                          </select>
                                 
                      </div>  
                    </div>

                  <div class="row">     
                    <div class="col-md-12 titulos2">
                      <label for="">Describe la actividad:</label>
                      <input type="text" class="form-control input-xs" id="descripcion" name="descripcion" placeholder="descripcion" value="<?php echo $vte->descripcion;?>" required >
                    </div>              
                  </div>
                  
                  <div class="row">
                    <div class="col-md-10">
                      <label for="">Imagen 1:</label>
                      <input type="txt" class="form-control" id="imagen" name="imagen" placeholder="Imagen 1" value="<?php echo $vte->imagen; ?>"  >
                    
                    </div>
                    <div class="col-md-2">
                      <br><label name="imagen" id="imagen"></label>
                      <input name="Subir Imagen" type="button" class="btn btn-info" id="Subir Imagen" onclick="javascript:subirimagen();" value="Subir Imagen" />
                    </div>
                  </div>  
                                   
                   <div class="row">
                    <div class="col-md-10">
                      <label for="">Imagen 2:</label>
                      <input type="txt" class="form-control" id="imagen2" name="imagen2" placeholder="Imagen 2" value="<?php echo $vte->imagen2; ?>"  >
                    </div>
                    <div class="col-md-2"><br>
                      <input name="Subir Imagen" type="button" class="btn btn-info" id="Subir Imagen" onclick="javascript:subirimagen2();" value="Subir Imagen" />
                    </div>
                  </div> 

                 <div class="row">
                    <div class="col-md-12" align="center">
                          <br><br>
                          <input type="submit"  id="Registrar" class="btn btn-success" value='Registrar'/>
                          <input type="button" id="cancelar" class="btn btn-danger" name="Cancelar" value="Cancelar" onClick="location.href='?c=menu_principal&a=menu_usuarios'">             
                    </div>
                 </div>                          
              </div>
              </form>

</div>

</div>
       
</div>




