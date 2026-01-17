<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="grid grid-cols-2">
    <div class="card">
        <h3 class="card-title"><?php echo __('services'); ?></h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Arabic Name</th>
                    <th>English Name</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($services as $s): ?>
                    <tr>
                        <td><?php echo $s['name_ar']; ?></td>
                        <td><?php echo $s['name_en']; ?></td>
                        <td><span class="badge <?php echo $s['active'] ? 'badge-success' : 'badge-danger'; ?>"><?php echo $s['active'] ? 'Active' : 'Inactive'; ?></span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="card">
        <h3 class="card-title">Add Service</h3>
        <form action="index.php?route=admin/services" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo CSRF::generate(); ?>">
            <div class="form-group">
                <label class="form-label">Name (Arabic)</label>
                <input type="text" name="name_ar" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Name (English)</label>
                <input type="text" name="name_en" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-full">Save Service</button>
        </form>
        <p class="text-sm text-muted mt-4">* Pipelines for new services can be configured in the database v1. UI for pipeline management planned for v2.</p>
    </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
