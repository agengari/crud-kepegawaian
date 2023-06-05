<?php 
    include "inc/koneksi.php"; //include koneksi database

    if(isset($_POST['btn_simpan'])){ //jika tombol simpan di klik
        //data diedit atau disimpan
        if($_GET['hal'] == "edit"){
            //data akan diedit
            $edit = mysqli_query($conn, "UPDATE jabatan set
                                        nama_jabatan = '$_POST[tb_namajabatan]',
                                        deskripsi = '$_POST[tb_deskripsi]',
                                        gaji = '$_POST[tb_gaji]'
                                        WHERE id_jabatan = '$_GET[id]'
            ");

            if($edit){
                echo"<script>
                    alert('Edit data Sukses!');
                    document.location='jabatan.php';
                </script>";
            }else{
                echo"<script>
                    alert('Edit data Gagal!');
                    document.location='jabatan.php';
                </script>";
            }
        }else{
            //data akan disimpan baru
            $simpan = mysqli_query($conn, "INSERT INTO jabatan (nama_jabatan, deskripsi, gaji) VALUES (
                '$_POST[tb_namajabatan]',
                '$_POST[tb_deskripsi]',
                '$_POST[tb_gaji]'
            )");

            if($simpan){
                echo"<script>
                    alert('Simpan data Sukses!');
                    document.location='jabatan.php';
                </script>";
            }else{
                echo"<script>
                    alert('Simpan data gagal!');
                    document.location='jabatan.php';
                </script>";
            }
        }
    }

    //jika tombol edit/hapus diklik
    if(isset($_GET['hal'])){
        //edit data
        if($_GET['hal'] == "edit"){
            //tampilkan data yang diedit
            $viewdata = mysqli_query($conn, "SELECT * FROM jabatan WHERE id_jabatan = '$_GET[id]' ");
            $data = mysqli_fetch_array($viewdata);
            if($data){ //jika data ditemukan, dimasukan dalam variabel yang tertampil di form sebagai value
                $var_namajabatan = $data['nama_jabatan'];
                $var_deskripsi = $data['deskripsi'];
                $var_gaji = $data['gaji'];
            }
        }else if($_GET['hal'] == "delete"){
            //persiapan hapus data
            $delete = mysqli_query($conn, "DELETE FROM jabatan WHERE id_jabatan = '$_GET[id]' ");
            if($delete){
                echo "<script>
                    alert('Hapus data Sukses!');
                    document.location='jabatan.php';
                </script>";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Kepegawaian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body class="overflow-x-hidden">
    <section class="min-vh-100" style="background-color: #f3f4f5;">

        <!-- Include Navbar  -->
        <?php include "inc/navbar.php";?>
        <!-- Akhir Include Navbar  -->

        <!-- Judul halaman -->
        <div class="mt-3">
            <h3 class="row justify-content-center">Halaman Jabatan</h3>
        </div>
        <!-- Akhir judul halaman -->

        <!-- Create/Edit data jabatan -->
        <div class="mx-auto row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-3 mb-2">
                <div class="card-header">
                    Tambah/Edit Jenis Jabatan
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="mb-1">
                            <label for="tb_namajabatan" class="form-label">Nama Jabatan</label>
                            <input type="text" name="tb_namajabatan" value="<?=@$var_namajabatan?>" class="form-control">
                        </div>
                        <div class="mb-1">
                            <label for="tb_deskripsi" class="form-label">Deskripsi</label>
                            <input type="text" name="tb_deskripsi" value="<?=@$var_deskripsi?>" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="tb_gaji" class="form-label">Gaji</label>
                            <input type="text" name="tb_gaji" value="<?=@$var_gaji?>" class="form-control">
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary" name="btn_simpan" >Simpan</button>
                            <button type="reset" class="btn btn-danger" name="btn_reset" >Kosongkan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
        <!-- Akhir create/edit data jabatan -->



        <!-- Read data tabel jabatan -->
        <div class="mx-auto row justify-content-center pb-5">
        <div class="col-md-10">
            <div class="card mt-3 mb-2">
                <div class="card-header">
                    Daftar Jabatan
                </div>
                <div class="card-body overflow-x-auto">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Jabatan</th>
                                <th>Deskripsi</th>
                                <th>Gaji</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $no=1;
                                $result = mysqli_query($conn, "SELECT * FROM jabatan");
                                while ($data = mysqli_fetch_array($result)) :
                            ?>
                                <tr>
                                    <td><?=$no++;?></td>
                                    <td><?=$data['nama_jabatan']?></td>
                                    <td><?=$data['deskripsi']?></td>
                                    <td>
                                        <?php
                                            $gaji = number_format($data['gaji'], 0, ',', '.');
                                            echo "Rp " . $gaji . ",-";
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="jabatan.php?hal=edit&id=<?=$data['id_jabatan']?>">
                                            <button type="button" class="btn btn-warning">Edit</button>
                                        </a>
                                        <a href="jabatan.php?hal=delete&id=<?=$data['id_jabatan']?>">
                                            <button type="button" class="btn btn-danger">Delete</button>
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; //penutup perulangan while ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
        <!-- Akhir read data tabel jabatan -->
    
    </section>
    


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>