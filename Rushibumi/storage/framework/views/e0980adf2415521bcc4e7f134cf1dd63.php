

<div class="custom--modal fade scale-style modal" id="shareModal" aria-labelledby="exampleModalLabel" aria-hidden="true"
    tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo app('translator')->get('Share On'); ?></h5>
                <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <?php
                    // Use live watch route if it's a live stream, otherwise use video play route
                    $watchUrl = isset($watchRoute) ? $watchRoute : route('video.play', [$video->id, $video->slug]);
                ?>
                <div class="share-items">
                    <a class="share-item whatsapp"
                        href="https://api.whatsapp.com/send?text=<?php echo e($watchUrl); ?>"
                        target="_blank">
                        <i class="lab la-whatsapp"></i>
                    </a>
                    <a class="share-item facebook"
                        href="https://www.facebook.com/sharer/sharer.php?u=<?php echo e($watchUrl); ?>"
                        target="_blank">
                        <i class="lab la-facebook-f"></i>
                    </a>

                    <a class="share-item twitter"
                        href="https://twitter.com/intent/tweet?url=<?php echo e($watchUrl); ?>&text=<?php echo e($video->title); ?>"
                        target="_blank">
                        <i class="fa-brands fa-x-twitter"></i>
                    </a>
                    <a class="share-item envelope"
                        href="mailto:?subject=<?php echo e($video->title); ?>&body=<?php echo e($watchUrl); ?>">
                        <i class="las la-envelope"></i>
                    </a>
                    <?php if(!isset($isLiveStream) || !$isLiveStream): ?>
                        <a class="share-item embed" href="javascript:void(0)" data-embed-code="<?php echo e(htmlspecialchars('<iframe src="' . route('embed', [$video->id, $video->slug]) . '" width="560" height="315" frameborder="0" allowfullscreen></iframe>')); ?>">
                            <i class="las la-code"></i>
                        </a>
                    <?php endif; ?>
                </div>
                <div class="share-embed">
                    <input class="form--control copyText" type="text"
                        value="<?php echo e($watchUrl); ?>">
                    <button class="share-embed-btn copyBtn"><?php echo app('translator')->get('Copy'); ?></button>
                </div>
                <div class="share-embed embed-code-section" style="display: none; margin-top: 15px;">
                    <label class="form--label mb-2"><?php echo app('translator')->get('Embed Code'); ?></label>
                    <textarea class="form--control copyText embedText" rows="3" readonly></textarea>
                    <button class="share-embed-btn copyBtn copyEmbedBtn" style="margin-top: 10px;"><?php echo app('translator')->get('Copy Embed Code'); ?></button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal custom--modal scale-style fade" id="addVideoModal" aria-labelledby="addVideoModal" aria-hidden="true"
    tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button class="close modal-close-btn" data-bs-dismiss="modal" type="button" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form class="add-video-form" method="post">
                <?php echo csrf_field(); ?>
                <input name="video_id" type="number" value="<?php echo e(@$video->id); ?>" hidden>
                <div class="modal-body playlist-list">
                    <?php if(!blank($playlists)): ?>
                        <?php $__currentLoopData = $playlists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $playlist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="check-type mb-2 w-100" for="flexCheck<?php echo e($playlist->id); ?>">
                                <input class="check-type-input" id="flexCheck<?php echo e($playlist->id); ?>" name="playlist_id[]"
                                    type="checkbox" value="<?php echo e($playlist->id); ?>"
                                    <?php if(isset($video->playlists) && $video->playlists->count() > 0 && in_array($playlist->id, $video->playlists->pluck('id')->toArray())): ?> checked <?php endif; ?>>
                                <span class="check-type-icon">
                                    <svg class="check-circle" width="13" height="10" viewBox="0 0 13 10"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path class="check" d="M1 5L4.5 8.5L12.5 0.5" stroke="currentColor"
                                            stroke-linecap="round">
                                        </path>
                                    </svg>
                                </span>
                                <span class="check-type-label" for="flexCheck<?php echo e($playlist->id); ?>">
                                    <p><?php echo e(__($playlist->title)); ?></p>
                                </span>
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <div class="justify-content-center d-flex flex-column">
                            <h6 class="text-center"><?php echo app('translator')->get('No Playlist Found'); ?></h6>
                            <?php if(auth()->guard()->check()): ?>
                                <a class="text-center"
                                    href="<?php echo e(route('preview.playlist', auth()->user()->slug)); ?>"><?php echo app('translator')->get('Create a new playlist'); ?></a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button
                        class="btn btn--base submitBtn w-100 btn--sm <?php if(blank($playlists)): ?> disabled <?php endif; ?>"
                        type="button"><?php echo app('translator')->get('Add'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>




<div class="modal custom--modal payment-modal scale-style fade" id="paymentConfirmationModal"
    aria-labelledby="playlistModalLabel" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo app('translator')->get('Please purchase this video to access our premium content'); ?></h5>

                <button class="close modal-close-btn" data-bs-dismiss="modal" type="button" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form class="deposit-form" action="<?php echo e(route('user.deposit.insert')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <input name="currency" type="hidden">
                <input type="hidden" name="playlist_id">
                <input type="hidden" name="video_id">
                <div class="gateway-card">
                    <div class="row justify-content-center gy-sm-4 gy-3">
                        <div class="col-lg-6">
                            <div class="payment-system-list is-scrollable gateway-option-list">
                                <?php $__currentLoopData = $gatewayCurrency; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <label
                                        class="payment-item <?php if($loop->index > 4): ?> d-none <?php endif; ?> gateway-option"
                                        for="<?php echo e(titleToKey($data->name)); ?>">
                                        <div class="payment-item-left">
                                            <div class="payment-item__thumb">
                                                <img class="payment-item__thumb-img"
                                                    src="<?php echo e(getImage(getFilePath('gateway') . '/' . $data->method->image)); ?>"
                                                    alt="<?php echo app('translator')->get('payment-thumb'); ?>">
                                            </div>
                                            <span class="payment-item__name"><?php echo e(__($data->name)); ?></span>
                                        </div>

                                        <span class="check-type-icon">
                                            <svg class="check-circle" width="13" height="10"
                                                viewBox="0 0 13 10" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path class="check" d="M1 5L4.5 8.5L12.5 0.5" stroke="currentColor"
                                                    stroke-linecap="round"></path>
                                            </svg>
                                        </span>

                                        <input class="payment-item__radio gateway-input"
                                            id="<?php echo e(titleToKey($data->name)); ?>" name="gateway"
                                            data-gateway='<?php echo json_encode($data, 15, 512) ?>'
                                            data-min-amount="<?php echo e(showAmount($data->min_amount)); ?>"
                                            data-max-amount="<?php echo e(showAmount($data->max_amount)); ?>" type="radio"
                                            value="<?php echo e($data->method_code); ?>" hidden
                                            <?php if(old('gateway')): ?> <?php if(old('gateway') == $data->method_code): echo 'checked'; endif; ?> <?php else: ?> <?php if($loop->first): echo 'checked'; endif; ?> <?php endif; ?>>
                                    </label>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php if($gatewayCurrency->count() > 4): ?>
                                    <button class="payment-item__btn more-gateway-option" type="button">
                                        <p class="payment-item__btn-text"><?php echo app('translator')->get('Show All Payment Options'); ?></p>
                                        <span class="payment-item__btn__icon"><i
                                                class="fas fa-chevron-down"></i></i></span>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <input class="form-control form--control amount" name="amount" type="hidden"
                                value="<?php echo e(getAmount($video->price ?? 0)); ?>" placeholder="<?php echo app('translator')->get('00.00'); ?>" readonly
                                autocomplete="off">
                            <div class="payment-system-list border-style">
                                <div class="deposit-info">
                                    <div class="deposit-info__title">
                                        <p class="text mb-0"><?php echo app('translator')->get('Item'); ?></p>
                                    </div>
                                    <div class="deposit-info__input">
                                        <p class="text"><span class="item-name"></span>
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <div class="deposit-info">
                                    <div class="deposit-info__title">
                                        <p class="text mb-0"><?php echo app('translator')->get('Amount'); ?></p>
                                    </div>
                                    <div class="deposit-info__input">
                                        <p class="text"><span class="item-price">00 <?php echo e(gs('cur_text')); ?></span>
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <div class="deposit-info">
                                    <div class="deposit-info__title">
                                        <p class="text has-icon"><?php echo app('translator')->get('Processing Charge'); ?>
                                            <span class="proccessing-fee-info" data-bs-toggle="tooltip"
                                                title="<?php echo app('translator')->get('Processing charge for payment gateways'); ?>"><i class="las la-info-circle"></i>
                                            </span>
                                        </p>
                                    </div>
                                    <div class="deposit-info__input">
                                        <p class="text"><span class="processing-fee"><?php echo app('translator')->get('0.00'); ?></span>
                                            <?php echo e(__(gs('cur_text'))); ?>

                                        </p>
                                    </div>
                                </div>

                                <div class="deposit-info total-amount pt-3">
                                    <div class="deposit-info__title">
                                        <p class="text"><?php echo app('translator')->get('Total'); ?></p>
                                    </div>
                                    <div class="deposit-info__input">
                                        <p class="text"><span class="final-amount"><?php echo app('translator')->get('0.00'); ?></span>
                                            <?php echo e(__(gs('cur_text'))); ?></p>
                                    </div>
                                </div>

                                <div class="deposit-info gateway-conversion d-none total-amount pt-2">
                                    <div class="deposit-info__title">
                                        <p class="text"><?php echo app('translator')->get('Conversion'); ?>
                                        </p>
                                    </div>
                                    <div class="deposit-info__input">
                                        <p class="text"></p>
                                    </div>
                                </div>
                                <div class="deposit-info conversion-currency d-none total-amount pt-2">
                                    <div class="deposit-info__title">
                                        <p class="text">
                                            <?php echo app('translator')->get('In'); ?> <span class="gateway-currency"></span>
                                        </p>
                                    </div>
                                    <div class="deposit-info__input">
                                        <p class="text">
                                            <span class="in-currency"></span>
                                        </p>

                                    </div>
                                </div>
                                <div class="d-none crypto-message mb-3">
                                    <div class="note-text">
                                        <span class="icon"><i class="fas fa-info-circle"></i></span>
                                        <p>
                                            <?php echo app('translator')->get('Conversion with'); ?> <span class="gateway-currency"></span>
                                            <?php echo app('translator')->get('and final value will Show on next step'); ?>
                                        </p>
                                    </div>
                                </div>
                                <button class="btn btn--base w-100" type="submit" disabled>
                                    <?php echo app('translator')->get('Payment Confirm'); ?>
                                </button>
                                <div class="info-text pt-3">
                                    <p class="text note-text">
                                        <span class="icon"><i class="fas fa-info-circle"></i></span>
                                        <?php echo app('translator')->get('Ensuring your funds grow safely through our secure payment process with world-class payment options.'); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



    
    <div class="modal scale-style fade custom--modal" id="unSubcriberModal" aria-labelledby="unSubcriberModalLabel"
        aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo app('translator')->get('Confirm Alert!'); ?></h5>
                    <button class="close modal-close-btn" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <p><?php echo app('translator')->get('Are you sure you want to unsubscribe this channel?'); ?></p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn--sm btn--white outline" data-bs-dismiss="modal"
                        type="button"><?php echo app('translator')->get('No'); ?></button>
                    <button class="btn btn--sm btn--white confirmUnsubscribe" type="button"><?php echo app('translator')->get('Yes'); ?></button>
                </div>
            </div>
        </div>
    </div>

    <?php /**PATH C:\laragon\www\Rushibumi\Rushibumi\core\resources\views/templates/basic/partials/play_video_page_modal.blade.php ENDPATH**/ ?>