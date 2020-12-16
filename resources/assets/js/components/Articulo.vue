<template>
<main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                
                <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
                
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Activos
                        <button type="button" @click="abrirModal('articulo','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                        <!--<button type="button" @click="cargarPdf()" class="btn btn-info">
                            <i class="icon-doc"></i>&nbsp;Reporte
                        </button>-->
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      <option value="descripcion">Descripción</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarArticulo(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarArticulo(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Categoría</th>
                                     <th>Ubicación</th>
                                    <th>Costo</th>
                                    <th>V. Residual</th>
                                    <!--<th>Descripción</th>-->
                                    <th>Imagen</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="articulo in arrayArticulo" :key="articulo.id">
                                    <td>
                                        
                                        <button type="button" data-toggle="tooltip" title="Editar"  @click="abrirModal('articulo','actualizar',articulo)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="articulo.condicion">
                                            <button type="button" data-toggle="tooltip" title="Desactivar" class="btn btn-danger btn-sm" @click="desactivarArticulo(articulo.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" data-toggle="tooltip" title="Activar" class="btn btn-info btn-sm" @click="activarArticulo(articulo.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                       <!-- <button type="button" data-toggle="tooltip" title="Depreciado" class="btn btn-secondary btn-sm"> Depreciado
                                            <i class="icon-bell"></i>
                                        </button>
                                        <button type="button" data-toggle="tooltip" title="Vendido" class="btn btn-primary btn-sm"> Vendido
                                            <i class="icon-basket"></i>                                           
                                        </button>-->
                                        
                                    </td>
                                    <td v-text="articulo.codigo"></td>
                                    <td v-text="articulo.nombre"></td>
                                    <td v-text="articulo.nombre_categoria"></td>
                                    <td v-text="articulo.nombre_ubicacion"></td>
                                    <td v-text="articulo.costo"></td>
                                    <td v-text="articulo.vresidual"></td>
                                    <!--<td v-text="articulo.descripcion"></td>
                                    <td img :src="'../img/articulo/'+articulo.imagen" class="img-responsive" width="100px" height="100px"></td>-->
                                    <td>
                                    <img :src="'../img/articulo/'+articulo.imagen" class="img-responsive" width="70px" height="50px">
                                    </td>
                                    <td>
                                        <div v-if="articulo.condicion === 0">
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                        <div v-if="articulo.condicion === 1">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-if="articulo.condicion === 2">
                                            <span class="badge badge-secondary">Depreciado</span>
                                        </div>
                                        <div v-if="articulo.condicion === 3">
                                            <span class="badge badge-primary">Vendido</span>
                                        </div>
                                        
                                    </td>
                                </tr>
                                
                                
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>                        
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    
                    <div class="modal-content">
                        <div class="modal-a">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" id="po" method="post" enctype="multipart/form-data" class="form-horizontal">
                                                             <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">N° Activo</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="codigo" onkeypress='return event.charCode >= 48 && event.charCode <= 57' class="form-control" placeholder="Numero de Activo">    
                                        <!--<barcode :value="codigo" :options="{ format: 'EAN-13'} ">
                                         Generando código de barras.   
                                        </barcode>        -->                   
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de activo">                                        
                                    </div>
                                </div>
                            <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Categoría</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="idcategoria">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="categoria in arrayCategoria" :key="categoria.id" :value="categoria.id" v-text="categoria.nombre"></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Ubicación</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="idubicacion">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="ubicacion in arrayUbicacion" :key="ubicacion.id" :value="ubicacion.id" v-text="ubicacion.nombreUbicacion"></option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Responsable</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="idresponsable">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="responsable in arrayResponsable" :key="responsable.id" :value="responsable.id" v-text="responsable.nombreResponsable"></option>
                                        </select>
                                    </div>
                                </div>

                                 <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Costo</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="costo" class="form-control" placeholder="">                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Valor Residual</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="vresidual" class="form-control" placeholder="">                                        
                                    </div>
                                </div>
                                <!--<form id="form">-->
                                <!-- ABRIR FECHA-->
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="date">Fecha Compra</label>
                                    <div class="col-md-9">
                                        <input type="date" v-model="fcompra" class="form-control" id="fecha_compra" >
                                      <!--  <p>{{ getHumanDate(fcompra) }}</p>  -->                                    
                                    </div>
                                </div>

                                <!-- CERRAR FECHA -->

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Vida Util(meses)</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="vidaUtil" class="form-control" id="vida_util" placeholder="">                                        
                                    </div>
                                </div>

                                                                <!-- ABRIR FECHA-->
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="date">Fecha Salida</label>
                                    <div class="col-md-9">
                                        <input type="date" v-model="fechaSalida" class="form-control" id="input" >                                        
                                         <button type="button" class="btn btn-primary" @click="aumentaFecha()" >Actualizar Fecha</button>                                                                                                             
                                    </div>
                                </div>
                                <!--</form>-->
                                <!-- CERRAR FECHA -->

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Descripción</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="descripcion" class="form-control" placeholder="Ingrese descripción">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Estado</label>
                                    <div class="col-md-9">
                                        <select v-model="condicion" class="form-control">
                                            <option value="1">Activo</option>
                                            <option value="0">Desactivado</option>
                                            <option value="2">Depreciado</option>
                                            <option value="3">Vendido</option>
                                        </select>                                    
                                    </div>
                                </div>

                                <!---  IMAGEN AQUIII -->

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Imagen</label>
                                    <div class="col-md-9">
                                      
                                        <!--poniendo :src se llama a la variable imagen que esta declarada en la propiedad data-->
                                        <!--poner this.imagen=""; en cerrarModal para limpiar el campo ya que aparecia la imagen al registrar un registro-->
                                       

                                     <!--   <div v-if="tipoAccion==1">-->
                                            <input type="file" @change="subirImagen" class="form-control" placeholder="">
                                      <!--      <img :src="imagen" class="img-responsive" width="100px" height="100px">
                                        </div>-->
                                             

                                     <!--    <div v-if="tipoAccion==2">

                                                <input type="file" @change="subirImagen" class="form-control" placeholder="">      
                                               <img :src="imagen" class="img-responsive"  width="100px" height="100px"> --> 
                                                <!--<img :src="'/img/articulo/'+imagen"  width="100px" height="100px">                         -->
                                     <!--   </div> -->
                                            
                      
                                    </div>
                                </div>

                                  <!---TERMINA IMAGEN AQUIII -->

                                <div v-show="errorArticulo" class="form-group row div-error">
                                    <div class="text-center text-error" >
                                        <div v-for="error in errorMostrarMsjArticulo" :key="error" v-text="error">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarArticulo()">Guardar</button>.
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarArticulo()" >Actualizar</button>
                        </div>
                    </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
        

        </main>
</template>

<script>

    $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
    });

    import VueBarcode from 'vue-barcode';
    import moment from 'moment';
    import Datepicker from 'vuejs-datepicker';

    export default {

        data (){
            return {
                articulo_id: 0,
                idcategoria : 0,
                nombre_categoria : '',
                idubicacion : 0,
                nombre_ubicacion : '',
                idresponsable : 0,
                nombre_responsable : '',
                codigo : '',                
                nombre : '',
                costo : 0,
                vresidual: 0,
                fcompra: '',
                vidaUtil: 0,
                fechaSalida: '',//fcompra.getFullYear() + "-" + (fcompra.getMonth()+vidaUtil) + "-" + fcompra.getDate(),                
                descripcion : '',     
                condicion : '',
                imagen : '',                           
                arrayArticulo : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorArticulo : 0,
                errorMostrarMsjArticulo : [],
                pagination : {
                    'total'         : 0,
                    'current_page'  : 0,
                    'per_page'      : 0,
                    'last_page'     : 0,
                    'from'          : 0,
                    'to'            : 0,
                },
                offset : 3,
                criterio : 'nombre',
                buscar : '',
                arrayCategoria : [],
                arrayUbicacion : [],
                arrayResponsable : []
            }
        },
        //components: {
        //    'barcode': VueBarcode
          // datetime: moment
       // },
        computed: {


            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginacion
            pagesNumber: function(){
                if (!this.pagination.to) {
                    return [];
                }

                var from = this.pagination.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2);
                if (to >= this.pagination.last_page) {
                    to = this.pagination.last_page;
                }

                var pagesArray = [];
                while(from <= to){
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            },

        },

        methods: {
            //calcularTotal

            /* METODO PARA CONVERTIT FECHA
            getHumanDate : function (fcompra) {
                   return moment(fcompra, 'YYYY-MM-DD').format('DD/MM/YYYY');
            },*/
            aumentaFecha: function(){
                let num = parseInt(document.getElementById('vida_util').value);
                // la fecha viene en formato yyyy-mm-dd
                let f = document.getElementById('fecha_compra').value;

                let fecha = new Date(f);
                fecha.setMonth(fecha.getMonth() + num);
                //
                let mes = fecha.getUTCMonth() + 1;
                if (mes <= 9) mes = '0' + mes;
                //
                let dia = fecha.getUTCDate();
                if (dia <= 9) dia = '0' + dia;

                let el = document.getElementById("input");
                el.value = fecha.getUTCFullYear() + '-' + mes + '-' + dia;    
                el.dispatchEvent(new Event('input'));
            },         

            listarArticulo(page, buscar, criterio){
                let me=this;
                var url = '/articulo?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayArticulo = respuesta.articulos.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            cargarPdf(){
                window.open('http://localhost:8000/articulo/listarPdf','_blank');
            },
            selectCategoria(){
                let me=this;
                var url = '/categoria/selectCategoria';
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayCategoria = respuesta.categorias;
                    
                    //console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            selectUbicacion(){
                let me=this;
                var url = '/ubicacion/selectUbicacion';
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayUbicacion = respuesta.ubicaciones;
                    
                    //console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            selectResponsable(){
                let me=this;
                var url = '/responsable/selectResponsable';
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayResponsable = respuesta.responsables;
                    
                    //console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            subirImagen(e){
                
                let me=this;
                let file = e.target.files[0];            
                //console.log(file);
                let reader = new FileReader();
                reader.onloadend = (file) => {                    
                    //console.log('RESULT', reader.result)
                    me.imagen = reader.result;
                }
                reader.readAsDataURL(file);
            },
            cambiarPagina(page, buscar, criterio){
                let me = this;
                // Actualiza la pagina actual
                me.pagination.current_page = page;
                // Envia la peticion para visualizar la data de esa pagina
                me.listarArticulo(page, buscar, criterio);
            },
            registrarArticulo(){

                //console.log("Holaaa.");
                if (this.validarArticulo()) {
                    return;
                }

                let me = this;

                axios.post('/articulo/registrar',{
                    'idcategoria': this.idcategoria,
                    'idubicacion': this.idubicacion,
                    'idresponsable': this.idresponsable,
                    'codigo': this.codigo,
                    'nombre': this.nombre,
                    'vresidual' : this.vresidual,
                    'fcompra' : this.fcompra,
                    'vidaUtil' : this.vidaUtil,
                    'fechaSalida' : this.fechaSalida,
                    'costo': this.costo,
                    'descripcion': this.descripcion,
                    'condicion' : this.condicion,
                    'imagen': this.imagen
                }).then(function (response){
                    me.cerrarModal();
                    me.listarArticulo(1,'','nombre');
                    //me.aumentaFecha();
                }).catch(function (error){
                    console.log(error);
                });
            },
            actualizarArticulo(){
                if (this.validarArticulo()) {
                    return;
                }

                let me = this;
               
                axios.put('/articulo/actualizar',{
                    'idcategoria': this.idcategoria,
                    'idubicacion': this.idubicacion,
                    'idresponsable': this.idresponsable,
                    'codigo': this.codigo,
                    'nombre': this.nombre,
                    'vresidual' : this.vresidual,
                    'fcompra' : this.fcompra,
                    'vidaUtil' : this.vidaUtil,
                    'fechaSalida' : this.fechaSalida,
                    'costo': this.costo,
                    'descripcion': this.descripcion,
                    'condicion' : this.condicion,
                    'imagen': this.imagen,
                    'id': this.articulo_id
                }).then(function (response){
                    me.cerrarModal();
                    me.listarArticulo(1,'','nombre');
                    //me.aumentaFecha();
                }).catch(function (error){
                    console.log(error);
                });
            },
            desactivarArticulo(id){
                swal({
                title: 'Esta seguro de desactivar este activo?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put('/articulo/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarArticulo(1,'','nombre');
                        swal(
                        'Desactivado!',
                        'El registro ha sido desactivado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
            activarArticulo(id){
                swal({
                title: 'Esta seguro de activar este activo?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put('/articulo/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarArticulo(1,'','nombre');
                        swal(
                        'Activado!',
                        'El registro ha sido activado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
            validarArticulo(){
                this.errorArticulo=0;
                this.errorMostrarMsjArticulo =[];

                if (this.idcategoria==0) this.errorMostrarMsjArticulo.push("Seleccione una categoria.");
                if (this.idubicacion==0) this.errorMostrarMsjArticulo.push("Seleccione una ubicacion.");
                if (this.idresponsable==0) this.errorMostrarMsjArticulo.push("Seleccione un responsable.");
                if (!this.nombre) this.errorMostrarMsjArticulo.push("El nombre del activo no puede estar vacío."); 
                if (!this.vresidual) this.errorMostrarMsjArticulo.push("El valor residual del articulo debe ser un número y no puede estar vacío.");
                if (!this.fcompra) this.errorMostrarMsjArticulo.push("Debe colocar una fecha correcta.");
                if (!this.vidaUtil) this.errorMostrarMsjArticulo.push("Debe colocar la vida util del activo.");
                //if (!this.costo) this.errorMostrarMsjArticulo.push("El costo del activo debe ser un número y no puede estar vacío.");
                if(!this.imagen) this.errorMostrarMsjArticulo.push("(*)Debe subir una imagen");
                if (this.errorMostrarMsjArticulo.length) this.errorArticulo = 1; 

                return this.errorArticulo;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.idcategoria=0;
                this.nombre_categoria='';
                this.idubicacion=0;
                this.nombre_ubicacion='';
                this.idresponsable=0;
                this.nombre_responsable='';
                this.codigo='';
                this.nombre='';
                this.costo = 0;
                this.vresidual = 0;
                this.fcompra = '';                
                this.vidaUtil = 0;
                this.fechaSalida = '';
                this.descripcion='';
                this.condicion='';
                this.imagen='';
                this.errorArticulo=0;
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "articulo":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Activo';
                                this.idcategoria=0;
                                this.nombre_categoria='';
                                this.idubicacion=0;
                                this.nombre_ubicacion='';
                                this.idresponsable=0;
                                this.nombre_responsable='';
                                this.codigo='';
                                this.nombre = '';
                                this.costo=0;
                                this.vresidual=0;
                                this.fcompra='';
                                this.vidaUtil=0;
                                this.fechaSalida='';
                                this.descripcion = '';
                                this.condicion='';
                                this.imagen = '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Actualizar Activo';
                                this.tipoAccion = 2;
                                this.articulo_id = data['id'];
                                this.idcategoria = data['idcategoria'];
                                this.idubicacion = data['idubicacion'];
                                this.idresponsable = data['idresponsable'];
                                this.codigo = data['codigo'];
                                this.nombre = data['nombre'];
                                this.vresidual = data['vresidual'];
                                this.fcompra = data['fcompra'];                                
                                this.vidaUtil = data['vidaUtil'];
                                this.fechaSalida = data['fechaSalida'];
                                this.costo = data['costo'];
                                this.descripcion = data['descripcion'];
                                this.condicion= data['condicion'];
                                this.imagen = data['imagen'];
                                break;
                            }
                        }
                    }
                }
                this.selectCategoria();
                this.selectUbicacion();
                this.selectResponsable();
                //this.aumentaFecha();
            }
        },
        mounted() {
            //console.log('Component mounted.')
            this.listarArticulo(1,this.buscar,this.criterio);
        }
    }
</script>
<style>
    
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .modal-a{
        height: 600px;
        overflow: scroll;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;  
        
    }

    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>
