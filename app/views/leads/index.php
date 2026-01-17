<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="flex justify-between items-center mb-4">
    <h2 class="card-title"><?php echo __('leads'); ?></h2>
    <a href="index.php?route=leads/create" class="btn btn-primary"><i data-lucide="plus"></i> <?php echo __('add_new'); ?></a>
</div>

<div class="card mb-4">
    <form action="index.php" method="GET" class="grid grid-cols-4 gap-2">
        <input type="hidden" name="route" value="leads">
        <input type="text" name="search" class="form-control" placeholder="<?php echo __('search'); ?>" value="<?php echo $_GET['search'] ?? ''; ?>">
        
        <select name="source_id" class="form-control">
            <option value=""><?php echo __('source'); ?>: All</option>
            <?php foreach ($sources as $s): ?>
                <option value="<?php echo $s['id']; ?>" <?php echo ($_GET['source_id'] ?? '') == $s['id'] ? 'selected' : ''; ?>>
                    <?php echo I18n::isRtl() ? $s['name_ar'] : $s['name_en']; ?>
                </option>
            <?php endforeach; ?>
        </select>

        <select name="sort" class="form-control">
            <option value="newest" <?php echo ($_GET['sort'] ?? '') == 'newest' ? 'selected' : ''; ?>>Newest</option>
            <option value="oldest" <?php echo ($_GET['sort'] ?? '') == 'oldest' ? 'selected' : ''; ?>>Oldest</option>
            <option value="last_contact" <?php echo ($_GET['sort'] ?? '') == 'last_contact' ? 'selected' : ''; ?>>Last Contact</option>
        </select>

        <button type="submit" class="btn btn-primary"><?php echo __('search'); ?></button>
    </form>
</div>

<div class="card" style="padding: 0; overflow: hidden;">
    <table class="table">
        <thead>
            <tr>
                <th><?php echo __('full_name'); ?></th>
                <th><?php echo __('mobile'); ?></th>
                <th><?php echo __('company'); ?></th>
                <th><?php echo __('source'); ?></th>
                <th><?php echo __('created_at'); ?></th>
                <th><?php echo __('actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($leads as $l): ?>
                <tr>
                    <td class="font-medium"><?php echo $l['full_name']; ?></td>
                    <td><?php echo $l['mobile']; ?></td>
                    <td><?php echo $l['company_or_activity']; ?></td>
                    <td>
                        <span class="badge badge-info">
                            <?php echo I18n::isRtl() ? $l['source_name_ar'] : $l['source_name_en']; ?>
                        </span>
                    </td>
                    <td class="text-sm text-muted"><?php echo date('Y-m-d', strtotime($l['created_at'])); ?></td>
                    <td>
                        <a href="index.php?route=leads/view&id=<?php echo $l['id']; ?>" class="btn btn-icon" style="padding: 0.25rem;"><i data-lucide="eye" style="width: 18px;"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
