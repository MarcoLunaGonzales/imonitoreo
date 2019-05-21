<style type="text/css">

#chart-container6 {
    width: 100%;
}
</style>
<?php
//session_start();

//$fondoTemporal='1011|1020';//echo "hola como vamos";

?>
<script type="text/javascript" src="assets/chartjs/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/chartjs/js/Chart.bundle.js"></script>
<script type="text/javascript" src="assets/chartjs/js/utils.js"></script>


</head>

    <div id="chart-container6" style="margin-left:auto; margin-right:auto">
        <canvas id="graphCanvas6"></canvas>
    </div>

    <script>
        $(document).ready(function () {
            showGraph6();
        });
        function showGraph6()
        {
            {
                console.log("antes de los datos Servicios Egresos;");
                $.get("graficos/dataEgresosServicios.php",
				{},
                function (data){
                    console.log("aqui mostramos los datos servicios Egresos:"+data);
                    var fondo = [];
                    var montoPresIngreso = [];
					var montoEjIngreso = [];						

                    for (var i in data) {
						fondo.push(data[i].fondo);
                        console.log(data[i].fondo);
                        montoPresIngreso.push(data[i].montoPresIngreso);
                        montoEjIngreso.push(data[i].montoEjIngreso);                        
                    }
					//alert(labs);
                    var chartdata = {
                        labels: fondo,
                        datasets: [
                            {
                                label: 'PresEgreso.',
                                backgroundColor: "rgba(0,0,205,0.2)",
                                borderColor: "rgb(0,0,205)",
                                borderWidth:2,
                                data: montoPresIngreso
                            },
                            {
                                label: 'EjEgreso.',
                                backgroundColor: "rgba(255,69,0,0.2)",
                                borderColor: "rgb(255,69,0)",
                                borderWidth:2,
                                data: montoEjIngreso
                            }
                        ]
                    };

                    var graphTarget = $("#graphCanvas6");

                    var barGraph = new Chart(graphTarget, {
                        type: 'bar',
                        data: chartdata,
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

                });
            }
        }
        </script>
