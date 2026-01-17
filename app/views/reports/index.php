<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="flex justify-between items-center mb-4">
    <h2 class="card-title">
        <?php echo __('reports'); ?>
    </h2>
    <a href="index.php?route=reports&export=csv" class="btn"><i data-lucide="download"></i> Export Pipeline CSV</a>
</div>

<div class="grid grid-cols-2">
    <div class="card">
        <h3 class="card-title">Leads by Status (Pipeline)</h3>
        <table class="table text-sm">
            <thead>
                <tr>
                    <th>Service</th>
                    <th>Status</th>
                    <th>Count</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $lastService = '';
                foreach ($pipelineReport as $row):
                    ?>
                    <tr>
                        <td class="font-bold">
                            <?php echo ($row['service_name'] !== $lastService) ? $row['service_name'] : ''; ?>
                        </td>
                        <td>
                            <?php echo $row['status_name']; ?>
                        </td>
                        <td><span class="badge badge-info">
                                <?php echo $row['lead_count']; ?>
                            </span></td>
                    </tr>
                    <?php
                    $lastService = $row['service_name'];
                endforeach;
                ?>
            </tbody>
        </table>
    </div>

    <div class="card">
        <h3 class="card-title">Source Performance</h3>
        <div style="padding: 1rem;">
            <?php foreach ($sourceStats as $s): ?>
                <div class="mb-4">
                    <div class="flex justify-between text-sm mb-1">
                        <span>
                            <?php echo I18n::isRtl() ? $s['name_ar'] : $s['name_en']; ?>
                        </span>
                        <span class="font-bold">
                            <?php echo $s['count']; ?>
                        </span>
                    </div>
                    <div style="width: 100%; height: 8px; background: #e5e7eb; border-radius: 4px; overflow: hidden;">
                        <div
                            style="width: <?php echo ($s['count'] / max(array_column($sourceStats, 'count')) * 100); ?>%; height: 100%; background: var(--primary-color);">
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>