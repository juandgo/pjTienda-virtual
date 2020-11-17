<!-- modalUsuarios -->
<div class="modal fade" id="modalFormPerfil" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header headerUpdates">
        <h5 class="modal-title" id="titleModal">Actualizar Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form id="formPerfil" name="formPerfil" class="formHorizontal">
              <input type="hidden" id="idUsuario" name="idUsuario" value="">
              <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>
              <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="txtIdentificacion">Identificación<span class="required">*</span></label>
                    <input type="text" class="form-control" id="txtIdentificacion" name="txtIdentificacion" value="<?= $_SESSION['userData']['identificacion']; ?>" required="">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="txtNombre">Nombres<span class="required">*</span></label>
                    <input type="text" class="form-control valid validText" id="txtNombre" value="<?= $_SESSION['userData']['nombres']; ?>" name="txtNombre" required="">
                </div>
                <div class="form-group col-md-6">
                    <label for="txtApellido">Apellidos<span class="required">*</span></label>
                    <input type="text" class="form-control valid validText" id="txtApellido" value="<?= $_SESSION['userData']['apellidos']; ?>" name="txtApellido" required="">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="txtTelefono">Telefono<span class="required">*</span></label>
                    <input type="text" class="form-control valid validNumber" id="txtTelefono"
                    value="<?= $_SESSION['userData']['telefono']; ?>" name="txtTelefono" required="" onkeypress="return controlTag(event);">
                </div>
                <!-- Este campo esta bloqueado para que no pueda ser editado -->
                <div class="form-group col-md-6">
                    <label for="txtEmail">Email</label>
                    <input type="text" class="form-control valid validEmail" id="txtEmail" value="<?= $_SESSION['userData']['email_user']; ?>" name="txtEmail" required="" readonly disabled>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="txtPassword">Password</label>
                    <input type="password" class="form-control" id="txtPassword" name="txtPassword" >
                </div>
                <div class="form-group col-md-6">
                    <label for="txtPasswordConfirm">Confirmar Password</label>
                    <input type="password" class="form-control" id="txtPasswordConfirm" name="txtPasswordConfirm" >
                </div>
              </div>
              <div class="tile-footer">
              <button  id="btnActionForm"class="btn btn-info" type="submit"><i class="fa fa-fw fa-lg fa-check-circle" aria-hidden="true"></i><span id="btnText">Actualizar</span></button>&nbsp;&nbsp;&nbsp;&nbsp;
                <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-check-circle"></i> Cerrar</button>
              </div>
            </form>
      </div>
    </div>
  </div>
</div>

