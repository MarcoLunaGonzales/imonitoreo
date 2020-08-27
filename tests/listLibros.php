<?php

require_once '../layouts/bodylogin2.php';
require_once '../conexion.php';
require_once '../styles.php';

$dbh = new Conexion();

?>

<div class="content">
	<div class="container-fluid">
  
                        <div class="row">
                          <?php
                          for($i=1; $i<=10; $i++){
                          ?>
                          <div class="col-md-3">
                            <div class="card card-product">
                              <div class="card-header card-header-image" data-header-animation="true">
                                <a href="#pablo">
                                  <img class="img" src="../assets/img/libro_1.jpg">
                                </a>
                              </div>
                              <div class="card-body">
                                <div class="card-actions text-center">
                                  <button type="button" class="btn btn-danger btn-link fix-broken-card">
                                    <i class="material-icons">build</i> Fix Header!
                                  </button>
                                  <button type="button" class="btn btn-default btn-link" rel="tooltip" data-placement="bottom" title="View">
                                    <i class="material-icons">art_track</i>
                                  </button>
                                  <button type="button" class="btn btn-success btn-link" rel="tooltip" data-placement="bottom" title="Edit">
                                    <i class="material-icons">edit</i>
                                  </button>
                                  <button type="button" class="btn btn-danger btn-link" rel="tooltip" data-placement="bottom" title="Remove">
                                    <i class="material-icons">close</i>
                                  </button>
                                </div>
                                <h4 class="card-title">
                                  <a href="#pablo">Beautiful Castle</a>
                                </h4>
                                <div class="card-description">
                                  Aca iria la descripcion del libro la sacarias de la tabla de Vista Previa.
                                </div>
                              </div>
                              <div class="card-footer">
                                <div class="price">
                                  <h4>200 Bob</h4>
                                </div>
                                <div class="stats">
                                  <p class="card-category"><i class="material-icons">place</i> Milan, Italy</p>
                                </div>
                              </div>
                            </div>
                          </div>
                        <?php
                        }  
                        ?>
                        </div>

  </div>
</div>
