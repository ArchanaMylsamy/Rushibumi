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
                </form>

                <table class="table table--responsive--lg">
                    <thead>
                        <tr>
                            <th><?php echo app('translator')->get('Plan'); ?></th>
                            <th><?php echo app('translator')->get('Price'); ?></th>
                            <th><?php echo app('translator')->get('Videos'); ?></th>
                            <th><?php echo app('translator')->get('Playlist'); ?></th>
                            <th><?php echo app('translator')->get('Channel'); ?></th>
                            <th><?php echo app('translator')->get('Action'); ?></th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php $__empty_1 = true; $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <span class="fw-bold"> <?php echo e(__(@$plan->plan->name)); ?></span>
                                </td>
                                <td>
                                    <?php echo e(showAmount($plan->plan->price)); ?>

                                </td>
                                <td>
                                    <?php echo e(@$plan->plan->videos_count); ?>

                                </td>
                                <td>
                                    <?php echo e(@$plan->plan->playlists_count); ?>

                                </td>
                                <td>
                                    <a class="text--base"
                                       href="<?php echo e(route('preview.channel', @$plan->plan->user->slug)); ?>"><?php echo e($plan->plan->user->channel_name); ?></a>
                                </td>
                                <td>
                                    <a href="<?php echo e(getPlanVideoUrl($plan->plan)); ?>"
                                       target="__blank" class="view-btn">
                                        <i class="las la-play"></i>
                                    </a>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Rushibumi\Rushibumi\core\resources\views/templates/basic/user/plans/purchased.blade.php ENDPATH**/ ?>