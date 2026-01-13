<?php $__env->startSection('content'); ?>
    <?php
        $content = getContent('advertiser_dashboard.content', true);

    ?>
    <div class="dashboard-content">
        <?php if(!$user->advertiser_status || $user->advertiser_status == Status::ADVERTISER_REJECTED): ?>
            <div class="chart-box">
                <div class="text-center">
                    <?php if(!$user->advertiser_status == Status::ADVERTISER_REJECTED): ?>
                        <h5 class="chart-box__title mb-2"><?php echo e(__($user->fullname)); ?></h5>
                        <p class="mb-2 text-white"><?php echo e(__($content->data_values->initiate_message)); ?></p>
                    <?php else: ?>
                        <div class="alert alert--danger" role="alert">
                            <div class="alert__icon"><i class="fas fa-file-signature"></i></div>
                            <p class="alert__message"><span class="fw-bold"><?php echo app('translator')->get('Your Documents Rejected'); ?></span><br>

                                <small>
                                    <?php echo app('translator')->get('Your advertiser request has been rejected.'); ?>
                                    <a href="javascript::void(0)" class="link-color" data-bs-toggle="modal"
                                        data-bs-target="#rejectionReason"><?php echo app('translator')->get('Click here'); ?></a> <?php echo app('translator')->get('to show the reason'); ?>.
                                </small>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
                <form action="<?php echo e(route('user.advertiser.data.submit')); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php if (isset($component)) { $__componentOriginal3bd95de28203859144f617d3fb6afebc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3bd95de28203859144f617d3fb6afebc = $attributes; } ?>
<?php $component = App\View\Components\ViserForm::resolve(['identifier' => 'act','identifierValue' => 'advertiser'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('viser-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\ViserForm::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3bd95de28203859144f617d3fb6afebc)): ?>
<?php $attributes = $__attributesOriginal3bd95de28203859144f617d3fb6afebc; ?>
<?php unset($__attributesOriginal3bd95de28203859144f617d3fb6afebc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3bd95de28203859144f617d3fb6afebc)): ?>
<?php $component = $__componentOriginal3bd95de28203859144f617d3fb6afebc; ?>
<?php unset($__componentOriginal3bd95de28203859144f617d3fb6afebc); ?>
<?php endif; ?>

                    <button class="btn btn--base w-100" type="submit"><?php echo app('translator')->get('Submit'); ?></button>

                </form>
            </div>
        <?php elseif($user->advertiser_status == Status::ADVERTISER_PENDING): ?>
            <div class="chart-box">
                <div class="text-center">
                    <img class="fit-image w-25"
                        src="<?php echo e(frontendImage('advertiser_dashboard', $content->data_values->image, '285x285')); ?>"
                        alt="<?php echo app('translator')->get('image'); ?>">
                    <h5 class="chart-box__title"><?php echo e(__($user->fullname)); ?></h5>
                    <p class=" text text--white"><?php echo e(__($content->data_values->review_message)); ?></p>
                </div>
            </div>
        <?php endif; ?>
        <?php if($user->advertiser_status == Status::ADVERTISER_APPROVED): ?>
            <div class="dashboard-card-wrapper">
                <div class="dashboard-card">
                    <h5 class="dashboard-card__title"><?php echo app('translator')->get('Total Ads'); ?></h5>
                    <h3 class="dashboard-card__number"><?php echo e($totalAds); ?></h3>
                    <span class="dashboard-card__icon"><img src="<?php echo e(asset($activeTemplateTrue . 'images/icon-img/7.png')); ?>"
                            alt="image"></span>
                </div>
                <div class="dashboard-card info">
                    <h5 class="dashboard-card__title"><?php echo app('translator')->get('Total Click'); ?></h5>
                    <h3 class="dashboard-card__number"><?php echo e($totalClicks); ?></h3>
                    <span class="dashboard-card__icon"><img src="<?php echo e(asset($activeTemplateTrue . 'images/icon-img/8.png')); ?>"
                            alt="image"></span>
                </div>
                <div class="dashboard-card purple">
                    <h5 class="dashboard-card__title"><?php echo app('translator')->get('Total Impression'); ?></h5>
                    <h3 class="dashboard-card__number"><?php echo e($totalImpressions); ?></h3>
                    <span class="dashboard-card__icon"><img
                            src="<?php echo e(asset($activeTemplateTrue . 'images/icon-img/9.png')); ?>" alt="image"></span>
                </div>
            </div>
            <div class="chart-box  mb-0">
                <div class="chart-box__top">
                    <h5 class="chart-box__title"><?php echo app('translator')->get('Ads Reports'); ?></h5>

                    <div class="border p-1 cursor-pointer rounded chart-title-text" id="impressionDatePicker">
                        <i class="la la-calendar"></i>&nbsp;
                        <span></span> <i class="la la-caret-down"></i>
                    </div>
                </div>
                <div id="adsReportChart">

                </div>
            </div>
        <?php endif; ?>
    </div>

    <?php if($user->advertiser_status == Status::ADVERTISER_REJECTED && $user->advertiser_rejection_reason): ?>
        <div class="modal custom--modal scale-style fade" id="rejectionReason">
            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><?php echo app('translator')->get('Document Rejection Reason'); ?></h5>
                        <button type="button" class="close modal-close-btn" data-bs-dismiss="modal" aria-label="Close">
                            <i class="las la-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p><?php echo e(__($user->advertiser_rejection_reason)); ?></p>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

<?php $__env->stopSection(); ?>


<?php $__env->startPush('style'); ?>
    <style>
        .chart-box {
            min-height: unset;
            margin-bottom: unset;
        }

        .chart-box img {
            max-width: 15%;
        }

        .chart-box__title {
            margin-top: 20px;
        }

        .chart-box .text {
            max-width: 600px;
            margin: 0 auto;
            margin-top: 15px;
        }

        .alert__message {
            text-align: start;

        }
    </style>
<?php $__env->stopPush(); ?>


<?php if($user->advertiser_status == Status::ADVERTISER_APPROVED): ?>
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



            let adsChart = lineChart(
                document.querySelector("#adsReportChart"),
                [{
                        name: "Clicks",
                        data: []
                    },
                    {
                        name: "Impressions",
                        data: []
                    }
                ],
                []
            );








            const videoChart = (startDate, endDate) => {

                const data = {
                    start_date: startDate.format('YYYY-MM-DD'),
                    end_date: endDate.format('YYYY-MM-DD')
                }

                const url = <?php echo json_encode(route('user.advertiser.ad.chart'), 15, 512) ?>;


                $.get(url, data,
                    function(data, status) {

                        if (status == 'success') {
                            adsChart.updateSeries([{
                                    name: data.data[0].name,
                                    data: data.data[0].data
                                },
                                {
                                    name: data.data[1].name,
                                    data: data.data[1].data
                                }

                            ]);


                            adsChart.updateOptions({
                                colors: ['#1E88E5', '#ff0000'],
                                yaxis: {
                                    labels: {
                                        formatter: function(value) {
                                            return Math.round(value);
                                        }
                                    }
                                },
                                xaxis: {
                                    categories: data.created_on,
                                }
                            });

                        }
                    }
                );
            }


            $('#impressionDatePicker').daterangepicker(dateRangeOptions, (start, end) => changeDatePickerText(
                '#impressionDatePicker span', start, end));


            changeDatePickerText('#impressionDatePicker span', start, end);

            videoChart(start, end);


            $('#impressionDatePicker').on('apply.daterangepicker', (event, picker) => videoChart(picker.startDate, picker
                .endDate));
        </script>
    <?php $__env->stopPush(); ?>
<?php endif; ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Rushibumi\Rushibumi\core\resources\views/templates/basic/advertiser/dashboard.blade.php ENDPATH**/ ?>