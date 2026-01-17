<?php 
include __DIR__ . '/../partials/header.php'; 
$serviceModel = new ServiceModel();
?>

<div class="grid grid-cols-2">
    <div class="card">
        <div class="flex justify-between items-start mb-4">
            <h2 class="card-title"><?php echo $lead['full_name']; ?></h2>
            <span class="badge badge-info"><?php echo I18n::isRtl() ? $lead['source_name_ar'] : $lead['source_name_en']; ?></span>
        </div>
        
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <div class="text-muted"><?php echo __('mobile'); ?></div>
                <div class="font-bold"><?php echo $lead['mobile']; ?></div>
            </div>
            <div>
                <div class="text-muted"><?php echo __('company'); ?></div>
                <div class="font-bold"><?php echo $lead['company_or_activity']; ?></div>
            </div>
            <div>
                <div class="text-muted"><?php echo __('created_at'); ?></div>
                <div><?php echo date('Y-m-d H:i', strtotime($lead['created_at'])); ?></div>
            </div>
            <div>
                <div class="text-muted">Managed By</div>
                <div><?php echo $lead['creator_name']; ?></div>
            </div>
        </div>

        <?php if ($lead['referral_referrer_name']): ?>
            <div class="mt-4 p-2 bg-yellow-50 border-l-4 border-yellow-400">
                <strong>Referrer:</strong> <?php echo $lead['referral_referrer_name']; ?>
            </div>
        <?php endif; ?>

        <?php if ($lead['source_notes']): ?>
            <div class="mt-4">
                <div class="text-muted">Source Notes</div>
                <p class="text-sm"><?php echo nl2br($lead['source_notes']); ?></p>
            </div>
        <?php endif; ?>
    </div>

    <div class="card">
        <h3 class="card-title"><?php echo __('services'); ?> & <?php echo __('status'); ?></h3>
        <?php foreach ($lead_services as $ls): ?>
            <div class="mb-4 p-3 border rounded-lg">
                <div class="flex justify-between items-center mb-2">
                    <span class="font-bold"><?php echo I18n::isRtl() ? $ls['name_ar'] : $ls['name_en']; ?></span>
                    <?php 
                        $statusClass = 'badge-info';
                        if ($ls['status_type'] === 'won') $statusClass = 'badge-success';
                        if ($ls['status_type'] === 'lost') $statusClass = 'badge-danger';
                    ?>
                    <span class="badge <?php echo $statusClass; ?>">
                        <?php echo I18n::isRtl() ? $ls['status_ar'] : $ls['status_en']; ?>
                    </span>
                </div>
                
                <form action="index.php?route=leads/view&id=<?php echo $lead['id']; ?>" method="POST" class="flex gap-2">
                    <input type="hidden" name="csrf_token" value="<?php echo CSRF::generate(); ?>">
                    <input type="hidden" name="action" value="update_status">
                    <input type="hidden" name="service_id" value="<?php echo $ls['service_id']; ?>">
                    <select name="status_id" class="form-control text-sm">
                        <?php 
                        $statuses = $serviceModel->getStatuses($ls['service_id']);
                        foreach ($statuses as $st): ?>
                            <option value="<?php echo $st['id']; ?>" <?php echo $ls['status_id'] == $st['id'] ? 'selected' : ''; ?>>
                                <?php echo I18n::isRtl() ? $st['name_ar'] : $st['name_en']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn btn-primary btn-sm"><?php echo __('save'); ?></button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="grid grid-cols-2">
    <div class="card">
        <h3 class="card-title">Schedule Follow-up</h3>
        <form action="index.php?route=leads/view&id=<?php echo $lead['id']; ?>" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo CSRF::generate(); ?>">
            <input type="hidden" name="action" value="add_followup">
            
            <div class="grid grid-cols-2 gap-2">
                <div class="form-group">
                    <label class="form-label">Date</label>
                    <input type="date" name="followup_date" class="form-control" required value="<?php echo date('Y-m-d'); ?>">
                </div>
                <div class="form-group">
                    <label class="form-label">Time</label>
                    <input type="time" name="followup_time" class="form-control" required value="<?php echo date('H:i', strtotime('+1 hour')); ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Assign To</label>
                <select name="assigned_to" class="form-control">
                    <?php foreach ($users as $u): ?>
                        <option value="<?php echo $u['id']; ?>" <?php echo Auth::user()['id'] == $u['id'] ? 'selected' : ''; ?>>
                            <?php echo $u['name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Notes</label>
                <textarea name="notes" class="form-control" rows="2"></textarea>
            </div>

            <button type="submit" class="btn btn-primary w-full"><?php echo __('save'); ?></button>
        </form>
    </div>

    <div class="card">
        <h3 class="card-title">Recent History</h3>
        <div class="timeline text-sm">
            <div style="border-left: 2px solid var(--border-color); padding-left: 1rem; position: relative;">
                <div style="position: absolute; left: -7px; top: 0; width: 12px; height: 12px; border-radius: 50%; background: var(--primary-color);"></div>
                <div class="text-muted"><?php echo date('Y-m-d H:i', strtotime($lead['created_at'])); ?></div>
                <div class="font-bold">Lead Created</div>
                <div class="text-sm">Added by <?php echo $lead['creator_name']; ?></div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
