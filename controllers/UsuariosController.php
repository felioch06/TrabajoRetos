<?php 

 class UsuariosController extends Usuario{

  //Vistas

   /*
    * @author  andrescortes
    * @view
    * @return all entity records <usuario>
    */
      public function index(){
          require_once('views/layouts/header.php');
          require_once('views/usuario/index.php');
          require_once('views/layouts/footer.php');
      }
   /*
    * @author  andrescortes
    * @view
    * @return ""
    */
      public function retos(){
        require_once('views/layouts/header.php');
        require_once('views/usuario/retos.php');
        require_once('views/layouts/footer.php');
    }
     /*
    * @author  andrescortes
    * @view
    * @return ""
    */
    public function entregable(){
        require_once('views/layouts/header.php');
        require_once('views/usuario/entregable.php');
        require_once('views/layouts/footer.php');
    }

    public function search(){
      require_once('views/layouts/header.php');
      require_once('views/usuario/search.php');
      require_once('views/layouts/footer.php');
  }

  public function create(){
    require_once('views/layouts/header.php');
    require_once('views/usuario/create.php');
    require_once('views/layouts/footer.php');
  }

  // Funciones

  public function stored(){
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $correo = $_POST['correo'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    date_default_timezone_set('America/Bogota');
    $created_at = date('Y-m-d H:i:s');

    $target_dir = "assets/img";
    $target_file = $_FILES["fileToUpload"]["name"];
    $tpm = $_FILES["fileToUpload"]["tmp_name"];
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    if(isset($_POST["submit"])) {
      $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      if($check !== false) {
          move_uploaded_file($tpm,"assets/img/". $target_file);
          $route_img = 'assets/img/'.$target_file;
          parent::store($nombres, $apellidos, $correo, $direccion, $telefono, $route_img, $created_at, $created_at);
          header("location:?c=Usuarios&m=index");
          $uploadOk = 1;
      } else {
          echo "File is not an image.";
          $uploadOk = 0;
      }
    }
  }

    public function searchAjax(){
      $nombre ='%'.$_POST['nombre'].'%';
      ?>
      <table class="table">
          <tr>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Correo</th>
            <th>Direccion</th>
          </tr>
      <?php
      
      foreach(parent::searchM($nombre) as $r){

        ?>
        
          <tr>
            <td><?php echo $r->nombres ?></td>
            <td><?php echo $r->apellidos ?></td>
            <td><?php echo $r->correo ?></td>
            <td><?php echo $r->direccion ?></td>
          </tr>
      <?php } ?>
        </table>
        <?php
      
    }
      
    public function destroyed(){
      $id = $_REQUEST['id'];

      parent::destroy($id);

      header('location:?c=usuarios&m=index');
    }

    public function edit(){
      echo $nombres = $_POST['nombres'];
      echo $id = $_POST['inputE'];
    }

    public function felipeC(){
      $consultaPorId = parent::searchForId($_POST['id']);
?>
      <form action="?c=Usuarios&m=Edit" method="post">
         
        <input type="text" name="id" value="<?php echo $consultaPorId->id ?>" class="form-control my-3">
        <input type="text" name="nombres" value="<?php echo $consultaPorId->nombres ?>" class="form-control my-3">
        <input type="text" name="apellidos" value="<?php echo $consultaPorId->apellidos ?>" class="form-control my-3">
        <input type="text" name="correo" value="<?php echo $consultaPorId->correo ?>" class="form-control my-3">
        <input type="text" name="direccion" value="<?php echo $consultaPorId->direccion ?>" class="form-control my-3">
        <input type="text" name="telefono" value="<?php echo $consultaPorId->telefono ?>" class="form-control my-3">
        <input type="text" name="foto_perfil" value="<?php echo $consultaPorId->foto_perfil ?>" class="form-control my-3">

      </div>

      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Actualizar</button>

        </form>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>


      <?php
    }

 }

?>
