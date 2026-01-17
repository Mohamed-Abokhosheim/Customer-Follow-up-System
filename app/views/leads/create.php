<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="card" style="max-width: 800px; margin: 0 auto;">
    <h2 class="card-title">
        <?php echo __('add_new'); ?>
        <?php echo __('leads'); ?>
    </h2>

    <form action="index.php?route=leads/create" method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo CSRF::generate(); ?>">

        <div class="grid grid-cols-2">
            <div class="form-group">
                <label class="form-label">
                    <?php echo __('full_name'); ?> *
                </label>
                <input type="text" name="full_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">
                    <?php echo __('mobile'); ?> *
                </label>
                <input type="text" name="mobile" class="form-control" required>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">
                <?php echo __('company'); ?> *
            </label>
            <input type="text" name="company_or_activity" class="form-control" required>
        </div>

        <div class="grid grid-cols-2">
            <div class="form-group">
                <label class="form-label">
                    <?php echo __('source'); ?>
                </label>
                <select name="source_id" class="form-control" id="source_select">
                    <?php foreach ($sources as $s): ?>
                        <option value="<?php echo $s['id']; ?>">
                            <?php echo I18n::isRtl() ? $s['name_ar'] : $s['name_en']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">
                <?php echo __('source_notes'); ?>
            </label>
            <textarea name="source_notes" class="form-control" rows="2"></textarea>
        </div>

        <div class="form-group">
            <label class="form-label">
                <?php echo __('services'); ?> (Select at least one)
            </label>
            <div class="grid grid-cols-2 gap-2" style="background: #f3f4f6; padding: 1rem; border-radius: 0.5rem;">
                <?php foreach ($services as $svc): ?>
                    <label class="flex items-center gap-2" style="cursor: pointer;">
                        <input type="checkbox" name="services[]" value="<?php echo $svc['id']; ?>">
                        <span>
                            <?php echo I18n::isRtl() ? $svc['name_ar'] : $svc['name_en']; ?>
                        </span>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="flex gap-2 mt-4">
            <button type="submit" class="btn btn-primary">
                <?php echo __('save'); ?>
            </button>
            <a href="index.php?route=leads" class="btn">
                <?php echo __('cancel'); ?>
            </a>
        </div>
    </form>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>