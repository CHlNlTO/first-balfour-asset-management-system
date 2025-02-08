<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'prefixActions' => [],
    'suffixActions' => [],
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
    'prefixActions' => [],
    'suffixActions' => [],
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $prefixActions = array_filter(
        $prefixActions,
        fn (\Filament\Infolists\Components\Actions\Action $prefixAction): bool => $prefixAction->isVisible(),
    );

    $suffixActions = array_filter(
        $suffixActions,
        fn (\Filament\Infolists\Components\Actions\Action $suffixAction): bool => $suffixAction->isVisible(),
    );

    $affixActionsClasses = 'flex items-center gap-3 self-stretch';
?>

<div
    <?php echo e($attributes->class(['fi-in-affixes flex'])); ?>

>
    <!--[if BLOCK]><![endif]--><?php if(count($prefixActions)): ?>
        <div
            class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                $affixActionsClasses,
                'pe-2',
            ]); ?>"
        >
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $prefixActions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prefixAction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo e($prefixAction); ?>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <div class="min-w-0 flex-1">
        <?php echo e($slot); ?>

    </div>

    <!--[if BLOCK]><![endif]--><?php if(count($suffixActions)): ?>
        <div
            class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                $affixActionsClasses,
                'ps-2',
            ]); ?>"
        >
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $suffixActions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $suffixAction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo e($suffixAction); ?>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\infolists\src\/../resources/views/components/affixes.blade.php ENDPATH**/ ?>