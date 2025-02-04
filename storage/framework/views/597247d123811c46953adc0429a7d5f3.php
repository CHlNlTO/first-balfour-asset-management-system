<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'method' => 'post',
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
    'method' => 'post',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<form
    method="<?php echo e($method); ?>"
    x-data="{ isProcessing: false }"
    x-on:submit="if (isProcessing) $event.preventDefault()"
    x-on:form-processing-started="isProcessing = true"
    x-on:form-processing-finished="isProcessing = false"
    <?php echo e($attributes->class(['fi-form grid gap-y-6'])); ?>

>
    <?php echo e($slot); ?>

</form>
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\filament\src\/../resources/views/components/form/index.blade.php ENDPATH**/ ?>