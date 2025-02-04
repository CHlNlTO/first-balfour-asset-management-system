<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'contained' => false,
    'label' => null,
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
    'contained' => false,
    'label' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<nav
    <?php echo e($attributes
            ->merge([
                'aria-label' => $label,
                'role' => 'tablist',
            ])
            ->class([
                'fi-tabs flex max-w-full gap-x-1 overflow-x-auto',
                'fi-contained border-b border-gray-200 px-3 py-2.5 dark:border-white/10' => $contained,
                'mx-auto rounded-xl bg-white p-2 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10' => ! $contained,
            ])); ?>

>
    <?php echo e($slot); ?>

</nav>
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\support\src\/../resources/views/components/tabs/index.blade.php ENDPATH**/ ?>