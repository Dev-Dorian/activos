<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
					<form action="" method="post" enctype="multipart/form-data" >
					    <div class="form-group row">
					     	<label for="server" class="col-sm-3 col-form-label">Servidor</label>
					      	<div class="col-sm-9">
					        	<input type="text" value="localhost" class="form-control" id="server" name="server">
					      	</div>
					    </div>
					    <div class="form-group row">
					      	<label for="username" class="col-sm-3 col-form-label">Usuario</label>
					      	<div class="col-sm-9">
					        	<input type="text" value="root" class="form-control" id="username" name="username" >
					      	</div>
					    </div>
					    <div class="form-group row">
					      	<label for="password" class="col-sm-3 col-form-label">Contraseña</label>
					      	<div class="col-sm-9">
					        	<input type="text" class="form-control" id="password" name="password">
					      	</div>
					    </div>
					    <div class="form-group row">
					      	<label for="dbname" class="col-sm-3 col-form-label">Base de datos</label>
					      	<div class="col-sm-9">
					        	<input type="text" value="dbsistemalaravel" class="form-control" id="dbname" name="dbname" >
					      	</div>
					    </div>
					     <button type="submit" class="btn btn-primary" @click="registrarRespaldo()" name="backup">Respaldo</button>
                 
                        
					</form>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
        </main>
</template>
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

<script>
        export default {
            methods: {



                registrarRespaldo(){

                let me = this;

                axios.post('/respaldo/registrar',{
                }).then(function (response){
                }).catch(function (error){
                    console.log(error);
                });
   
            },
                
               
                    //href = ('C:/xampp/htdocs/Centro_Diurno/backup/MySQLBackup.bat');
                       //WshShell = new ActiveXObject("WScript.Shell");
                       // WshShell.Run("C:/xampp/htdocs/Centro_Diurno/backup/MySQLBackup.bat", 1, false);

                    

                    //console.log("Genero correcto");
                
                //let me = this;

                //axios.post('myphp-backup.php');                
            
        },
}
</script>