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
                        <i class="fa fa-align-justify"></i> Reportes Auditoria
                    </div> 
                </div> 
                <div>                
                <div>                
                    <button type="button" @click="cargarPdf()" class="btn btn-info">
                        <i class="icon-doc"></i>&nbsp;Auditoria Categorias
                    </button>
                </div> 
                <div>
                    <button type="button" @click="cargarPdf2()" class="btn btn-info">
                        <i class="icon-doc"></i>&nbsp;Auditoria Ubicaciones
                    </button>
                </div> 
                <div> 
                    <button type="button" @click="cargarPdf1()" class="btn btn-info">
                        <i class="icon-doc"></i>&nbsp;Auditoria Responsable
                    </button>
                </div> 
                <div> 
                    <button type="button" @click="cargarPdf3()" class="btn btn-info">
                        <i class="icon-doc"></i>&nbsp;Auditoria Activos Fijos
                    </button>
                </div> 
                <div> 
                    <button type="button" @click="cargarPdf()" class="btn btn-info">
                        <i class="icon-doc"></i>&nbsp;Auditoria Depreciación
                    </button>
                </div> 
                <div> 
                    <button type="button" @click="cargarPdf4()" class="btn btn-info">
                        <i class="icon-doc"></i>&nbsp;Auditoria Usuarios
                    </button>
                </div>  
                </div>      
            </div> 
                     
        </main>
</template>

<script>

    export default {

        methods: {

            cargarPdf(){
                window.open('http://localhost:8000/auditoria/listarPdf','_blank');
                //alert("Hola sirve!!");
            },
            cargarPdf1(){
                window.open('http://localhost:8000/auditoria/listarPdf1','_blank');
                //alert("Hola sirve!!");
            },
            cargarPdf2(){
                window.open('http://localhost:8000/auditoria/listarPdf2','_blank');
                //alert("Hola sirve!!");
            },
            cargarPdf3(){
                window.open('http://localhost:8000/auditoria/listarPdf3','_blank');
                //alert("Hola sirve!!");
            },
            cargarPdf4(){
                window.open('http://localhost:8000/auditoria/listarPdf4','_blank');
                //alert("Hola sirve!!");
            },
        },
    }
</script>
<style>
    .btn-info{
        width: 300px;
        margin: 5px;
    }

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
