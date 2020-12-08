<!-- modalUsuarios -->
<div class="modal fade" id="modalFormCategorias" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nueva Categoria</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form id="formCategoria" name="formCategoria" class="formHorizontal">
              <input type="hidden" id="idUsuario" name="idUsuario" value="">
              <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>
              
              <div class="tile-footer">
                  <div class="row">
                      <div class="col-md-6">
                      <input type="hidden" id="idCategoria" name="idCategoria" value="">
                        <div class="form-group">
                            <label class="control-label">Nombre <span class="required">*</span></label>
                            <input class="form-control" id="txtNombre" name="txtNombre" type="text" placeholder="Nombre del Categoria" required="">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Descripción <span class="required">*</span></label>
                            <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" rows="2" placeholder="Descripcion del Rol" required=""></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleSelect1">Estado <span class="required">*</span></label>
                            <select class="form-control" id="listStatus" name="listStatus" required="">
                            <option value="1">Activo</option>
                            <option value="2">Inactivo</option>
                            </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <label for="foto">Foto (567x380)</label>
                        <div class="prevPhoto">
                            <span class="delPhoto notBlock">X</span>
                            <label for="foto"></label>
                            <div>
                                <img id="img" src="<?= media(); ?>/images/uploads/img_portada.png" alt="">
                            </div>
                        </div>
                        <div class="upimg">
                            <input type="file" name="foto" id="foto">
                        </div>
                        <div id="form_alert">
                            
                        </div>
                      </div>
                  </div>
                  <button  id="btnActionForm"class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle" aria-hidden="true"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;&nbsp;
                <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-check-circle"></i> Cerrar</button>
              </div>
            </form>
      </div>
    </div>
  </div>
</div>

<!-- modalViewCliente -->
<div class="modal fade" id="modalViewCategoria" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos del cliente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td>Identificación:</td>
              <td id="celIdentificacion">654654654</td>
            </tr>
            <tr>
              <td>Nombres:</td>
              <td id="celNombre">Jacob</td>
            </tr>
            <tr>
              <td>Apellidos:</td>
              <td id="celApellido">Jacob</td>
            </tr>
            <tr>
              <td>Teléfono:</td>
              <td id="celTelefono">Larry</td>
            </tr>
            <tr>
              <td>Email (Usuario):</td>
              <td id="celEmail">Larry</td>
            </tr>
            <tr>
              <td>Identificacioón Tributaria:</td>
              <td id="celIde">Larry</td>
            </tr>
            <tr>
              <td>Nombre Fiscal:</td>
              <td id="celNomFiscal">Larry</td>
            </tr>
            <tr>
              <td>Dirección Fiscal:</td>
              <td id="celDirFiscal">Larry</td>
            </tr>
            <tr>
              <td>Fecha registro:</td>
              <td id="celFechaRegistro">Larry</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


