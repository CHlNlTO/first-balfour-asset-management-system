<?php
    $columns = $this->getColumns();
    $heading = $this->getHeading();
    $description = $this->getDescription();
    $hasHeading = filled($heading);
    $hasDescription = filled($description);
?>

<?php if (isset($component)) { $__componentOriginalb525200bfa976483b4eaa0b7685c6e24 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb525200bfa976483b4eaa0b7685c6e24 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-widgets::components.widget','data' => ['class' => 'fi-wi-stats-overview grid gap-y-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-widgets::widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'fi-wi-stats-overview grid gap-y-4']); ?>
    <!--[if BLOCK]><![endif]--><?php if($hasHeading || $hasDescription): ?>
        <div class="fi-wi-stats-overview-header grid gap-y-1">
            <!--[if BLOCK]><![endif]--><?php if($hasHeading): ?>
                <h3
                    class="fi-wi-stats-overview-header-heading col-span-full text-base font-semibold leading-6 text-gray-950 dark:text-white"
                >
                    <?php echo e($heading); ?>

                </h3>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            <!--[if BLOCK]><![endif]--><?php if($hasDescription): ?>
                <p
                    class="fi-wi-stats-overview-header-description overflow-hidden break-words text-sm text-gray-500 dark:text-gray-400"
                >
                    <?php echo e($description); ?>

                </p>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <div
        <?php if($pollingInterval = $this->getPollingInterval()): ?>
            wire:poll.<?php echo e($pollingInterval); ?>

        <?php endif; ?>
        class="<?php echo \Illuminate\Support\Arr::toCssClasses([
            'fi-wi-stats-overview-stats-ctn grid gap-6',
            'md:grid-cols-1' => $columns === 1,
            'md:grid-cols-2' => $columns === 2,
            'md:grid-cols-3' => $columns === 3,
            'md:grid-cols-2 xl:grid-cols-4' => $columns === 4,
        ]); ?>"
    >
        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $this->getCachedStats(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo e($stat); ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb525200bfa976483b4eaa0b7685c6e24)): ?>
<?php $attributes = $__attributesOriginalb525200bfa976483b4eaa0b7685c6e24; ?>
<?php unset($__attributesOriginalb525200bfa976483b4eaa0b7685c6e24); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb525200bfa976483b4eaa0b7685c6e24)): ?>
<?php $component = $__componentOriginalb525200bfa976483b4eaa0b7685c6e24; ?>
<?php unset($__componentOriginalb525200bfa976483b4eaa0b7685c6e24); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\widgets\src\/../resources/views/stats-overview-widget.blade.php ENDPATH**/ ?>