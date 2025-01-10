<?php
include "koneksi.php";

$hlm = (isset($_POST['hlm'])) ? $_POST['hlm'] : 1;
$limit = 5; // Jumlah data per halaman
$limit_start = ($hlm - 1) * $limit;
$no = $limit_start + 1;

$sql = "SELECT * FROM users ORDER BY created_at DESC LIMIT $limit_start, $limit";
$hasil = $conn->query($sql);

?>

<table class="table table-hover">
    <thead class="table-dark">
        <tr>
            <th>No</th>
            <th>Username</th>
            <th>Email</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $hasil->fetch_assoc()) { ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row["username"] ?></td>
                <td><?= $row["email"] ?></td>
                <td><?= $row["created_at"] ?></td>
                <td>
                    <a href="#" class="badge rounded-pill text-bg-success" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row["id"] ?>">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <a href="#" class="badge rounded-pill text-bg-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $row["id"] ?>">
                        <i class="bi bi-trash"></i> Delete
                    </a>
                </td>
            </tr>

            <!-- Modal Edit -->
            <div class="modal fade" id="modalEdit<?= $row["id"] ?>" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="post" action="users_action.php">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalEditLabel">Edit User</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" name="username" value="<?= $row["username"] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" value="<?= $row["email"] ?>" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" name="update" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Hapus -->
            <div class="modal fade" id="modalHapus<?= $row["id"] ?>" tabindex="-1" aria-labelledby="modalHapusLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="post" action="users_action.php">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalHapusLabel">Delete User</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete user "<strong><?= $row["username"] ?></strong>"?</p>
                                <input type="hidden" name="id" value="<?= $row["id"] ?>">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php } ?>
    </tbody>
</table>

<!-- Pagination -->
<?php
$sql1 = "SELECT COUNT(*) AS total FROM users";
$hasil1 = $conn->query($sql1);
$total_records = $hasil1->fetch_assoc()['total'];
?>
<p>Total Users: <?= $total_records ?></p>
<nav class="mb-2">
    <ul class="pagination justify-content-end">
        <?php
        $jumlah_page = ceil($total_records / $limit);
        for ($i = 1; $i <= $jumlah_page; $i++) {
            $active = ($hlm == $i) ? "active" : "";
            echo '<li class="page-item ' . $active . '"><a class="page-link halaman" id="' . $i . '">' . $i . '</a></li>';
        }
        ?>
    </ul>
</nav>
