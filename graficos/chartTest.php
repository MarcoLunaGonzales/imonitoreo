<style type="text/css">
/*BODY {
	width: 70%;
	height: 200px;
}*/

#chart-container {
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
                $.get("graficos/dataTest.php",
				{},
                function (data){
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
                                backgroundColor: '#66BB6A',
                                borderColor: '#66BB6A',
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
                                backgroundColor: '#F8BBD0',
                                borderColor: '#F8BBD0',
                                data: resultadoEj
                            },                            
                            {
                                label: 'EjecutadoEgresos',
                                backgroundColor: '#E91E63',
                                borderColor: '#E91E63',
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
