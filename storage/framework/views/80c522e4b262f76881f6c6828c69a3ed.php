<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'allSelectableRecordsCount',
    'deselectAllRecordsAction' => 'deselectAllRecords',
    'end' => null,
    'page' => null,
    'selectAllRecordsAction' => 'selectAllRecords',
    'selectCurrentPageOnly' => false,
    'selectedRecordsCount',
    'selectedRecordsPropertyName' => 'selectedRecords',
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
    'allSelectableRecordsCount',
    'deselectAllRecordsAction' => 'deselectAllRecords',
    'end' => null,
    'page' => null,
    'selectAllRecordsAction' => 'selectAllRecords',
    'selectCurrentPageOnly' => false,
    'selectedRecordsCount',
    'selectedRecordsPropertyName' => 'selectedRecords',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div
    x-cloak
    <?php echo e($attributes
            ->merge([
                'wire:key' => "{$this->getId()}.table.selection.indicator",
            ], escape: false)
            ->class([
                'fi-ta-selection-indicator flex flex-col justify-between gap-y-1 bg-gray-50 px-3 py-2 dark:bg-white/5 sm:flex-row sm:items-center sm:px-6 sm:py-1.5',
            ])); ?>

>
    <div class="flex gap-x-3">
        <?php if (isset($component)) { $__componentOriginalbef7c2371a870b1887ec3741fe311a10 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbef7c2371a870b1887ec3741fe311a10 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.loading-indicator','data' => ['xShow' => 'isLoading','class' => 'h-5 w-5 text-gray-400 dark:text-gray-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::loading-indicator'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['x-show' => 'isLoading','class' => 'h-5 w-5 text-gray-400 dark:text-gray-500']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbef7c2371a870b1887ec3741fe311a10)): ?>
<?php $attributes = $__attributesOriginalbef7c2371a870b1887ec3741fe311a10; ?>
<?php unset($__attributesOriginalbef7c2371a870b1887ec3741fe311a10); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbef7c2371a870b1887ec3741fe311a10)): ?>
<?php $component = $__componentOriginalbef7c2371a870b1887ec3741fe311a10; ?>
<?php unset($__componentOriginalbef7c2371a870b1887ec3741fe311a10); ?>
<?php endif; ?>

        <span
            x-text="
                window.pluralize(<?php echo \Illuminate\Support\Js::from(__('filament-tables::table.selection_indicator.selected_count'))->toHtml() ?>, <?php echo e($selectedRecordsPropertyName); ?>.length, {
                    count: <?php echo e($selectedRecordsPropertyName); ?>.length,
                })
            "
            class="text-sm font-medium leading-6 text-gray-700 dark:text-gray-200"
        ></span>
    </div>

    <div class="flex gap-x-3">
        <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\Tables\View\TablesRenderHook::SELECTION_INDICATOR_ACTIONS_BEFORE, scopes: static::class)); ?>


        <div class="flex gap-x-3">
            <?php if (isset($component)) { $__componentOriginal549c94d872270b69c72bdf48cb183bc9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal549c94d872270b69c72bdf48cb183bc9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.link','data' => ['color' => 'primary','tag' => 'button','xOn:click' => $selectAllRecordsAction,'xShow' => $selectCurrentPageOnly ? '! areRecordsSelected(getRecordsOnPage())' : $allSelectableRecordsCount . ' !== ' . $selectedRecordsPropertyName . '.length','wire:key' => $this->getId() . 'table.selection.indicator.actions.select-all.' . $allSelectableRecordsCount . '.' . $page]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => 'primary','tag' => 'button','x-on:click' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($selectAllRecordsAction),'x-show' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($selectCurrentPageOnly ? '! areRecordsSelected(getRecordsOnPage())' : $allSelectableRecordsCount . ' !== ' . $selectedRecordsPropertyName . '.length'),'wire:key' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($this->getId() . 'table.selection.indicator.actions.select-all.' . $allSelectableRecordsCount . '.' . $page)]); ?>
                <?php echo e(trans_choice('filament-tables::table.selection_indicator.actions.select_all.label', $allSelectableRecordsCount, ['count' => \Illuminate\Support\Number::format($allSelectableRecordsCount)])); ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal549c94d872270b69c72bdf48cb183bc9)): ?>
<?php $attributes = $__attributesOriginal549c94d872270b69c72bdf48cb183bc9; ?>
<?php unset($__attributesOriginal549c94d872270b69c72bdf48cb183bc9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal549c94d872270b69c72bdf48cb183bc9)): ?>
<?php $component = $__componentOriginal549c94d872270b69c72bdf48cb183bc9; ?>
<?php unset($__componentOriginal549c94d872270b69c72bdf48cb183bc9); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginal549c94d872270b69c72bdf48cb183bc9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal549c94d872270b69c72bdf48cb183bc9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.link','data' => ['color' => 'danger','tag' => 'button','xOn:click' => $deselectAllRecordsAction]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => 'danger','tag' => 'button','x-on:click' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($deselectAllRecordsAction)]); ?>
                <?php echo e(__('filament-tables::table.selection_indicator.actions.deselect_all.label')); ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal549c94d872270b69c72bdf48cb183bc9)): ?>
<?php $attributes = $__attributesOriginal549c94d872270b69c72bdf48cb183bc9; ?>
<?php unset($__attributesOriginal549c94d872270b69c72bdf48cb183bc9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal549c94d872270b69c72bdf48cb183bc9)): ?>
<?php $component = $__componentOriginal549c94d872270b69c72bdf48cb183bc9; ?>
<?php unset($__componentOriginal549c94d872270b69c72bdf48cb183bc9); ?>
<?php endif; ?>
        </div>

        <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\Tables\View\TablesRenderHook::SELECTION_INDICATOR_ACTIONS_AFTER, scopes: static::class)); ?>


        <?php echo e($end); ?>

    </div>
</div>
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\tables\src\/../resources/views/components/selection/indicator.blade.php ENDPATH**/ ?>