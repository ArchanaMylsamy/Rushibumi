<?php if(@gs('socialite_credentials')->linkedin->status || @gs('socialite_credentials')->facebook->status == Status::ENABLE || @gs('socialite_credentials')->google->status == Status::ENABLE): ?>
    <div class="social-login-wrapper">
        <?php if(@gs('socialite_credentials')->google->status == Status::ENABLE): ?>
            <div class="continue-google">
                <a href="<?php echo e(route('user.social.login', 'google')); ?>" class="social-login-btn">
                    <span class="google-icon">
                        <img src="<?php echo e(asset($activeTemplateTrue . 'images/google.svg')); ?>" alt="Google">
                    </span>
                </a>
            </div>
        <?php endif; ?>
        <?php if(@gs('socialite_credentials')->facebook->status == Status::ENABLE): ?>
            <div class="continue-facebook">
                <a href="<?php echo e(route('user.social.login', 'facebook')); ?>" class="social-login-btn">
                    <span class="facebook-icon">
                        <img src="<?php echo e(asset($activeTemplateTrue . 'images/facebook.svg')); ?>" alt="Facebook">
                    </span>
                </a>
            </div>
        <?php endif; ?>
        <?php if(@gs('socialite_credentials')->linkedin->status == Status::ENABLE): ?>
            <div class="continue-linkedin">
                <a href="<?php echo e(route('user.social.login', 'linkedin')); ?>" class="social-login-btn">
                    <span class="facebook-icon">
                        <img src="<?php echo e(asset($activeTemplateTrue . 'images/linkdin.svg')); ?>" alt="Linkedin">
                    </span>
                </a>
            </div>
        <?php endif; ?>
    </div>

    <div class="text-center another-login">
        <span class="text"><?php echo app('translator')->get('OR'); ?></span>
    </div>
<?php endif; ?>
<?php /**PATH C:\laragon\www\Rushibumi\Rushibumi\core\resources\views/templates/basic/partials/social_login.blade.php ENDPATH**/ ?>