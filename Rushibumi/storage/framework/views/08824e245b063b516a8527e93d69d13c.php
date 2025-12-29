<div class="modal scale-style fade custom--modal" id="existModalCenter" tabindex="-1" role="dialog"
    aria-labelledby="existModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="existModalLongTitle"><?php echo app('translator')->get('You are with us'); ?></h4>
                <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </span>
            </div>
            <div class="modal-body">
                <p class="mb-0">
                    <?php echo app('translator')->get('To continue, please'); ?> <a href="<?php echo e(route('user.login')); ?>" class="text--white fw-bold"><?php echo app('translator')->get(' log in '); ?>
                    </a>
                    <?php echo app('translator')->get('to'); ?> <?php echo e(__(gs('site_name'))); ?>

                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn--white outline btn--sm"
                    data-bs-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                <a href="<?php echo e(route('user.login')); ?>" class="btn btn--sm btn--white"><?php echo app('translator')->get('Login'); ?></a>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\Rushibumi\Rushibumi\core\resources\views/templates/basic/partials/login_alert_modal.blade.php ENDPATH**/ ?>