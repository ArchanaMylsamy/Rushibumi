<button class="dashboard-menu-btn btn btn--base d-xl-none d-block"><i class="las la-sliders-h"></i></button>
<div class="dashboard-menu">
    <span class="dashboard-menu__close d-xl-none d-block"><i class="las la-times"></i></span>
    <ul class="dashboard-menu__list">
        <li class="dashboard-menu__item">
            <a href="<?php echo e(route('user.home')); ?>" class="dashboard-menu__link <?php echo e(menuActive('user.home')); ?>">
                <span class="icon"><i class="vti-dashboard"></i></span>
                <span class="text"><?php echo app('translator')->get('Dashboard'); ?></span>
            </a>
        </li>
        <li
            class="dashboard-menu__item  has-dropdown <?php echo e(menuActive(['user.videos', 'user.free.videos', 'user.shorts'])); ?>">
            <a href="javascript:void(0)" class="dashboard-menu__link">
                <span class="icon"><i class="vti-video"></i></span>
                <span class="text"><?php echo app('translator')->get('Videos'); ?></span>
            </a>
            <div
                class="sidebar-submenu <?php echo e(menuActive(['user.videos', 'user.free.videos', 'user.shorts'], 3)); ?>">
                <ul class="sidebar-submenu-list">
                    <li class="sidebar-submenu-list__item <?php echo e(menuActive('user.videos')); ?>">
                        <a href="<?php echo e(route('user.videos')); ?>" class="sidebar-submenu-list__link">
                            <span class="text"> <?php echo app('translator')->get('All Videos'); ?> </span>
                        </a>
                    </li>

                    <li class="sidebar-submenu-list__item <?php echo e(menuActive('user.free.videos')); ?> ">
                        <a href="<?php echo e(route('user.free.videos')); ?>" class="sidebar-submenu-list__link">
                            <span class="text"> <?php echo app('translator')->get('Free Videos'); ?> </span>
                        </a>
                    </li>

                    <li class="sidebar-submenu-list__item <?php echo e(menuActive('user.shorts')); ?>">
                        <a href="<?php echo e(route('user.shorts')); ?>" class="sidebar-submenu-list__link">
                            <span class="text"> <?php echo app('translator')->get('Shorts'); ?> </span>
                        </a>
                    </li>

                </ul>
            </div>
        </li>



        <?php if(auth()->user()->monetization_status == Status::YES): ?>
            <li class="dashboard-menu__item">
                <a href="<?php echo e(route('user.wallet')); ?>"
                    class="dashboard-menu__link <?php echo e(menuActive(['user.wallet', 'user.withdraw'])); ?>">
                    <span class="icon"><i class="vti-wallet"></i></span>
                    <span class="text"><?php echo app('translator')->get('Wallet'); ?></span>
                </a>
            </li>
        <?php endif; ?>


        <li class="dashboard-menu__item">
            <a href="<?php echo e(route('user.monetization')); ?>"
                class="dashboard-menu__link <?php echo e(menuActive('user.monetization')); ?>">
                <span class="icon"><i class="vti-money"></i></span>
                <span class="text"><?php echo app('translator')->get('Monetization'); ?></span>
            </a>
        </li>

        <?php if(gs('is_monthly_subscription')): ?>
            <li class="dashboard-menu__item">
                <a href="<?php echo e(route('user.manage.plan.index')); ?>"
                    class="dashboard-menu__link <?php echo e(menuActive(['user.manage.plan.index', 'user.manage.plan.details'])); ?>">
                    <span class="icon"><i class="las la-calendar-alt"></i></span>
                    <span class="text"><?php echo app('translator')->get('Monthly Plan'); ?></span>
                </a>
            </li>
        <?php endif; ?>

        <li class="dashboard-menu__item">
            <a href="<?php echo e(route('user.earnings')); ?>" class="dashboard-menu__link <?php echo e(menuActive('user.earnings')); ?>">
                <span class="icon"><i class="las la-hand-holding-usd"></i></span>
                <span class="text"><?php echo app('translator')->get('Earnings'); ?></span>
            </a>
        </li>

        <li class="dashboard-menu__item">
            <a href="<?php echo e(route('user.purchased.history')); ?>"
                class="dashboard-menu__link <?php echo e(menuActive('user.purchased.history')); ?>">
                <span class="icon"><i class="las la-file-invoice-dollar"></i></span>
                <span class="text"><?php echo app('translator')->get('Purchased Video '); ?></span>
            </a>
        </li>

        <?php if(gs('is_playlist_sell')): ?>
            <li class="dashboard-menu__item">
                <a href="<?php echo e(route('user.playlist.purchased.history')); ?>"
                    class="dashboard-menu__link <?php echo e(menuActive('user.playlist.purchased.history')); ?>">
                    <span class="icon"><i class="las la-list-ul"></i></span>
                    <span class="text"><?php echo app('translator')->get('Purchased Playlist'); ?></span>
                </a>
            </li>
        <?php endif; ?>

        <?php if(gs('is_monthly_subscription')): ?>
            <li class="dashboard-menu__item">
                <a href="<?php echo e(route('user.plan.purchased')); ?>"
                    class="dashboard-menu__link <?php echo e(menuActive('user.plan.purchased')); ?>">
                    <span class="icon"><i class="las la-receipt"></i></span>
                    <span class="text"><?php echo app('translator')->get('Purchased Plan'); ?></span>
                </a>
            </li>
        <?php endif; ?>

        <?php if(gs('is_playlist_sell') && auth()->user()->salePlaylists()->exists()): ?>
            <li class="dashboard-menu__item">
                <a href="<?php echo e(route('user.playlist.sell.history')); ?>"
                    class="dashboard-menu__link <?php echo e(menuActive('user.playlist.sell.history')); ?>">
                    <span class="icon"><i class="las la-history"></i></span>
                    <span class="text"><?php echo app('translator')->get('Sold Playlist History'); ?></span>
                </a>
            </li>
        <?php endif; ?>

        <?php if(gs('is_monthly_subscription') && auth()->user()->salePlans()->exists()): ?>
            <li class="dashboard-menu__item">
                <a href="<?php echo e(route('user.plan.sell.history')); ?>"
                    class="dashboard-menu__link <?php echo e(menuActive('user.plan.sell.history')); ?>">
                    <span class="icon"><i class="las la-wallet"></i></span>
                    <span class="text"><?php echo app('translator')->get('Sold Plan History'); ?></span>
                </a>
            </li>
        <?php endif; ?>

        <li class="dashboard-menu__item">
            <a href="<?php echo e(route('ticket.index')); ?>"
                class="dashboard-menu__link <?php echo e(menuActive(['ticket.index', 'ticket.view'])); ?>">
                <span class="icon"><i class="las la-ticket-alt"></i></span>
                <span class="text"><?php echo app('translator')->get('Support Ticket'); ?></span>
            </a>
        </li>


        <li class="dashboard-menu__item">
            <a href="<?php echo e(route('user.transactions')); ?>"
                class="dashboard-menu__link <?php echo e(menuActive('user.transactions')); ?>">
                <span class="icon"><i class="las la-exchange-alt"></i></span>
                <span class="text"><?php echo app('translator')->get('Transaction'); ?></span>
            </a>
        </li>
        <li class="dashboard-menu__item">
            <a href="<?php echo e(route('user.notification.all')); ?>"
                class="dashboard-menu__link <?php echo e(menuActive('user.notification.all')); ?>">
                <span class="icon"><i class="las la-bell"></i></span>
                <span class="text"><?php echo app('translator')->get('Notification'); ?></span>
            </a>
        </li>

    </ul>
</div>
<?php /**PATH C:\laragon\www\Rushibumi\Rushibumi\core\resources\views/templates/basic/partials/user_sidebar.blade.php ENDPATH**/ ?>