<?php $__env->startSection('content'); ?>
    <div class="dashboard-content">
        <div class="advertising-table">
            <div class="table--header d-flex justify-content-between align-items-center flex-wrap gap-3">
                <form class="advertising-table__search flex-grow-1 p-0 border-0">
                    <div class="form-group mb-0">
                        <input class="form--control" name="search" type="text" value="<?php echo e(request()->search); ?>"
                               placeholder="Search Here...">
                        <button class="search-btn" type="submit"><i class="vti-search"></i></button>
                    </div>
                </form>

                <a class="btn ticket--btn" href="<?php echo e(route('ticket.open')); ?>">
                        <i class="far fa-list-alt"></i>
                    <?php echo app('translator')->get('New Ticket'); ?>
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table--responsive--lg">
                    <thead>
                        <tr>
                            <th><?php echo app('translator')->get('Subject'); ?></th>
                            <th><?php echo app('translator')->get('Status'); ?></th>
                            <th><?php echo app('translator')->get('Priority'); ?></th>
                            <th><?php echo app('translator')->get('Last Reply'); ?></th>
                            <th><?php echo app('translator')->get('Action'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $supports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $support): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td> <a class="fw-bold" href="<?php echo e(route('ticket.view', $support->ticket)); ?>">
                                        [<?php echo app('translator')->get('Ticket'); ?>#<?php echo e($support->ticket); ?>] <?php echo e(__($support->subject)); ?> </a></td>
                                <td>
                                    <?php echo $support->statusBadge; ?>
                                </td>
                                <td>
                                    <?php if($support->priority == Status::PRIORITY_LOW): ?>
                                        <span class="badge badge--dark"><?php echo app('translator')->get('Low'); ?></span>
                                    <?php elseif($support->priority == Status::PRIORITY_MEDIUM): ?>
                                        <span class="badge  badge--warning"><?php echo app('translator')->get('Medium'); ?></span>
                                    <?php elseif($support->priority == Status::PRIORITY_HIGH): ?>
                                        <span class="badge badge--danger"><?php echo app('translator')->get('High'); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e(diffForHumans($support->last_reply)); ?> </td>
                                <td>
                                    <a class="view-btn" href="<?php echo e(route('ticket.view', $support->ticket)); ?>">
                                        <i class="las la-desktop"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td class="text-muted text-center empty-msg" colspan="100%">
                                    <div class="empty-container empty-card-two">
                                        <?php echo $__env->make("Template::partials.empty", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($supports->hasPages()): ?>
                <?php echo e(paginateLinks($supports)); ?>

            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Rushibumi\Rushibumi\core\resources\views/templates/basic/user/support/index.blade.php ENDPATH**/ ?>