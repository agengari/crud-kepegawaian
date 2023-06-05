<?php 
    include "inc/koneksi.php"; //include koneksi database

    if(isset($_POST['btn_simpan'])){ //jika tombol simpan di klik
        //data diedit atau disimpan
        if($_GET['hal'] == "edit"){
            //data akan diedit
            $edit = mysqli_query($conn, "UPDATE kontrak set
                                        nama_kontrak = '$_POST[tb_namakontrak]',
                                        tgl_mulai = '$_POST[tb_tglmulai]',
                                        durasi = '$_POST[tb_durasi]'
                                        WHERE id_kontrak = '$_GET[id]'
            ");

            if($edit){
                echo"<script>
                    alert('Edit data Sukses!');
                    document.location='kontrak.php';
                </script>";
            }else{
                echo"<script>
                    alert('Edit data Gagal!');
                    document.location='kontrak.php';
                </script>";
            }
        }else{
            //data akan disimpan baru
            $simpan = mysqli_query($conn, "INSERT INTO kontrak (nama_kontrak, tgl_mulai, durasi) VALUES (
                '$_POST[tb_namakontrak]',
                '$_POST[tb_tglmulai]',
                '$_POST[tb_durasi]'
            )");

            if($simpan){
                echo"<script>
                    alert('Simpan data Sukses!');
                    document.location='kontrak.php';
                </script>";
            }else{
                echo"<script>
                    alert('Simpan data gagal!');
                    document.location='kontrak.php';
                </script>";
            }
        }
    }

    //jika tombol edit/hapus diklik
    if(isset($_GET['hal'])){
        //edit data
        if($_GET['hal'] == "edit"){
            //tampilkan data yang diedit
            $viewdata = mysqli_query($conn, "SELECT * FROM kontrak WHERE id_kontrak = '$_GET[id]' ");
            $data = mysqli_fetch_array($viewdata);
            if($data){ //jika data ditemukan, dimasukan dalam variabel yang tertampil di form sebagai value
                $var_namakontrak = $data['nama_kontrak'];
                $var_tglmulai = $data['tgl_mulai'];
                $var_durasi = $data['durasi'];
            }
        }else if($_GET['hal'] == "delete"){
            //persiapan hapus data
            $delete = mysqli_query($conn, "DELETE FROM kontrak WHERE id_kontrak = '$_GET[id]' ");
            if($delete){
                echo "<script>
                    alert('Hapus data Sukses!');
                    document.location='kontrak.php';
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
            <h3 class="row justify-content-center">Halaman Kontrak</h3>
        </div>
        <!-- Akhir judul halaman -->

        <!-- Create/Edit data kontrak -->
        <div class="mx-auto row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-3 mb-2">
                <div class="card-header">
                    Tambah/Edit Daftar Kontrak
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="mb-1">
                            <label for="tb_namakontrak" class="form-label">Nama Kontrak</label>
                            <input type="text" name="tb_namakontrak" value="<?=@$var_namakontrak?>" class="form-control">
                        </div>
                        <div class="mb-1">
                            <label for="tb_tglmulai" class="form-label">Tanggal Mulai</label>
                            <input type="text" name="tb_tglmulai" value="<?=@$var_tglmulai?>" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="tb_durasi" class="form-label">Durasi</label>
                            <input type="text" name="tb_durasi" value="<?=@$var_durasi?>" class="form-control">
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
        <!-- Akhir create/edit data kontrak -->



        <!-- Read data tabel kontrak -->
        <div class="mx-auto row justify-content-center pb-5">
        <div class="col-md-10">
            <div class="card mt-3 mb-2">
                <div class="card-header">
                    Daftar Kontrak
                </div>
                <div class="card-body overflow-x-auto">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Kontrak</th>
                                <th>Tanggal Mulai</th>
                                <th>Durasi</th>
                                <th>Tanggal Berakhir</th>
                                <th>Sisa Waktu</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $no=1;
                                $result = mysqli_query($conn, "SELECT * FROM kontrak");
                                while ($data = mysqli_fetch_array($result)) :
                            ?>
                                <tr>
                                    <td><?=$no++;?></td>
                                    <td><?=$data['nama_kontrak']?></td>
                                    <td><?=$data['tgl_mulai']?></td>
                                    <td><?=$data['durasi']?></td>
                                    <td>
                                        <?php
                                            // Mengambil data
                                            $tgl_mulai = $data['tgl_mulai'];
                                            $durasi = $data['durasi'];

                                            // Menghitung tanggal berakhir kontrak
                                            $tgl_berakhir = date('Y-m-d', strtotime($tgl_mulai . ' + ' . $durasi . ' days'));

                                            echo $tgl_berakhir;
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            // Mengambil data
                                            $tgl_mulai = $data['tgl_mulai'];
                                            $durasi = $data['durasi'];

                                            // Menghitung tanggal berakhir kontrak
                                            $tgl_berakhir = date('Y-m-d', strtotime($tgl_mulai . ' + ' . $durasi . ' days'));

                                            // Menghitung sisa hari kontrak
                                            $tgl_sekarang = date('Y-m-d');
                                            $sisa_hari = floor((strtotime($tgl_berakhir) - strtotime($tgl_sekarang)) / (60 * 60 * 24));

                                            echo $sisa_hari . " hari";
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="kontrak.php?hal=edit&id=<?=$data['id_kontrak']?>">
                                            <button type="button" class="btn btn-warning">Edit</button>
                                        </a>
                                        <a href="kontrak.php?hal=delete&id=<?=$data['id_kontrak']?>">
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
        <!-- Akhir read data tabel kontrak -->
    
    </section>
    


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>