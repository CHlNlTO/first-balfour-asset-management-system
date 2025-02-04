<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'isGrid' => true,
    'default' => 1,
    'direction' => 'row',
    'sm' => null,
    'md' => null,
    'lg' => null,
    'xl' => null,
    'twoXl' => null,
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
    'isGrid' => true,
    'default' => 1,
    'direction' => 'row',
    'sm' => null,
    'md' => null,
    'lg' => null,
    'xl' => null,
    'twoXl' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div
    <?php echo e($attributes
            ->class([
                'grid' => $isGrid && $direction === 'row',
                'grid-cols-[--cols-default]' => $default && ($direction === 'row'),
                'columns-[--cols-default]' => $default && ($direction === 'column'),
                'sm:grid-cols-[--cols-sm]' => $sm && ($direction === 'row'),
                'sm:columns-[--cols-sm]' => $sm && ($direction === 'column'),
                'md:grid-cols-[--cols-md]' => $md && ($direction === 'row'),
                'md:columns-[--cols-md]' => $md && ($direction === 'column'),
                'lg:grid-cols-[--cols-lg]' => $lg && ($direction === 'row'),
                'lg:columns-[--cols-lg]' => $lg && ($direction === 'column'),
                'xl:grid-cols-[--cols-xl]' => $xl && ($direction === 'row'),
                'xl:columns-[--cols-xl]' => $xl && ($direction === 'column'),
                '2xl:grid-cols-[--cols-2xl]' => $twoXl && ($direction === 'row'),
                '2xl:columns-[--cols-2xl]' => $twoXl && ($direction === 'column'),
            ])
            ->style(
                match ($direction) {
                    'column' => [
                        "--cols-default: {$default}" => $default,
                        "--cols-sm: {$sm}" => $sm,
                        "--cols-md: {$md}" => $md,
                        "--cols-lg: {$lg}" => $lg,
                        "--cols-xl: {$xl}" => $xl,
                        "--cols-2xl: {$twoXl}" => $twoXl,
                    ],
                    'row' => [
                        "--cols-default: repeat({$default}, minmax(0, 1fr))" => $default,
                        "--cols-sm: repeat({$sm}, minmax(0, 1fr))" => $sm,
                        "--cols-md: repeat({$md}, minmax(0, 1fr))" => $md,
                        "--cols-lg: repeat({$lg}, minmax(0, 1fr))" => $lg,
                        "--cols-xl: repeat({$xl}, minmax(0, 1fr))" => $xl,
                        "--cols-2xl: repeat({$twoXl}, minmax(0, 1fr))" => $twoXl,
                    ],
                },
            )); ?>

>
    <?php echo e($slot); ?>

</div>
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\support\src\/../resources/views/components/grid/index.blade.php ENDPATH**/ ?>