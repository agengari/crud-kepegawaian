<?php 
    include "inc/koneksi.php"; //include koneksi database

    if(isset($_POST['btn_simpan'])){ //jika tombol simpan di klik
        //data diedit atau disimpan
        if($_GET['hal'] == "edit"){
            //data akan diedit
            $edit = mysqli_query($conn, "UPDATE pegawai set
                                        nama = '$_POST[tb_nama]',
                                        alamat = '$_POST[tb_alamat]',
                                        no_telpon = '$_POST[tb_notelpon]',
                                        id_jabatan = '$_POST[select_jabatan]',
                                        id_kontrak = '$_POST[select_kontrak]'
                                        WHERE id_pegawai = '$_GET[id]'
            ");

            if($edit){
                echo"<script>
                    alert('Edit data Sukses!');
                    document.location='index.php';
                </script>";
            }else{
                echo"<script>
                    alert('Edit data Gagal!');
                    document.location='index.php';
                </script>";
            }
        }else{
            //data akan disimpan baru
            $simpan = mysqli_query($conn, "INSERT INTO pegawai (nama, alamat, no_telpon, id_jabatan, id_kontrak) VALUES (
                '$_POST[tb_nama]',
                '$_POST[tb_alamat]',
                '$_POST[tb_notelpon]',
                '$_POST[select_jabatan]',
                '$_POST[select_kontrak]'
            )");

            if($simpan){
                echo"<script>
                    alert('Simpan data Sukses!');
                    document.location='index.php';
                </script>";
            }else{
                echo"<script>
                    alert('Simpan data gagal!');
                    document.location='index.php';
                </script>";
            }
        }
    }

    //jika tombol edit/hapus diklik
    if(isset($_GET['hal'])){
        //edit data
        if($_GET['hal'] == "edit"){
            //tampilkan data yang diedit
            $viewdata = mysqli_query($conn, "SELECT * FROM pegawai WHERE id_pegawai = '$_GET[id]' ");
            $data = mysqli_fetch_array($viewdata);
            if($data){ //jika data ditemukan, dimasukan dalam variabel yang tertampil di form sebagai value
                $var_nama = $data['nama'];
                $var_alamat = $data['alamat'];
                $var_notelpon = $data['no_telpon'];
                $var_jabatan = $data['id_jabatan'];
                $var_kontrak = $data['id_kontrak'];
            }
        }else if($_GET['hal'] == "delete"){
            //persiapan hapus data
            $delete = mysqli_query($conn, "DELETE FROM pegawai WHERE id_pegawai = '$_GET[id]' ");
            if($delete){
                echo "<script>
                    alert('Hapus data Sukses!');
                    document.location='index.php';
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
            <h3 class="row justify-content-center">Halaman Pegawai</h3>
        </div>
        <!-- Akhir judul halaman -->

        <!-- Create/Edit data pegawai -->
        <div class="mx-auto row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-3 mb-2">
                <div class="card-header">
                    Tambah/Edit Daftar Pegawai
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="mb-1">
                            <label for="tb_nama" class="form-label">Nama</label>
                            <input type="text" name="tb_nama" value="<?=@$var_nama?>" class="form-control">
                        </div>
                        <div class="mb-1">
                            <label for="tb_alamat" class="form-label">Alamat</label>
                            <input type="text" name="tb_alamat" value="<?=@$var_alamat?>" class="form-control">
                        </div>
                        <div class="mb-1">
                            <label for="tb_notelpon" class="form-label">No Telpon</label>
                            <input type="text" name="tb_notelpon" value="<?=@$var_notelpon?>" class="form-control">
                        </div>
                        <div class="mb-1">
                            <label for="select_jabatan" class="form-label">Pilih Jabatan</label>
                            <select name="select_jabatan" value="<?=@$var_jabatan?>" class="form-control">
                                <?php 
                                    $query = "SELECT id_jabatan, nama_jabatan FROM jabatan";
                                    $hasil = mysqli_query($conn, $query);

                                    if (isset($_GET['hal']) && $_GET['hal'] === 'edit' && isset($_GET['id'])) {
                                        $id_pegawai = $_GET['id'];
                                        $query_pegawai = "SELECT id_jabatan FROM pegawai WHERE id_pegawai = $id_pegawai";
                                        $result_pegawai = mysqli_query($conn, $query_pegawai);
                                        $data_pegawai = mysqli_fetch_assoc($result_pegawai);
                                        $selected_jabatan = $data_pegawai['id_jabatan'];
                                
                                        while ($data = mysqli_fetch_assoc($hasil)) {
                                            if ($data['id_jabatan'] == $selected_jabatan) {
                                                echo "<option value='" . $data['id_jabatan'] . "' selected>" . $data['nama_jabatan'] . "</option>";
                                            } else {
                                                echo "<option value='" . $data['id_jabatan'] . "'>" . $data['nama_jabatan'] . "</option>";
                                            }
                                        }
                                    } else {
                                        echo "<option value='' disabled selected>- Pilih Jabatan -</option>";
                                        while ($data = mysqli_fetch_assoc($hasil)) {
                                            echo "<option value='" . $data['id_jabatan'] . "'>" . $data['nama_jabatan'] . "</option>";
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="select_kontrak" class="form-label">Paket Kontrak</label>
                            <select name="select_kontrak" value="<?=@$var_kontrak?>" class="form-control">
                                <?php 
                                    $query = "SELECT * FROM kontrak";
                                    $hasil = mysqli_query($conn, $query);

                                    if (isset($_GET['hal']) && $_GET['hal'] === 'edit' && isset($_GET['id'])) {
                                        $id_pegawai = $_GET['id'];
                                        $query_pegawai = "SELECT id_kontrak FROM pegawai WHERE id_pegawai = $id_pegawai";
                                        $result_pegawai = mysqli_query($conn, $query_pegawai);
                                        $data_pegawai = mysqli_fetch_assoc($result_pegawai);
                                        $selected_kontrak = $data_pegawai['id_kontrak'];
                                
                                        while ($data = mysqli_fetch_assoc($hasil)) {
                                            if ($data['id_kontrak'] == $selected_kontrak) {
                                                echo "<option value='" . $data['id_kontrak'] . "' selected>" . $data['tgl_mulai'] . "</option>";
                                            } else {
                                                echo "<option value='" . $data['id_kontrak'] . "'>" . $data['tgl_mulai'] . "</option>";
                                            }
                                        }
                                    } else {
                                        echo "<option value='' disabled selected>- Pilih Paket Kontrak -</option>";
                                        while ($data = mysqli_fetch_assoc($hasil)) {
                                            echo "<option value='" . $data['id_kontrak'] . "'>" . $data['nama_kontrak'] . "</option>";
                                        }
                                    }
                                ?>
                            </select>
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
        <!-- Akhir create/edit data pegawai -->



        <!-- Read data tabel pegawai -->
        <div class="mx-auto row justify-content-center pb-5">
        <div class="col-md-10">
            <div class="card mt-3 mb-2">
                <div class="card-header">
                    Daftar Pegawai
                </div>
                <div class="card-body overflow-x-auto">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>No Telpon</th>
                                <th>Jabatan</th>
                                <th>Sisa Kontrak</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $no=1;
                                $result = mysqli_query($conn, "SELECT * FROM pegawai
                                INNER JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan
                                INNER JOIN kontrak ON pegawai.id_kontrak = kontrak.id_kontrak");
                                while ($data = mysqli_fetch_array($result)) :
                            ?>
                                <tr>
                                    <td><?=$no++;?></td>
                                    <td><?=$data['nama']?></td>
                                    <td><?=$data['alamat']?></td>
                                    <td><?=$data['no_telpon']?></td>
                                    <td><?=$data['nama_jabatan']?></td>
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
                                        <a href="index.php?hal=edit&id=<?=$data['id_pegawai']?>">
                                            <button type="button" class="btn btn-warning">Edit</button>
                                        </a>
                                        <a href="index.php?hal=delete&id=<?=$data['id_pegawai']?>">
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
        <!-- Akhir read data tabel pegawai -->
    
    </section>
    


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>