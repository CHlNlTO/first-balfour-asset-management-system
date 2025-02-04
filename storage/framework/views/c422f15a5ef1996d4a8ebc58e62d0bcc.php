<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'default' => 1,
    'sm' => null,
    'md' => null,
    'lg' => null,
    'xl' => null,
    'twoXl' => null,
    'defaultStart' => null,
    'smStart' => null,
    'mdStart' => null,
    'lgStart' => null,
    'xlStart' => null,
    'twoXlStart' => null,
    'hidden' => false,
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
    'default' => 1,
    'sm' => null,
    'md' => null,
    'lg' => null,
    'xl' => null,
    'twoXl' => null,
    'defaultStart' => null,
    'smStart' => null,
    'mdStart' => null,
    'lgStart' => null,
    'xlStart' => null,
    'twoXlStart' => null,
    'hidden' => false,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $getSpanValue = function ($span): string {
        if ($span === 'full') {
            return '1 / -1';
        }

        return "span {$span} / span {$span}";
    };
?>

<div
    <?php echo e($attributes
            ->class([
                'hidden' => $hidden || $default === 'hidden',
                'col-[--col-span-default]' => $default && (! $hidden),
                'sm:col-[--col-span-sm]' => $sm && (! $hidden),
                'md:col-[--col-span-md]' => $md && (! $hidden),
                'lg:col-[--col-span-lg]' => $lg && (! $hidden),
                'xl:col-[--col-span-xl]' => $xl && (! $hidden),
                '2xl:col-[--col-span-2xl]' => $twoXl && (! $hidden),
                'col-start-[--col-start-default]' => $defaultStart && (! $hidden),
                'sm:col-start-[--col-start-sm]' => $smStart && (! $hidden),
                'md:col-start-[--col-start-md]' => $mdStart && (! $hidden),
                'lg:col-start-[--col-start-lg]' => $lgStart && (! $hidden),
                'xl:col-start-[--col-start-xl]' => $xlStart && (! $hidden),
                '2xl:col-start-[--col-start-2xl]' => $twoXlStart && (! $hidden),
            ])
            ->style([
                "--col-span-default: {$getSpanValue($default)}" => $default,
                "--col-span-sm: {$getSpanValue($sm)}" => $sm,
                "--col-span-md: {$getSpanValue($md)}" => $md,
                "--col-span-lg: {$getSpanValue($lg)}" => $lg,
                "--col-span-xl: {$getSpanValue($xl)}" => $xl,
                "--col-span-2xl: {$getSpanValue($twoXl)}" => $twoXl,
                "--col-start-default: {$defaultStart}" => $defaultStart,
                "--col-start-sm: {$smStart}" => $smStart,
                "--col-start-md: {$mdStart}" => $mdStart,
                "--col-start-lg: {$lgStart}" => $lgStart,
                "--col-start-xl: {$xlStart}" => $xlStart,
                "--col-start-2xl: {$twoXlStart}" => $twoXlStart,
            ])); ?>

>
    <?php echo e($slot); ?>

</div>
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\support\src\/../resources/views/components/grid/column.blade.php ENDPATH**/ ?>