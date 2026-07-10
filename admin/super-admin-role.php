<?php require_once('super-admin-header.php'); ?>
<?php include('../db-connection.php'); ?>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        th, td { white-space: nowrap; }
        .edit-btn, .delete-btn {
            min-width: 40px;
            width: 40px;
            height: 40px;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .add-btn {
            font-size: 1rem;
            padding: 10px 20px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background-color: black !important;
            color: white !important;
            border: none;
        }
        .add-btn:hover { background-color: #333 !important; color: white !important; }
        .action-btns { display: flex; justify-content: center; gap: 10px; }
        h2 { font-weight: bold; }

        @media (max-width: 768px) {
            .table-responsive { overflow-x: auto; }
            .btn { width: 100%; margin-bottom: 5px; }
            .modal-dialog { max-width: 100%; margin: 1.75rem auto; }
        }
        @media (max-width: 576px) {
            .modal-dialog { width: 90%; margin: 10px auto; }
            .modal-header, .modal-body, .modal-footer { padding: 10px; }
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?= $_SESSION['error']; ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <h2 class="mb-4 text-center">User Management</h2>

        <div class="d-flex justify-content-between flex-wrap">
            <button class="btn btn-success mb-3 add-btn" data-bs-toggle="modal" data-bs-target="#addAdminModal">
                <i class="bi bi-plus-lg"></i> Add Admin
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT id, user_email, user_name, user_role FROM tbl_users WHERE user_role != 'user'";
                    $result = mysqli_query($conn, $sql);
                    $count = 1;
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $count . "</td>";
                            echo "<td>" . htmlspecialchars($row['user_email']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['user_name']) . "</td>";
                            echo "<td id='role-" . $row['id'] . "'>" . htmlspecialchars($row['user_role']) . "</td>";
                            echo "<td class='action-btns'>
                                    <button class='btn btn-primary btn-sm edit-btn' data-id='" . $row['id'] . "' data-role='" . htmlspecialchars($row['user_role']) . "' data-bs-toggle='modal' data-bs-target='#editRoleModal'>
                                        <i class='bi bi-pencil'></i>
                                    </button>
                                    <button class='btn btn-danger btn-sm delete-btn' data-id='" . $row['id'] . "' data-bs-toggle='modal' data-bs-target='#deleteUserModal'>
                                        <i class='bi bi-trash'></i>
                                    </button>
                                  </td>";
                            echo "</tr>";
                            $count++;
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center'>No users found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="addAdminModal" tabindex="-1" aria-labelledby="addAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAdminModalLabel">Add Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="../process/add-admin-process.php" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="full_name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" name="full_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="user_name" class="form-label">Username</label>
                            <input type="text" class="form-control" name="user_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="user_email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="user_email" required>
                        </div>
                        <div class="mb-3">
                            <label for="user_password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="user_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="user_role" class="form-label">Role</label>
                            <select class="form-select" name="user_role" required>
                                <option value="super_admin">Super Admin</option>
                                <option value="admin">Admin</option>
                                <option value="editor">Editor</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="add_admin" class="btn btn-success">Add Admin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRoleModalLabel">Edit User Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="../process/edit-role-process.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit_user_id">
                        <div class="mb-3">
                            <label for="user_role" class="form-label">User Role</label>
                            <select class="form-select" name="user_role" id="user_role" required>
                                <option value="super_admin">Super Admin</option>
                                <option value="admin">Admin</option>
                                <option value="editor">Editor</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="edit_role" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteUserModalLabel">Delete User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this user?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="#" id="deleteLink" class="btn btn-danger">Delete</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $(".edit-btn").on("click", function() {
                let userId = $(this).data("id");
                let userRole = $(this).data("role");
                $("#edit_user_id").val(userId);
                $("#user_role").val(userRole);
            });

            $(".delete-btn").on("click", function() {
                let userId = $(this).data("id");
                $("#deleteLink").attr("href", "../process/delete-admin-process.php?id=" + userId);
                $('#deleteUserModal').modal('show');
            });
        });
    </script>
</body>

<?php require_once('../footer.php'); ?>
