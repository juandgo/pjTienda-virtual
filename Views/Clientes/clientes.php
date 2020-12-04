<?php 
  headerAdmin($data); 
  getModal('modalClientes', $data);
?>
<main class="app-content">    
      <div class="app-title">
        <div>
          <h1>
              <i class="fas fa-user-tag"></i>  <?= $data['page_title'] ?>
              <!-- Si permisosMod tiene write en true mostrara el boto para poder crear un ususario en este modulo -->
              <?php if ($_SESSION['permisosMod']['w']){ ?>
              <button class="btn btn-primary" type="button" onclick="openModal();">
              <i class="fas fa-plus-circle"></i> Nuevo</button>
              <?php } ?>
          </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="<?= base_url(); ?>/Clientes"><?= $data['page_title'] ?></a></li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered" id="tableClientes">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Identificación</th>
                      <th>Nombres</th>
                      <th>Apellidos</th>
                      <th>Email</th>
                      <th>Teléfono</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th>1</th>
                      <th>Carlos</th>
                      <th>Hernandes</th>
                      <th>carlos@info.com</th>
                      <th>78542155</th>
                      <th>Administrador</th>
                      <th>Activo</th>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
<?php footerAdmin($data); ?>