<?php
    use Filament\Support\Enums\Alignment;
?>

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'actions',
    'alignment' => Alignment::End,
    'record' => null,
    'wrap' => false,
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
    'actions',
    'alignment' => Alignment::End,
    'record' => null,
    'wrap' => false,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $actions = array_filter(
        $actions,
        function ($action) use ($record): bool {
            if (! $action instanceof \Filament\Tables\Actions\BulkAction) {
                $action->record($record);
            }

            return $action->isVisible();
        },
    );

    if (! $alignment instanceof Alignment) {
        $alignment = filled($alignment) ? (Alignment::tryFrom($alignment) ?? $alignment) : null;
    }
?>

<!--[if BLOCK]><![endif]--><?php if($actions): ?>
    <div
        <?php echo e($attributes->class([
                'fi-ta-actions flex shrink-0 items-center gap-3',
                'flex-wrap' => $wrap,
                'sm:flex-nowrap' => $wrap === '-sm',
                match ($alignment) {
                    Alignment::Center => 'justify-center',
                    Alignment::Start, Alignment::Left => 'justify-start',
                    Alignment::End, Alignment::Right => 'justify-end',
                    Alignment::Between, Alignment::Justify => 'justify-between',
                    'start md:end' => 'justify-start md:justify-end',
                    default => $alignment,
                },
            ])); ?>

    >
        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $actions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo e($action); ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
    </div>
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\tables\src\/../resources/views/components/actions.blade.php ENDPATH**/ ?>