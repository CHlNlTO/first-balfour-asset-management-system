<?php
    use Filament\Support\Enums\Alignment;
    use Filament\Support\Enums\VerticalAlignment;
?>

<div>
    <div
        class="<?php echo \Illuminate\Support\Arr::toCssClasses([
            'fi-no pointer-events-none fixed inset-4 z-50 mx-auto flex gap-3',
            match (static::$alignment) {
                Alignment::Start, Alignment::Left => 'items-start',
                Alignment::Center => 'items-center',
                Alignment::End, Alignment::Right => 'items-end',
                default => null,
            },
            match (static::$verticalAlignment) {
                VerticalAlignment::Start => 'flex-col-reverse justify-end',
                VerticalAlignment::End => 'flex-col justify-end',
                VerticalAlignment::Center => 'flex-col justify-center',
            },
        ]); ?>"
        role="status"
    >
        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo e($notification); ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
    </div>

    <!--[if BLOCK]><![endif]--><?php if($broadcastChannel = $this->getBroadcastChannel()): ?>
        <?php if (isset($component)) { $__componentOriginal40a2401e895531715a66e1631dec94aa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40a2401e895531715a66e1631dec94aa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-notifications::components.echo','data' => ['channel' => $broadcastChannel]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-notifications::echo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['channel' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($broadcastChannel)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40a2401e895531715a66e1631dec94aa)): ?>
<?php $attributes = $__attributesOriginal40a2401e895531715a66e1631dec94aa; ?>
<?php unset($__attributesOriginal40a2401e895531715a66e1631dec94aa); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40a2401e895531715a66e1631dec94aa)): ?>
<?php $component = $__componentOriginal40a2401e895531715a66e1631dec94aa; ?>
<?php unset($__componentOriginal40a2401e895531715a66e1631dec94aa); ?>
<?php endif; ?>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\notifications\src\/../resources/views/notifications.blade.php ENDPATH**/ ?>