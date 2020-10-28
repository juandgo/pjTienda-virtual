<!-- modalRoles -->
<div class="modal fade" id="modalFormUsuario" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
    
            <form id="formUsuario" name="formUsuario" class="formHorizontal">
              <input type="hidden" id="idUsuario" name="idUsuario" value="">
              <p class="text-primary">Todos los campos son obligatorios.</p>
              <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="textIdentificacion">Identificación</label>s
                    <input type="text" class="form-control" id="textIdentificacion" name="textIdentificacion" required="">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="textNombre">Nombres</label>s
                    <input type="text" class="form-control" id="textNombre" name="textNombre" required="">
                </div>
                <div class="form-group col-md-6">
                    <label for="textApellido">Apellidos</label>s
                    <input type="text" class="form-control" id="textApellido" name="textApellido" required="">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="textTelefono">Telefono</label>s
                    <input type="text" class="form-control" id="textTelefono" name="textTelefono" required="">
                </div>
                <div class="form-group col-md-6">
                    <label for="textEmail">Email</label>s
                    <input type="text" class="form-control" id="textEmail" name="textEmail" required="">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="listRolid">Tipo usuario</label>s
                    <select type="text" class="form-control" id="listRolid" name="listRolid" required="">
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="listStatus">Status</label>s
                    <select class="form-control" id="listStatus" name="listStatus" required="">
                        <option value="1">Activo</option>
                        <option value="2">Inactivo</option>
                    </select>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="textPassword">Password</label>s
                    <input type="text" class="form-control" id="textPassword" name="textPassword" required="">
                </div>
              </div>
              
              <div class="tile-footer">
                <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="#" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
              </div>
            </form>
        
      </div>
    </div>
  </div>
</div>



