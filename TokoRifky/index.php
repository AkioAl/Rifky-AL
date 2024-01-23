<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "tugasrifky";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if(!$koneksi){
    die("Tidak bisa terkoneksi ke database");
}
$id_buku = "";
$kategori = "";
$nama_buku = "" ;
$harga = "";
$stok = "";
$penerbit = "";
$sukses = "";
$error = "";

$op = isset($_GET['op']) ? $_GET['op'] : "";
if ($op == 'delete') {
  $id_buku = $_GET['id_buku'];
  $sqli1 = "DELETE FROM tokobuku WHERE id_buku = '$id_buku'";
  $q1 = mysqli_query($koneksi, $sqli1);

  if ($q1) {
      $sukses = "Berhasil Menghapus Data";
  } else {
      $error = "Gagal Menghapus Data: " . mysqli_error($koneksi);
  }
}

if ($op == 'edit') {
    $id_buku = isset($_GET['id_buku']) ? $_GET['id_buku'] : "";
    
    if ($id_buku != "") {
        $sql1 = "SELECT * FROM tokobuku WHERE id_buku = '$id_buku'";
        $q1 = mysqli_query($koneksi, $sql1);

        if ($q1) {
            $r1 = mysqli_fetch_array($q1);

            if ($r1) {
                $kategori = $r1['Kategori'];
                $nama_buku = $r1['nama_buku'];
                $harga = $r1['harga'];
                $stok = $r1['stok'];
                $penerbit = $r1['penerbit'];
            } else {
                $error = "Data Tidak Ditemukan";
            }
        } else {
            die("Query error: " . mysqli_error($koneksi));
        }
    } else {
        $error = "ID Buku tidak valid";
    }
}



if (isset($_POST['simpan'])){ //untuk create
  $id_buku = $_POST['id_buku'];
  $kategori = $_POST['kategori'];
  $nama_buku = $_POST['nama_buku'];
  $harga = $_POST['harga'];
  $stok = $_POST['stok'];
  $penerbit = $_POST['penerbit'];

  if ($id_buku && $kategori && $nama_buku && $harga && $stok && $penerbit){
      if($op == 'edit'){
        $sql1 = "UPDATE tokobuku SET id_buku = '$id_buku', Kategori = '$kategori', nama_buku = '$nama_buku', harga = '$harga', stok = '$stok', penerbit = '$penerbit' WHERE id_buku = '$id_buku'";
        $q1 = mysqli_query($koneksi,$sql1);
        if($q1){
          $sukses = "Data Berhasil di Update";
        }else{
          $error = "Data gagal di Update";
        }
      }else{
        $sql1 = "INSERT INTO tokobuku(id_buku,kategori,nama_buku,harga,stok,penerbit) VALUES ('$id_buku','$kategori','$nama_buku','$harga','$stok','$penerbit')";
      $q1 = mysqli_query($koneksi, $sql1);
      if($q1){
        $sukses = "Berhasil memasukkan data baru";
      }else{
        $error = "Gagal memasukkan data";
      }
    }
  }else{
    $error = "Silahkan Lengkapi data Di atas";
  }
      }
      


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .mx-auto {width: 800px;}
        .card {margin-top: 10px;}
    </style>
</head>
<body>
    <div class="mx-auto">
    <div class="card">
  <div class="card-header">
    Create/Edit Data
  </div>
  <div class="card-body">
    <?php
    if($error){
        ?>
        <div class="alert alert-danger" role="alert">
          <?php echo $error; ?>
        </div>
    <?php
      header("refresh:1;url=index.php");
    }
    ?>
    <?php
    if($sukses){
        ?>
        <div class="alert alert-success" role="alert">
          <?php echo $sukses; ?>
        </div>
    <?php
      header("refresh:1;url=index.php");
    }
    ?>
   <form action="" method="POST">
   <div class="mb-3 row">
    <label for="id_buku" class="col-sm-2 col-form-label">id_buku</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="id_buku" name="id_buku" value="<?php echo $id_buku ?>">
    </div>
  </div>
  <div class="mb-3 row">
    <label for="kategori" class="col-sm-2 col-form-label">kategori</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="kategori" name="kategori" value="<?php echo $kategori ?>">
    </div>
  </div>
  <div class="mb-3 row">
    <label for="nama_buku" class="col-sm-2 col-form-label">nama_buku</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="nama_buku" name="nama_buku" value="<?php echo $nama_buku ?>">
    </div>
  </div>
  <div class="mb-3 row">
    <label for="harga" class="col-sm-2 col-form-label">harga</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="harga" name="harga" value="<?php echo $harga ?>">
    </div>
  </div>
  <div class="mb-3 row">
    <label for="stok" class="col-sm-2 col-form-label">stok</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="stok" name="stok" value="<?php echo $stok ?>">
    </div>
  </div>
  <div class="mb-3 row">
    <label for="penerbit" class="col-sm-2 col-form-label">penerbit</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="penerbit" name="penerbit" value="<?php echo $penerbit ?>">
    </div>
  </div>
  <div class="col-12">
    <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary"/>
  </div>
</form>
   </form>
  </div>
</div>

<div class="card">
  <div class="card-header text-white bg-secondary">
    Toko Buku
  </div>
  <div class="card-body">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">id_buku</th>
          <th scope="col">kategori</th>
          <th scope="col">nama_buku</th>
          <th scope="col">harga</th>
          <th scope="col">stok</th>
          <th scope="col">penerbit</th>
          <th scope="col">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql2 = "SELECT * FROM tokobuku ORDER BY id_buku ASC";
        $q2 = mysqli_query($koneksi, $sql2);
        $urut = 1;
        while($r2 = mysqli_fetch_array($q2)){
          $id_buku = $r2['id_buku'];
          $kategori = $r2['Kategori'];
          $nama_buku = $r2['nama_buku'];
          $harga = $r2['harga'];
          $stok = $r2['stok'];
          $penerbit = $r2['penerbit'];
        ?>
        <tr>
          <th scope="row"><?php echo $urut++ ?></th>
          <td scope="row"><?php echo $id_buku ?></td>
          <td scope="row"><?php echo $kategori ?></td>
          <td scope="row"><?php echo $nama_buku ?></td>
          <td scope="row"><?php echo $harga ?></td>
          <td scope="row"><?php echo $stok ?></td>
          <td scope="row"><?php echo $penerbit ?></td>
          <td scope="row">
            <a href="index.php?op=edit&id_buku=<?php echo $id_buku ?>"><button type="button" class="btn btn-warning">Edit</button></a>
            <a href="index.php?op=delete&id_buku=<?php echo $id_buku ?>" onclick="return confirm('Apakah Anda Yakin ingin menghapus data tersebut?')"><button type="button" class="btn btn-danger">Delete</button></a>
          
          
          </td>
        </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
  </div>
</div>

   
  </div>
</div>
    </div>
</body>
</html>