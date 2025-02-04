<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'alpineDisabled' => null,
    'alpineValid' => null,
    'disabled' => false,
    'inlinePrefix' => false,
    'inlineSuffix' => false,
    'prefix' => null,
    'prefixActions' => [],
    'prefixIcon' => null,
    'prefixIconColor' => 'gray',
    'prefixIconAlias' => null,
    'suffix' => null,
    'suffixActions' => [],
    'suffixIcon' => null,
    'suffixIconColor' => 'gray',
    'suffixIconAlias' => null,
    'valid' => true,
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
    'alpineDisabled' => null,
    'alpineValid' => null,
    'disabled' => false,
    'inlinePrefix' => false,
    'inlineSuffix' => false,
    'prefix' => null,
    'prefixActions' => [],
    'prefixIcon' => null,
    'prefixIconColor' => 'gray',
    'prefixIconAlias' => null,
    'suffix' => null,
    'suffixActions' => [],
    'suffixIcon' => null,
    'suffixIconColor' => 'gray',
    'suffixIconAlias' => null,
    'valid' => true,
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
        fn (\Filament\Forms\Components\Actions\Action $prefixAction): bool => $prefixAction->isVisible(),
    );

    $suffixActions = array_filter(
        $suffixActions,
        fn (\Filament\Forms\Components\Actions\Action $suffixAction): bool => $suffixAction->isVisible(),
    );

    $hasPrefix = count($prefixActions) || $prefixIcon || filled($prefix);
    $hasSuffix = count($suffixActions) || $suffixIcon || filled($suffix);

    $hasAlpineDisabledClasses = filled($alpineDisabled);
    $hasAlpineValidClasses = filled($alpineValid);
    $hasAlpineClasses = $hasAlpineDisabledClasses || $hasAlpineValidClasses;

    $enabledWrapperClasses = 'bg-white dark:bg-white/5 [&:not(:has(.fi-ac-action:focus))]:focus-within:ring-2';
    $disabledWrapperClasses = 'fi-disabled bg-gray-50 dark:bg-transparent';
    $validWrapperClasses = 'ring-gray-950/10';
    $invalidWrapperClasses = 'fi-invalid ring-danger-600 dark:ring-danger-500';
    $enabledValidWrapperClasses = 'dark:ring-white/20 [&:not(:has(.fi-ac-action:focus))]:focus-within:ring-primary-600 dark:[&:not(:has(.fi-ac-action:focus))]:focus-within:ring-primary-500';
    $enabledInvalidWrapperClasses = '[&:not(:has(.fi-ac-action:focus))]:focus-within:ring-danger-600 dark:[&:not(:has(.fi-ac-action:focus))]:focus-within:ring-danger-500';
    $disabledValidWrapperClasses = 'dark:ring-white/10';

    $actionsClasses = 'flex items-center gap-3';
    $labelClasses = 'fi-input-wrp-label whitespace-nowrap text-sm text-gray-500 dark:text-gray-400';

    $getIconClasses = fn (string | array $color = 'gray'): string => \Illuminate\Support\Arr::toCssClasses([
        'fi-input-wrp-icon h-5 w-5',
        match ($color) {
            'gray' => 'text-gray-400 dark:text-gray-500',
            default => 'text-custom-500',
        },
    ]);

    $getIconStyles = fn (string | array $color = 'gray'): string => \Illuminate\Support\Arr::toCssStyles([
        \Filament\Support\get_color_css_variables(
            $color,
            shades: [500],
            alias: 'input-wrapper.icon',
        ) => $color !== 'gray',
    ]);

    $wireTarget = $attributes->whereStartsWith(['wire:target'])->first();

    $hasLoadingIndicator = filled($wireTarget);

    if ($hasLoadingIndicator) {
        $loadingIndicatorTarget = html_entity_decode($wireTarget, ENT_QUOTES);
    }
?>

<div
    <?php if($hasAlpineClasses): ?>
        x-bind:class="{
            <?php echo e($hasAlpineDisabledClasses ? "'{$enabledWrapperClasses}': ! ({$alpineDisabled})," : null); ?>

            <?php echo e($hasAlpineDisabledClasses ? "'{$disabledWrapperClasses}': {$alpineDisabled}," : null); ?>

            <?php echo e($hasAlpineValidClasses ? "'{$validWrapperClasses}': {$alpineValid}," : null); ?>

            <?php echo e($hasAlpineValidClasses ? "'{$invalidWrapperClasses}': ! ({$alpineValid})," : null); ?>

            <?php echo e(($hasAlpineDisabledClasses && $hasAlpineValidClasses) ? "'{$enabledValidWrapperClasses}': ! ({$alpineDisabled}) && {$alpineValid}," : null); ?>

            <?php echo e(($hasAlpineDisabledClasses && $hasAlpineValidClasses) ? "'{$enabledInvalidWrapperClasses}': ! ({$alpineDisabled}) && ! ({$alpineValid})," : null); ?>

            <?php echo e(($hasAlpineDisabledClasses && $hasAlpineValidClasses) ? "'{$disabledValidWrapperClasses}': {$alpineDisabled} && ! ({$alpineValid})," : null); ?>

        }"
    <?php endif; ?>
    <?php echo e($attributes
            ->except(['wire:target', 'tabindex'])
            ->class([
                'fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75',
                $enabledWrapperClasses => (! $hasAlpineClasses) && (! $disabled),
                $disabledWrapperClasses => (! $hasAlpineClasses) && $disabled,
                $validWrapperClasses => (! $hasAlpineClasses) && $valid,
                $invalidWrapperClasses => (! $hasAlpineClasses) && (! $valid),
                $enabledValidWrapperClasses => (! $hasAlpineClasses) && (! $disabled) && $valid,
                $enabledInvalidWrapperClasses => (! $hasAlpineClasses) && (! $disabled) && (! $valid),
                $disabledValidWrapperClasses => (! $hasAlpineClasses) && $disabled && $valid,
            ])); ?>

>
    <!--[if BLOCK]><![endif]--><?php if($hasPrefix || $hasLoadingIndicator): ?>
        <div
            <?php if(! $hasPrefix): ?>
                wire:loading.delay.<?php echo e(config('filament.livewire_loading_delay', 'default')); ?>.flex
                wire:target="<?php echo e($loadingIndicatorTarget); ?>"
                wire:key="<?php echo e(\Illuminate\Support\Str::random()); ?>" 
            <?php endif; ?>
            class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                'fi-input-wrp-prefix items-center gap-x-3 ps-3',
                'flex' => $hasPrefix,
                'hidden' => ! $hasPrefix,
                'pe-1' => $inlinePrefix && filled($prefix),
                'pe-2' => $inlinePrefix && blank($prefix),
                'border-e border-gray-200 pe-3 ps-3 dark:border-white/10' => ! $inlinePrefix,
            ]); ?>"
        >
            <!--[if BLOCK]><![endif]--><?php if(count($prefixActions)): ?>
                <div class="<?php echo e($actionsClasses); ?>">
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $prefixActions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prefixAction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo e($prefixAction); ?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            <!--[if BLOCK]><![endif]--><?php if($prefixIcon): ?>
                <?php if (isset($component)) { $__componentOriginalbfc641e0710ce04e5fe02876ffc6f950 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.icon','data' => ['attributes' => 
                        \Filament\Support\prepare_inherited_attributes(
                            new \Illuminate\View\ComponentAttributeBag([
                                'alias' => $prefixIconAlias,
                                'icon' => $prefixIcon,
                                'wire:loading.remove.delay.' . config('filament.livewire_loading_delay', 'default') => $hasLoadingIndicator,
                                'wire:target' => $hasLoadingIndicator ? $loadingIndicatorTarget : null,
                            ])
                        )
                            ->class([$getIconClasses($prefixIconColor)])
                            ->style([$getIconStyles($prefixIconColor)])
                    ]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['attributes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(
                        \Filament\Support\prepare_inherited_attributes(
                            new \Illuminate\View\ComponentAttributeBag([
                                'alias' => $prefixIconAlias,
                                'icon' => $prefixIcon,
                                'wire:loading.remove.delay.' . config('filament.livewire_loading_delay', 'default') => $hasLoadingIndicator,
                                'wire:target' => $hasLoadingIndicator ? $loadingIndicatorTarget : null,
                            ])
                        )
                            ->class([$getIconClasses($prefixIconColor)])
                            ->style([$getIconStyles($prefixIconColor)])
                    )]); ?>
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

            <!--[if BLOCK]><![endif]--><?php if($hasLoadingIndicator): ?>
                <?php if (isset($component)) { $__componentOriginalbef7c2371a870b1887ec3741fe311a10 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbef7c2371a870b1887ec3741fe311a10 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.loading-indicator','data' => ['attributes' => 
                        \Filament\Support\prepare_inherited_attributes(
                            new \Illuminate\View\ComponentAttributeBag([
                                'wire:loading.delay.' . config('filament.livewire_loading_delay', 'default') => $hasPrefix,
                                'wire:target' => $hasPrefix ? $loadingIndicatorTarget : null,
                            ])
                        )->class([$getIconClasses()])
                    ]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::loading-indicator'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['attributes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(
                        \Filament\Support\prepare_inherited_attributes(
                            new \Illuminate\View\ComponentAttributeBag([
                                'wire:loading.delay.' . config('filament.livewire_loading_delay', 'default') => $hasPrefix,
                                'wire:target' => $hasPrefix ? $loadingIndicatorTarget : null,
                            ])
                        )->class([$getIconClasses()])
                    )]); ?>
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
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            <!--[if BLOCK]><![endif]--><?php if(filled($prefix)): ?>
                <span class="<?php echo e($labelClasses); ?>">
                    <?php echo e($prefix); ?>

                </span>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <div
        <?php if($hasLoadingIndicator && (! $hasPrefix)): ?>
            <?php if($inlinePrefix): ?>
                wire:loading.delay.<?php echo e(config('filament.livewire_loading_delay', 'default')); ?>.class.remove="ps-3"
            <?php endif; ?>

            wire:target="<?php echo e($loadingIndicatorTarget); ?>"
        <?php endif; ?>
        class="<?php echo \Illuminate\Support\Arr::toCssClasses([
            'fi-input-wrp-input min-w-0 flex-1',
            'ps-3' => $hasLoadingIndicator && (! $hasPrefix) && $inlinePrefix,
        ]); ?>"
    >
        <?php echo e($slot); ?>

    </div>

    <!--[if BLOCK]><![endif]--><?php if($hasSuffix): ?>
        <div
            class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                'fi-input-wrp-suffix flex items-center gap-x-3 pe-3',
                'ps-1' => $inlineSuffix && filled($suffix),
                'ps-2' => $inlineSuffix && blank($suffix),
                'border-s border-gray-200 ps-3 dark:border-white/10' => ! $inlineSuffix,
            ]); ?>"
        >
            <!--[if BLOCK]><![endif]--><?php if(filled($suffix)): ?>
                <span class="<?php echo e($labelClasses); ?>">
                    <?php echo e($suffix); ?>

                </span>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            <!--[if BLOCK]><![endif]--><?php if($suffixIcon): ?>
                <?php if (isset($component)) { $__componentOriginalbfc641e0710ce04e5fe02876ffc6f950 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.icon','data' => ['alias' => $suffixIconAlias,'icon' => $suffixIcon,'class' => $getIconClasses($suffixIconColor),'style' => $getIconStyles($suffixIconColor)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['alias' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($suffixIconAlias),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($suffixIcon),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getIconClasses($suffixIconColor)),'style' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getIconStyles($suffixIconColor))]); ?>
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

            <!--[if BLOCK]><![endif]--><?php if(count($suffixActions)): ?>
                <div class="<?php echo e($actionsClasses); ?>">
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $suffixActions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $suffixAction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo e($suffixAction); ?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\support\src\/../resources/views/components/input/wrapper.blade.php ENDPATH**/ ?>