<?php $act = $_GET['action'] ?? 'khach'; ?>
<div class="sidebar">
    <div class="logo">THƯ VIỆN ABC</div>
    <ul>
        <li>
            <a href="index.php?action=khachGUI" class="<?= ($act == 'khach' || $act == 'chi_tiet') ? 'active' : '' ?>">
                <i class="fas fa-search"></i> Tra cứu sách
            </a>
        </li>
        
        <li>
            <a href="index.php?action=dangKy" class="<?= ($act == 'dangKy') ? 'active' : '' ?>">
                <i class="fas fa-user-plus"></i> Đăng ký
            </a>
        </li>
        <li>
            <a href="index.php?action=login" class="<?= ($act == 'login') ? 'active' : '' ?>">
                <i class="fas fa-sign-in-alt"></i> Đăng nhập
            </a>
        </li>
    </ul>
</div>