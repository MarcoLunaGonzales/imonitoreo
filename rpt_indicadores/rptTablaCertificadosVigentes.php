              <table width="100%" class="table table-condensed" id="main">
                <thead>
                  <tr>
                    <th class="text-center font-weight-bold">Servicio</th>
                    <th class="text-center font-weight-bold" colspan="2">TCP</th>
                    <th class="text-center font-weight-bold" colspan="2">TCS</th>
                    <th class="text-center font-weight-bold" colspan="2">Totales</th>
                  </tr>
                  <tr>
                    <th class="text-center font-weight-bold">-</th>
                    <th class="text-center font-weight-bold">#</th>
                    <th class="text-center font-weight-bold">%</th>


                    <th class="text-center font-weight-bold">#</th>
                    <th class="text-center font-weight-bold">%</th>

                    <th class="text-center font-weight-bold">#</th>
                    <th class="text-center font-weight-bold">%</th>

                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sqlU="SELECT u.codigo, u.nombre, u.abreviatura FROM unidades_organizacionales u WHERE u.codigo in ($cadenaUnidades) order by 2";
                  $stmtU = $dbh->prepare($sqlU);
                  $stmtU->execute();
                  $stmtU->bindColumn('codigo', $codigoX);
                  $stmtU->bindColumn('abreviatura', $abrevX);

                  /*ESTA PARTE ES PARA OBTENER LOS TOTALES*/
                  $totalMesUnidadX=0;
                  $totalAcumUnidadX=0;

                  $cantEmpresasTCPTotal=obtenerCantCertificados(0,$anioTemporal,$mesTemporal,39,0,0,$vista);
                  $cantEmpresasTCPAcumTotal=obtenerCantCertificados(0,$anioTemporal,$mesTemporal,39,0,1,$vista);

                  $cantEmpresasTCSTotal=obtenerCantCertificados(0,$anioTemporal,$mesTemporal,38,0,0,$vista);
                  $cantEmpresasTCSAcumTotal=obtenerCantCertificados(0,$anioTemporal,$mesTemporal,38,0,1,$vista);

                  $totalMesUnidadX=$cantEmpresasTCP+$cantEmpresasTCS;
                  $totalAcumUnidadX=$cantEmpresasTCPAcumTotal+$cantEmpresasTCSAcumTotal;
                  /*FIN OBTENER LOS TOTALES*/

                  while($rowU = $stmtU -> fetch(PDO::FETCH_BOUND)){
                    $totalMesUnidad=0;
                    $totalAcumUnidad=0;

                    $cantEmpresasTCP=obtenerCantCertificados($codigoX,$anioTemporal,$mesTemporal,39,0,0,$vista);
                    $cantEmpresasTCPAcum=obtenerCantCertificados($codigoX,$anioTemporal,$mesTemporal,39,0,1,$vista);

                    $cantEmpresasTCS=obtenerCantCertificados($codigoX,$anioTemporal,$mesTemporal,38,0,0,$vista);
                    $cantEmpresasTCSAcum=obtenerCantCertificados($codigoX,$anioTemporal,$mesTemporal,38,0,1,$vista);
                    
                    $totalMes=$cantEmpresasTCP+$cantEmpresasTCS;
                    $totalAcumulado=$cantEmpresasTCPAcum+$cantEmpresasTCSAcum;

                    $totalMesUnidad=$cantEmpresasTCP+$cantEmpresasTCS;
                    $totalAcumUnidad=$cantEmpresasTCPAcum+$cantEmpresasTCSAcum;

                    $partMesTCP=0;
                    $partMesTCS=0;
                    if($cantEmpresasTCPTotal>0){
                      $partMesTCP=($cantEmpresasTCP/$cantEmpresasTCPTotal)*100;                    
                      $partMesTCS=($cantEmpresasTCS/$cantEmpresasTCSTotal)*100;                    
                    }

                    $partAcumTCP=0;
                    $partAcumTCS=0;
                    if($cantEmpresasTCSAcumTotal>0){
                      $partAcumTCP=($cantEmpresasTCPAcum/$cantEmpresasTCSAcumTotal)*100;                    
                      $partAcumTCS=($cantEmpresasTCSAcum/$cantEmpresasTCSAcumTotal)*100;                    
                    }
                    $porcentajeMes=($totalMesUnidad/$totalMesUnidadX)*100;
                    $porcentajeAcum=($totalAcumUnidad/$totalAcumUnidadX)*100;

                    $urlDetalle="rptCertificadosDetalle.php?vista=$vista&codUnidad=$codigoX&mes=$mesTemporal&anio=$anioTemporal&norma=&iaf=0&certificador=0";
                  ?>
                  <tr>
                    <td class="text-center"><?=$abrevX;?></td>
                    <td class="table-warning text-center"><a href="<?=$urlDetalle;?>&codArea=39&acumulado=1" target="_blank"><?=($cantEmpresasTCPAcum==0)?"-":formatNumberDec($cantEmpresasTCPAcum);?></a></td>
                    <td class="table-success text-center"><?=($partAcumTCP==0)?"-":formatNumberDec($partAcumTCP);?></td>

                    <td class="table-warning text-center"><a href="<?=$urlDetalle;?>&codArea=38&acumulado=1" target="_blank"><?=($cantEmpresasTCSAcum==0)?"-":formatNumberDec($cantEmpresasTCSAcum);?></a></td>
                    <td class="table-success text-center"><?=($partAcumTCS==0)?"-":formatNumberDec($partAcumTCS);?></td>

                    <td class="table-warning text-center font-weight-bold"><?=formatNumberDec($totalAcumUnidad);?></td>
                    <td class="table-success text-center font-weight-bold"><?=($porcentajeAcum==0)?"-":formatNumberDec($porcentajeAcum);?></td>

                  </tr>
                  <?php
                  }
                  $totalMesUnidad=0;
                  $totalAcumUnidad=0;

                  $cantEmpresasTCP=obtenerCantCertificados(0,$anioTemporal,$mesTemporal,39,0,0,$vista);
                  $cantEmpresasTCPAcum=obtenerCantCertificados(0,$anioTemporal,$mesTemporal,39,0,1,$vista);

                  $cantEmpresasTCS=obtenerCantCertificados(0,$anioTemporal,$mesTemporal,38,0,0,$vista);
                  $cantEmpresasTCSAcum=obtenerCantCertificados(0,$anioTemporal,$mesTemporal,38,0,1,$vista);
                  
                  $totalMes=$cantEmpresasTCP+$cantEmpresasTCS;
                  $totalAcumulado=$cantEmpresasTCPAcum+$cantEmpresasTCSAcum;

                  $totalMesUnidad=$cantEmpresasTCP+$cantEmpresasTCS;
                  $totalAcumUnidad=$cantEmpresasTCPAcum+$cantEmpresasTCSAcum;

                  $partMesTCP=0;
                  $partMesTCS=0;
                  if($totalMes>0){
                    $partMesTCP=($cantEmpresasTCP/$cantEmpresasTCP)*100;                    
                    $partMesTCS=($cantEmpresasTCS/$cantEmpresasTCS)*100;                    
                  }

                  $partAcumTCP=0;
                  $partAcumTCS=0;
                  if($totalAcumulado>0){
                    $partAcumTCP=($cantEmpresasTCPAcum/$cantEmpresasTCPAcum)*100;                    
                    $partAcumTCS=($cantEmpresasTCSAcum/$cantEmpresasTCSAcum)*100;                    
                  }

                  $urlDetalle="rptCertificadosDetalle.php?vista=$vista&codUnidad=0&mes=$mesTemporal&anio=$anioTemporal&norma=&iaf=0&certificador=0";
                  ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th class="text-center">Totales</th>
                    <th class="table-warning text-center"><a href="<?=$urlDetalle;?>&codArea=39&acumulado=1" target="_blank"><?=($cantEmpresasTCPAcum==0)?"-":formatNumberDec($cantEmpresasTCPAcum);?></a></th>
                    <th class="table-success text-center"><?=($partAcumTCP==0)?"-":formatNumberDec($partAcumTCP);?></th>

                    <th class="table-warning text-center"><a href="<?=$urlDetalle;?>&codArea=38&acumulado=1" target="_blank"><?=($cantEmpresasTCSAcum==0)?"-":formatNumberDec($cantEmpresasTCSAcum);?></a></th>
                    <th class="table-success text-center"><?=($partAcumTCS==0)?"-":formatNumberDec($partAcumTCS);?></th>

                    <th class="table-warning text-center"><?=formatNumberDec($totalAcumUnidad);?></th>
                    <th class="table-success text-center"><?=formatNumberDec(100);?></th>
                  </tr>
                </tfoot>
              </table>
