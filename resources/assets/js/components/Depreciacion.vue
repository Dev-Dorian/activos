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
                        <i class="fa fa-align-justify"></i> Depreciaciónes
                       <!-- <button type="button" @click="abrirModal('depreciacion','registrar')" class="btn btn-secondary">
                        <button type="button" @click="calcularDepreciacion()" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Calcular Depreciación
                        </button>                     
                        <i></i> Fecha Depreciación&nbsp;
			            <datepicker v-model="fechaDepreciacion" :format="customFormatter" placeholder="Fecha" name="uniquename">
                        </datepicker>
                        <button type="button" @click="registrarDepreciacion()" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Depreciar
                        </button>-->
                    </div>
                    
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                     <option value="nombre">Nombre</option>
                                      <option value="codigo">Codigo</option>                                                                                                                  
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarDepreciacion(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarDepreciacion(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>                                    
                                    <th>Codigo</th>
                                    <th>Nombre</th>
                                    <th>F. Compra</th>
                                    <th>F. Depreciación</th> 
                                    <th>M. Depreciado</th>                                    
                                    <th>D. Acumulada</th>       
                                    <th>V. Libros</th>                                                                   
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="depreciacion in arrayDepreciacion" :key="depreciacion.id">
                                    <td v-text="depreciacion.codigo"></td>
                                    <td v-text="depreciacion.nombre_articulo"></td>
                                    <td v-text="depreciacion.fcompra_articulo"></td>
                                    <td v-text="depreciacion.fechaDepreciacion"></td>
                                    <td v-text="depreciacion.montoDepreciado"></td>
                                    <td v-text="depreciacion.depreciacionAcumulada"></td>                                    
                                    <td v-text="depreciacion.valorLibros"></td>                                                                        
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
            <!--<div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Codigo</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="codigo" class="form-control" placeholder="Codigo de Depreciacion">
                                        <input type="text" v-model="montoDepreciado" class="form-control" placeholder="Monto de Depreciacion">
                                        
                                    </div>
                                </div>

                                <div v-show="errorDepreciacion" class="form-group row div-error">
                                    <div class="text-center text-error" >
                                        <div v-for="error in errorMostrarMsjDepreciacion" :key="error" v-text="error">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-secondary" @click="">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarDepreciacion()">Guardar</button>.
                            
                        </div>
                    </div>
                    
                </div>
                
            </div>-->
            <!--Fin del modal-->
        

        </main>
</template>

<script>
    import moment from 'moment';
    import DatePicker from 'vuejs-datepicker';
    

    export default {
        
        data (){
            return {
                
                codigo : '',
                nombre_articulo : '',            
                fcompra_articulo : '',
                fechaDepreciacion : '',
                costo_articulo : 0,
                montoDepreciado: 0,
                depreciacionAcumulada: 0,
                valorLibros : 0,
                

                costo: 0,
                


               
                arrayDepreciacion : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorDepreciacion : 0,
                errorMostrarMsjDepreciacion : [],
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
                buscar : ''
            }
        },
        components: {
           'datepicker': DatePicker,
                    
        },
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
            /*calcularDepreciacion: function(){
                montoDepreciado = (costo_articulo.Value / vidaUtil_articulo.Value)
                console.log(montoDepreciado);
            },*/
            customFormatter(date) {
                return moment(date).format('MM/YYYY');                
                                                
            },
            listarDepreciacion(page, buscar, criterio){
                let me=this;
                var url='/depreciacion?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayDepreciacion = respuesta.depreciaciones.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            cambiarPagina(page, buscar, criterio){
                let me = this;
                // Actualiza la pagina actual
                me.pagination.current_page = page;
                // Envia la peticion para visualizar la data de esa pagina
                me.listarDepreciacion(page, buscar, criterio);
            },
            registrarDepreciacion(){
                let me = this;

                axios.post('/depreciacion/registrar',{
                    'codigo': this.codigo,
                    'fechaDepreciacion': this.fechaDepreciacion,
                    'montoDepreciado': this.montoDepreciado

                   
                }).then(function (response){
                    
                    me.listarDepreciacion(1,'','codigo');
                }).catch(function (error){
                    console.log(error);
                });
            },            
            /*abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "depreciacion":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.codigo;
                                this.fechaDepreciacion;
                                this.montoDepreciado;


                                break;
                            }
                        }
                    }
                }

            }*/
        },
        mounted() {
            //console.log('Component mounted.')
            this.listarDepreciacion(1,this.buscar,this.criterio);
        }
    }
</script>
<style>
    .modal-content{
        width: 100% !important;
        position: absolute !important;
        
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
