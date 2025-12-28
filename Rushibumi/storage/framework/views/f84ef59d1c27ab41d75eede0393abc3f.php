<?php $__env->startSection('content'); ?>
    <div class="dashboard-content">

        <div class="col-md-12">
            <div class="advertising-table">
                <form class="advertising-table__search d-flex justify-content-between">
                    <div class="form-group">
                        <input class="form--control" name="search" value="<?php echo e(request()->search); ?>" type="text"
                               placeholder="Search Here...">
                        <button class="search-btn" type="submit"><i class="vti-search"></i></button>
                    </div>
                    <button class="btn btn--base btn--sm createBtn" type="button">
                        <span class="icon"><i class="las la-plus"></i></span>
                        <span class="text"><?php echo app('translator')->get('Add New'); ?></span>
                    </button>
                </form>


                <table class="table table--responsive--lg">
                    <thead>
                        <tr>
                            <th><?php echo app('translator')->get('Name'); ?></th>
                            <th><?php echo app('translator')->get('Price'); ?></th>
                            <th><?php echo app('translator')->get('Videos'); ?></th>
                            <th><?php echo app('translator')->get('Playlist'); ?></th>
                            <th><?php echo app('translator')->get('Status'); ?></th>
                            <th><?php echo app('translator')->get('Action'); ?></th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php $__empty_1 = true; $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <a href="<?php echo e(route('user.manage.plan.details', $plan->slug)); ?>"><span class="fw-bold text--base">
                                            <?php echo e(__(@$plan->name)); ?></span></a>
                                </td>
                                <td>
                                    <?php echo e(showAmount($plan->price)); ?>

                                </td>
                                <td>
                                    <a href="<?php echo e(route('user.manage.plan.details', $plan->slug)); ?>?tab=videos">
                                        <span class="fw-bold count"><?php echo e($plan->videos_count); ?></span>
                                    </a>
                                </td>
                                <td>
                                    <a href="<?php echo e(route('user.manage.plan.details', $plan->slug)); ?>?tab=playlists">
                                        <span class="fw-bold count"><?php echo e($plan->playlists_count); ?></span>
                                    </a>
                                </td>
                                <td>
                                    <?php echo $plan->statusBadge ?>
                                </td>
                                <td>
                                    <div class="dropdown action--dropdown">
                                        <button class="btn btn--sm btn--base dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="las la-cog"></i> <?php echo app('translator')->get('Actions'); ?>
                                        </button>
                                        <ul class="dropdown-menu plan-dropdown">
                                            <li>
                                                <button class="dropdown-item editBtn" type="button"
                                                        data-plan="<?php echo e($plan); ?>">
                                                    <i class="las la-pencil-alt me-1"></i> <?php echo app('translator')->get('Edit'); ?>
                                                </button>
                                            </li>
                                            <li>
                                                <a href="<?php echo e(route('user.manage.plan.details', $plan->slug)); ?>"
                                                   class="dropdown-item">
                                                    <i class="las la-eye me-1"></i> <?php echo app('translator')->get('Details'); ?>
                                                </a>
                                            </li>
                                            <li>
                                                <?php if(@$plan->status): ?>
                                                    <a class="dropdown-item confirmationBtn" href="javascript:void(0)"
                                                       data-action="<?php echo e(route('user.manage.plan.status', $plan->id)); ?>"
                                                       data-question="<?php echo app('translator')->get('Are you sure want to disable this plan?'); ?>">
                                                        <i class="las la-eye-slash me-1"></i> <?php echo app('translator')->get('Disable'); ?>
                                                    </a>
                                                <?php else: ?>
                                                    <a class="dropdown-item confirmationBtn" href="javascript:void(0)"
                                                       data-action="<?php echo e(route('user.manage.plan.status', $plan->id)); ?>"
                                                       data-question="<?php echo app('translator')->get('Are you sure want to enable this plan?'); ?>">
                                                        <i class="las la-eye me-1"></i> <?php echo app('translator')->get('Enable'); ?>
                                                    </a>
                                                <?php endif; ?>
                                            </li>
                                            <li>
                                                <button class="dropdown-item addVideo" type="button"
                                                        data-action="<?php echo e(route('user.manage.plan.add.video', $plan->id)); ?>"
                                                        data-plan_id="<?php echo e($plan->id); ?>"
                                                        >
                                                    <i class="las la-video me-1"></i> <?php echo app('translator')->get('Add Videos'); ?>
                                                </button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item addPlaylist" type="button"
                                                        data-action="<?php echo e(route('user.manage.plan.add.playlist', $plan->id)); ?>"
                                                        data-plan_id="<?php echo e($plan->id); ?>"
                                                        data-selected='<?php echo json_encode($plan->playlists->pluck('id'), 15, 512) ?>'>
                                                    <i class="las la-list me-1"></i> <?php echo app('translator')->get('Add Playlists'); ?>
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>

                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td class="text-muted text-center empty-msg" colspan="100%">
                                    <div class="empty-container empty-card-two">
                                        <?php echo $__env->make('Template::partials.empty', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <?php if($plans->hasPages()): ?>
                    <?php echo paginateLinks($plans) ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if (isset($component)) { $__componentOriginalbd5922df145d522b37bf664b524be380 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbd5922df145d522b37bf664b524be380 = $attributes; } ?>
<?php $component = App\View\Components\ConfirmationModal::resolve(['frontend' => 'true'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('confirmation-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\ConfirmationModal::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbd5922df145d522b37bf664b524be380)): ?>
<?php $attributes = $__attributesOriginalbd5922df145d522b37bf664b524be380; ?>
<?php unset($__attributesOriginalbd5922df145d522b37bf664b524be380); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbd5922df145d522b37bf664b524be380)): ?>
<?php $component = $__componentOriginalbd5922df145d522b37bf664b524be380; ?>
<?php unset($__componentOriginalbd5922df145d522b37bf664b524be380); ?>
<?php endif; ?>
    <?php echo $__env->make('Template::user.plans.modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('style'); ?>
    <style>
        .plan-dropdown {
            background: hsl(var(--black));
            padding: 0;
            border: 0 !important;
            border-radius: 6px;
            overflow: hidden;
        }

        .plan-dropdown .dropdown-item {
            padding: 5px 10px;
            color: hsl(var(--white));
        }

        .plan-dropdown .dropdown-item:hover {}

        .plan-dropdown .dropdown-item:hover {
            background: hsl(var(--base));
            color: hsl(var(--static-white));
            border: 0;
        }

        @media screen and (max-width: 424px) {
            .modal-close-btn {
                position: absolute;
                top: 10px;
                right: 10px;
            }

            .custom--modal .modal-header {
                padding-top: 40px;
            }
        }

        @media screen and (max-width: 367px) {
            .advertising-table__search {
                display: block !important;
            }

            .createBtn {
                margin-top: 10px !important;
            }
        }

        .count {
            font-size: 18px;
        }

        .table tbody tr td {
            font-size: 16px;
        }

        .table tbody tr td a {
            color: inherit;
        }

        .table tbody tr td a:hover {
            color: hsl(var(--base));
        }

        .action--dropdown .dropdown-item:hover,
        .action--dropdown .dropdown-item:focus,
        .action--dropdown .dropdown-item:active {
            background-color: hsl(var(--base));
            outline: none;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Rushibumi\Rushibumi\core\resources\views/templates/basic/user/plans/index.blade.php ENDPATH**/ ?>