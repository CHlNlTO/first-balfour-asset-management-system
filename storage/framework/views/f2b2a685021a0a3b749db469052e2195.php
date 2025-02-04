<?php
    use Filament\Support\Enums\Alignment;
    use Filament\Tables\Actions\HeaderActionsPosition;
?>

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'actions' => [],
    'actionsPosition',
    'description' => null,
    'heading' => null,
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'actions' => [],
    'actionsPosition',
    'description' => null,
    'heading' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div
    <?php echo e($attributes->class([
            'fi-ta-header flex flex-col gap-3 p-4 sm:px-6',
            'sm:flex-row sm:items-center' => $actionsPosition === HeaderActionsPosition::Adaptive,
        ])); ?>

>
    <!--[if BLOCK]><![endif]--><?php if($heading || $description): ?>
        <div class="grid gap-y-1">
            <!--[if BLOCK]><![endif]--><?php if($heading): ?>
                <h3
                    class="fi-ta-header-heading text-base font-semibold leading-6 text-gray-950 dark:text-white"
                >
                    <?php echo e($heading); ?>

                </h3>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            <!--[if BLOCK]><![endif]--><?php if($description): ?>
                <p
                    class="fi-ta-header-description text-sm text-gray-600 dark:text-gray-400"
                >
                    <?php echo e($description); ?>

                </p>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!--[if BLOCK]><![endif]--><?php if($actions): ?>
        <?php if (isset($component)) { $__componentOriginal32a2358b99de73a2a27625c392d6fe38 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal32a2358b99de73a2a27625c392d6fe38 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.actions','data' => ['actions' => $actions,'alignment' => Alignment::Start,'wrap' => true,'class' => \Illuminate\Support\Arr::toCssClasses([
                'ms-auto' => $actionsPosition === HeaderActionsPosition::Adaptive && ! ($heading || $description),
                'sm:ms-auto' => $actionsPosition === HeaderActionsPosition::Adaptive,
            ])]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::actions'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['actions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($actions),'alignment' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(Alignment::Start),'wrap' => true,'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\Illuminate\Support\Arr::toCssClasses([
                'ms-auto' => $actionsPosition === HeaderActionsPosition::Adaptive && ! ($heading || $description),
                'sm:ms-auto' => $actionsPosition === HeaderActionsPosition::Adaptive,
            ]))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal32a2358b99de73a2a27625c392d6fe38)): ?>
<?php $attributes = $__attributesOriginal32a2358b99de73a2a27625c392d6fe38; ?>
<?php unset($__attributesOriginal32a2358b99de73a2a27625c392d6fe38); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal32a2358b99de73a2a27625c392d6fe38)): ?>
<?php $component = $__componentOriginal32a2358b99de73a2a27625c392d6fe38; ?>
<?php unset($__componentOriginal32a2358b99de73a2a27625c392d6fe38); ?>
<?php endif; ?>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\tables\src\/../resources/views/components/header.blade.php ENDPATH**/ ?>