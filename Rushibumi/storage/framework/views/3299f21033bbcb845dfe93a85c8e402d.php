<div class="sidebar-menu">
    <div class="sidebar-menu__inner">
        <!-- Sidebar Logo -->
        <div class="sidebar-logo d-none d-xxl-block">
            <a href="<?php echo e(route('home')); ?>" class="side-sm-logo">
                <span class="sidebar-logo-r">R</span>
            </a>
            <a href="<?php echo e(route('home')); ?>" class="sidebar-logo__link dark"><img src="<?php echo e(siteLogo()); ?>"
                    alt="<?php echo app('translator')->get('logo'); ?>"></a>
            <a href="<?php echo e(route('home')); ?>" class="sidebar-logo__link light"><img src="<?php echo e(siteLogo('dark')); ?>"
                    alt="<?php echo app('translator')->get('logo'); ?>"></a>
        </div>

        <ul class="sidebar-menu-list">
            <li class="sidebar-menu-list__item <?php echo e(menuActive('home')); ?>">
                <a href="<?php echo e(route('home')); ?>" class="sidebar-menu-list__link">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-house">
                            <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8" />
                            <path
                                d="M3 10a2 2 0 0 1 .709-1.528l7-5.999a2 2 0 0 1 2.582 0l7 5.999A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                        </svg>
                    </span>
                    <span class="text"><?php echo app('translator')->get('Home'); ?></span>
                </a>
            </li>
            <li class="sidebar-menu-list__item">
                <a href="<?php echo e(route('shorts.list')); ?>" class="sidebar-menu-list__link <?php echo e(menuActive('shorts.list')); ?>">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 20 20"
                            fill="none">
                            <g id="Shorts">
                                <g id="Group 68">
                                    <path id="Subtract"
                                        d="M4.83441 6.10509L5.08441 6.53811L4.83441 6.10509ZM11.1872 2.43733L10.9372 2.00432L11.1872 2.43733ZM15.6407 3.63066L16.0737 3.38066L15.6407 3.63066ZM14.4474 8.08422L14.1974 7.65121L14.4474 8.08422ZM14.2037 8.22488L13.9537 7.79187C13.7979 7.88186 13.7024 8.04867 13.7038 8.22863C13.7051 8.4086 13.8031 8.57396 13.9603 8.6616L14.2037 8.22488ZM14.2436 13.8949L14.4936 14.3279L14.2436 13.8949ZM7.89089 17.5627L7.64089 17.1297L7.89089 17.5627ZM3.43733 16.3693L3.00432 16.6193L3.43733 16.3693ZM4.63066 11.9158L4.38066 11.4828L4.63066 11.9158ZM4.8743 11.7751L5.1243 12.2081C5.28016 12.1181 5.37564 11.9513 5.37429 11.7714C5.37294 11.5914 5.27497 11.426 5.11778 11.3384L4.8743 11.7751ZM4.58441 5.67208C2.78592 6.71044 2.16971 9.01016 3.20807 10.8087L4.07409 10.3087C3.31188 8.98845 3.76421 7.30032 5.08441 6.53811L4.58441 5.67208ZM10.9372 2.00432L4.58441 5.67208L5.08441 6.53811L11.4372 2.87035L10.9372 2.00432ZM16.0737 3.38066C15.0354 1.58217 12.7356 0.965961 10.9372 2.00432L11.4372 2.87035C12.7574 2.10813 14.4455 2.56046 15.2077 3.88066L16.0737 3.38066ZM14.6974 8.51723C16.4959 7.47887 17.1121 5.17915 16.0737 3.38066L15.2077 3.88066C15.9699 5.20086 15.5176 6.88899 14.1974 7.65121L14.6974 8.51723ZM14.4537 8.6579L14.6974 8.51723L14.1974 7.65121L13.9537 7.79187L14.4537 8.6579ZM15.87 9.19135C15.5184 8.58236 15.0208 8.10794 14.4472 7.78817L13.9603 8.6616C14.3806 8.89595 14.7452 9.24324 15.004 9.69135L15.87 9.19135ZM14.4936 14.3279C16.2921 13.2896 16.9083 10.9898 15.87 9.19135L15.004 9.69135C15.7662 11.0115 15.3138 12.6997 13.9936 13.4619L14.4936 14.3279ZM8.14089 17.9957L14.4936 14.3279L13.9936 13.4619L7.64089 17.1297L8.14089 17.9957ZM3.00432 16.6193C4.04268 18.4178 6.3424 19.034 8.14089 17.9957L7.64089 17.1297C6.32069 17.8919 4.63256 17.4395 3.87035 16.1193L3.00432 16.6193ZM4.38066 11.4828C2.58217 12.5211 1.96596 14.8208 3.00432 16.6193L3.87035 16.1193C3.10813 14.7991 3.56046 13.111 4.88066 12.3488L4.38066 11.4828ZM4.6243 11.3421L4.38066 11.4828L4.88066 12.3488L5.1243 12.2081L4.6243 11.3421ZM3.20807 10.8087C3.55967 11.4176 4.05727 11.8921 4.63083 12.2118L5.11778 11.3384C4.69743 11.104 4.33281 10.7568 4.07409 10.3087L3.20807 10.8087Z"
                                        fill="currentColor" />
                                    <path id="Vector"
                                        d="M8.04688 8.62652C8.04688 8.41646 8.26368 8.28345 8.441 8.38455L11.1694 9.94237C11.2111 9.9662 11.2459 10.0012 11.2701 10.0438C11.2943 10.0863 11.3071 10.1348 11.3071 10.1842C11.3071 10.2336 11.2943 10.2821 11.2701 10.3247C11.2459 10.3672 11.2111 10.4022 11.1694 10.4261L8.441 11.9836C8.40052 12.0067 8.35493 12.0185 8.30874 12.0177C8.26254 12.017 8.21733 12.0038 8.17755 11.9794C8.13777 11.955 8.1048 11.9203 8.08189 11.8786C8.05898 11.837 8.04691 11.7899 8.04688 11.7419V8.62652Z"
                                        stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                                </g>
                            </g>
                        </svg>
                    </span>
                    <span class="text"><?php echo app('translator')->get('Shorts'); ?></span>
                </a>
            </li>
            <li class="sidebar-menu-list__item">
                <a href="<?php echo e(route('trending.list')); ?>"
                    class="sidebar-menu-list__link <?php echo e(menuActive('trending.list')); ?> ">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 20 20"
                            fill="none">
                            <path
                                d="M12.8014 4.345C14.2388 4.98731 15.4122 6.10339 16.1257 7.50679C16.8392 8.91019 17.0496 10.5159 16.7217 12.0558C16.3937 13.5956 15.5473 14.9763 14.3239 15.9672C13.1005 16.958 11.5741 17.4991 9.99971 17.5C8.65305 17.4999 7.33606 17.1044 6.21222 16.3625C5.08839 15.6205 4.20719 14.5649 3.67803 13.3265C3.14886 12.0882 2.99502 10.7217 3.23561 9.39672C3.47621 8.07173 4.10063 6.84658 5.03137 5.87333C5.67276 6.76894 6.51909 7.49813 7.49971 8C7.51688 6.89886 7.77681 5.81506 8.26094 4.82591C8.74508 3.83675 9.4415 2.9666 10.3005 2.2775C10.9562 3.15683 11.8136 3.86563 12.8005 4.34417L12.8014 4.345Z"
                                stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M9.16406 9.44856C9.16406 9.23439 9.3851 9.09879 9.56589 9.20187L12.3475 10.7901C12.3901 10.8144 12.4255 10.8501 12.4502 10.8935C12.4749 10.9368 12.4879 10.9863 12.4879 11.0367C12.4879 11.087 12.4749 11.1365 12.4502 11.1799C12.4255 11.2232 12.3901 11.2589 12.3475 11.2832L9.56589 12.8712C9.52461 12.8948 9.47813 12.9067 9.43103 12.906C9.38394 12.9052 9.33784 12.8917 9.29729 12.8669C9.25673 12.842 9.22312 12.8066 9.19976 12.7641C9.1764 12.7217 9.1641 12.6737 9.16406 12.6248V9.44856Z"
                                stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                    <span class="text"><?php echo app('translator')->get('Trending'); ?></span>
                </a>
            </li>


            <span class="separate-border"></span>


            <?php if(auth()->guard()->check()): ?>

                <li class="sidebar-menu-list__item">
                    <a href="<?php echo e(route('user.history')); ?>"
                        class="sidebar-menu-list__link <?php echo e(menuActive('user.history')); ?>">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-history">
                                <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                                <path d="M3 3v5h5" />
                                <path d="M12 7v5l4 2" />
                            </svg>
                        </span>
                        <span class="text"><?php echo app('translator')->get('History'); ?></span>
                    </a>
                </li>
                <li class="sidebar-menu-list__item">
                    <a href="<?php echo e(route('user.watch.later.list')); ?>"
                        class="sidebar-menu-list__link <?php echo e(menuActive('user.watch.later.list')); ?>">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                fill="none">
                                <path
                                    d="M9.45833 3.19667C9.40417 3.37167 9.375 3.5575 9.375 3.75C9.375 4.095 9.655 4.375 10 4.375H13.75C13.9158 4.375 14.0747 4.30915 14.1919 4.19194C14.3092 4.07473 14.375 3.91576 14.375 3.75C14.3751 3.56243 14.347 3.3759 14.2917 3.19667M9.45833 3.19667C9.57669 2.81392 9.81448 2.47911 10.1369 2.24128C10.4593 2.00345 10.8494 1.87509 11.25 1.875H12.5C13.3433 1.875 14.0558 2.43167 14.2917 3.19667M9.45833 3.19667C9.145 3.21583 8.83333 3.23833 8.52167 3.26333C7.57917 3.34167 6.875 4.14417 6.875 5.09V6.875M14.2917 3.19667C14.605 3.21583 14.9167 3.23833 15.2283 3.26333C16.1708 3.34167 16.875 4.14417 16.875 5.09V13.75C16.875 14.2473 16.6775 14.7242 16.3258 15.0758C15.9742 15.4275 15.4973 15.625 15 15.625H13.125M6.875 6.875H4.0625C3.545 6.875 3.125 7.295 3.125 7.8125V17.1875C3.125 17.705 3.545 18.125 4.0625 18.125H12.1875C12.705 18.125 13.125 17.705 13.125 17.1875V15.625M6.875 6.875H12.1875C12.705 6.875 13.125 7.295 13.125 7.8125V15.625"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M6.66406 11.0682C6.66406 10.8898 6.84826 10.7768 6.99891 10.8627L9.31697 12.1862C9.3524 12.2064 9.38194 12.2362 9.40252 12.2723C9.4231 12.3085 9.43396 12.3497 9.43396 12.3917C9.43396 12.4336 9.4231 12.4749 9.40252 12.511C9.38194 12.5471 9.3524 12.5769 9.31697 12.5971L6.99891 13.9204C6.96452 13.9401 6.92579 13.9501 6.88654 13.9494C6.84729 13.9488 6.80888 13.9376 6.77508 13.9168C6.74129 13.8961 6.71328 13.8666 6.69381 13.8312C6.67434 13.7958 6.66409 13.7558 6.66406 13.7151V11.0682Z"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                        <span class="text"><?php echo app('translator')->get('Watch Later'); ?></span>
                    </a>
                </li>
                <li class="sidebar-menu-list__item">
                    <a href="<?php echo e(route('user.playlist.index')); ?>"
                        class="sidebar-menu-list__link <?php echo e(menuActive('playlists.index')); ?>">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-list-video">
                                <path d="M12 12H3" />
                                <path d="M16 6H3" />
                                <path d="M12 18H3" />
                                <path d="m16 12 5 3-5 3v-6Z" />
                            </svg>
                        </span>
                        <span class="text"><?php echo app('translator')->get('Playlist'); ?></span>
                    </a>
                </li>
                <span class="separate-border"></span>
            <?php endif; ?>
            <?php if(auth()->check() && !blank(auth()->user()->subscriptions)): ?>
                <?php
                    $subscriptions = auth()->user()->subscriptions;
                ?>
                <li class="sidebar-menu-list__item">
                    <div class="sidebar-menu-list__link sidebar-menu-list__title">
                        <span class="text"><?php echo app('translator')->get('Subscriptions'); ?></span>
                    </div>
                </li>
                <?php $__currentLoopData = $subscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="sidebar-menu-list__item">
                        <a href="<?php echo e(route('preview.channel', $subscription->followUser->slug)); ?>"
                            class="sidebar-menu-list__link <?php echo e(menuActive('stock.video')); ?>">
                            <span class="author_image">
                                <img class="fit-image"
                                    src="<?php echo e(getImage(getFilePath('userProfile') . '/' . $subscription->followUser->image)); ?>"
                                    alt="image">
                            </span>
                            <span class="text"><?php echo e($subscription->followUser->channel_name); ?></span>
                        </a>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <span class="separate-border"></span>
            <?php endif; ?>
            <?php
                $categories = App\Models\Category::active()
                    ->withCount('videos')
                    ->orderByDesc('videos_count')
                    ->take(12)
                    ->get();
            ?>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="sidebar-menu-list__item">
                    <a href="<?php echo e(route('category.video', $category->slug)); ?>"
                        class="sidebar-menu-list__link <?php echo e(menuActive('category.video', null, $category->slug)); ?>">
                        <span class="icon">
                            <?php
                                echo $category->icon;
                            ?>
                        </span>
                        <span class="text"><?php echo e(__($category->name)); ?></span>
                    </a>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
</div>
<?php /**PATH C:\laragon\www\Rushibumi\Rushibumi\core\resources\views/templates/basic/partials/sidebar.blade.php ENDPATH**/ ?>