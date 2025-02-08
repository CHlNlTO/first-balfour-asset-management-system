<?php
    use Filament\Support\Enums\Alignment;
?>

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'actions' => [],
    'description' => null,
    'heading',
    'icon',
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
    'description' => null,
    'heading',
    'icon',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div
    <?php echo e($attributes->class(['fi-ta-empty-state px-6 py-12'])); ?>

>
    <div
        class="fi-ta-empty-state-content mx-auto grid max-w-lg justify-items-center text-center"
    >
        <div
            class="fi-ta-empty-state-icon-ctn mb-4 rounded-full bg-gray-100 p-3 dark:bg-gray-500/20"
        >
            <?php if (isset($component)) { $__componentOriginalbfc641e0710ce04e5fe02876ffc6f950 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.icon','data' => ['icon' => $icon,'class' => 'fi-ta-empty-state-icon h-6 w-6 text-gray-500 dark:text-gray-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($icon),'class' => 'fi-ta-empty-state-icon h-6 w-6 text-gray-500 dark:text-gray-400']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950)): ?>
<?php $attributes = $__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950; ?>
<?php unset($__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbfc641e0710ce04e5fe02876ffc6f950)): ?>
<?php $component = $__componentOriginalbfc641e0710ce04e5fe02876ffc6f950; ?>
<?php unset($__componentOriginalbfc641e0710ce04e5fe02876ffc6f950); ?>
<?php endif; ?>
        </div>

        <?php if (isset($component)) { $__componentOriginal130fd53052f7fb96516142d5e36c3545 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal130fd53052f7fb96516142d5e36c3545 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.empty-state.heading','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::empty-state.heading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
            <?php echo e($heading); ?>

         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal130fd53052f7fb96516142d5e36c3545)): ?>
<?php $attributes = $__attributesOriginal130fd53052f7fb96516142d5e36c3545; ?>
<?php unset($__attributesOriginal130fd53052f7fb96516142d5e36c3545); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal130fd53052f7fb96516142d5e36c3545)): ?>
<?php $component = $__componentOriginal130fd53052f7fb96516142d5e36c3545; ?>
<?php unset($__componentOriginal130fd53052f7fb96516142d5e36c3545); ?>
<?php endif; ?>

        <!--[if BLOCK]><![endif]--><?php if($description): ?>
            <?php if (isset($component)) { $__componentOriginalc142a3e962e03b45ea4d798cbb1a12b4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc142a3e962e03b45ea4d798cbb1a12b4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.empty-state.description','data' => ['class' => 'mt-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::empty-state.description'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-1']); ?>
                <?php echo e($description); ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc142a3e962e03b45ea4d798cbb1a12b4)): ?>
<?php $attributes = $__attributesOriginalc142a3e962e03b45ea4d798cbb1a12b4; ?>
<?php unset($__attributesOriginalc142a3e962e03b45ea4d798cbb1a12b4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc142a3e962e03b45ea4d798cbb1a12b4)): ?>
<?php $component = $__componentOriginalc142a3e962e03b45ea4d798cbb1a12b4; ?>
<?php unset($__componentOriginalc142a3e962e03b45ea4d798cbb1a12b4); ?>
<?php endif; ?>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <!--[if BLOCK]><![endif]--><?php if($actions): ?>
            <?php if (isset($component)) { $__componentOriginal32a2358b99de73a2a27625c392d6fe38 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal32a2358b99de73a2a27625c392d6fe38 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.actions','data' => ['actions' => $actions,'alignment' => Alignment::Center,'wrap' => true,'class' => 'mt-6']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::actions'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['actions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($actions),'alignment' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(Alignment::Center),'wrap' => true,'class' => 'mt-6']); ?>
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
</div>
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\tables\src\/../resources/views/components/empty-state/index.blade.php ENDPATH**/ ?>