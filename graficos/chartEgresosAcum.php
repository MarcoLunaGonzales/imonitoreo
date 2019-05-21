<style type="text/css">

#chart-container4 {
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

    <div id="chart-container4" style="margin-left:auto; margin-right:auto">
        <canvas id="graphCanvas4"></canvas>
    </div>

    <script>
        $(document).ready(function () {
            showGraph4();
        });
        function showGraph4()
        {
            {
                console.log("antes de los datos;");
                $.get("graficos/dataEgresosAcum.php",
				{},
                function (data){
                    console.log("aqui mostramos los datos:"+data);
                    var fondo = [];
                    var montoPres = [];
					var montoEj = [];						

                    for (var i in data) {
						fondo.push(data[i].fondo);
                        console.log(data[i].fondo);
                        montoPres.push(data[i].montoPres);
                        montoEj.push(data[i].montoEj);                        
                    }
					//alert(labs);
                    var chartdata = {
                        labels: fondo,
                        datasets: [
                            {
                                label: 'PresEg.',
                                backgroundColor: "rgba(0, 255, 127, 0.2)",
                                borderColor: "rgb(0, 255, 127)",
                                borderWidth:2,
                                data: montoPres
                            },
                            {
                                label: 'EjEg.',
                                backgroundColor: "rgba(255, 99, 71, 0.2)",
                                borderColor: "rgb(255, 99, 71)",
                                borderWidth:2,
                                data: montoEj
                            }
                        ]
                    };

                    var graphTarget = $("#graphCanvas4");

                    var barGraph = new Chart(graphTarget, {
                        type: 'horizontalBar',
                        data: chartdata,
						options: {
							responsive: true,
							legend: {
								position: 'top',
							},
							title: {
								display: true,
                                text: ''
							}
						}
                    });

                });
            }
        }
        </script>
