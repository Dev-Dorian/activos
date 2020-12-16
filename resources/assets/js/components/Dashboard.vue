<template>
<main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
    </ol>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                
            </div>
            <div class="car-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-chart">
                            <div class="card-header">
                                <h4>Activos Fijos</h4>
                            </div>
                            <div class="card-content">
                                <div class="ct-chart">
                                    <canvas id="articulos">                                                
                                    </canvas>
                                </div>
                            </div>
                            <div class="card-footer">
                                <p>Activos fijos de los últimos meses.</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</main>
</template>
<script>
    export default {
        data (){
            return {
                varArticulo:null,
                charArticulo:null,
                articulos:[],
                varTotalArticulo:[],
                varMesArticulo:[], 
                

            }
        },
        methods : {
            getArticulos(){
                let me=this;
                var url= '/dashboard';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.articulos = respuesta.articulos;
                    //cargamos los datos del chart
                    me.loadArticulos();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            loadArticulos(){
                let me=this;
                me.articulos.map(function(x){
                    me.varMesArticulo.push(x.mes);
                    me.varTotalArticulo.push(x.costo);
                });
                me.varArticulo=document.getElementById('articulos').getContext('2d');

                me.charArticulo = new Chart(me.varArticulo, {
                    type: 'bar',
                    data: {
                        labels: me.varMesArticulo,
                        datasets: [{
                            label: 'Articulos',
                            data: me.varTotalArticulo,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 0.2)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                }
                            }]
                        }
                    }
                });
            },
            
        },
        mounted() {
            this.getArticulos();
            
        }
    }
</script>
