<div class="container">

<!-- Button trigger modal -->
<button type="button" class="btn btn-secondary mb-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
    <i class="bi bi-plus-lg"></i> Tambah User
</button>

<div class="row">
    <div class="table-responsive" id="users_data">
        
    </div>

    <!-- Awal Modal Tambah-->
    <div class="modal fade" id="modalTambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="formGroupExampleInput" class="form-label">Nama</label>
                            <input type="text" class="form-control" name="nama" placeholder="Tuliskan Nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="formGroupExampleInput2" class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" placeholder="Tuliskan Username" required>
                        </div>
                        <div class="mb-3">
                            <label for="formGroupExampleInput3" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Tuliskan Email" required>
                        </div>
                        <div class="mb-3">
                            <label for="formGroupExampleInput4" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Tuliskan Password" required>
                        </div>
                        <div class="mb-3">
                            <label for="formGroupExampleInput5" class="form-label">Role</label>
                            <select class="form-select" name="role">
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" value="simpan" name="simpan" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Akhir Modal Tambah-->

    <!-- Modal Profil -->
    <div class="modal fade" id="modalProfil" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="profilLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="profilLabel">Profil User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="profil_detail">
                    <!-- Detail profil akan dimuat melalui Ajax -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Akhir Modal Profil -->
</div>

<script>
$(document).ready(function(){
    load_data();
    function load_data(hlm){
        $.ajax({
            url : "users_data.php",
            method : "POST",
            data : { hlm: hlm },
            success : function(data){
                $('#users_data').html(data);
            }
        });
    }

    $(document).on('click', '.halaman', function(){
        var hlm = $(this).attr("id");
        load_data(hlm);
    });

    $(document).on('click', '.view_profil', function(){
        var id = $(this).data("id");
        $.ajax({
            url: "user_profil.php",
            method: "POST",
            data: { id: id },
            success: function(data){
                $('#profil_detail').html(data);
                $('#modalProfil').modal('show');
            }
        });
    });
});
</script>

<?php
include "koneksi.php";

// Jika tombol simpan diklik
if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];

    $stmt = $conn->prepare("INSERT INTO users (nama, username, email, password, role) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nama, $username, $email, $password, $role);
    $simpan = $stmt->execute();

    if ($simpan) {
        echo "<script>
            alert('Simpan data sukses');
            document.location='admin.php?page=users';
        </script>";
    } else {
        echo "<script>
            alert('Simpan data gagal');
            document.location='admin.php?page=users';
        </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
