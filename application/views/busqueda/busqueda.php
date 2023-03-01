
<div id="cl-wrapper" class="sb-collapsed">
    <div class="cl-sidebar">
        <?php
        //obtener fecha actual
          $var2=0;
          $date=date('Y-m-d');
          $fecha_limite=$this->session->userdata('f_limite');
          $paquete= $this->session->userdata('paquete');
          $dias= $this->session->userdata('tiempo');
          $datetime1 = new DateTime($date);
          $datetime2 = new DateTime($fecha_limite);
          $interval = $datetime1->diff($datetime2);
          $interval->days;
          $var=0;
          if((int)$paquete<=(int)$totalBusquedas or ((int)$dias<(int)$interval->days)){
            $var=1;
          }
          $this->load->view('menu_left');
        ?>
    </div>

    <!--muestra el menu de opciones de busqueda de personas-->
    <div class="page-aside app filters">
        <div>
            <div class="content">
                <button data-target=".app-nav" data-toggle="collapse" type="button" class="navbar-toggle"><span class="fa fa-chevron-down"></span></button>
                <h2 class="page-title">Filtrar por:</h2>
            </div>
            <div class="app-nav collapse">
                <div class="content">
                    <div class="form-group">
                        <label class="control-label">Selecciona:</label>
                        <label class="radio">
                            <input id="pfisica" type="radio" name="optradio"
                            value="fisica" class="icheck" checked> Persona Física
                        </label>
                        <label class="radio">
                            <input id="pmoral" type="radio" name="optradio"
                            value="moral" class="icheck"> Persona Moral
                        </label>
                        <label class="radio">
                            <input id="busqAvanzada" type="radio" name="optradio"
                            value="busqAvanzada" class="icheck"> Busqueda Multiple
                        </label>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div id="pcont" class="container-fluid">
        <div class="main-app">
            <div class="head">
              <div id="div10">
                <label> <span class="text-danger"> Busquedas realizadas:
                  <input id="idioma" type="text" value="<?php if($totalBusquedas==''){echo '0';}else{echo $totalBusquedas;}?>" disabled  size="4" style="border: 0; background-color: #ffff;">/<?php echo $paquete;?></label>

              </div>

                <h2>Busqueda en listas</h2>
                <div class="tooltip1"><i class="far fa-question-circle"></i>
                  <span class="tooltiptext1">Para obtener mejores resultados ingrese el mayor número de datos</span>
                </div>

                <div id="pf">
                    <div class="content">
                        <form id="search_fisica">
                            <input type="hidden" name="type" value="f">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Nombre completo<span class="text-danger"> * </span></label>
                                        <input type="text" name="nombre" id="nombre" placeholder="ej. JUAN PEREZ PEREZ" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>RFC</label>
                                        <input type="text" name="rfc" id="rfc" placeholder="RFC" class="form-control" >
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>CURP</label>
                                        <input type="text" name="curp" id="curp" placeholder="CURP" class="form-control" >
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                  <label class="">
                                    Tipo de busqueda
                                  </label>
                                  <div class="radio">
                                    <label class="">
                                      <div class="iradio_square-blue" aria-checked="false" aria-disabled="false" style="position: relative;">
                                        <input type="radio" name="busqueda" value="search_exactly_f" class="icheck" style="position: absolute; opacity: 0;">
                                      </div> Exacta
                                      <div class="tooltip3"><i class="far fa-question-circle"></i>
                                        <span class="tooltiptext3">Se limita a presentar solo a las personas cuyo nombre sea exactamente igual al ingresado </span>
                                      </div>
                                    </label>
                                  </div>
                                  <div class="radio">
                                    <label class="">
                                      <div class="iradio_square-blue hover" aria-checked="false" aria-disabled="false" style="position: relative;">
                                        <input type="radio" name="busqueda" value="search_extend"class="icheck" style="position: absolute; opacity: 0;" checked>
                                      </div> Extendida
                                      <div class="tooltip3"><i class="far fa-question-circle"></i>
                                        <span class="tooltiptext3">Busca coicidencias que contengan las palabras que incluyo en sus busquedas</span>
                                      </div>
                                    </label>
                                  </div>

                                </div>
                                <div class="col-sm-4">
                                  <label class="">
                                    Listas para la busqueda
                                  </label>
                                  <div class="radio">
                                    <label class="">
                                      <div class="iradio_square-blue" aria-checked="false" aria-disabled="false" style="position: relative;">
                                        <input type="radio" name="conf" value="regulatorias" class="icheck" style="position: absolute; opacity: 0;" checked>
                                      </div> Regulatorias(Negras + peps)
                                    </label>
                                  </div>
                                  <div class="radio">
                                    <label class="">
                                      <div class="iradio_square-blue hover" aria-checked="false" aria-disabled="false" style="position: relative;">
                                        <input type="radio" name="conf" value="negras"class="icheck" style="position: absolute; opacity: 0;">
                                      </div> Solo listas negras (OFAC, ONU, SAT, etc.)
                                    </label>
                                  </div>
                                  <div class="radio">
                                    <label class="">
                                      <div class="iradio_square-blue hover" aria-checked="false" aria-disabled="false" style="position: relative;">
                                        <input type="radio" name="conf" value="peps"class="icheck" style="position: absolute; opacity: 0;">
                                      </div> Solo PEP´s
                                      <div class="tooltip3"><i class="far fa-question-circle"></i>
                                        <span class="tooltiptext3">Artículo 27 del Reglamento Interior de la Secretaría de Hacienda y Crédito Público</span>
                                      </div>
                                    </label>
                                  </div>
                                  <div class="radio">
                                    <label class="">
                                      <div class="iradio_square-blue hover" aria-checked="false" aria-disabled="false" style="position: relative;">
                                        <input type="radio" name="conf" value="pepN"class="icheck" style="position: absolute; opacity: 0;" >
                                      </div>  Solo Pep´s nacionales
                                    </label>
                                  </div>
                                  <div class="radio">
                                    <label class="">
                                      <div class="iradio_square-blue hover" aria-checked="false" aria-disabled="false" style="position: relative;">
                                        <input type="radio" name="conf" value="pepE"class="icheck" style="position: absolute; opacity: 0;">
                                      </div> Solo Pep´s extranjeros
                                    </label>
                                  </div>
                                </div>
                                <div class="col-sm-4">

                                  <div class="radio">
                                    <label class="">
                                      <div class="iradio_square-blue" aria-checked="false" aria-disabled="false" style="position: relative;">
                                        <input type="radio" name="conf" value="ci" class="icheck" style="position: absolute; opacity: 0;">
                                      </div> Solo Contribuyente inclumplido
                                      <div class="tooltip3"><i class="far fa-question-circle"></i>
                                        <span class="tooltiptext3">Artículo 69 del Código Fiscal de la Federación</span>
                                      </div>
                                  </div>
                                  <div class="radio">
                                    <label class="">
                                      <div class="iradio_square-blue hover" aria-checked="false" aria-disabled="false" style="position: relative;">
                                        <input type="radio" name="conf" value="todas"class="icheck" style="position: absolute; opacity: 0;">
                                      </div> Todas las listas
                                    </label>
                                  </div>

                                </div>

                            </div>
                            <div class="modal-footer" id="uno">
                                <button type="reset" class="btn btn-default btn-flat" id="clear_form_search">Borrar</button>
                                <?php
                                  if($var==1){
                                    echo"<button  type='submit' class='btn btn-primary btn-flat' id='btnBuscar' name='btnBuscar' required disabled>Buscar</button><br>";
                                    echo"<label> <span class='text-danger'> Tu plan se ha agotado, contacta a un asesor para ampliarlo </label>";
                                    }else{
                                    echo"<button  type='submit' class='btn btn-primary btn-flat' id='btnBuscar' name='btnBuscar' required>Buscar</button>";
                                    }
                                ?>
                            </div>
                            <div class="modal-footer" id="dos" hidden>
                                    <button type="reset" class="btn btn-default btn-flat" id="clear_form_search">Borrar</button>
                                    <button  type="submit" class="btn btn-primary btn-flat" id="btnBuscar" name="btnBuscar" required disabled>Buscar</button><br>
                                    <label> <span class='text-danger'> Tu plan se ha agotado, contacta a un asesor para ampliarlo </label>


                            </div>
                        </form>
                    </div>
                </div>
                <div id="pm" class="oculto">
                    <h3>Búsqueda Individual</h3>
                    <div class="content">
                        <form id="search_moral">
                            <input type="hidden" name="type" value="m">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Razón Social <span class="text-danger"> * </span></label>
                                        <input type="text" name="razon_social" id="razon_social" placeholder="Razón Social" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>RFC</label>
                                        <input type="text" name="rfc" id="rfc" placeholder="RFC" class="form-control">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                  <label class="">
                                    Tipo de busqueda
                                  </label>
                                  <div class="radio">
                                    <label class="">
                                      <div class="iradio_square-blue" aria-checked="false" aria-disabled="false" style="position: relative;">
                                        <input type="radio" name="busqueda" value="search_exactly_f" class="icheck" style="position: absolute; opacity: 0;">
                                      </div> Exacta
                                      <div class="tooltip3"><i class="far fa-question-circle"></i>
                                        <span class="tooltiptext3">Se limita a presentar solo a las personas cuyo nombre sea exactamente igual al ingresado </span>
                                      </div>
                                    </label>
                                  </div>
                                  <div class="radio">
                                    <label class="">
                                      <div class="iradio_square-blue hover" aria-checked="false" aria-disabled="false" style="position: relative;">
                                        <input type="radio" name="busqueda" value="search_extend"class="icheck" style="position: absolute; opacity: 0;" checked>
                                      </div> Extendida
                                      <div class="tooltip3"><i class="far fa-question-circle"></i>
                                        <span class="tooltiptext3">Busca coicidencias que contengan las palabras que incluyo en sus busquedas</span>
                                      </div>
                                    </label>
                                  </div>

                                </div>

                                <div class="col-sm-4">
                                  <label class="">
                                    Listas para la busqueda
                                  </label>
                                  <div class="radio">
                                    <label class="">
                                      <div class="iradio_square-blue" aria-checked="false" aria-disabled="false" style="position: relative;">
                                        <input type="radio" name="conf" value="regulatorias" class="icheck" style="position: absolute; opacity: 0;" checked>
                                      </div> Regulatorias(Negras)
                                    </label>
                                  </div>
                                  <div class="radio">
                                    <label class="">
                                      <div class="iradio_square-blue hover" aria-checked="false" aria-disabled="false" style="position: relative;">
                                        <input type="radio" name="conf" value="negras"class="icheck" style="position: absolute; opacity: 0;">
                                      </div> Solo listas negras (OFAC, ONU, SAT, etc.)
                                    </label>
                                  </div>



                                </div>
                                <div class="col-sm-4">

                                  <div class="radio">
                                    <label class="">
                                      <div class="iradio_square-blue" aria-checked="false" aria-disabled="false" style="position: relative;">
                                        <input type="radio" name="conf" value="ci" class="icheck" style="position: absolute; opacity: 0;">
                                      </div> Solo Contribuyente inclumplido
                                      <div class="tooltip3"><i class="far fa-question-circle"></i>
                                        <span class="tooltiptext3">Artículo 69 del Código Fiscal de la Federación</span>
                                      </div>
                                  </div>
                                  <div class="radio">
                                    <label class="">
                                      <div class="iradio_square-blue hover" aria-checked="false" aria-disabled="false" style="position: relative;">
                                        <input type="radio" name="conf" value="todas"class="icheck" style="position: absolute; opacity: 0;">
                                      </div> Todas las listas
                                    </label>
                                  </div>

                                </div>

                            </div>
                            <div class="modal-footer" id="uno1">
                                <button type="reset" class="btn btn-default btn-flat" id="clear_form_search_m">Borrar</button>
                                <?php
                                  if($var==1){
                                    echo"<button  type='submit' class='btn btn-primary btn-flat' id='btnBuscar' name='btnBuscar' required disabled>Buscar</button><br>";
                                    echo"<label> <span class='text-danger'> Tu plan se ha agotado, contacta a un asesor para ampliarlo </label>";
                                  }else{
                                    echo"<button  type='submit' class='btn btn-primary btn-flat' id='btnBuscar' name='btnBuscar' required>Buscar</button>";
                                  }
                                ?>
                            </div>
                            <div class="modal-footer" id="dos2" hidden>
                                <button type="reset" class="btn btn-default btn-flat" id="clear_form_search_m">Borrar</button>
                                    <button  type="submit" class="btn btn-primary btn-flat" id="btnBuscar" name="btnBuscar" required disabled>Buscar</button><br>
                                    <label> <span class="text-danger"> Tu plan se ha agotado, contacta a un asesor para ampliarlo </label>
                            </div>
                        </form>
                    </div>
                </div>
                <div id="c" class="oculto">
                    <div class="content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="block-flat">
                                    <h4>Archivo excel</h4>
                                    <a href="<?= base_url('busqueda/downloads') ?>" target="_blank">Descargar excel muestra</a>
                                    <div class="content">
                                    </div>
                                    <form id="mpE"  method="POST" action="<?= base_url('busqueda/busquedaMultiple') ?>" enctype="multipart/form-data">
                                      <input name='archivo' id='file-0a'  class='file' type='file'  accept='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,' data-min-file-count='1' data-show-preview='false'><br>
                                      <div class="radio">
                                        <label class="">
                                          <div class="iradio_square-blue hover" aria-checked="false" aria-disabled="false" style="position: relative;">
                                          <input type="radio" name="opcion" value="SI"class="icheck" style="position: absolute; opacity: 0;">
                                          </div> La busqueda masiva omite por defecto las listas grises del sistema, si desea que se incluyan seleccione esta opcion pero las busquedas tardan entre 6 y 20 minutos más dependiendo de la cantidad de registros en su archivo

                                        </label>
                                      </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row"> <!-- resultado de búsqueda -->
                    <div id="loader" class="loader" hidden></div>
                        <table id="list_table" class="no-border oculto">
                            <thead>
                                <th>Nombre</th>
                                <th>Pertenece</th>
                                <th>Actividad</th>
                                <th>Fecha</th>
                                <th>Tipo</th>
                                <th>Alias</th>
                                <th>Estatus</th>
                                <th>Porcentaje de coincidencia</th>
                            </thead>
                            <tbody id="list_data">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

                <!--Listas de busqueda, cargada dinamicamente -->
            <div class="items no-link">
                <p class=" text-center" >LA BÚSQUEDA SE REALIZÓ EN LAS SIGUIENTES FUENTES:</p>
                <button class="accordion">Listas Nacionales</button>
                  <div class="panel">
                    <p><?php foreach ($nacionales as $nacional):
                              echo"<div class='item'>".$nacional['nombre']."(".$nacional['clave_pertenece'].")</div>";
                        endforeach; ?>
                    </p>
                  </div>

                  <button class="accordion">Listas internacionales</button>
                  <div class="panel">
                    <p> <?php foreach ($internacionales as $internacional):
                              echo"<div class='item'>".$internacional['nombre']."(".$internacional['clave_pertenece'].")</div>";
                        endforeach; ?>
                    </p>
                  </div>
            </div>
        </div>
    </div>

<!-- Modal -->
    <div class="modal fade" id="unlock" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel"><i class="fas fa-unlock-alt"></i> Desbloquear persona</h4>
          </div>
          <form id="form_desbloqueo" method="POST">
            <div class="modal-body">
              <input type="" name="id" id="id" class="oculto" value="">
              <div class="form-group">
                  <label>Oficio relacionado</label>
                  <input type="text" class="form-control" name="oficio_relacionado" id="oficio_relacionado" required>
              </div>
              <div class="form-group">
                <label>Motivo:</label>
                <textarea id="motivo" name="motivo" class="form-control" required></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="submit" id="guardar" class="btn btn-primary">Guardar</button>
            </div>
          </form>
        </div>
      </div> <a href=""></a>
    </div>

<!-- Modal -->
<div class="modal fade" id="person_info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width: 70%">
    <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <div id="person_info_name"></div>
      </div>
      <div class="content">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-2">
              <div class="form-group" id="alias">
                  <label>Alias/Otro nombres</label>
                  <input type="text" id="alias1" class="form-control" disabled>
              </div>

                <div class="form-group" id="sc">
                    <label>Situación del contribuyente</label>
                    <input type="text" id="situacion_del_contribuyente" class="form-control"  disabled>
                </div>
                <div class="form-group" id="tpi">
                    <label>Tipo</label>
                    <input type="text" id="tipo_person_info" class="form-control" disabled>
                </div>

                <div class="form-group" id="per">
                    <label>Pertenece</label>
                    <input type="text" id="per2" class="form-control" disabled>
                </div>

            </div>
            <div class="col-md-2">

                <div class="form-group" id="cpi">
                    <label>CURP</label>
                    <input type="text" id="curp_person_info" class="form-control"  disabled>
                </div>
                <div class="form-group"id="rpi">
                    <label>RFC</label>
                    <input type="text" id="rfc_person_info" class="form-control" disabled>
                </div>


                <div class="form-group" id="ac">
                    <label>Actividad</label>
                    <input type="text" id="actividad" class="form-control"  disabled>
                </div>
            </div>
            <div class="col-md-2">

                <div class="form-group" id="nac">
                    <label>Nacionalidad</label>
                    <input type="text" id="nacionalidad" class="form-control"  disabled>
                </div>
                <div class="form-group" id="bday">
                    <label>Fecha de nacimiento</label>
                    <input type="text" id="fday" class="form-control"  disabled>
                </div>
                  <div class="form-group" id="proc">
                      <label>Procedencia (Domicilio)</label>
                      <input type="text" id="procedencia" class="form-control"  disabled>
                  </div>


            </div>
            <div class="col-md-2">

                <div class="form-group" id="fa">
                    <label>Fechas alta</label>
                    <input type="text" id="fecha_alta" class="form-control"  disabled>

                    <div class="form-group" id="obs">
                        <label>observaciones</label>

                        <textarea rows="10" id="observaciones" class="form-control" name="observaciones"disabled></textarea>
                    </div>

                </div>
            </div>
            <div class="col-md-2" id="fotoshow">
                <label>Foto:</label>
                <div id="url_foto"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-4">

                <div class="form-group" id="nyddogp">
                    <label>Número y fecha global de presunción</label>
                    <input type="text" id="numero_y_fecha_de_oficio_global_de_presuncion" class="form-control" disabled>
                </div>
                <div class="form-group" id="nfogcd">
                    <label>Número y fecha oficio global desvirtuados</label>
                    <input type="text" id="numero_fecha_oficio_global_contribuyentes_desvirtuaron" class="form-control" disabled>
                </div>
                <div class="form-group" id="nfogd">
                    <label>Número y fecha oficio global de definitivos</label>
                    <input type="text" id="numero_y_fecha_de_oficio_global_de_definitivos" class="form-control" disabled>
                </div>
                <div class="form-group" id="nfogsf">
                    <label>Número y fecha de oficio global de sentencia favorable</label>
                    <input type="text" id="numero_y_fecha_de_oficio_global_de_sentencia_favorable" class="form-control" disabled>
                </div>
                <div class="form-group" id="nofpb">
                    <label>Número de oficio personas bloqueadas</label>
                    <input type="text" id="numero_oficio_personas_bloqueadas" class="form-control" disabled>
                </div>
            </div>
            <div class="col-md-2">
              <div class="form-group" id="pdp">
                  <label>Publicación DOF presuntos</label>
                  <input type="date" id="publicacion_dof_presuntos" class="form-control" disabled>
              </div>
                <div class="form-group" id="pdd">
                    <label>Pub. DOF Desvirtuados</label>
                    <input type="date" id="publicacion_dof_desvirtuados" class="form-control" disabled>
                </div>
                <div class="form-group" id="pdfd">
                    <label>Pub. DOF Definitivos</label>
                    <input type="date" id="publicacion_dof_definitivos" class="form-control" disabled>
                </div>
                <div class="form-group" id="pdsf">
                    <label>Pub. DOF sentencia favorable</label>
                    <input type="date" id="publicacion_dof_sentencia_favorable" class="form-control" disabled>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group" id="ppsp">
                    <label>Pub. Pág. SAT Presuntos</label>
                    <input type="date" id="publicacion_pagina_sat_presuntos" class="form-control" disabled>
                </div>
                <div class="form-group" id="ppsp1">
                    <label>Pub. Pág. SAT desvirtuados</label>
                    <input type="date" id="publicacion_pagina_sat_desvirtuados" class="form-control" disabled>
                </div>
                <div class="form-group" id="ppsd">
                    <label>Pub. Pág. SAT definitivos</label>
                    <input type="date" id="publicacion_pagina_sat_definitivos" class="form-control" disabled>
                </div>
                <div class="form-group" id="ppssf">
                    <label>Pub. Pág SAT sentencia favorable</label>
                    <input type="date" id="publicacion_pagina_sat_sentencia_favorable" class="form-control" disabled>
                </div>
            </div>
            <!--
            <div class="col-md-2" id="fotoshow2">
              <div class="form-group" id="subir_foto" >
                  <form method="POST" id="form_subir_foto" enctype="multipart/form-data">
                     <label>¿Relaciona está persona por su nombre y sus datos? Si la respuesta es “Sí” sube una URL de su foto.</label>
                     <input type="text" placeholder="URL Foto" name="foto" id="foto" class="form-control" >
                     <input type="hidden" name="id_persona" id="id_persona">
                     <input type="submit"  class="btn btn-primary" value="Subir">
                  </form>
              </div>
              <div id="url_persona"></div>
            </div>-->

        </div>
        <input type="hidden" name="datos4" id="datos4">
      <button class="btn btn-primary" id="print_result4" data-name="" data-table="">Imprimir</button>
      </div>

    </div>
  <a href=""></a>
</div>


<script>
      $(document).ready(function(){

      $('#search_fisica').on('submit', function(e) {
            e.preventDefault();
            $("#list_data").empty();
            $("#loader").show();
            $.ajax({
                url: '<?= base_url('busqueda/searchfisica') ?>',
                type: 'POST',
                dataType: 'html',
                data: $(this).serialize(),
            })
            .done(function(response) {
                var val1=($("#idioma").val());
                var val= parseInt(val1)+1;
                var limite='<?php echo $paquete; ?>';
                var limite2= parseInt(limite);
                if(limite2<=val){
                  $('#uno').hide();
                  $('#dos').show();
                  $('#uno1').hide();
                  $('#dos2').show();
                  $('#tresA').hide();
                  $('#tresB').show();
                }
                $("#list_table").show();
                $("#list_data").append(response);
                $("#loader").hide();
                $("#idioma").val(val);
                })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                console.log("complete");
            });


        });
      $('#search_moral').on('submit', function(e) {
            e.preventDefault();
            $("#list_data").empty();
            $("#loader").show();

            $.ajax({
                url: '<?= base_url('busqueda/searchmoral') ?>',
                type: 'POST',
                dataType: 'html',
                data: $(this).serialize(),
            })
            .done(function(response) {
              var val1=($("#idioma").val());
              var val= parseInt(val1)+1;
              var limite='<?php echo $paquete; ?>';
              var limite2= parseInt(limite);
              if(limite2<=val){
                $('#uno').hide();
                $('#dos').show();
                $('#uno1').hide();
                $('#dos2').show();
                $('#tresA').hide();
                $('#tresB').show();
                }
                $("#list_table").show();
                $("#list_data").append(response);
                $("#loader").hide();
                $("#idioma").val(val);

            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                console.log("complete");
            });

        });
      $(document).on('click', '#print_result', function() {
            name    = $("#name").val()
            estatus = $("#estatus").val();
            datos   = $("#datos").val();
            var data = new FormData();
            data.append('name', name);
            data.append('estatus', estatus);
            data.append('datos', datos);
            var xhr = new XMLHttpRequest();
            xhr.open('POST', "<?= base_url('busqueda/print_result') ?>", true);
            xhr.responseType = 'blob';

            xhr.onload = function(e) {
              if (this.status == 200) {
                var blob = new Blob([this.response], {type: 'application/pdf'});
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = name+".pdf";
                link.click();
              }
            };

            xhr.send(data);

        });
        $('input:radio[name="optradio"][value="fisica"]').prop('checked', true);
        $('input[name="rad1"]').css('background-color', 'red');
        $('input[name="optradio"]').on('ifChecked', function() {
        $(document).on('click', '#printres', function() {
                alert("imprimir");
            });
            if ($(this).val()=='moral')
            {
                $('input[name="nombre"]').val('');
                $('input[name="apaterno"]').val('');
                $('input[name="amaterno"]').val('');


                $('#pm').show();

                $( "#pf" ).hide();

                $("#c").hide();

            }
            else if($(this).val()=='fisica')
            {
                $('input[name="nombre"]').val('');
                $("#pf").show();
                $("#pm").hide();
                $('#c').hide();
            }
            else {
                $("#pf").hide();
                $("#pm").hide();
                $("#c").show();
            }

        });

        $('#form_subir_foto').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: '<?= base_url('busqueda/subir_foto') ?>',
                type: 'POST',
                dataType: 'json',
                data: $(this).serialize(),
            })
            .done(function(response) {
                $('#subir_foto').hide(); // oculta para subir foto
                $('#foto_default').hide(); //oculta la foto default

                $('#url_foto').html('<img src="'+response.foto_persona+'" class="img-responsive img-thumbnail img-circle"  >');
            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                console.log("complete");
            });

        });
        $('#mpE').on('submit', function(e) {
              $("#loader").show();
        });
        $(document).on('click', '#print_result4', function() {
              name    = $("#name").val()
              estatus = $("#estatus").val();
              datos   = $("#datos4").val();
              var data = new FormData();
              data.append('name', name);
              data.append('estatus', estatus);
              data.append('datos', datos);
              var xhr = new XMLHttpRequest();
              xhr.open('POST', "<?= base_url('busqueda/print_result4') ?>", true);
              xhr.responseType = 'blob';

              xhr.onload = function(e) {
                if (this.status == 200) {
                  var blob = new Blob([this.response], {type: 'application/pdf'});
                  var link = document.createElement('a');
                  link.href = window.URL.createObjectURL(blob);
                  link.download = name+".pdf";
                  link.click();
                }
              };

              xhr.send(data);

          });
    });

    function unlock(id = 0) {
        $('#unlock').modal('show');
        $('#id').val(id);
    }

    function unlock_views(id = 0){
        $('#unlock').modal('show');
        $.ajax({
            url: '<?= base_url('busqueda/unlock_views') ?>',
            type: 'POST',
            dataType: 'json',
            data: {id:id},
        })
        .done(function(response) {
            response = response[0];
            $('#oficio_relacionado').val(response.related_trade);
            $('#motivo').val(response.reason);

            $('#guardar').hide();
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
    }

    function person_info(id = 0){
          var prue = '';

        $('#person_info').modal('show');
        $.ajax({
            url: '<?= base_url('busqueda/unlock_views2') ?>',
            type: 'POST',
            dataType: 'json',
            data: {id:id},
        })
        .done(function(response) {
            response = response[0];

            if(!response.tipo){
              $('#tpi').hide();
            }
            else{
              var par1 = "<tr><td>Tipo persona</td><td>";
              var par2= response.tipo;
              var par3 = "</td></tr>";
              var uno = par1.concat(par2);
              var dos = uno.concat(par3);
              prue = prue.concat(dos);
                $('#tpi').show();
              $('#tipo_person_info').val(response.tipo);
            }

            if(!response.situacion_contribuyente){
              $('#sc').hide();
            }
            else{
              var par1 = "<tr><td>Situación del contribuyente</td><td>";
              var par2= response.situacion_contribuyente;
              var par3 = "</td></tr>";
              var uno = par1.concat(par2);
              var dos = uno.concat(par3);
              prue = prue.concat(dos);
              //$('#datos4').val(prue);
              $('#sc').show();
              $('#situacion_del_contribuyente').val(response.situacion_contribuyente);
            }
            $('#person_info_name').html('<h4 class="modal-title" id="myModalLabel"><i class="fas fa-user-shield"></i>Información de la persona: '+response.name+'</h4>');

            if(!response.rfc){
              $('#rpi').hide();
            }
            else{
              var par1 = "<tr><td>RFC</td><td>";
              var par2= response.rfc;
              var par3 = "</td></tr>";
              var uno = par1.concat(par2);
              var dos = uno.concat(par3);
              prue = prue.concat(dos);
              $('#rpi').show();
                $('#rfc_person_info').val(response.rfc);
            }

            if(!response.curp){
                $('#cpi').hide();
            }
            else{
              var par1 = "<tr><td>CURP</td><td>";
              var par2= response.curp;
              var par3 = "</td></tr>";
              var uno = par1.concat(par2);
              var dos = uno.concat(par3);
              prue = prue.concat(dos);
                $('#cpi').show();
                $('#curp_person_info').val(response.curp);
            }

            if(!response.actividad){
              $('#ac').hide();
            }
            else{
              var par1 = "<tr><td>Actividad</td><td>";
              var par2= response.actividad;
              var par3 = "</td></tr>";
              var uno = par1.concat(par2);
              var dos = uno.concat(par3);
              prue = prue.concat(dos);
              $('#ac').show();
              $('#actividad').val(response.actividad);
            }

            if(!response.alias){
              $('#alias').hide();
            }
            else{
              var par1 = "<tr><td>Alias</td><td>";
              var par2= response.alias;
              var par3 = "</td></tr>";
              var uno = par1.concat(par2);
              var dos = uno.concat(par3);
              prue = prue.concat(dos);
              $('#alias').show();
              $('#alias1').val(response.alias);
            }

            if(!response.nacionalidad){
              $('#nac').hide();
            }
            else{
              var par1 = "<tr><td>Nacionalidad</td><td>";
              var par2= response.nacionalidad;
              var par3 = "</td></tr>";
              var uno = par1.concat(par2);
              var dos = uno.concat(par3);
              prue = prue.concat(dos);
              $('#nac').show();
              $('#nacionalidad').val(response.nacionalidad);
            }

            if(!response.observaciones){
              $('#obs').hide();
            }
            else{
              var par1 = "<tr><td>Observaciones</td><td>";
              var par2= response.observaciones;
              var par3 = "</td></tr>";
              var uno = par1.concat(par2);
              var dos = uno.concat(par3);
              prue = prue.concat(dos);
              $('#obs').show();
              $('#observaciones').val(response.observaciones);
            }

            if(!response.domicilio){
              $('#proc').hide();
            }
            else{
              var par1 = "<tr><td>Domicilio</td><td>";
              var par2= response.domicilio;
              var par3 = "</td></tr>";
              var uno = par1.concat(par2);
              var dos = uno.concat(par3);
              prue = prue.concat(dos);
              $('#proc').show();
              $('#procedencia').val(response.domicilio);
            }

            if(!response.fecha){
              $('#fa').hide();
            }
            else{
              var par1 = "<tr><td>Alta</td><td>";
              var par2= response.fecha;
              var par3 = "</td></tr>";
              var uno = par1.concat(par2);
              var dos = uno.concat(par3);
              prue = prue.concat(dos);
              $('#fa').show();
              $('#fecha_alta').val(response.fecha);
            }

            if(!response.oficio_presuntos){
              $('#nyddogp').hide();
            }
            else{
              var par1 = "<tr><td>Numero y fecha del oficio global de presunción</td><td>";
              var par2= response.oficio_presuntos;
              var par3 = "</td></tr>";
              var uno = par1.concat(par2);
              var dos = uno.concat(par3);
              prue = prue.concat(dos);
              $('#nyddogp').show();
              $('#numero_y_fecha_de_oficio_global_de_presuncion').val(response.oficio_presuntos);
            }

            if(!response.dof_presuntos){
              $('#pdp').hide();
            }
            else{
              var par1 = "<tr><td>publicacion DOF presuntos</td><td>";
              var par2= response.dof_presuntos;
              var par3 = "</td></tr>";
              var uno = par1.concat(par2);
              var dos = uno.concat(par3);
              prue = prue.concat(dos);
              $('#pdp').show();
              $('#publicacion_dof_presuntos').val(response.dof_presuntos);
            }

            if(!response.sat_desvirtuados){
              $('#ppsp1').hide();
            }
            else{
              var par1 = "<tr><td>Publicación en la pagina del SAT Desvirtuados</td><td>";
              var par2= response.sat_desvirtuados;
              var par3 = "</td></tr>";
              var uno = par1.concat(par2);
              var dos = uno.concat(par3);
              prue = prue.concat(dos);
              $('#ppsp1').show();
              $('#publicacion_pagina_sat_desvirtuados').val(response.sat_desvirtuados);
            }

            if(!response.sat_presuntos){
              $('#ppsp').hide();
            }
            else{
              var par1 = "<tr><td>Publicacion en pagina de SAT Presuntos</td><td>";
              var par2= response.sat_presuntos;
              var par3 = "</td></tr>";
              var uno = par1.concat(par2);
              var dos = uno.concat(par3);
              prue = prue.concat(dos);
              $('#ppsp').show();
              $('#publicacion_pagina_sat_presuntos').val(response.sat_presuntos);
            }

            if(!response.oficio_desvirtuados){
              $('#nfogcd').hide();
            }
            else{
              var par1 = "<tr><td>Numero y fecha oficio global de contribuyente desvirtuados</td><td>";
              var par2= response.oficio_desvirtuados;
              var par3 = "</td></tr>";
              var uno = par1.concat(par2);
              var dos = uno.concat(par3);
              prue = prue.concat(dos);
              $('#nfogcd').show();
              $('#numero_fecha_oficio_global_contribuyentes_desvirtuaron').val(response.oficio_desvirtuados);
            }

            if(!response.dof_desvirtuados){
              $('#pdd').hide();
            }
            else{
              var par1 = "<tr><td>Publicacion DOF desvirtuados</td><td>";
              var par2= response.dof_desvirtuados;
              var par3 = "</td></tr>";
              var uno = par1.concat(par2);
              var dos = uno.concat(par3);
              prue = prue.concat(dos);
              $('#pdd').show();
              $('#publicacion_dof_desvirtuados').val(response.dof_desvirtuados);
            }

            if(!response.oficio_definitivos){
              $('#nfogd').hide();
            }
            else{
              var par1 = "<tr><td>Numero y fechade oficio global de definitivos</td><td>";
              var par2= response.oficio_definitivos;
              var par3 = "</td></tr>";
              var uno = par1.concat(par2);
              var dos = uno.concat(par3);
              prue = prue.concat(dos);
              $('#nfogd').show();
              $('#numero_y_fecha_de_oficio_global_de_definitivos').val(response.oficio_definitivos);
            }

            if(!response.sat_definitivos){
              $('#ppsd').hide();
            }
            else{
              var par1 = "<tr><td>Publicacion SAT Definitivos</td><td>";
              var par2= response.sat_definitivos;
              var par3 = "</td></tr>";
              var uno = par1.concat(par2);
              var dos = uno.concat(par3);
              prue = prue.concat(dos);
              $('#ppsd').show();
              $('#publicacion_pagina_sat_definitivos').val(response.sat_definitivos);
            }

            if(!response.oficio_sentenciaF){
              $('#nfogsf').hide();
            }
            else{
              var par1 = "<tr><td>Numero y fecha de oficio global de sentencia favorable</td><td>";
              var par2= response.oficio_sentenciaF;
              var par3 = "</td></tr>";
              var uno = par1.concat(par2);
              var dos = uno.concat(par3);
              prue = prue.concat(dos);
              $('#nfogsf').show();
              $('#numero_y_fecha_de_oficio_global_de_sentencia_favorable').val(response.oficio_sentenciaF);
            }

            if(!response.sat_sentenciaF){
              $('#ppssf').hide();
            }
            else{
              var par1 = "<tr><td>Publicacion pagina del SAT sentencia favorable</td><td>";
              var par2= response.sat_sentenciaF;
              var par3 = "</td></tr>";
              var uno = par1.concat(par2);
              var dos = uno.concat(par3);
              prue = prue.concat(dos);
              $('#ppssf').show();
              $('#publicacion_pagina_sat_sentencia_favorable').val(response.sat_sentenciaF);
            }

            if(!response.dof_sentenciaF){
              $('#pdsf').hide();
            }
            else{
              var par1 = "<tr><td>Publicacion DOF sentencia favorable</td><td>";
              var par2= response.dof_sentenciaF;
              var par3 = "</td></tr>";
              var uno = par1.concat(par2);
              var dos = uno.concat(par3);
              prue = prue.concat(dos);
              $('#pdsf').show();
              $('#publicacion_dof_sentencia_favorable').val(response.dof_sentenciaF);
            }

            if(!response.dof_definitivos){
              $('#pdfd').hide();
            }
            else{
              var par1 = "<tr><td>Publicacion DOF definitivos</td><td>";
              var par2= response.dof_definitivos;
              var par3 = "</td></tr>";
              var uno = par1.concat(par2);
              var dos = uno.concat(par3);
              prue = prue.concat(dos);
              $('#pdfd').show();
              $('#publicacion_dof_definitivos').val(response.dof_definitivos);
            }


                        if(!response.pertenece){
                          $('#per').hide();
                        }
                        else{
                          var par1 = "<tr><td>Pertenece</td><td>";
                          var par2= response.pertenece;
                          var par3 = "</td></tr>";
                          var uno = par1.concat(par2);
                          var dos = uno.concat(par3);
                          prue = prue.concat(dos);
                          $('#per').show();
                          $('#per2').val(response.pertenece);
                        }



                        if(!response.birthday){
                          $('#bday').hide();
                        }
                        else{
                          var par1 = "<tr><td>Fecha de nacimiento</td><td>";
                          var par2= response.birthday;
                          var par3 = "</td></tr>";
                          var uno = par1.concat(par2);
                          var dos = uno.concat(par3);
                          prue = prue.concat(dos);
                          $('#bday').show();
                          $('#fday').val(response.birthday);
                        }

            if(!response.oficio_pb){
              $('#nofpb').hide();
            }
            else{
              var par1 = "<tr><td>Numero de oficio de personas bloqueadas</td><td>";
              var par2= response.oficio_pb;
              var par3 = "</td></tr>";
              var uno = par1.concat(par2);
              var dos = uno.concat(par3);
              prue = prue.concat(dos);
              $('#nofpb').show();
              $('#numero_oficio_personas_bloqueadas').val(response.oficio_pb);
            }

            $('#id_persona').val(response.id);

            if (response.photo != null && response.photo != '') //con foto
            {
                $('#subir_foto').hide(); // oculta para subir foto
                $('#foto_default').hide(); //oculta la foto default
                $('#url_foto').html('<img src="'+response.photo+'" class="img-responsive img-thumbnail img-circle"  >');
            }
            else //sin  url foto
            {
                $('#subir_foto').show();
                $('#foto_default').show();
                switch (response.tipo) {
                  case '69B'://SAt1
                    $('#url_foto').html('<img src="<?= base_url('assets/img/imgListas/sat.jpg'); ?>" class="img-responsive img-thumbnail img-circle" >');
                  break;

                  case 'BIS'://bis1
                    $('#url_foto').html('<img src="<?= base_url('assets/img/imgListas/bis.png'); ?>" class="img-responsive img-thumbnail img-circle" >');
                  break;

                  case 'BLOQUEADO'://lpb1
                    $('#url_foto').html('<img src="<?= base_url('assets/img/imgListas/lpb.jpg'); ?>" class="img-responsive img-thumbnail img-circle" >');
                  break;

                  case 'CI'://SAT1
                    $('#url_foto').html('<img src="<?= base_url('assets/img/imgListas/sat.jpg'); ?>" class="img-responsive img-thumbnail img-circle" >');
                  break;

                  case 'DDTC'://DDTC 1
                    $('#url_foto').html('<img src="<?= base_url('assets/img/imgListas/ddtc.jpg'); ?>" class="img-responsive img-thumbnail img-circle" >');
                  break;

                  case 'DEA'://dea1
                    $('#url_foto').html('<img src="<?= base_url('assets/img/imgListas/dea.jpg'); ?>" class="img-responsive img-thumbnail img-circle" >');
                  break;

                  case 'DOJ'://doj1
                    $('#url_foto').html('<img src="<?= base_url('assets/img/imgListas/doj.png'); ?>" class="img-responsive img-thumbnail img-circle" >');
                  break;

                  case 'FBI'://fbi1
                    $('#url_foto').html('<img src="<?= base_url('assets/img/imgListas/fbi.jpg'); ?>" class="img-responsive img-thumbnail img-circle" >');
                  break;

                  case 'ICE'://ice1
                    $('#url_foto').html('<img src="<?= base_url('assets/img/imgListas/ice.jpg'); ?>" class="img-responsive img-thumbnail img-circle" >');
                  break;

                  case 'INTERPOL'://interpoL1
                    $('#url_foto').html('<img src="<?= base_url('assets/img/imgListas/interpol.png'); ?>" class="img-responsive img-thumbnail img-circle" >');
                  break;

                  case 'LPB'://lpb1
                    $('#url_foto').html('<img src="<?= base_url('assets/img/imgListas/lpb.jpg'); ?>" class="img-responsive img-thumbnail img-circle" >');
                  break;

                  case 'MARSHAL DISTRICT OFFICES'://lpb1
                    $('#url_foto').html('<img src="<?= base_url('assets/img/imgListas/marshal.jpg'); ?>" class="img-responsive img-thumbnail img-circle" >');
                  break;

                  case 'OFAC'://ofac1
                    $('#url_foto').html('<img src="<?= base_url('assets/img/imgListas/ofac.jpg'); ?>" class="img-responsive img-thumbnail img-circle" >');
                  break;

                  case 'ONU'://onu1
                    $('#url_foto').html('<img src="<?= base_url('assets/img/imgListas/onu.jpg'); ?>" class="img-responsive img-thumbnail img-circle" >');
                  break;

                  case 'PEP'://pep1
                    $('#url_foto').html('<img src="<?= base_url('assets/img/imgListas/pep.jpg'); ?>" class="img-responsive img-thumbnail img-circle" >');
                  break;

                  case 'PEP-CIA'://pep1
                    $('#url_foto').html('<img src="<?= base_url('assets/img/imgListas/pepI.jpg'); ?>" class="img-responsive img-thumbnail img-circle" >');
                  break;

                  case 'PEP-RULERS'://pep1
                    $('#url_foto').html('<img src="<?= base_url('assets/img/imgListas/pepI.jpg'); ?>" class="img-responsive img-thumbnail img-circle" >');
                  break;

                  case 'PGJ'://PGJ1
                    $('#url_foto').html('<img src="<?= base_url('assets/img/imgListas/PGJ.jpg'); ?>" class="img-responsive img-thumbnail img-circle" >');
                  break;

                  case 'PGR'://PGR1
                    $('#url_foto').html('<img src="<?= base_url('assets/img/imgListas/pgr.png'); ?>" class="img-responsive img-thumbnail img-circle" >');
                  break;

                  case 'SAT'://SAT1
                    $('#url_foto').html('<img src="<?= base_url('assets/img/imgListas/sat.jpg'); ?>" class="img-responsive img-thumbnail img-circle" >');
                  break;

                  case 'TREAS'://TREAS1
                    $('#url_foto').html('<img src="<?= base_url('assets/img/imgListas/ofac.jpg'); ?>" class="img-responsive img-thumbnail img-circle" >');
                  break;

                  case 'UFML'://UFML1
                    $('#url_foto').html('<img src="<?= base_url('assets/img/imgListas/ucrania.jpg'); ?>" class="img-responsive img-thumbnail img-circle" >');
                  break;

                  case 'UIF'://UFI1
                    $('#url_foto').html('<img src="<?= base_url('assets/img/imgListas/ufi.png'); ?>" class="img-responsive img-thumbnail img-circle" >');
                  break;

                  case 'OCDETF'://OCDETF0
                    $('#url_foto').html('<img src="<?= base_url('assets/img/imgListas/odcetf.jpg'); ?>" class="img-responsive img-thumbnail img-circle" >');
                  break;

                  default:
                      $('#url_foto').html('<img src="<?= base_url('assets/img/avatars/avatar_m.png'); ?>" class="img-responsive img-thumbnail img-circle" >');
                  break;

                }

            }


            $('#datos4').val(prue);
            $('#guardar').hide();
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
    }

    /*Acordeon*/
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var panel = this.nextElementSibling;
        if (panel.style.display === "block") {
          panel.style.display = "none";
        }
        else {
          panel.style.display = "block";
        }
        });
     }

</script>




<link href="<?= base_url('assets/css/fileinput.css')?>" media="all" rel="stylesheet" type="text/css" />
<script src="<?= base_url('assets/js/fileinput.js')?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/fileinput_locale_fr.js')?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/fileinput_locale_es.js')?>" type="text/javascript"></script>
