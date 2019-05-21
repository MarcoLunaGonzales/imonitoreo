<style type="text/css">
BODY {
	width: 100%;
	height: 300px;
}

#chart-container {
    width: 80%;
}
</style>
<?php
//session_start();
$fondoTemporal=$_SESSION['fondoTemporal'];
$anioTemporal=$_SESSION['anioTemporal'];
$mesTemporal=$_SESSION['mesTemporal'];

/*$fondoTemporal=1030;
$anioTemporal=2019;
$mesTemporal=2;*/


//$fondoTemporal='1011|1020';//echo "hola como vamos";

?>
<script type="text/javascript" src="../assets/chartjs/js/jquery.min.js"></script>
<script type="text/javascript" src="../assets/chartjs/js/Chart.bundle.js"></script>
<script type="text/javascript" src="../assets/chartjs/js/utils.js"></script>


</head>

    <div id="chart-container" style="margin-left:auto; margin-right:auto">
        <canvas id="graphCanvas"></canvas>
    </div>

    <script>
        $(document).ready(function () {
            showGraph();
        });

/*
fondoTemporal:<?=$fondoTemporal;?>,
anioTemporal:<?=$anioTemporal;?>,
mesTemporal:<?=$mesTemporal;?>
*/
        function showGraph()
        {
            {
                console.log("entramos;");
                $.get("dataPresOpPorServicio.php",
				{},
                function (data)
                {
                    console.log(data);
                    var servicio = [];
                    var montoPresIngreso = [];
					var montoEjIngreso = [];						
                    var montoPresEgreso = [];
					var montoEjEgreso = [];	
                    var resultadoPres = [];
                    var resultadoEj = []; 


                    for (var i in data) {
						servicio.push(data[i].servicio);
                        montoPresIngreso.push(data[i].montoPresIngreso);
                        montoEjIngreso.push(data[i].montoEjIngreso);
                        
                        montoPresEgreso.push(data[i].montoPresEgreso);
                        montoEjEgreso.push(data[i].montoEjEgreso);

                        resultadoPres.push(data[i].resultadoPres);
                        resultadoEj.push(data[i].resultadoEj);

                    }
					//alert(labs);
                    var chartdata = {
                        labels: servicio,
                        datasets: [
                            /*{
                                label: 'PresupuestoIng.',
                                backgroundColor: '#81D4FA',
                                borderColor: '#81D4FA',
                                data: montoPresIngreso
                            },
                            {
                                label: 'ResultadoPres.',
                                backgroundColor: '#01579B',
                                borderColor: '#01579B',
                                data: resultadoPres
                            },*/

                            {
                                label: 'EjecutadoIng.',
                                backgroundColor: "rgba(55, 128, 249, 0.2)",
                                borderColor: "rgb(55, 128, 249)",
                                borderWidth:2,
                                data: montoEjIngreso
                            },
                            /*{
                                label: 'PresupuestoEgresos',
                                backgroundColor: '#FFCC80',
                                borderColor: '#FFCC80',
                                data: montoPresEgreso
                            },*/
                            {
                                label: 'ResultadoEj.',
                                backgroundColor: "rgba(249, 125, 55, 0.2)",
                                borderColor: "rgb(249, 125, 55)",
                                borderWidth:2,
                                data: resultadoEj
                            },                            
                            {
                                label: 'EjecutadoEgresos',
                                backgroundColor: "rgba(249, 246, 55, 0.2)",
                                borderColor: "rgb(249, 246, 55)",
                                borderWidth:2,
                                data: montoEjEgreso
                            }
                        ]
                    };

                    var graphTarget = $("#graphCanvas");

                    var barGraph = new Chart(graphTarget, {
                        type: 'bar',
                        data: chartdata,
						options: {
							responsive: true,
							legend: {
								position: 'top',
							},
							title: {
								display: true,
								text: 'Seguimiento al Presupuesto Operativo Por Servicio'
							}
						}
                    });
                });
            }
        }
        </script>
