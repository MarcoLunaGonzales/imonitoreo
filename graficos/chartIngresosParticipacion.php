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

<script>filaChart=<?=$fila?>;

</script>


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
                $.get("../graficos/dataIngresosParticipacion.php?filaTemporal=<?=$_SESSION['filaTemporal']?>&acumuladoTemporal=<?=$_SESSION['acumuladoTemporal']?>",
                {},
                function (data){
                    console.log("aqui mostramos los datos:"+data);
                    var nombreOrganismo = [];
                    var montoIngresoTotal = [];                        
                    var participacionPorcent = [];                                             

                    for (var i in data) {
                        nombreOrganismo.push(data[i].nombreOrganismo);
                        montoIngresoTotal.push(data[i].montoIngresoTotal);
                        participacionPorcent.push(data[i].participacionPorcent);     
                    }
                    //alert(labs);
                    var chartdata = {
                        
                        labels: nombreOrganismo,
                        datasets: [
                            {
                                data: montoIngresoTotal,
                                backgroundColor: coloresRandom,
                                borderColor: "black",
                                borderWidth: 2

                            }
                        ]
                    };

                    var graphTarget = $("#graphCanvas<?=$fila?>");

                    var barGraph = new Chart(graphTarget, {
                        type: 'pie',
                        data: chartdata,
                        options: {
                          plugins: {
                             labels: {
                                render: 'porcent',
                                fontSize: 14,
                                fontColor: '#000000'
                            }
                          }
                            /*scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero:true
                                    }
                                }]
                            }*/
                        }
                        
                    });

                });
           }
        }
        </script>
