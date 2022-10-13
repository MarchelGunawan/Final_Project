        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-book"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Library System</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Query the menu -->
            <?php 
                $queryMenu = "SELECT t1.id, t1.Menu FROM `user_menu` t1 
                JOIN `user_access_menu` t2 ON t1.id = t2.menu_id WHERE t2.role_id = ".$user['role_id']." ORDER BY t2.menu_id ASC";
                $menu = $this->db->query($queryMenu)->result_array();
            ?>

            <!-- Heading -->
            <?php foreach($menu as $m): ?>
                <div class="sidebar-heading">
                    <?= $m['Menu']; ?>
                </div>
                <?php 
                    $menuId = $m['id'];
                    $querysubmenu = "SELECT t3.menu_title, t3.url, t3.icon, t3.is_active FROM `user_menu` t1 
                    JOIN `user_sub_menu` t3 ON t1.id = t3.menu_id WHERE t1.id = ". $menuId ." AND 
                    t3.is_active = 1;";
                    $submenu = $this->db->query($querysubmenu)->result_array();
                ?>

                <?php foreach($submenu as $sb): ?>
                    <?php if($sb['is_active'] == 1): ?>
                <!-- Nav Item - Dashboard -->
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url()?><?= $sb['url']?>">
                            <i class="<?= $sb['icon']?>"></i>
                            <span><?= $sb['menu_title']; ?></span></a>
                    </li>
                    <?php endif; ?>
                <?php endforeach; ?>
                <hr class="sidebar-divider">
            <?php endforeach; ?>
            
            <!-- SUB menu -->
            
            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->