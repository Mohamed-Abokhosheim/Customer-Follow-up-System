<!DOCTYPE html>
<html lang="<?php echo I18n::getLang(); ?>" dir="<?php echo I18n::isRtl() ? 'rtl' : 'ltr'; ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CFSYS CRM -
        <?php echo $title ?? __('dashboard'); ?>
    </title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@400;500;600;700&family=Cairo:wght@400;600;700&display=swap"
        rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <div class="layout">
        <?php include __DIR__ . '/sidebar.php'; ?>
        <div class="main-wrapper">
            <header class="topbar">
                <div class="flex items-center gap-2">
                    <button id="menu-toggle" class="btn btn-icon d-md-none"><i data-lucide="menu"></i></button>
                    <h1 class="text-sm font-semibold">
                        <?php echo $title ?? __('dashboard'); ?>
                    </h1>
                </div>
                <div class="flex items-center gap-4">
                    <div class="lang-switch">
                        <a href="index.php?route=set_lang&lang=en"
                            class="lang-btn <?php echo I18n::getLang() === 'en' ? 'active' : ''; ?>">EN</a>
                        <a href="index.php?route=set_lang&lang=ar"
                            class="lang-btn <?php echo I18n::getLang() === 'ar' ? 'active' : ''; ?>">AR</a>
                    </div>
                    <?php
                    require_once __DIR__ . '/../../models/FollowupModel.php';
                    $fModel = new FollowupModel();
                    $overdueCount = $fModel->countOverdue(Auth::user()['id']);
                    ?>
                    <div class="notification-bell" style="position: relative; cursor: pointer;"
                        onclick="location.href='index.php?route=followups'">
                        <i data-lucide="bell"></i>
                        <?php if ($overdueCount > 0): ?>
                            <span
                                style="position: absolute; top: -5px; right: -5px; background: var(--danger); color: white; border-radius: 50%; width: 18px; height: 18px; font-size: 10px; display: flex; align-items: center; justify-content: center;">
                                <?php echo $overdueCount; ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="user-menu flex items-center gap-2">
                        <span class="text-sm">
                            <?php echo Auth::user()['name']; ?>
                        </span>
                        <a href="index.php?route=logout" class="btn btn-icon" title="<?php echo __('logout'); ?>"><i
                                data-lucide="log-out"></i></a>
                    </div>
                </div>
            </header>
            <main class="content">
                <?php if ($flash = Flash::get()): ?>
                    <div class="badge badge-<?php echo $flash['type']; ?> mb-4 w-full"
                        style="padding: 1rem; border-radius: 0.5rem;">
                        <?php echo $flash['message']; ?>
                    </div>
                <?php endif; ?>