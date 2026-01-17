<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="grid grid-cols-2">
    <div class="card">
        <h3 class="card-title">
            <?php echo __('sources'); ?>
        </h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Arabic Name</th>
                    <th>English Name</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sources as $s): ?>
                    <tr>
                        <td>
                            <?php echo $s['name_ar']; ?>
                        </td>
                        <td>
                            <?php echo $s['name_en']; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="card">
        <h3 class="card-title">Add Source</h3>
        <form action="index.php?route=admin/sources" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo CSRF::generate(); ?>">
            <div class="form-group">
                <label class="form-label">Name (Arabic)</label>
                <input type="text" name="name_ar" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Name (English)</label>
                <input type="text" name="name_en" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-full">Save Source</button>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>