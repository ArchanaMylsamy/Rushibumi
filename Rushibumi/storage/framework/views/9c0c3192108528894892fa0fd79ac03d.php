<div class="reaction-btn__like  commentReaction" data-comment_id="<?php echo e($comment->id); ?>" data-reaction="1">
    <?php if(@$comment->isLikedByAuthUser): ?>
        <i class="vti-like-fill  reactionIcon"></i>
    <?php else: ?>
        <i class="vti-like reactionIcon"></i>
    <?php endif; ?>
    <span class="likeCount"><?php echo e(@$comment->reactionLikeCount); ?></span>
</div>
<div class="reaction-btn__dislike  commentReaction" data-comment_id="<?php echo e($comment->id); ?>" data-reaction="0">
    <?php if(@$comment->isUnlikedByAuthUser): ?>
        <i class="vti-dislike-fill reactionIcon"></i>
    <?php else: ?>
        <i class="vti-dislike reactionIcon"></i>
    <?php endif; ?>
</div>
<?php /**PATH C:\laragon\www\Rushibumi\Rushibumi\core\resources\views/templates/basic/partials/comment_reaction.blade.php ENDPATH**/ ?>