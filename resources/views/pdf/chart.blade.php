<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
        ]); ?>

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['ID', 'Categorias'],  
                  
          @foreach ($articulos as $articulos)
          [ '{{$articulos->nombre}}', {{$articulos->costo}} ],
          @endforeach
        ]);

        var options = {
          title: 'Activos por categorias'
        };    

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="piechart" style="width: 900px; height: 500px;"></div>
  </body>
</html>
