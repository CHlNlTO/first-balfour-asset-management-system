<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'alias' => null,
    'class' => '',
    'icon' => null,
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
    'alias' => null,
    'class' => '',
    'icon' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $icon = ($alias ? \Filament\Support\Facades\FilamentIcon::resolve($alias) : null) ?: ($icon ?? $slot);
?>

<!--[if BLOCK]><![endif]--><?php if($icon instanceof \Illuminate\Contracts\Support\Htmlable): ?>
    <span <?php echo e($attributes->class($class)); ?>>
        <?php echo e($icon); ?>

    </span>
<?php elseif(str_contains($icon, '/')): ?>
    <img
        <?php echo e($attributes
                ->merge(['src' => $icon])
                ->class($class)); ?>

    />
<?php else: ?>
    <?php echo e(svg($icon,
        $class,
        array_filter($attributes->getAttributes()),)); ?>
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\support\src\/../resources/views/components/icon.blade.php ENDPATH**/ ?>