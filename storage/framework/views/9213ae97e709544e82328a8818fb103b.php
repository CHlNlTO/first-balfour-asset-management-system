<?php
    use Filament\Support\Enums\Alignment;
    use Filament\Support\Enums\IconSize;
?>

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'aside' => false,
    'collapsed' => false,
    'collapsible' => false,
    'compact' => false,
    'contentBefore' => false,
    'description' => null,
    'footerActions' => [],
    'footerActionsAlignment' => Alignment::Start,
    'headerActions' => [],
    'headerEnd' => null,
    'heading' => null,
    'icon' => null,
    'iconColor' => 'gray',
    'iconSize' => IconSize::Large,
    'persistCollapsed' => false,
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
    'aside' => false,
    'collapsed' => false,
    'collapsible' => false,
    'compact' => false,
    'contentBefore' => false,
    'description' => null,
    'footerActions' => [],
    'footerActionsAlignment' => Alignment::Start,
    'headerActions' => [],
    'headerEnd' => null,
    'heading' => null,
    'icon' => null,
    'iconColor' => 'gray',
    'iconSize' => IconSize::Large,
    'persistCollapsed' => false,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $hasDescription = filled((string) $description);
    $hasHeading = filled($heading);
    $hasIcon = filled($icon);

    if (is_array($headerActions)) {
        $headerActions = array_filter(
            $headerActions,
            fn ($headerAction): bool => $headerAction->isVisible(),
        );
    }

    if (is_array($footerActions)) {
        $footerActions = array_filter(
            $footerActions,
            fn ($footerAction): bool => $footerAction->isVisible(),
        );
    }

    $hasHeaderActions = $headerActions instanceof \Illuminate\Contracts\Support\Htmlable
        ? ! \Filament\Support\is_slot_empty($headerActions)
        : filled($headerActions);

    $hasFooterActions = $footerActions instanceof \Illuminate\Contracts\Support\Htmlable
        ? ! \Filament\Support\is_slot_empty($footerActions)
        : filled($footerActions);

    $hasHeader = $hasIcon || $hasHeading || $hasDescription || $collapsible || $hasHeaderActions || filled((string) $headerEnd);
?>

<section
    
    x-data="{
        isCollapsed: <?php if($persistCollapsed): ?> $persist(<?php echo \Illuminate\Support\Js::from($collapsed)->toHtml() ?>).as(`section-${$el.id}-isCollapsed`) <?php else: ?> <?php echo \Illuminate\Support\Js::from($collapsed)->toHtml() ?> <?php endif; ?>,
    }"
    <?php if($collapsible): ?>
        x-on:collapse-section.window="if ($event.detail.id == $el.id) isCollapsed = true"
        x-on:expand="isCollapsed = false"
        x-on:open-section.window="if ($event.detail.id == $el.id) isCollapsed = false"
        x-on:toggle-section.window="if ($event.detail.id == $el.id) isCollapsed = ! isCollapsed"
        x-bind:class="isCollapsed && 'fi-collapsed'"
    <?php endif; ?>
    <?php echo e($attributes->class([
            'fi-section',
            match ($aside) {
                true => 'fi-aside grid grid-cols-1 items-start gap-x-6 gap-y-4 md:grid-cols-3',
                false => 'rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10',
            },
        ])); ?>

>
    <!--[if BLOCK]><![endif]--><?php if($hasHeader): ?>
        <header
            <?php if($collapsible): ?>
                x-on:click="isCollapsed = ! isCollapsed"
            <?php endif; ?>
            class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                'fi-section-header flex flex-col gap-3',
                'cursor-pointer' => $collapsible,
                match ($compact) {
                    true => 'px-4 py-2.5',
                    false => 'px-6 py-4',
                } => ! $aside,
            ]); ?>"
        >
            <div class="flex items-center gap-3">
                <!--[if BLOCK]><![endif]--><?php if($hasIcon): ?>
                    <?php if (isset($component)) { $__componentOriginalbfc641e0710ce04e5fe02876ffc6f950 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.icon','data' => ['icon' => $icon,'class' => \Illuminate\Support\Arr::toCssClasses([
                            'fi-section-header-icon self-start',
                            match ($iconColor) {
                                'gray' => 'text-gray-400 dark:text-gray-500',
                                default => 'fi-color-custom text-custom-500 dark:text-custom-400',
                            },
                            is_string($iconColor) ? 'fi-color-{$iconColor}' : null,
                            match ($iconSize) {
                                IconSize::Small, 'sm' => 'h-4 w-4 mt-1',
                                IconSize::Medium, 'md' => 'h-5 w-5 mt-0.5',
                                IconSize::Large, 'lg' => 'h-6 w-6',
                                default => $iconSize,
                            },
                        ]),'style' => \Illuminate\Support\Arr::toCssStyles([
                            \Filament\Support\get_color_css_variables(
                                $iconColor,
                                shades: [400, 500],
                                alias: 'section.header.icon',
                            ) => $iconColor !== 'gray',
                        ])]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($icon),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\Illuminate\Support\Arr::toCssClasses([
                            'fi-section-header-icon self-start',
                            match ($iconColor) {
                                'gray' => 'text-gray-400 dark:text-gray-500',
                                default => 'fi-color-custom text-custom-500 dark:text-custom-400',
                            },
                            is_string($iconColor) ? 'fi-color-{$iconColor}' : null,
                            match ($iconSize) {
                                IconSize::Small, 'sm' => 'h-4 w-4 mt-1',
                                IconSize::Medium, 'md' => 'h-5 w-5 mt-0.5',
                                IconSize::Large, 'lg' => 'h-6 w-6',
                                default => $iconSize,
                            },
                        ])),'style' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\Illuminate\Support\Arr::toCssStyles([
                            \Filament\Support\get_color_css_variables(
                                $iconColor,
                                shades: [400, 500],
                                alias: 'section.header.icon',
                            ) => $iconColor !== 'gray',
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

                <!--[if BLOCK]><![endif]--><?php if($hasHeading || $hasDescription): ?>
                    <div class="grid flex-1 gap-y-1">
                        <!--[if BLOCK]><![endif]--><?php if($hasHeading): ?>
                            <?php if (isset($component)) { $__componentOriginalf35f9d5c1b29d7f1be16c01d4cf43815 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf35f9d5c1b29d7f1be16c01d4cf43815 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.section.heading','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::section.heading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                                <?php echo e($heading); ?>

                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf35f9d5c1b29d7f1be16c01d4cf43815)): ?>
<?php $attributes = $__attributesOriginalf35f9d5c1b29d7f1be16c01d4cf43815; ?>
<?php unset($__attributesOriginalf35f9d5c1b29d7f1be16c01d4cf43815); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf35f9d5c1b29d7f1be16c01d4cf43815)): ?>
<?php $component = $__componentOriginalf35f9d5c1b29d7f1be16c01d4cf43815; ?>
<?php unset($__componentOriginalf35f9d5c1b29d7f1be16c01d4cf43815); ?>
<?php endif; ?>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                        <!--[if BLOCK]><![endif]--><?php if($hasDescription): ?>
                            <?php if (isset($component)) { $__componentOriginal0998190339a840b029249e9ecb6b0282 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0998190339a840b029249e9ecb6b0282 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.section.description','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::section.description'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                                <?php echo e($description); ?>

                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0998190339a840b029249e9ecb6b0282)): ?>
<?php $attributes = $__attributesOriginal0998190339a840b029249e9ecb6b0282; ?>
<?php unset($__attributesOriginal0998190339a840b029249e9ecb6b0282); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0998190339a840b029249e9ecb6b0282)): ?>
<?php $component = $__componentOriginal0998190339a840b029249e9ecb6b0282; ?>
<?php unset($__componentOriginal0998190339a840b029249e9ecb6b0282); ?>
<?php endif; ?>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <!--[if BLOCK]><![endif]--><?php if($hasHeaderActions): ?>
                    <div class="hidden sm:block">
                        <?php if (isset($component)) { $__componentOriginal59d80b1aec4ae4c914a3e52dede19504 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal59d80b1aec4ae4c914a3e52dede19504 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.actions','data' => ['actions' => $headerActions,'alignment' => \Filament\Support\Enums\Alignment::Start,'xOn:click.stop' => '']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::actions'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['actions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($headerActions),'alignment' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\Filament\Support\Enums\Alignment::Start),'x-on:click.stop' => '']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal59d80b1aec4ae4c914a3e52dede19504)): ?>
<?php $attributes = $__attributesOriginal59d80b1aec4ae4c914a3e52dede19504; ?>
<?php unset($__attributesOriginal59d80b1aec4ae4c914a3e52dede19504); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal59d80b1aec4ae4c914a3e52dede19504)): ?>
<?php $component = $__componentOriginal59d80b1aec4ae4c914a3e52dede19504; ?>
<?php unset($__componentOriginal59d80b1aec4ae4c914a3e52dede19504); ?>
<?php endif; ?>
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <?php echo e($headerEnd); ?>


                <!--[if BLOCK]><![endif]--><?php if($collapsible): ?>
                    <?php if (isset($component)) { $__componentOriginalf0029cce6d19fd6d472097ff06a800a1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf0029cce6d19fd6d472097ff06a800a1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.icon-button','data' => ['color' => 'gray','icon' => 'heroicon-m-chevron-down','iconAlias' => 'section.collapse-button','xOn:click.stop' => 'isCollapsed = ! isCollapsed','xBind:class' => '{ \'rotate-180\': ! isCollapsed }']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::icon-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => 'gray','icon' => 'heroicon-m-chevron-down','icon-alias' => 'section.collapse-button','x-on:click.stop' => 'isCollapsed = ! isCollapsed','x-bind:class' => '{ \'rotate-180\': ! isCollapsed }']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf0029cce6d19fd6d472097ff06a800a1)): ?>
<?php $attributes = $__attributesOriginalf0029cce6d19fd6d472097ff06a800a1; ?>
<?php unset($__attributesOriginalf0029cce6d19fd6d472097ff06a800a1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf0029cce6d19fd6d472097ff06a800a1)): ?>
<?php $component = $__componentOriginalf0029cce6d19fd6d472097ff06a800a1; ?>
<?php unset($__componentOriginalf0029cce6d19fd6d472097ff06a800a1); ?>
<?php endif; ?>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>

            <!--[if BLOCK]><![endif]--><?php if($hasHeaderActions): ?>
                <div class="sm:hidden">
                    <?php if (isset($component)) { $__componentOriginal59d80b1aec4ae4c914a3e52dede19504 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal59d80b1aec4ae4c914a3e52dede19504 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.actions','data' => ['actions' => $headerActions,'alignment' => \Filament\Support\Enums\Alignment::Start,'xOn:click.stop' => '']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::actions'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['actions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($headerActions),'alignment' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\Filament\Support\Enums\Alignment::Start),'x-on:click.stop' => '']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal59d80b1aec4ae4c914a3e52dede19504)): ?>
<?php $attributes = $__attributesOriginal59d80b1aec4ae4c914a3e52dede19504; ?>
<?php unset($__attributesOriginal59d80b1aec4ae4c914a3e52dede19504); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal59d80b1aec4ae4c914a3e52dede19504)): ?>
<?php $component = $__componentOriginal59d80b1aec4ae4c914a3e52dede19504; ?>
<?php unset($__componentOriginal59d80b1aec4ae4c914a3e52dede19504); ?>
<?php endif; ?>
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </header>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <div
        <?php if($collapsible): ?>
            x-bind:aria-expanded="(! isCollapsed).toString()"
            <?php if($collapsed || $persistCollapsed): ?>
                x-cloak
            <?php endif; ?>
            x-bind:class="{
                'invisible absolute h-0 overflow-hidden border-none': isCollapsed,
            }"
        <?php endif; ?>
        class="<?php echo \Illuminate\Support\Arr::toCssClasses([
            'fi-section-content-ctn',
            'border-t border-gray-200 dark:border-white/10' => $hasHeader && (! $aside),
            'rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 md:col-span-2' => $aside,
            'md:order-first' => $contentBefore,
        ]); ?>"
    >
        <div
            class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                'fi-section-content',
                match ($compact) {
                    true => 'p-4',
                    false => 'p-6',
                },
            ]); ?>"
        >
            <?php echo e($slot); ?>

        </div>

        <!--[if BLOCK]><![endif]--><?php if($hasFooterActions): ?>
            <footer
                class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                    'fi-section-footer border-t border-gray-200 dark:border-white/10',
                    'px-6 py-4' => ! $compact,
                    'px-4 py-2.5' => $compact,
                ]); ?>"
            >
                <?php if (isset($component)) { $__componentOriginal59d80b1aec4ae4c914a3e52dede19504 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal59d80b1aec4ae4c914a3e52dede19504 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.actions','data' => ['actions' => $footerActions,'alignment' => $footerActionsAlignment]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::actions'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['actions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($footerActions),'alignment' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($footerActionsAlignment)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal59d80b1aec4ae4c914a3e52dede19504)): ?>
<?php $attributes = $__attributesOriginal59d80b1aec4ae4c914a3e52dede19504; ?>
<?php unset($__attributesOriginal59d80b1aec4ae4c914a3e52dede19504); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal59d80b1aec4ae4c914a3e52dede19504)): ?>
<?php $component = $__componentOriginal59d80b1aec4ae4c914a3e52dede19504; ?>
<?php unset($__componentOriginal59d80b1aec4ae4c914a3e52dede19504); ?>
<?php endif; ?>
            </footer>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>
</section>
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\support\src\/../resources/views/components/section/index.blade.php ENDPATH**/ ?>