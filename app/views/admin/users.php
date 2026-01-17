<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="flex justify-between items-center mb-4">
    <h2 class="card-title">
        <?php echo __('user_management'); ?>
    </h2>
    <button class="btn btn-primary" onclick="showUserModal()"><i data-lucide="plus"></i>
        <?php echo __('add_new'); ?>
    </button>
</div>

<div class="card" style="padding:0;">
    <table class="table">
        <thead>
            <tr>
                <th>
                    <?php echo __('full_name'); ?>
                </th>
                <th>
                    <?php echo __('username'); ?>
                </th>
                <th>
                    <?php echo __('role'); ?>
                </th>
                <th>
                    <?php echo __('status'); ?>
                </th>
                <th>
                    <?php echo __('actions'); ?>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $u): ?>
                <tr>
                    <td>
                        <div class="font-bold">
                            <?php echo $u['name']; ?>
                        </div>
                        <div class="text-sm text-muted">
                            <?php echo $u['email']; ?>
                        </div>
                    </td>
                    <td>
                        <?php echo $u['username']; ?>
                    </td>
                    <td><span class="badge <?php echo $u['role'] === 'admin' ? 'badge-info' : 'badge-success'; ?>">
                            <?php echo $u['role']; ?>
                        </span></td>
                    <td><span class="badge <?php echo $u['status'] === 'active' ? 'badge-success' : 'badge-danger'; ?>">
                            <?php echo $u['status']; ?>
                        </span></td>
                    <td>
                        <button class="btn btn-icon" onclick='editUser(<?php echo json_encode($u); ?>)'><i
                                data-lucide="edit"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div id="userModal"
    style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:100; display:none; align-items:center; justify-content:center;">
    <div class="card" style="width:400px; margin:0;">
        <h3 id="modalTitle" class="card-title">Add User</h3>
        <form action="index.php?route=admin/users" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo CSRF::generate(); ?>">
            <input type="hidden" name="id" id="user_id">

            <div class="form-group">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" id="user_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Username</label>
                <input type="text" name="username" id="user_username" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" id="user_email" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Password (Leave blank to keep current)</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="grid grid-cols-2">
                <div class="form-group">
                    <label class="form-label">Role</label>
                    <select name="role" id="user_role" class="form-control">
                        <option value="sales">Sales</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" id="user_status" class="form-control">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Language Preference</label>
                <select name="lang_pref" id="user_lang" class="form-control">
                    <option value="en">English</option>
                    <option value="ar">Arabic</option>
                </select>
            </div>
            <div class="flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary w-full">Save</button>
                <button type="button" class="btn w-full" onclick="closeUserModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    const modal = document.getElementById('userModal');
    function showUserModal() {
        document.getElementById('modalTitle').innerText = 'Add User';
        document.getElementById('user_id').value = '';
        document.querySelector('form').reset();
        modal.style.display = 'flex';
    }
    function editUser(user) {
        document.getElementById('modalTitle').innerText = 'Edit User';
        document.getElementById('user_id').value = user.id;
        document.getElementById('user_name').value = user.name;
        document.getElementById('user_username').value = user.username;
        document.getElementById('user_email').value = user.email;
        document.getElementById('user_role').value = user.role;
        document.getElementById('user_status').value = user.status;
        document.getElementById('user_lang').value = user.lang_pref;
        modal.style.display = 'flex';
    }
    function closeUserModal() {
        modal.style.display = 'none';
    }
</script>

<?php include __DIR__ . '/../partials/footer.php'; ?>