<?php

$current_view = $_GET['view'] ?? 'tongquan';
?>

<aside class="sidebar">
    <div class="sidebar-header">
        <h2>Hệ thống Admin</h2>
    </div>
    
    <ul class="sidebar-menu">
        <li class="<?= ($current_view === 'tongquan') ? 'active' : '' ?>">
            <a href="index.php?action=admin_dashboard&view=tongquan">
                <i class="fas fa-chart-line"></i> Tổng quan
            </a>
        </li>

        <li class="<?= ($current_view === 'thuthu') ? 'active' : '' ?>">
            <a href="index.php?action=admin_dashboard&view=thuthu">
                <i class="fas fa-user-tie"></i> Quản lý thủ thư
            </a>
        </li>

        <li class="<?= ($current_view === 'docgia') ? 'active' : '' ?>">
            <a href="index.php?action=admin_dashboard&view=docgia">
                <i class="fas fa-user-tie"></i> Quản lý độc giả
            </a>
        </li>

        <li class="<?= ($current_view === 'phanquyen') ? 'active' : '' ?>">
            <a href="index.php?action=admin_dashboard&view=phanquyen">
                <i class="fas fa-user-lock"></i> Phân quyền
            </a>
        </li>

    <div class="sidebar-footer">
        <a href="/hocphp/pttkpm_QLTV moi/index.php?action=logout" class="logout-btn" 
        onclick="return confirm('Xác nhận đăng xuất khỏi hệ thống quản trị?')">
            <i class="fas fa-sign-out-alt"></i> Đăng xuất
        </a>
    </div>
</aside>