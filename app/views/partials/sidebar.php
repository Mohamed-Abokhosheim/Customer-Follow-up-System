<?php
$currentRoute = $_GET['route'] ?? 'dashboard';
?>
<aside class="sidebar">
    <div class="sidebar-header">
        <i data-lucide="layers"></i>
        <span>CFSYS</span>
    </div>
    <nav class="sidebar-nav">
        <a href="index.php?route=dashboard"
            class="nav-item <?php echo $currentRoute === 'dashboard' ? 'active' : ''; ?>">
            <i data-lucide="layout-dashboard"></i>
            <span>
                <?php echo __('dashboard'); ?>
            </span>
        </a>
        <a href="index.php?route=leads"
            class="nav-item <?php echo strpos($currentRoute, 'leads') !== false ? 'active' : ''; ?>">
            <i data-lucide="users"></i>
            <span>
                <?php echo __('leads'); ?>
            </span>
        </a>
        <a href="index.php?route=followups"
            class="nav-item <?php echo $currentRoute === 'followups' ? 'active' : ''; ?>">
            <i data-lucide="calendar"></i>
            <span>
                <?php echo __('followups'); ?>
            </span>
        </a>
        <a href="index.php?route=reports" class="nav-item <?php echo $currentRoute === 'reports' ? 'active' : ''; ?>">
            <i data-lucide="bar-chart-2"></i>
            <span>
                <?php echo __('reports'); ?>
            </span>
        </a>

        <?php if (Auth::user()['role'] === 'admin'): ?>
            <div
                style="padding: 1rem 1rem 0.5rem; font-size: 0.75rem; color: var(--sidebar-text); text-transform: uppercase;">
                <?php echo __('admin'); ?>
            </div>
            <a href="index.php?route=admin/users"
                class="nav-item <?php echo $currentRoute === 'admin/users' ? 'active' : ''; ?>">
                <i data-lucide="user-cog"></i>
                <span>
                    <?php echo __('users'); ?>
                </span>
            </a>
            <a href="index.php?route=admin/services"
                class="nav-item <?php echo $currentRoute === 'admin/services' ? 'active' : ''; ?>">
                <i data-lucide="package"></i>
                <span>
                    <?php echo __('services'); ?>
                </span>
            </a>
            <a href="index.php?route=admin/sources"
                class="nav-item <?php echo $currentRoute === 'admin/sources' ? 'active' : ''; ?>">
                <i data-lucide="share-2"></i>
                <span>
                    <?php echo __('sources'); ?>
                </span>
            </a>
        <?php endif; ?>
    </nav>
    <div style="padding: 1rem; border-top: 1px solid var(--sidebar-hover);">
        <a href="index.php?route=logout" class="nav-item">
            <i data-lucide="log-out"></i>
            <span>
                <?php echo __('logout'); ?>
            </span>
        </a>
    </div>
</aside>