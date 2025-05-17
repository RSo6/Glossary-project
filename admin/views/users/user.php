<?php require_once __DIR__ . '/../parts/header.php'; ?>
<body class="bg-light">
<div class="container py-5">
    <h1 class="mb-4 text text-left">Users</h1>
    <a href="user/create" class="btn btn-success mb-3">+ Add New User</a>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Username</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= htmlspecialchars($user['username']) ?></td>
                <td><?= $user['role'] ?></td>
                <td>
                    <a href="user/edit/<?= $user['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="user/delete/<?= $user['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete user?');">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
