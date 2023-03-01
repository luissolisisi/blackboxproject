<div id="cl-wrapper">
        <div class="cl-sidebar">
          <?php $this->load->view('menu_left');?>
        </div>
        <div class="container-fluid" id="pcont">
          <div class="cl-mcont">
            <div class="col-md-4">
              <div class="block-flat">
                <div class="content no-padding">
                  <div class="overflow-hidden"><i class="fas fa-users fa-4x pull-left color-primary"></i>
                    <h3 class="no-margin">Busquedas</h3>
                    <p class="color-primary">Número Total</p>
                  </div>
                  <h1 class="no-margin big-text"><?php echo (count($noCoincidencia)+count($coincidencia));?></h1>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="block-flat ">
                <div class="content no-padding  md-trigger">
                  <div class="overflow-hidden"><i class="fas fa-user-check fa-4x pull-left color-success"></i>
                    <h3 class="no-margin">Total</h3>
                    <p class="color-success">Coincidencias de la busqueda</p><br>
                  </div>
                  <h1 class="big-text no-margin"><?php echo count($coincidencia);?></h1>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="block-flat">
                <div class="content no-padding md-trigger" >
                  <div class="overflow-hidden"><i class="fas fa-user-times fa-4x pull-left color-danger"></i>
                    <h3 class="no-margin"></i>Total</h3>
                    <p class="color-danger">No coincidencias en la busqueda</p><br>
                  </div>
                  <h1 class="big-text no-margin"><?php echo count($noCoincidencia);?></h1>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="block-flat">
                  <div class="header">
                    <h2>Registros coincidentes en el sistema</h2>
                  </div>
                  <div class="content">
                    <div>
                      <table class="table no-border blue">
                        <thead>
                          <tr>
                            <th>Nombre</th>
                            <th>Apellido Paterno </th>
                            <th>Apellido Materno</th>
                            <th>Resultado</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if(count($coincidencia) > 0 ){foreach ($coincidencia as $coincidenciaB):?>
                            <tr class="odd gradeX">
                              <td class="center">
                                  <a data-toggle="modal"
                                  data-nombre= "<?php  echo $coincidenciaB['nombre'].' '.$coincidenciaB['apellidoP'].' '.$coincidenciaB['apellidoM'];?>"
                                  data-tipo= "<?php  echo $coincidenciaB['tipo'];?>"
                                  data-rfc= "<?php  echo $coincidenciaB['rfc'];?>"
                                  data-nac= "<?php  echo $coincidenciaB['nac'];?>"
                                  data-obs= "<?php  echo $coincidenciaB['obs'];?>"
                                  data-pertenece= "<?php  echo $coincidenciaB['pertenece'];?>"
                                  data-actividad= "<?php  echo $coincidenciaB['actividad'];?>"
                                  data-fecha= "<?php  echo $coincidenciaB['fecha'];?>"
                                  data-situacion_c= "<?php  echo $coincidenciaB['situacion_c'];?>"
                                  data-ofgp= "<?php  echo $coincidenciaB['ofgp'];?>"
                                  data-psp= "<?php  echo $coincidenciaB['psp'];?>"
                                  data-pdp= "<?php  echo $coincidenciaB['pdp'];?>"
                                  data-psdes= "<?php  echo $coincidenciaB['psdes'];?>"
                                  data-pdgdes= "<?php  echo $coincidenciaB['pdgdes'];?>"
                                  data-pddes= "<?php  echo $coincidenciaB['pddes'];?>"
                                  data-pogdef= "<?php  echo $coincidenciaB['pogdef'];?>"
                                  data-psdef= "<?php  echo $coincidenciaB['psdef'];?>"
                                  data-pddef= "<?php  echo $coincidenciaB['pddef'];?>"
                                  data-pogsf= "<?php  echo $coincidenciaB['pogsf'];?>"
                                  data-pssf= "<?php  echo $coincidenciaB['pssf'];?>"
                                  data-pdsf= "<?php  echo $coincidenciaB['pdsf'];?>"

                                 class="open-Modal" href="#person_info">
                                    <?php  echo $coincidenciaB['nombre'];?>
                                  </a>
                              </td>
                              <td><?php  echo $coincidenciaB['apellidoP'];?></td>
                              <td><?php  echo $coincidenciaB['apellidoM'];?></td>

                              <td class="center"><p class="color-success"><?php  echo $coincidenciaB['mensaje'];?></p></td>

                            </tr>
                          <?php endforeach;}?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="block-flat">
                  <div class="header">
                    <h2>Registros no coincidentes en el sistema</h2>
                  </div>
                  <div class="content">
                    <div>
                      <table class="table no-border blue">
                        <thead>
                          <tr>
                            <th>Nombre</th>
                            <th>Apellido Paterno</th>
                            <th>Apellido Materno</th>
                            <th>Observación</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php  if(count($noCoincidencia) > 0 ){ foreach ($noCoincidencia as $noCoincidenciaB):?>
                            <tr class="odd gradeX">
                              <td><?php  echo $noCoincidenciaB['nombre'];?></td>
                              <td><?php  echo $noCoincidenciaB['apellidoP'];?></td>
                              <td><?php  echo $noCoincidenciaB['apellidoM'];?></td>

                              <td class="center"><p class="color-danger"><?php echo $noCoincidenciaB['mensaje'];?></p></td>

                            </tr>
                          <?php endforeach;}?>
                        </tbody>
                      </table>
                    </div>

                  </div>

                </div>
                <input type="hidden" name="datos" id="datos" value="<?php echo $res;?>" >
                <div style="text-align:center;"><button class="btn btn-primary" id="print_result" data-table="" autocomplete="off">Imprimir resultados</button></div>
                <div style="text-align:center;">
                  <a href="<?=base_url('busqueda/busqueda');?>">
                  <button class="btn btn-primary" id="volver" data-table="" autocomplete="off">Volver a búsquedas</button>
                  </a>
                </div>
              </div>

            </div>
          </div>
        </div>
        <div class="md-overlay"> </div>

        <div class="modal fade" id="person_info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document" style="width: 70%">
            <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <div id="person_info_name">
                    <h4 class="modal-title" id="myModalLabel"><i class="fas fa-user-shield"></i>Información de la persona:</h4>
                  </div>
              </div>
              <div class="content">
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-2">
                      <div class="form-group" id="sc">
                          <label>Nombre</label>
                          <input type="text" id="nombre" class="form-control"  disabled>
                      </div>
                        <div class="form-group" id="sc">
                            <label>Situación del contribuyente</label>
                            <input type="text" id="situacion_del_contribuyente" class="form-control"  disabled>
                        </div>
                        <div class="form-group" id="tpi">
                            <label>Tipo</label>
                            <input type="text" id="tipo_person_info" class="form-control" disabled>
                        </div>

                    </div>
                    <div class="col-md-2">
                        <div class="form-group"id="rpi">
                            <label>RFC</label>
                            <input type="text" id="rfc_person_info" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group" id="nac">
                            <label>Nacionalidad</label>
                            <input type="text" id="nacionalidad" class="form-control"  disabled>
                        </div>
                        <div class="form-group" id="obs">
                            <label>observaciones</label>
                            <textarea rows="3" id="observaciones" class="form-control" name="observaciones"disabled></textarea>
                        </div>

                    </div>
                    <div class="col-md-2">
                        <div class="form-group" id="fa">
                            <label>Fechas alta</label>
                            <input type="text" id="fecha_alta" class="form-control"  disabled>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-4">
                        <div class="form-group" id="ac">
                            <label>Actividad</label>
                            <input type="text" id="actividad" class="form-control"  disabled>
                        </div>
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
                          <label>Pub. Pág. SAT presuntos</label>
                          <input type="date" id="publicacion_pagina_sat_presuntos" class="form-control" disabled>
                      </div>
                        <div class="form-group" id="ppsp">
                            <label>Pub. Pág. SAT Desvirtuados</label>
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

                </div>
                <input type="hidden" name="datos4" id="datos4">
                <button class="btn btn-primary" id="print_result4" data-name="" data-table="">Imprimir</button>
              </div>
            </div>
          </div>

          <a href=""></a>
        </div>
</div>




<script>
$(document).on('click', '#print_result', function() {
      name    = 'Busqueda Multiple';
      estatus = '';
      datos   = $("#datos").val();
      var data = new FormData();
      data.append('name', name);
      data.append('estatus', estatus);
      data.append('datos', datos);
      var xhr = new XMLHttpRequest();
      xhr.open('POST', "<?= base_url('busqueda/print_result2') ?>", true);
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
$(document).on("click", ".open-Modal", function () {
  var prue = '';

  var nombre=  $(this).data('nombre');
  var par1 = "<tr><td>Nombre / Razon social</td><td>";
  var par2=  $(this).data('nombre');
  var par3 = "</td></tr>";
  var uno = par1.concat(par2);
  var dos = uno.concat(par3);
  prue = prue.concat(dos);

    var rfc=  $(this).data('rfc');
    var par1 = "<tr><td>RFC</td><td>";
    var par2=  $(this).data('rfc');
    var par3 = "</td></tr>";
    var uno = par1.concat(par2);
    var dos = uno.concat(par3);
    prue = prue.concat(dos);

    var tipo=  $(this).data('tipo');
    var par1 = "<tr><td>Tipo persona</td><td>";
    var par2= $(this).data('tipo');
    var par3 = "</td></tr>";
    var uno = par1.concat(par2);
    var dos = uno.concat(par3);
    prue = prue.concat(dos);

    var nac=  $(this).data('nac');
    var par1 = "<tr><td>nacionalidad</td><td>";
    var par2= $(this).data('nac');
    var par3 = "</td></tr>";
    var uno = par1.concat(par2);
    var dos = uno.concat(par3);
    prue = prue.concat(dos);

    var obs=  $(this).data('obs');
    var par1 = "<tr><td>Observaciones</td><td>";
    var par2= $(this).data('obs');
    var par3 = "</td></tr>";
    var uno = par1.concat(par2);
    var dos = uno.concat(par3);
    prue = prue.concat(dos);

    var pertenece=  $(this).data('pertenece');
    var par1 = "<tr><td>Pertenece</td><td>";
    var par2= $(this).data('pertenece');
    var par3 = "</td></tr>";
    var uno = par1.concat(par2);
    var dos = uno.concat(par3);
    prue = prue.concat(dos);

    var actividad=  $(this).data('actividad');
    var par1 = "<tr><td>Actividad</td><td>";
    var par2= $(this).data('actividad');
    var par3 = "</td></tr>";
    var uno = par1.concat(par2);
    var dos = uno.concat(par3);
    prue = prue.concat(dos);

    var fecha= $(this).data('fecha');
    var par1 = "<tr><td>Fecha</td><td>";
    var par2= $(this).data('fecha');
    var par3 = "</td></tr>";
    var uno = par1.concat(par2);
    var dos = uno.concat(par3);
    prue = prue.concat(dos);

    var situacion_c=  $(this).data('situacion_c');
    var par1 = "<tr><td>Situacion del contribuyente</td><td>";
    var par2= $(this).data('situacion_c');
    var par3 = "</td></tr>";
    var uno = par1.concat(par2);
    var dos = uno.concat(par3);
    prue = prue.concat(dos);

    var ofgp=  $(this).data('ofgp');
    var par1 = "<tr><td>numero y fecha de oficio global de presuncion</td><td>";
    var par2= $(this).data('ofgp');
    var par3 = "</td></tr>";
    var uno = par1.concat(par2);
    var dos = uno.concat(par3);
    prue = prue.concat(dos);

    var psp=  $(this).data('psp');
    var par1 = "<tr><td>Publicacion pagina SAT presuntos</td><td>";
    var par2= $(this).data('psp');
    var par3 = "</td></tr>";
    var uno = par1.concat(par2);
    var dos = uno.concat(par3);
    prue = prue.concat(dos);

    var pdp=  $(this).data('pdp');
    var par1 = "<tr><td>Publicacion DOF presuntos</td><td>";
    var par2= $(this).data('pdp');
    var par3 = "</td></tr>";
    var uno = par1.concat(par2);
    var dos = uno.concat(par3);
    prue = prue.concat(dos);

    var psdes=  $(this).data('psdes');
    var par1 = "<tr><td>Publicacion pagina SAT desvirtuados</td><td>";
    var par2= $(this).data('psdes');
    var par3 = "</td></tr>";
    var uno = par1.concat(par2);
    var dos = uno.concat(par3);
    prue = prue.concat(dos);

    var pdgdes=  $(this).data('pdgdes');
    var par1 = "<tr><td>Numero fecha oficio global contribuyentes desvirtuaron</td><td>";
    var par2= $(this).data('pdgdes');
    var par3 = "</td></tr>";
    var uno = par1.concat(par2);
    var dos = uno.concat(par3);
    prue = prue.concat(dos);

    var pddes=  $(this).data('pddes');
    var par1 = "<tr><td>Publicacion DOF desvirtuados</td><td>";
    var par2=  $(this).data('pddes');
    var par3 = "</td></tr>";
    var uno = par1.concat(par2);
    var dos = uno.concat(par3);
    prue = prue.concat(dos);

    var pogdef=  $(this).data('pogdef');
    var par1 = "<tr><td>Numero y fecha de oficio global de definitivos</td><td>";
    var par2= $(this).data('pogdef');
    var par3 = "</td></tr>";
    var uno = par1.concat(par2);
    var dos = uno.concat(par3);
    prue = prue.concat(dos);

    var psdef=  $(this).data('psdef');
    var par1 = "<tr><td>Publicacion pagina SAT definitivos</td><td>";
    var par2= $(this).data('psdef');
    var par3 = "</td></tr>";
    var uno = par1.concat(par2);
    var dos = uno.concat(par3);
    prue = prue.concat(dos);

    var pddef=  $(this).data('pddef');
    var par1 = "<tr><td>Publicacion DOF definitivos</td><td>";
    var par2= $(this).data('pddef');
    var par3 = "</td></tr>";
    var uno = par1.concat(par2);
    var dos = uno.concat(par3);
    prue = prue.concat(dos);

    var pogsf=  $(this).data('pogsf');
    var par1 = "<tr><td>Numero y fecha de oficio global sentencia favorable</td><td>";
    var par2=  $(this).data('pogsf');
    var par3 = "</td></tr>";
    var uno = par1.concat(par2);
    var dos = uno.concat(par3);
    prue = prue.concat(dos);

    var pssf=  $(this).data('pssf');
    var par1 = "<tr><td>Publicacion pagina SAT sentencia favorable</td><td>";
    var par2= $(this).data('pssf');
    var par3 = "</td></tr>";
    var uno = par1.concat(par2);
    var dos = uno.concat(par3);
    prue = prue.concat(dos);

    var pdsf=  $(this).data('pdsf');
    var par1 = "<tr><td>publicacion DOF sentencia favorable</td><td>";
    var par2= $(this).data('pdsf');
    var par3 = "</td></tr>";
    var uno = par1.concat(par2);
    var dos = uno.concat(par3);
    prue = prue.concat(dos);


    $('#nombre').val(nombre);
    $('#situacion_del_contribuyente').val(situacion_c);
    $('#tipo_person_info').val(tipo);
    $('#rfc_person_info').val(rfc);
    $('#nacionalidad').val(nac);
    $('#observaciones').val(obs);
    $('#publicacion_dof_presuntos').val(pdp);
    $('#fecha_alta').val(fecha);
    $('#actividad').val(actividad);
    $('#numero_y_fecha_de_oficio_global_de_presuncion').val(ofgp);

    $('#publicacion_pagina_sat_desvirtuados').val(psdes);

    $('#numero_fecha_oficio_global_contribuyentes_desvirtuaron').val(pdgdes);

    $('#numero_y_fecha_de_oficio_global_de_definitivos').val(pogdef);
    $('#numero_y_fecha_de_oficio_global_de_sentencia_favorable').val(pogsf);

    $('#publicacion_dof_desvirtuados').val(pddes);
    $('#publicacion_dof_definitivos').val(pddef);
    $('#publicacion_dof_sentencia_favorable').val(pdsf);
    $('#publicacion_pagina_sat_presuntos').val(psp);
    $('#publicacion_pagina_sat_definitivos').val(psdef);
    $('#publicacion_pagina_sat_sentencia_favorable').val(pssf);
    $('#datos4').val(prue);

  });


</script>
