<?php extract((new \Illuminate\Support\Collection($attributes->getAttributes()))->mapWithKeys(function ($value, $key) { return [Illuminate\Support\Str::camel(str_replace([':', '.'], ' ', $key)) => $value]; })->all(), EXTR_SKIP); ?>
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['entry']));

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

foreach (array_filter((['entry']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>
<?php if (isset($component)) { $__componentOriginal5235065006f6f2f35bec5ed2e6525916 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5235065006f6f2f35bec5ed2e6525916 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-infolists::components.entry-wrapper.index','data' => ['entry' => $entry]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-infolists::entry-wrapper'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['entry' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($entry)]); ?>

<?php echo e($slot ?? ""); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5235065006f6f2f35bec5ed2e6525916)): ?>
<?php $attributes = $__attributesOriginal5235065006f6f2f35bec5ed2e6525916; ?>
<?php unset($__attributesOriginal5235065006f6f2f35bec5ed2e6525916); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5235065006f6f2f35bec5ed2e6525916)): ?>
<?php $component = $__componentOriginal5235065006f6f2f35bec5ed2e6525916; ?>
<?php unset($__componentOriginal5235065006f6f2f35bec5ed2e6525916); ?>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\storage\framework\views/5b504205ad24ffe517940962e6913ddb.blade.php ENDPATH**/ ?>