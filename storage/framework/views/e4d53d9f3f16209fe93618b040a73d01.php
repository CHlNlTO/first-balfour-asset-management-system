<?php
    $notifications = $this->getNotifications();
    $unreadNotificationsCount = $this->getUnreadNotificationsCount();
?>

<div
    <?php if($pollingInterval = $this->getPollingInterval()): ?>
        wire:poll.<?php echo e($pollingInterval); ?>

    <?php endif; ?>
    class="flex"
>
    <!--[if BLOCK]><![endif]--><?php if($trigger = $this->getTrigger()): ?>
        <?php if (isset($component)) { $__componentOriginala1a91060fadd74fb878e2f256cecda43 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala1a91060fadd74fb878e2f256cecda43 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-notifications::components.database.trigger','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-notifications::database.trigger'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
            <?php echo e($trigger->with(['unreadNotificationsCount' => $unreadNotificationsCount])); ?>

         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala1a91060fadd74fb878e2f256cecda43)): ?>
<?php $attributes = $__attributesOriginala1a91060fadd74fb878e2f256cecda43; ?>
<?php unset($__attributesOriginala1a91060fadd74fb878e2f256cecda43); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala1a91060fadd74fb878e2f256cecda43)): ?>
<?php $component = $__componentOriginala1a91060fadd74fb878e2f256cecda43; ?>
<?php unset($__componentOriginala1a91060fadd74fb878e2f256cecda43); ?>
<?php endif; ?>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <?php if (isset($component)) { $__componentOriginal1e32cd8671689eb44c5c643f889012d2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1e32cd8671689eb44c5c643f889012d2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-notifications::components.database.modal.index','data' => ['notifications' => $notifications,'unreadNotificationsCount' => $unreadNotificationsCount]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-notifications::database.modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['notifications' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($notifications),'unread-notifications-count' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($unreadNotificationsCount)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1e32cd8671689eb44c5c643f889012d2)): ?>
<?php $attributes = $__attributesOriginal1e32cd8671689eb44c5c643f889012d2; ?>
<?php unset($__attributesOriginal1e32cd8671689eb44c5c643f889012d2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1e32cd8671689eb44c5c643f889012d2)): ?>
<?php $component = $__componentOriginal1e32cd8671689eb44c5c643f889012d2; ?>
<?php unset($__componentOriginal1e32cd8671689eb44c5c643f889012d2); ?>
<?php endif; ?>

    <!--[if BLOCK]><![endif]--><?php if($broadcastChannel = $this->getBroadcastChannel()): ?>
        <?php if (isset($component)) { $__componentOriginal96a851ddbb0e30dc41386b42158028e7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal96a851ddbb0e30dc41386b42158028e7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-notifications::components.database.echo','data' => ['channel' => $broadcastChannel]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-notifications::database.echo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['channel' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($broadcastChannel)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal96a851ddbb0e30dc41386b42158028e7)): ?>
<?php $attributes = $__attributesOriginal96a851ddbb0e30dc41386b42158028e7; ?>
<?php unset($__attributesOriginal96a851ddbb0e30dc41386b42158028e7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal96a851ddbb0e30dc41386b42158028e7)): ?>
<?php $component = $__componentOriginal96a851ddbb0e30dc41386b42158028e7; ?>
<?php unset($__componentOriginal96a851ddbb0e30dc41386b42158028e7); ?>
<?php endif; ?>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\notifications\src\/../resources/views/database-notifications.blade.php ENDPATH**/ ?>