<?php
    use Filament\Support\Enums\Alignment;
?>

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'activelySorted' => false,
    'alignment' => Alignment::Start,
    'name',
    'sortable' => false,
    'sortDirection',
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
    'activelySorted' => false,
    'alignment' => Alignment::Start,
    'name',
    'sortable' => false,
    'sortDirection',
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
    if (! $alignment instanceof Alignment) {
        $alignment = filled($alignment) ? (Alignment::tryFrom($alignment) ?? $alignment) : null;
    }
?>

<th
    <?php if($activelySorted): ?>
        aria-sort="<?php echo e($sortDirection === 'asc' ? 'ascending' : 'descending'); ?>"
    <?php endif; ?>
    <?php echo e($attributes->class(['fi-ta-header-cell px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6'])); ?>

>
    <<?php echo e($sortable ? 'button' : 'span'); ?>

        <?php if($sortable): ?>
            aria-label="<?php echo e(trim(strip_tags($slot))); ?>"
            type="button"
            wire:click="sortTable('<?php echo e($name); ?>')"
        <?php endif; ?>
        class="<?php echo \Illuminate\Support\Arr::toCssClasses([
            'group flex w-full items-center gap-x-1',
            'whitespace-nowrap' => ! $wrap,
            'whitespace-normal' => $wrap,
            match ($alignment) {
                Alignment::Start => 'justify-start',
                Alignment::Center => 'justify-center',
                Alignment::End => 'justify-end',
                Alignment::Left => 'justify-start rtl:flex-row-reverse',
                Alignment::Right => 'justify-end rtl:flex-row-reverse',
                Alignment::Justify, Alignment::Between => 'justify-between',
                default => $alignment,
            },
        ]); ?>"
    >
        <span
            class="fi-ta-header-cell-label text-sm font-semibold text-gray-950 dark:text-white"
        >
            <?php echo e($slot); ?>

        </span>

        <!--[if BLOCK]><![endif]--><?php if($sortable): ?>
            <?php if (isset($component)) { $__componentOriginalbfc641e0710ce04e5fe02876ffc6f950 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.icon','data' => ['alias' => 
                    match (true) {
                        $activelySorted && ($sortDirection === 'asc') => 'tables::header-cell.sort-asc-button',
                        $activelySorted && ($sortDirection === 'desc') => 'tables::header-cell.sort-desc-button',
                        default => 'tables::header-cell.sort-button',
                    }
                ,'icon' => $activelySorted && $sortDirection === 'asc' ? 'heroicon-m-chevron-up' : 'heroicon-m-chevron-down','class' => \Illuminate\Support\Arr::toCssClasses([
                    'fi-ta-header-cell-sort-icon h-5 w-5 shrink-0 transition duration-75',
                    'text-gray-950 dark:text-white' => $activelySorted,
                    'text-gray-400 dark:text-gray-500 group-hover:text-gray-500 group-focus-visible:text-gray-500 dark:group-hover:text-gray-400 dark:group-focus-visible:text-gray-400' => ! $activelySorted,
                ])]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['alias' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(
                    match (true) {
                        $activelySorted && ($sortDirection === 'asc') => 'tables::header-cell.sort-asc-button',
                        $activelySorted && ($sortDirection === 'desc') => 'tables::header-cell.sort-desc-button',
                        default => 'tables::header-cell.sort-button',
                    }
                ),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($activelySorted && $sortDirection === 'asc' ? 'heroicon-m-chevron-up' : 'heroicon-m-chevron-down'),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\Illuminate\Support\Arr::toCssClasses([
                    'fi-ta-header-cell-sort-icon h-5 w-5 shrink-0 transition duration-75',
                    'text-gray-950 dark:text-white' => $activelySorted,
                    'text-gray-400 dark:text-gray-500 group-hover:text-gray-500 group-focus-visible:text-gray-500 dark:group-hover:text-gray-400 dark:group-focus-visible:text-gray-400' => ! $activelySorted,
                ]))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950)): ?>
<?php $attributes = $__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950; ?>
<?php unset($__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbfc641e0710ce04e5fe02876ffc6f950)): ?>
<?php $component = $__componentOriginalbfc641e0710ce04e5fe02876ffc6f950; ?>
<?php unset($__componentOriginalbfc641e0710ce04e5fe02876ffc6f950); ?>
<?php endif; ?>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </<?php echo e($sortable ? 'button' : 'span'); ?>>
</th>
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\tables\src\/../resources/views/components/header-cell.blade.php ENDPATH**/ ?>