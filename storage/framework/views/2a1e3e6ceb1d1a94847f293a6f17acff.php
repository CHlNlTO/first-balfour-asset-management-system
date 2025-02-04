<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'footer' => null,
    'header' => null,
    'headerGroups' => null,
    'reorderable' => false,
    'reorderAnimationDuration' => 300,
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
    'footer' => null,
    'header' => null,
    'headerGroups' => null,
    'reorderable' => false,
    'reorderAnimationDuration' => 300,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<table
    <?php echo e($attributes->class(['fi-ta-table w-full table-auto divide-y divide-gray-200 text-start dark:divide-white/5'])); ?>

>
    <!--[if BLOCK]><![endif]--><?php if($header): ?>
        <thead class="divide-y divide-gray-200 dark:divide-white/5">
            <!--[if BLOCK]><![endif]--><?php if($headerGroups): ?>
                <tr class="bg-gray-100 dark:bg-transparent">
                    <?php echo e($headerGroups); ?>

                </tr>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            <tr class="bg-gray-50 dark:bg-white/5">
                <?php echo e($header); ?>

            </tr>
        </thead>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <tbody
        <?php if($reorderable): ?>
            x-on:end.stop="$wire.reorderTable($event.target.sortable.toArray())"
            x-sortable
            data-sortable-animation-duration="<?php echo e($reorderAnimationDuration); ?>"
        <?php endif; ?>
        class="divide-y divide-gray-200 whitespace-nowrap dark:divide-white/5"
    >
        <?php echo e($slot); ?>

    </tbody>

    <!--[if BLOCK]><![endif]--><?php if($footer): ?>
        <tfoot class="bg-gray-50 dark:bg-white/5">
            <tr>
                <?php echo e($footer); ?>

            </tr>
        </tfoot>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</table>
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\tables\src\/../resources/views/components/table.blade.php ENDPATH**/ ?>