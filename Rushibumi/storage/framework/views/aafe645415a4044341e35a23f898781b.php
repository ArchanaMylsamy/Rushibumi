<script src="<?php echo e(asset('assets/global/js/firebase/firebase-app.js')); ?>"></script>
<script src="<?php echo e(asset('assets/global/js/firebase/firebase-messaging.js')); ?>"></script> 
<script>
    "use strict";

    var permission = null;
    var authenticated = '<?php echo e(auth()->user() ? true : false); ?>';
    var pushNotify = <?php echo json_encode(gs('pn'), 15, 512) ?>;
    var firebaseConfig = <?php echo json_encode(gs('firebase_config'), 15, 512) ?>;

    function pushNotifyAction() {
        permission = Notification.permission;

        if (!('Notification' in window)) {
            notify('info', 'Push notifications not available in your browser. Try Chromium.')
        } else if (permission === 'denied' || permission == 'default') { //Notice for users dashboard
            $('.notice').append(`

            <div class="alert alert--primary" role="alert">
                <div class="alert__icon"><i class="fas fa-bell"></i></div>
                <p class="alert__message">
                    <span class="fw-bold d-block"><?php echo app('translator')->get('Please Allow / Reset Browser Notification'); ?></span>
                    <small><i><?php echo app('translator')->get('If you want to get push notification then you have to allow notification from your browser'); ?> </i></small>
                </p>
            </div>
            `);
        }
    }

    if (pushNotify == 1) {
        pushNotifyAction();
    }

    //When users allow browser notification
    if (permission != 'denied' && firebaseConfig) {

        //Firebase
        firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();

        navigator.serviceWorker.register("<?php echo e(asset('assets/global/js/firebase/firebase-messaging-sw.js')); ?>")

            .then((registration) => {
                messaging.useServiceWorker(registration);

                function initFirebaseMessagingRegistration() {
                    messaging
                        .requestPermission()
                        .then(function() {
                            return messaging.getToken()
                        })
                        .then(function(token) {
                            $.ajax({
                                url: '<?php echo e(route('user.add.device.token')); ?>',
                                type: 'POST',
                                data: {
                                    token: token,
                                    '_token': "<?php echo e(csrf_token()); ?>"
                                },
                                success: function(response) {},
                                error: function(err) {},
                            });
                        }).catch(function(error) {});
                }

                messaging.onMessage(function(payload) {
                    const title = payload.notification.title;
                    const options = {
                        body: payload.notification.body,
                        icon: payload.notification.icon,
                        image: payload.notification.image,
                        click_action: payload.notification.click_action,
                        vibrate: [200, 100, 200]
                    };
                    new Notification(title, options);
                });

                //For authenticated users
                if (authenticated) {
                    initFirebaseMessagingRegistration();
                }

            });

    }
</script>
<?php /**PATH C:\laragon\www\Rushibumi\Rushibumi\core\resources\views/partials/push_script.blade.php ENDPATH**/ ?>