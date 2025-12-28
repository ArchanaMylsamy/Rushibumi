<div id="confirmationModal" class="modal custom--modal fade <?php if($frontend): ?> scale-style <?php endif; ?>"
    tabindex="-1" role="dialog">
    <div class="modal-dialog <?php if($frontend): ?> modal-dialog-centered <?php endif; ?>" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo app('translator')->get('Confirmation Alert!'); ?></h5>
                <button type="button" class="close btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <p class="question"></p>
                    <?php echo e($slot); ?>

                </div>

                <div class="modal-footer">
                    <button type="button"
                        class="btn--sm btn <?php if($frontend): ?> btn--white outline <?php else: ?> btn--dark <?php endif; ?>"
                        data-bs-dismiss="modal"><?php echo app('translator')->get('No'); ?></button>
                    <button type="submit"
                        class="btn--sm btn <?php if($frontend): ?> btn--white <?php else: ?> btn--primary <?php endif; ?>"><?php echo app('translator')->get('Yes'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";
            $(document).on('click', '.confirmationBtn', function() {
                var modal = $('#confirmationModal');
                let data = $(this).data();
                modal.find('.question').text(`${data.question}`);
                modal.find('form').attr('action', `${data.action}`);
                modal.modal('show');
            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\laragon\www\Rushibumi\Rushibumi\core\resources\views/components/confirmation-modal.blade.php ENDPATH**/ ?>