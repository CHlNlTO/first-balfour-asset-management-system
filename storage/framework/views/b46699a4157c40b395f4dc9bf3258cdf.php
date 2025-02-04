<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'alpineValid' => null,
    'valid' => true,
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
    'alpineValid' => null,
    'valid' => true,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $hasAlpineValidClasses = filled($alpineValid);

    $validInputClasses = 'text-primary-600 ring-gray-950/10 focus:ring-primary-600 checked:focus:ring-primary-500/50 dark:text-primary-500 dark:ring-white/20 dark:checked:bg-primary-500 dark:focus:ring-primary-500 dark:checked:focus:ring-primary-400/50 dark:disabled:ring-white/10';
    $invalidInputClasses = 'fi-invalid text-danger-600 ring-danger-600 focus:ring-danger-600 checked:focus:ring-danger-500/50 dark:text-danger-500 dark:ring-danger-500 dark:checked:bg-danger-500 dark:focus:ring-danger-500 dark:checked:focus:ring-danger-400/50';
?>

<input
    type="checkbox"
    <?php if($hasAlpineValidClasses): ?>
        x-bind:class="{
            <?php echo \Illuminate\Support\Js::from($validInputClasses)->toHtml() ?>: <?php echo e($alpineValid); ?>,
            <?php echo \Illuminate\Support\Js::from($invalidInputClasses)->toHtml() ?>: <?php echo e("(! {$alpineValid})"); ?>,
        }"
    <?php endif; ?>
    <?php echo e($attributes
            ->class([
                'fi-checkbox-input rounded border-none bg-white shadow-sm ring-1 transition duration-75 checked:ring-0 focus:ring-2 focus:ring-offset-0 disabled:pointer-events-none disabled:bg-gray-50 disabled:text-gray-50 disabled:checked:bg-gray-400 disabled:checked:text-gray-400 dark:bg-white/5 dark:disabled:bg-transparent dark:disabled:checked:bg-gray-600',
                $validInputClasses => (! $hasAlpineValidClasses) && $valid,
                $invalidInputClasses => (! $hasAlpineValidClasses) && (! $valid),
            ])); ?>

/>
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\support\src\/../resources/views/components/input/checkbox.blade.php ENDPATH**/ ?>