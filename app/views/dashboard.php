<?php include __DIR__ . '/partials/header.php'; ?>

<div class="grid grid-cols-4 mb-4">
    <div class="card stats-card">
        <div class="stats-icon" style="background: #e0e7ff; color: #4338ca;"><i data-lucide="users"></i></div>
        <div class="stats-info">
            <div class="value"><?php echo $stats['total_leads']; ?></div>
            <div class="label"><?php echo __('total_leads'); ?></div>
        </div>
    </div>
    <div class="card stats-card">
        <div class="stats-icon" style="background: #dcfce7; color: #166534;"><i data-lucide="check-circle"></i></div>
        <div class="stats-info">
            <div class="value"><?php echo $stats['won_leads']; ?></div>
            <div class="label"><?php echo __('won_leads'); ?></div>
        </div>
    </div>
    <div class="card stats-card">
        <div class="stats-icon" style="background: #fee2e2; color: #991b1b;"><i data-lucide="x-circle"></i></div>
        <div class="stats-info">
            <div class="value"><?php echo $stats['lost_leads']; ?></div>
            <div class="label"><?php echo __('lost_leads'); ?></div>
        </div>
    </div>
    <div class="card stats-card">
        <div class="stats-icon" style="background: #fef3c7; color: #92400e;"><i data-lucide="clock"></i></div>
        <div class="stats-info">
            <div class="value"><?php echo $stats['overdue_count']; ?></div>
            <div class="label">Overdue Follow-ups</div>
        </div>
    </div>
</div>

<div class="grid grid-cols-2">
    <div class="card">
        <h3 class="card-title"><?php echo __('leads_by_service'); ?></h3>
        <div style="height: 300px; display: flex; align-items: flex-end; gap: 1rem; padding-top: 2rem;">
            <?php foreach ($stats['leads_by_service'] as $item):
                $height = ($stats['total_leads'] > 0) ? ($item['count'] / $stats['total_leads'] * 100) : 0;
                ?>
                <div style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 0.5rem;">
                    <div
                        style="width: 100%; height: <?php echo $height; ?>%; background: var(--primary-color); border-radius: 4px 4px 0 0; min-height: 5px;">
                    </div>
                    <span class="text-sm"
                        style="text-align: center; height: 40px; overflow: hidden;"><?php echo I18n::isRtl() ? $item['name_ar'] : $item['name_en']; ?></span>
                    <span class="font-bold"><?php echo $item['count']; ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="grid grid-cols-2">
    <div class="card">
        <h3 class="card-title">Leads by Source</h3>
        <div class="flex items-center justify-center" style="height: 300px;">
            <svg viewBox="0 0 100 100" style="width: 200px; transform: rotate(-90deg);">
                <?php 
                $totalS = array_sum(array_column($stats['leads_by_source'], 'count'));
                $offset = 0;
                $colors = ['#4f46e5', '#10b981', '#f59e0b', '#ef4444', '#3b82f6', '#8b5cf6'];
                foreach ($stats['leads_by_source'] as $index => $item): 
                    if ($totalS == 0) break;
                    $percent = ($item['count'] / $totalS) * 100;
                    $stroke = (float)($percent * 2.512); 
                ?>
                    <circle cx="50" cy="50" r="40" fill="transparent" stroke="<?php echo $colors[$index % count($colors)]; ?>" stroke-width="12" stroke-dasharray="<?php echo $stroke; ?> 251.2" stroke-dashoffset="-<?php echo $offset; ?>" style="transition: all 0.5s;"></circle>
                <?php 
                $offset += $stroke;
                endforeach; ?>
                <circle cx="50" cy="50" r="30" fill="white"></circle>
            </svg>
            <div style="margin-left: 2rem;">
                <?php foreach ($stats['leads_by_source'] as $index => $item): ?>
                    <div class="flex items-center gap-2 text-xs mb-1">
                        <span style="width: 10px; height: 10px; background: <?php echo $colors[$index % count($colors)]; ?>; border-radius: 2px;"></span>
                        <span><?php echo I18n::isRtl() ? $item['name_ar'] : $item['name_en']; ?> (<?php echo $item['count']; ?>)</span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="card">
        <h3 class="card-title">Upcoming Follow-ups</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Lead</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($stats['upcoming_followups'] as $f): ?>
                    <tr>
                        <td class="text-sm font-medium"><?php echo $f['lead_name']; ?></td>
                        <td class="text-sm"><?php echo date('M d, H:i', strtotime($f['followup_at'])); ?></td>
                        <td><a href="index.php?route=leads/view&id=<?php echo $f['lead_id']; ?>" class="btn btn-icon"><i data-lucide="external-link"></i></a></td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($stats['upcoming_followups'])): ?>
                    <tr><td colspan="3" style="text-align: center; color: var(--text-muted);">No upcoming tasks</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>