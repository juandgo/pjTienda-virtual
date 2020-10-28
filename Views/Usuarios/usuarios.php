<?php 
  headerAdmin($data); 
//   getModal('modalRoles', $data);//los datos de la modal se envian por parametro a la funcion getmodals ubicada en  helpers
?>
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fas fa-user-tag"></i>  <?= $data['page_title'] ?>
              <button class="btn btn-primary" type="button" onclick="openModal();">
              <i class="fas fa-plus-circle"></i> Nuevo</button>
          </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="<?= base_url(); ?>"><?= $data['page_title'] ?></a></li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered" id="tableUsuarios">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nombres</th>
                      <th>Apellidos</th>
                      <th>Email</th>
                      <th>Telefono</th>
                      <th>Rol</th>
                      <th>Status</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
<?php footerAdmin($data); ?>