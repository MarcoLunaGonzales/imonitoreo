<style type="text/css">

#chart-container5 {
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

    <div id="chart-container5" style="margin-left:auto; margin-right:auto">
        <canvas id="graphCanvas5"></canvas>
    </div>

    <script>
        $(document).ready(function () {
            showGraph5();
        });
        function showGraph5()
        {
            {
                console.log("antes de los datos Servicios;");
                $.get("graficos/dataIngresosServicios.php",
				{},
                function (data){
                    console.log("aqui mostramos los datos servicios:"+data);
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
                                label: 'PresIng.',
                                backgroundColor: "rgba(255, 99, 132, 0.2)",
                                borderColor: "rgb(255, 99, 132)",
                                borderWidth:2,
                                data: montoPresIngreso
                            },
                            {
                                label: 'EjIngreso.',
                                backgroundColor: "rgba(75, 192, 192, 0.2)",
                                borderColor: "rgb(75, 192, 192)",
                                borderWidth:2,
                                data: montoEjIngreso
                            }
                        ]
                    };

                    var graphTarget = $("#graphCanvas5");

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
