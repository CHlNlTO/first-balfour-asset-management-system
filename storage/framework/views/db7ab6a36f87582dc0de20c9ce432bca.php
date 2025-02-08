<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'prefix' => null,
    'suffix' => null,
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
    'prefix' => null,
    'suffix' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<dt
    <?php echo e($attributes->class(['fi-in-entry-wrp-label inline-flex items-center gap-x-3'])); ?>

>
    <?php echo e($prefix); ?>


    <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
        <?php echo e($slot); ?>

    </span>

    <?php echo e($suffix); ?>

</dt>
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\infolists\src\/../resources/views/components/entry-wrapper/label.blade.php ENDPATH**/ ?>