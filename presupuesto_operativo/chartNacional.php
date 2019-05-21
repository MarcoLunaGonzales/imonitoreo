<style type="text/css">
BODY {
	width: 100%;
	height: 300px;
}

#chart-container {
    width: 60%;
}
</style>
<?php
//session_start();


$fondoTemporal=$_SESSION['fondoTemporal'];
$anioTemporal=$_SESSION['anioTemporal'];
$mesTemporal=$_SESSION['mesTemporal'];

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
fondoTemporal:escape(<?=$fondoTemporal;?>),
                anioTemporal:<?=$anioTemporal;?>,
                mesTemporal:<?=$mesTemporal;?>
*/
        function showGraph()
        {
            {
                $.get("dataPresOpNacional.php",
				{},
                function (data)
                {
                    console.log(data);
                    var gestion = [];
                    var montoPresIngreso = [];
					var montoEjIngreso = [];						
                    var montoPresEgreso = [];
					var montoEjEgreso = [];	
                    var resultadoPres = [];
                    var resultadoEj = []; 


                    for (var i in data) {
						gestion.push(data[i].gestion);
                        montoPresIngreso.push(data[i].montoPresIngreso);
                        montoEjIngreso.push(data[i].montoEjIngreso);
                        
                        montoPresEgreso.push(data[i].montoPresEgreso);
                        montoEjEgreso.push(data[i].montoEjEgreso);

                        resultadoPres.push(data[i].resultadoPres);
                        resultadoEj.push(data[i].resultadoEj);

                    }
					//alert(labs);
                    var chartdata = {
                        labels: gestion,
                        datasets: [
                            /*{
                                label: 'PresupuestoIng.',
                                backgroundColor: '#A5D6A7',
                                borderColor: '#A5D6A7',
                                data: montoPresIngreso
                            },
                            {
                                label: 'ResultadoPres.',
                                backgroundColor: '#2E7D32',
                                borderColor: '#2E7D32',
                                data: resultadoPres
                            },*/
                            {
                                label: 'EjecutadoIng.',
                                backgroundColor: "rgba(48, 101, 187, 0.2)",
                                borderColor: "rgb(48, 101, 187)",
                                borderWidth:2,
                                data: montoEjIngreso
                            },
                            /*{
                                label: 'PresupuestoEgresos',
                                backgroundColor: '#F06292',
                                borderColor: '#F06292',
                                data: montoPresEgreso
                            },*/
                            {
                                label: 'ResultadoEj.',
                                backgroundColor: "rgba(191, 18, 241, 0.2)",
                                borderColor: "rgb(191, 18, 241)",
                                borderWidth:2,
                                data: resultadoEj
                            },                            
                            {
                                label: 'EjecutadoEgresos',
                                backgroundColor: "rgba(247, 69, 2, 0.2)",
                                borderColor: "rgb(247, 69, 2)",
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
								text: 'Seguimiento al Presupuesto Operativo'
							}
						}
                    });
                });
            }
        }
        </script>
