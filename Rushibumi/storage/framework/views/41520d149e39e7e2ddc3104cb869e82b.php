<?php $__env->startSection('content'); ?>
    <div class="dashboard-content">

        <div class="notice"></div>

        <?php
            $kyc = getContent('kyc.content', true);
            $user = auth()->user();
        ?>

        <?php if($user->kv == Status::KYC_UNVERIFIED && $user->kyc_rejection_reason): ?>
            <div class="alert alert--danger" role="alert">
                <div class="alert__icon"><i class="fas fa-file-signature"></i></div>
                <p class="alert__message">
                    <span class="fw-bold"><?php echo app('translator')->get('KYC Documents Rejected'); ?></span><br>
                    <small><i><?php echo e(__(@$kyc->data_values->reject)); ?>

                            <a href="javascript::void(0)" class="link-color" data-bs-toggle="modal"
                                data-bs-target="#kycRejectionReason"><?php echo app('translator')->get('Click here'); ?></a> <?php echo app('translator')->get('to show the reason'); ?>.

                            <a href="<?php echo e(route('user.kyc.form')); ?>" class="link-color"><?php echo app('translator')->get('Click Here'); ?></a>
                            <?php echo app('translator')->get('to Re-submit Documents'); ?>. <br>
                            <a href="<?php echo e(route('user.kyc.data')); ?>" class="link-color"><?php echo app('translator')->get('See KYC Data'); ?></a>
                        </i></small>
                </p>
            </div>
        <?php elseif($user->kv == Status::KYC_UNVERIFIED): ?>
            <div class="alert alert--info" role="alert">
                <div class="alert__icon"><i class="fas fa-file-signature"></i></div>
                <p class="alert__message">
                    <span class="fw-bold"><?php echo app('translator')->get('KYC Verification Required'); ?></span><br>
                    <small><i><?php echo e(__(@$kyc->data_values->required)); ?>

                            <a href="<?php echo e(route('user.kyc.form')); ?>" class="link-color"><?php echo app('translator')->get('Click here'); ?></a>
                            <?php echo app('translator')->get('to submit KYC information'); ?>.</i></small>
                </p>
            </div>
        <?php elseif($user->kv == Status::KYC_PENDING): ?>
            <div class="alert alert--warning" role="alert">
                <div class="alert__icon"><i class="fas fa-user-check"></i></div>
                <p class="alert__message">
                    <span class="fw-bold"><?php echo app('translator')->get('KYC Verification Pending'); ?></span><br>
                    <small><i><?php echo e(__(@$kyc->data_values->pending)); ?> <a href="<?php echo e(route('user.kyc.data')); ?>"
                                class="link-color"><?php echo app('translator')->get('Click here'); ?></a> <?php echo app('translator')->get('to see your submitted information'); ?></i></small>
                </p>
            </div>
        <?php endif; ?>

        <div class="dashboard-card-wrapper">
            <div class="dashboard-card">
                <h5 class="dashboard-card__title"><?php echo app('translator')->get('Total views'); ?></h5>
                <h3 class="dashboard-card__number"><?php echo e(formatNumber($totalViews)); ?></h3>
                <span class="dashboard-card__icon"><img src="<?php echo e(asset($activeTemplateTrue . 'images/icon-img/7.png')); ?>"
                        alt="image"></span>
            </div>
            <div class="dashboard-card info">
                <h5 class="dashboard-card__title"><?php echo app('translator')->get('Subscribers'); ?></h5>
                <h3 class="dashboard-card__number"><?php echo e(formatNumber($totalFollowers)); ?></h3>
                <span class="dashboard-card__icon"><img src="<?php echo e(asset($activeTemplateTrue . 'images/icon-img/8.png')); ?>"
                        alt="image"></span>
            </div>
            <div class="dashboard-card purple">
                <h5 class="dashboard-card__title"><?php echo app('translator')->get('Total Earning'); ?></h5>
                <h3 class="dashboard-card__number"><?php echo e(showAmount($totalEarning)); ?></h3>
                <span class="dashboard-card__icon"><img
                        src="<?php echo e(asset($activeTemplateTrue . 'images/icon-img/9.png')); ?>"alt="image"></span>
            </div>
        </div>
        <div class="chart-box">
            <div class="chart-box__top">
                <h5 class="chart-box__title"><?php echo app('translator')->get('Video impression'); ?></h5>

                <div class="border p-1 cursor-pointer rounded chart-title-text" id="impressionDatePicker">
                    <i class="la la-calendar"></i>&nbsp;
                    <span></span> <i class="la la-caret-down"></i>
                </div>

            </div>
            <div id="videoImpression"></div>
        </div>
        <div class="video-analytics">
            <div class="video-analytics__top">
                <h3 class="video-analytics__title"><?php echo app('translator')->get('Video Analytics'); ?></h3>

            </div>
            <div class="dashboard-card-wrapper sm">
                <div class="dashboard-card sm">
                    <h6 class="dashboard-card__title"><?php echo app('translator')->get('Total views'); ?></h6>
                    <h3 class="dashboard-card__number"><?php echo e(formatNumber($totalViews)); ?></h3>
                </div>
                <div class="dashboard-card sm">
                    <h6 class="dashboard-card__title"><?php echo app('translator')->get('Average views'); ?></h6>
                    <h3 class="dashboard-card__number"><?php echo e(formatNumber(number_format($averageViews))); ?></h3>
                </div>
                <div class="dashboard-card sm">
                    <h6 class="dashboard-card__title"><?php echo app('translator')->get('Total Like Video'); ?></h6>
                    <h3 class="dashboard-card__number"><?php echo e(formatNumber($totalLike)); ?></h3>
                </div>
                <div class="dashboard-card sm">
                    <div class="d-flex justify-content-between">

                        <h6 class="dashboard-card__title"><?php echo app('translator')->get('New Subscribers (Last 7 Days)'); ?></h6>
                        <h6 class="dashboard-card__title"></h6>
                    </div>
                    <h3 class="dashboard-card__number"><?php echo e(formatNumber($newFollowers)); ?></h3>
                </div>
            </div>
        </div>
    </div>



    <?php if(auth()->user()->kv == Status::KYC_UNVERIFIED && auth()->user()->kyc_rejection_reason): ?>
        <div class="custom--modal scale-style modal fade" id="kycRejectionReason">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><?php echo app('translator')->get('KYC Document Rejection Reason'); ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><?php echo e(auth()->user()->kyc_rejection_reason); ?></p>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>



<?php $__env->startPush('script-lib'); ?>
    <script src="<?php echo e(asset('assets/global/js/vendor/apexcharts.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/global/js/vendor/chart.js.2.8.0.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/global/js/moment.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/global/js/daterangepicker.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/global/js/charts.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('style-lib'); ?>
    <link type="text/css" href="<?php echo e(asset('assets/global/css/daterangepicker.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        "use strict";

        const start = moment().subtract(14, 'days');
        const end = moment();

        const dateRangeOptions = {
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 15 Days': [moment().subtract(14, 'days'), moment()],
                'Last 30 Days': [moment().subtract(30, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf(
                    'month')],
                'Last 6 Months': [moment().subtract(6, 'months').startOf('month'), moment().endOf('month')],
                'This Year': [moment().startOf('year'), moment().endOf('year')],
            },
            maxDate: moment()
        }

        const changeDatePickerText = (element, startDate, endDate) => {
            $(element).html(startDate.format('MMMM D, YYYY') + ' - ' + endDate.format('MMMM D, YYYY'));
        }

        let trxChart = lineChart(
            document.querySelector("#videoImpression"),
            [{
                name: "Total Impressions",
                data: []
            }],
            []
        );



        const impressionChart = (startDate, endDate) => {
            const data = {
                start_date: startDate.format('YYYY-MM-DD'),
                end_date: endDate.format('YYYY-MM-DD')
            }
            const url = <?php echo json_encode(route('user.chart.impression'), 15, 512) ?>;
            $.get(url, data,
                function(data, status) {
                    if (status == 'success') {
                        trxChart.updateSeries(data.data);
                        trxChart.updateOptions({
                            xaxis: {
                                categories: data.created_on,
                            },
                            colors: ['#fa8500'],
                            fill: {
                                type: "gradient",
                                gradient: {
                                    shadeIntensity: 0,
                                    opacityFrom: 0.2,
                                    opacityTo: 0.1,
                                    stops: [0, 90, 100]
                                }
                            },
                        });
                    }
                }
            );
        }


        $('#impressionDatePicker').daterangepicker(dateRangeOptions, (start, end) => changeDatePickerText(
            '#impressionDatePicker span', start, end));


        changeDatePickerText('#impressionDatePicker span', start, end);

        impressionChart(start, end);


        $('#impressionDatePicker').on('apply.daterangepicker', (event, picker) => impressionChart(picker.startDate, picker
            .endDate));
    </script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('style'); ?>
<style>
    /* Theme-aware Dashboard Styling */
    .dashboard-content {
        background: hsl(var(--body-background));
        position: relative;
        overflow: hidden;
        min-height: 100vh;
        padding: 20px;
    }

    /* Animated Background Effects - Theme Aware */
    .dashboard-content::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: 
            radial-gradient(circle at 20% 50%, rgba(220, 20, 60, 0.08) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(139, 0, 0, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 40% 20%, rgba(178, 34, 34, 0.05) 0%, transparent 50%);
        animation: pulse-glow 8s ease-in-out infinite;
        z-index: 0;
        opacity: 0.3;
    }

    [data-theme="light"] .dashboard-content::before {
        opacity: 0.15;
    }

    @keyframes pulse-glow {
        0%, 100% {
            opacity: 0.3;
            transform: scale(1);
        }
        50% {
            opacity: 0.5;
            transform: scale(1.1);
        }
    }

    [data-theme="light"] .dashboard-content::before {
        opacity: 0.15;
    }

    /* Floating Particles - Theme Aware */
    .dashboard-content::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background-image: 
            radial-gradient(2px 2px at 20% 30%, rgba(220, 20, 60, 0.15), transparent),
            radial-gradient(2px 2px at 60% 70%, rgba(139, 0, 0, 0.15), transparent),
            radial-gradient(1px 1px at 50% 50%, rgba(255, 0, 0, 0.1), transparent),
            radial-gradient(1px 1px at 80% 10%, rgba(220, 20, 60, 0.1), transparent),
            radial-gradient(2px 2px at 40% 80%, rgba(139, 0, 0, 0.15), transparent);
        background-size: 200% 200%;
        animation: particle-move 20s linear infinite;
        z-index: 0;
        opacity: 0.5;
    }

    [data-theme="light"] .dashboard-content::after {
        opacity: 0.2;
    }

    @keyframes particle-move {
        0% {
            background-position: 0% 0%;
        }
        100% {
            background-position: 100% 100%;
        }
    }

    .dashboard-content > * {
        position: relative;
        z-index: 1;
    }

    /* Dashboard Cards - Theme Aware */
    .dashboard-card {
        background: hsl(var(--card-bg)) !important;
        border: 1px solid hsl(var(--border-color)) !important;
        box-shadow: var(--box-shadow) !important;
        animation: slideInUp 0.6s ease-out;
        position: relative;
        overflow: hidden;
    }

    .dashboard-card::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(220, 20, 60, 0.05) 0%, transparent 70%);
        animation: rotate-glow 10s linear infinite;
        pointer-events: none;
    }

    [data-theme="light"] .dashboard-card::before {
        background: radial-gradient(circle, rgba(220, 20, 60, 0.02) 0%, transparent 70%);
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes rotate-glow {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }

    .dashboard-card__title {
        color: hsl(var(--heading-color)) !important;
    }

    .dashboard-card__number {
        color: hsl(var(--base)) !important;
        font-weight: 700;
    }

    /* Chart Box - Theme Aware */
    .chart-box {
        background: hsl(var(--card-bg)) !important;
        border: 1px solid hsl(var(--border-color)) !important;
        box-shadow: var(--box-shadow) !important;
        border-radius: 8px;
        padding: 20px;
        margin-top: 20px;
    }

    .chart-box__title {
        color: hsl(var(--heading-color)) !important;
        font-weight: 700;
    }

    .chart-title-text {
        background: hsl(var(--card-bg)) !important;
        border: 1px solid hsl(var(--border-color)) !important;
        color: hsl(var(--body-color)) !important;
        transition: all 0.3s ease !important;
    }

    .chart-title-text:hover {
        border-color: hsl(var(--base)) !important;
        box-shadow: 0 0 0 3px hsla(var(--base), 0.1) !important;
    }

    /* Video Analytics - Theme Aware */
    .video-analytics {
        background: hsl(var(--card-bg)) !important;
        border: 1px solid hsl(var(--border-color)) !important;
        box-shadow: var(--box-shadow) !important;
        border-radius: 8px;
        padding: 20px;
        margin-top: 20px;
    }

    .video-analytics__title {
        color: hsl(var(--heading-color)) !important;
        font-weight: 700;
    }

    /* Alerts - Theme Aware */
    .alert {
        background: hsl(var(--card-bg)) !important;
        border: 1px solid hsl(var(--border-color)) !important;
        color: hsl(var(--body-color)) !important;
    }

    .alert__message {
        color: hsl(var(--body-color)) !important;
    }

    .link-color {
        color: hsl(var(--base)) !important;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .link-color:hover {
        opacity: 0.8;
    }
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Rushibumi\Rushibumi\core\resources\views/templates/basic/user/dashboard.blade.php ENDPATH**/ ?>