<head>
<script src="persona/js/ajaxA.js"></script>
</head>
<div class="container-fluid">
    <h2>Personas</h2>
    <div class="row">
        <div class="col-auto h5">
            <p align="center">Mostrar :</p>
                <select name="num_registros" id="num_registros" class="form-control">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select><br>
                     <p align="center">Registros</p>   
        </div>

        <div class="col-auto h5">
            <p align="left">Buscar:</p>
            <input type="text" name="campo" id="campo" class="form-control">
        </div>    
        <div class="col-auto h5">
            <p align="left">Genero:</p>
                <select name="genero" id="genero" class="form-control">
                    <option value="">Todos</option>
                    <option value="M">M</option>
                    <option value="F">F</option>

                </select>
        </div> 
        <div class="col-auto h5">
            <p align="left">Empresa:</p>
                <select name="idEmpresa" id="idEmpresa" class="form-control">
                    <option value="">Todas</option>               
                        <?php  foreach ($this->model->ListarEmpresas()as $a): ?>
                    <option  <?php echo $a->idEmpresa == "" ? 'selected' : ''; ?> value="<?php echo "$a->idEmpresa" ;?>"><?php echo $a->nombreEmpresa;?></option>
                    <?php endforeach; ?>
                    </select>
        </div>  

        <div class="col-auto h5">
            <p align="left">Creado Desde:</p>
            <div class="input-group">
                <input class="form-control" id="desde" name="desde"  type="date" value=""  autocomplete="off" required/>
            </div>  
        </div>

        <div class="col-auto h5">
            <p align="left">Creado Hasta:</p>
            <div class="input-group">
                <input class="form-control" id="hasta" name="hasta"  type="date" value=""  autocomplete="off" required/>
            </div>
        </div>        

        <div class="col-auto h5">
            <a href="javascript:reportePDF1();"  data-toggle="tooltip" title="descargar actividad"><img src="img/pdf.png" width="50px" height="50px"><p align="center">Descargar</p></a>     
        </div>

        <div class="col-auto h5">
            <a href="javascript:reporteExcel();"  data-toggle="tooltip" title="descargar personas"><img src="img/excel.png" width="50px" height="50px"><p align="center">Descargar</p></a>
        </div>
 </div>


            <div class="row py-4">
                <div class="col">
                    <table class="table table-sm table-bordered table-striped">
                        <thead class="bg-primary">
                            <th class="sort asc h4" >#</th>
                            <th class="sort asc h4">R.u.t</th>
                            <th class="sort asc h4">Persona</th>
                            <th class="sort asc h4">Fecha Creado</th>
                            <th class="sort asc h4">Hora Creado</th>
                            <th class="sort asc h4">Genero</th>
                            <th class="sort asc h4">Empresa</th>
                            <th class="sort asc h4">Tarjeta Qr</th>
                            <th class="h4">EDITAR</th>
                            <th class="h4">ELIMINAR</th>
                        </thead>

                        <!-- El id del cuerpo de la tabla. -->
                        <tbody id="content" class="h5" align="center" >

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <label id="lbl-total"></label>
                </div>

                <div class="col-6" id="nav-paginacion"></div>

                <input type="hidden" id="pagina" value="1">
                <input type="hidden" id="orderCol" value="0">
                <input type="hidden" id="orderType" value="asc">
            </div>
        </div>
    </main>

    <script>
        /* Llamando a la función getData() */
        getData()

        /* Escuchar un evento keyup en el campo de entrada y luego llamar a la función getData. */
        document.getElementById("campo").addEventListener("keyup", function() {
            getData()
        }, false)
        document.getElementById("num_registros").addEventListener("change", function() {
            getData()
        }, false)


        document.getElementById("genero").addEventListener("change", function() {
            getData()
        }, false)

         document.getElementById("idEmpresa").addEventListener("change", function() {
            getData()
        }, false)       

         document.getElementById("desde").addEventListener("change", function() {
            getData()
        }, false)  

         document.getElementById("hasta").addEventListener("change", function() {
            getData()
        }, false)           
        /* Peticion AJAX */
        function getData() {
            let input = document.getElementById("campo").value
            let genero = document.getElementById("genero").value
            let idEmpresa = document.getElementById("idEmpresa").value
            let desde = document.getElementById("desde").value
            let hasta = document.getElementById("hasta").value
            let num_registros = document.getElementById("num_registros").value
            let content = document.getElementById("content")
            let pagina = document.getElementById("pagina").value
            let orderCol = document.getElementById("orderCol").value
            let orderType = document.getElementById("orderType").value

            if (pagina == null) {
                pagina = 1
            }

            let url = "persona/vista/loadPersonas.php"
            let formaData = new FormData()
            formaData.append('campo', input)
            formaData.append('genero', genero)
            formaData.append('idEmpresa', idEmpresa)
            formaData.append('desde', desde)
            formaData.append('hasta', hasta)
            formaData.append('registros', num_registros)
            formaData.append('pagina', pagina)
            formaData.append('orderCol', orderCol)
            formaData.append('orderType', orderType)

            fetch(url, {
                    method: "POST",
                    body: formaData
                }).then(response => response.json())
                .then(data => {
                    content.innerHTML = data.data
                    document.getElementById("lbl-total").innerHTML = 'Mostrando ' + data.totalFiltro +
                        ' de ' + data.totalRegistros + ' registros'
                    document.getElementById("nav-paginacion").innerHTML = data.paginacion
                }).catch(err => console.log(err))
        }

        function nextPage(pagina){
            document.getElementById('pagina').value = pagina
            getData()
        }

        let columns = document.getElementsByClassName("sort")
        let tamanio = columns.length
        for(let i = 0; i < tamanio; i++){
            columns[i].addEventListener("click", ordenar)
        }

        function ordenar(e){
            let elemento = e.target

            document.getElementById('orderCol').value = elemento.cellIndex

            if(elemento.classList.contains("asc")){
                document.getElementById("orderType").value = "asc"
                elemento.classList.remove("asc")
                elemento.classList.add("desc")
            } else {
                document.getElementById("orderType").value = "desc"
                elemento.classList.remove("desc")
                elemento.classList.add("asc")
            }

            getData()
        }

    </script>

    <!-- Bootstrap core JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>