<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="flex justify-between items-center mb-4">
    <h2 class="card-title"><?php echo __('my_followups'); ?></h2>
    <div class="lang-switch">
        <a href="index.php?route=followups&status=pending" class="lang-btn <?php echo ($_GET['status'] ?? 'pending') == 'pending' ? 'active' : ''; ?>">Pending</a>
        <a href="index.php?route=followups&status=done" class="lang-btn <?php echo ($_GET['status'] ?? '') == 'done' ? 'active' : ''; ?>">Completed</a>
    </div>
</div>

<div class="card" style="padding: 0;">
    <table class="table">
        <thead>
            <tr>
                <th>Lead</th>
                <th>Due Date</th>
                <th>Notes</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($followups as $f): 
                $isOverdue = !$f['is_done'] && strtotime($f['followup_at']) < time();
            ?>
                <tr>
                    <td>
                        <div class="font-bold"><?php echo $f['lead_name']; ?></div>
                        <div class="text-sm text-muted"><?php echo $f['lead_mobile']; ?></div>
                    </td>
                    <td>
                        <span class="<?php echo $isOverdue ? 'text-danger font-bold' : ''; ?>">
                            <?php echo date('Y-m-d H:i', strtotime($f['followup_at'])); ?>
                        </span>
                        <?php if ($isOverdue): ?> <span class="badge badge-danger">Overdue</span> <?php endif; ?>
                    </td>
                    <td class="text-sm"><?php echo nl2br($f['notes']); ?></td>
                    <td>
                        <div class="flex gap-2">
                            <a href="index.php?route=leads/view&id=<?php echo $f['lead_id']; ?>" class="btn btn-icon" title="View Lead"><i data-lucide="eye"></i></a>
                            <?php if (!$f['is_done']): ?>
                                <form action="index.php?route=followups" method="POST" style="display:inline;">
                                    <input type="hidden" name="csrf_token" value="<?php echo CSRF::generate(); ?>">
                                    <input type="hidden" name="action" value="mark_done">
                                    <input type="hidden" name="id" value="<?php echo $f['id']; ?>">
                                    <button type="submit" class="btn btn-primary btn-sm"><i data-lucide="check"></i> Done</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($followups)): ?>
                <tr><td colspan="4" style="text-align: center; padding: 2rem; color: var(--text-muted);">No follow-ups found</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
