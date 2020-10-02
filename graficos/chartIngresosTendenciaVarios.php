<?php
//session_start();
//$fondoTemporal='1011|1020';//echo "hola como vamos";
//
$fila=$_SESSION["filaTemporal"];

?>
<style type="text/css">

#chart-container<?=$fila;?> {
    width: 100%;
}
</style>

<script>filaChart=<?=$fila?>;</script>


    <div id="chart-container<?=$fila?>" style="margin-left:auto; margin-right:auto">
        <canvas id="graphCanvas<?=$fila?>"></canvas>
    </div>

    <script>
        $(document).ready(function () {
            showGraph<?=$fila?>();
        });
        function showGraph<?=$fila?>()
        {
            {
       console.log("antes de los datos;");
                $.get("../graficos/dataIngresosTendenciaVarios.php",
                {},
                function (data){
                    console.log("aqui mostramos los datos:"+data);
                    var mes = [];
                    var montoPresIngreso = [];
                    var montoEjIngreso = [];                        

                    var montoPresIngresoAnt = [];
                    var montoEjIngresoAnt = [];                        

                    var montoPresRegional = [];
                    var montoEjRegional = [];                        
                    

                    for (var i in data) {
                        mes.push(data[i].mes);
                        console.log(data[i].mes);
                        montoPresIngreso.push(data[i].montoPresIngreso);
                        montoEjIngreso.push(data[i].montoEjIngreso);   
                        montoPresIngresoAnt.push(data[i].montoPresIngresoAnt);
                        montoEjIngresoAnt.push(data[i].montoEjIngresoAnt);

                    }
                    //alert(labs);
                    var chartdata = {
                        labels: mes,
                        datasets: [
                            {
                                label: 'Pres. Gestión Anterior',
                                backgroundColor: "rgba(241, 227, 17, 0.2)",
                                borderColor: "rgb(241, 227, 17)",
                                borderWidth:2,
                                data: montoPresIngresoAnt
                            },
                            {
                                label: 'Ej. Gestión Anterior',
                                backgroundColor: "rgba(16, 242, 47, 0.2)",
                                borderColor: "rgb(16, 242, 47)",
                                borderWidth:2,
                                data: montoEjIngresoAnt
                            },
                            {
                                label: 'Presupuesto',
                                backgroundColor: "rgba(255, 99, 132, 0.2)",
                                borderColor: "rgb(255, 99, 132)",
                                borderWidth:2,
                                data: montoPresIngreso
                            },
                            {
                                label: 'Ejecutado',
                                backgroundColor: "rgba(75, 192, 192, 0.2)",
                                borderColor: "rgb(75, 192, 192)",
                                borderWidth:2,
                                data: montoEjIngreso
                            }
                        ]
                    };

                    var graphTarget = $("#graphCanvas<?=$fila?>");

                    var barGraph = new Chart(graphTarget, {
                        type: 'line',
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
