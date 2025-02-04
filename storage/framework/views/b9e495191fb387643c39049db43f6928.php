<?php
    use Filament\Support\Enums\Alignment;
    use Filament\Support\Enums\MaxWidth;
    use Filament\Support\Facades\FilamentView;
?>

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'alignment' => Alignment::Start,
    'ariaLabelledby' => null,
    'autofocus' => \Filament\Support\View\Components\Modal::$isAutofocused,
    'closeButton' => \Filament\Support\View\Components\Modal::$hasCloseButton,
    'closeByClickingAway' => \Filament\Support\View\Components\Modal::$isClosedByClickingAway,
    'closeByEscaping' => \Filament\Support\View\Components\Modal::$isClosedByEscaping,
    'closeEventName' => 'close-modal',
    'description' => null,
    'displayClasses' => 'inline-block',
    'extraModalWindowAttributeBag' => null,
    'footer' => null,
    'footerActions' => [],
    'footerActionsAlignment' => Alignment::Start,
    'header' => null,
    'heading' => null,
    'icon' => null,
    'iconAlias' => null,
    'iconColor' => 'primary',
    'id' => null,
    'openEventName' => 'open-modal',
    'slideOver' => false,
    'stickyFooter' => false,
    'stickyHeader' => false,
    'trigger' => null,
    'visible' => true,
    'width' => 'sm',
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
    'alignment' => Alignment::Start,
    'ariaLabelledby' => null,
    'autofocus' => \Filament\Support\View\Components\Modal::$isAutofocused,
    'closeButton' => \Filament\Support\View\Components\Modal::$hasCloseButton,
    'closeByClickingAway' => \Filament\Support\View\Components\Modal::$isClosedByClickingAway,
    'closeByEscaping' => \Filament\Support\View\Components\Modal::$isClosedByEscaping,
    'closeEventName' => 'close-modal',
    'description' => null,
    'displayClasses' => 'inline-block',
    'extraModalWindowAttributeBag' => null,
    'footer' => null,
    'footerActions' => [],
    'footerActionsAlignment' => Alignment::Start,
    'header' => null,
    'heading' => null,
    'icon' => null,
    'iconAlias' => null,
    'iconColor' => 'primary',
    'id' => null,
    'openEventName' => 'open-modal',
    'slideOver' => false,
    'stickyFooter' => false,
    'stickyHeader' => false,
    'trigger' => null,
    'visible' => true,
    'width' => 'sm',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $hasDescription = filled($description);
    $hasFooter = (! \Filament\Support\is_slot_empty($footer)) || (is_array($footerActions) && count($footerActions)) || (! is_array($footerActions) && (! \Filament\Support\is_slot_empty($footerActions)));
    $hasHeading = filled($heading);
    $hasIcon = filled($icon);
    $hasSlot = ! \Filament\Support\is_slot_empty($slot);

    if (! $alignment instanceof Alignment) {
        $alignment = filled($alignment) ? (Alignment::tryFrom($alignment) ?? $alignment) : null;
    }

    if (! $footerActionsAlignment instanceof Alignment) {
        $footerActionsAlignment = filled($footerActionsAlignment) ? (Alignment::tryFrom($footerActionsAlignment) ?? $footerActionsAlignment) : null;
    }

    if (! $width instanceof MaxWidth) {
        $width = filled($width) ? (MaxWidth::tryFrom($width) ?? $width) : null;
    }

    $closeEventHandler = filled($id) ? '$dispatch(' . \Illuminate\Support\Js::from($closeEventName) . ', { id: ' . \Illuminate\Support\Js::from($id) . ' })' : 'close()';
?>

<div
    <?php if($ariaLabelledby): ?>
        aria-labelledby="<?php echo e($ariaLabelledby); ?>"
    <?php elseif($heading): ?>
        aria-labelledby="<?php echo e("{$id}.heading"); ?>"
    <?php endif; ?>
    aria-modal="true"
    role="dialog"
    x-data="{
        isOpen: false,

        livewire: null,

        close: function () {
            this.isOpen = false

            this.$refs.modalContainer.dispatchEvent(
                new CustomEvent('modal-closed', { id: '<?php echo e($id); ?>' }),
            )
        },

        open: function () {
            this.$nextTick(() => {
                this.isOpen = true

                <?php if(FilamentView::hasSpaMode()): ?>
                    this.$dispatch('ax-modal-opened')
                <?php endif; ?>

                this.$refs.modalContainer.dispatchEvent(
                    new CustomEvent('modal-opened', { id: '<?php echo e($id); ?>' }),
                )
            })
        },
    }"
    <?php if($id): ?>
        x-on:<?php echo e($closeEventName); ?>.window="if ($event.detail.id === '<?php echo e($id); ?>') close()"
        x-on:<?php echo e($openEventName); ?>.window="if ($event.detail.id === '<?php echo e($id); ?>') open()"
    <?php endif; ?>
    x-trap.noscroll<?php echo e($autofocus ? '' : '.noautofocus'); ?>="isOpen"
    x-bind:class="{
        'fi-modal-open': isOpen,
    }"
    class="<?php echo \Illuminate\Support\Arr::toCssClasses([
        'fi-modal',
        'fi-width-screen' => $width === MaxWidth::Screen,
        $displayClasses,
    ]); ?>"
>
    <!--[if BLOCK]><![endif]--><?php if($trigger): ?>
        <div
            x-on:click="open"
            <?php echo e($trigger->attributes->class(['fi-modal-trigger flex cursor-pointer'])); ?>

        >
            <?php echo e($trigger); ?>

        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <div x-cloak x-show="isOpen">
        <div
            aria-hidden="true"
            x-show="isOpen"
            x-transition.duration.300ms.opacity
            class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                'fi-modal-close-overlay fixed inset-0 z-40 bg-gray-950/50 dark:bg-gray-950/75',
            ]); ?>"
        ></div>

        <div
            class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                'fixed inset-0 z-40',
                'overflow-y-auto' => ! ($slideOver || ($width === MaxWidth::Screen)),
                'cursor-pointer' => $closeByClickingAway,
            ]); ?>"
        >
            <div
                x-ref="modalContainer"
                <?php if($closeByClickingAway): ?>
                    
                    x-on:click.self="
                        document.activeElement.selectionStart === undefined &&
                            document.activeElement.selectionEnd === undefined &&
                            <?php echo e($closeEventHandler); ?>

                    "
                <?php endif; ?>
                <?php echo e($attributes->class([
                        'relative grid min-h-full grid-rows-[1fr_auto_1fr] justify-items-center sm:grid-rows-[1fr_auto_3fr]',
                        'p-4' => ! ($slideOver || ($width === MaxWidth::Screen)),
                    ])); ?>

            >
                <div
                    x-data="{ isShown: false }"
                    x-init="
                        $nextTick(() => {
                            isShown = isOpen
                            $watch('isOpen', () => (isShown = isOpen))
                        })
                    "
                    <?php if($closeByEscaping): ?>
                        x-on:keydown.window.escape="<?php echo e($closeEventHandler); ?>"
                    <?php endif; ?>
                    x-show="isShown"
                    x-transition:enter="duration-300"
                    x-transition:leave="duration-300"
                    <?php if($width === MaxWidth::Screen): ?>
                    <?php elseif($slideOver): ?>
                        x-transition:enter-start="translate-x-full rtl:-translate-x-full"
                        x-transition:enter-end="translate-x-0"
                        x-transition:leave-start="translate-x-0"
                        x-transition:leave-end="translate-x-full rtl:-translate-x-full"
                    <?php else: ?>
                        x-transition:enter-start="scale-95 opacity-0"
                        x-transition:enter-end="scale-100 opacity-100"
                        x-transition:leave-start="scale-100 opacity-100"
                        x-transition:leave-end="scale-95 opacity-0"
                    <?php endif; ?>
                    <?php echo e(($extraModalWindowAttributeBag ?? new \Illuminate\View\ComponentAttributeBag)->class([
                            'fi-modal-window pointer-events-auto relative row-start-2 flex w-full cursor-default flex-col bg-white shadow-xl ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10',
                            'fi-modal-slide-over-window ms-auto overflow-y-auto' => $slideOver,
                            // Using an arbitrary value instead of the h-dvh class that was added in Tailwind CSS v3.4.0
                            // to ensure compatibility with custom themes that may use an older version of Tailwind CSS.
                            'h-[100dvh]' => $slideOver || ($width === MaxWidth::Screen),
                            'mx-auto rounded-xl' => ! ($slideOver || ($width === MaxWidth::Screen)),
                            'hidden' => ! $visible,
                            match ($width) {
                                MaxWidth::ExtraSmall => 'max-w-xs',
                                MaxWidth::Small => 'max-w-sm',
                                MaxWidth::Medium => 'max-w-md',
                                MaxWidth::Large => 'max-w-lg',
                                MaxWidth::ExtraLarge => 'max-w-xl',
                                MaxWidth::TwoExtraLarge => 'max-w-2xl',
                                MaxWidth::ThreeExtraLarge => 'max-w-3xl',
                                MaxWidth::FourExtraLarge => 'max-w-4xl',
                                MaxWidth::FiveExtraLarge => 'max-w-5xl',
                                MaxWidth::SixExtraLarge => 'max-w-6xl',
                                MaxWidth::SevenExtraLarge => 'max-w-7xl',
                                MaxWidth::Full => 'max-w-full',
                                MaxWidth::MinContent => 'max-w-min',
                                MaxWidth::MaxContent => 'max-w-max',
                                MaxWidth::FitContent => 'max-w-fit',
                                MaxWidth::Prose => 'max-w-prose',
                                MaxWidth::ScreenSmall => 'max-w-screen-sm',
                                MaxWidth::ScreenMedium => 'max-w-screen-md',
                                MaxWidth::ScreenLarge => 'max-w-screen-lg',
                                MaxWidth::ScreenExtraLarge => 'max-w-screen-xl',
                                MaxWidth::ScreenTwoExtraLarge => 'max-w-screen-2xl',
                                MaxWidth::Screen => 'fixed inset-0',
                                default => $width,
                            },
                        ])); ?>

                >
                    <!--[if BLOCK]><![endif]--><?php if($heading || $header): ?>
                        <div
                            class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                'fi-modal-header flex px-6 pt-6',
                                'pb-6' => (! $hasSlot) && (! $hasFooter),
                                'fi-sticky sticky top-0 z-10 border-b border-gray-200 bg-white pb-6 dark:border-white/10 dark:bg-gray-900' => $stickyHeader,
                                'rounded-t-xl' => $stickyHeader && ! ($slideOver || ($width === MaxWidth::Screen)),
                                match ($alignment) {
                                    Alignment::Start, Alignment::Left => 'gap-x-5',
                                    Alignment::Center => 'flex-col',
                                    default => null,
                                },
                                'items-center' => $hasIcon && $hasHeading && (! $hasDescription) && in_array($alignment, [Alignment::Start, Alignment::Left]),
                            ]); ?>"
                        >
                            <!--[if BLOCK]><![endif]--><?php if($closeButton): ?>
                                <div
                                    class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                        'absolute',
                                        'end-4 top-4' => ! $slideOver,
                                        'end-6 top-6' => $slideOver,
                                    ]); ?>"
                                >
                                    <?php if (isset($component)) { $__componentOriginalf0029cce6d19fd6d472097ff06a800a1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf0029cce6d19fd6d472097ff06a800a1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.icon-button','data' => ['color' => 'gray','icon' => 'heroicon-o-x-mark','iconAlias' => 'modal.close-button','iconSize' => 'lg','label' => __('filament::components/modal.actions.close.label'),'tabindex' => '-1','xOn:click' => $closeEventHandler,'class' => 'fi-modal-close-btn']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::icon-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => 'gray','icon' => 'heroicon-o-x-mark','icon-alias' => 'modal.close-button','icon-size' => 'lg','label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('filament::components/modal.actions.close.label')),'tabindex' => '-1','x-on:click' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($closeEventHandler),'class' => 'fi-modal-close-btn']); ?>
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
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                            <!--[if BLOCK]><![endif]--><?php if($header): ?>
                                <?php echo e($header); ?>

                            <?php else: ?>
                                <!--[if BLOCK]><![endif]--><?php if($hasIcon): ?>
                                    <div
                                        class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                            'mb-5 flex items-center justify-center' => $alignment === Alignment::Center,
                                        ]); ?>"
                                    >
                                        <div
                                            class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                                'rounded-full',
                                                match ($iconColor) {
                                                    'gray' => 'bg-gray-100 dark:bg-gray-500/20',
                                                    default => 'fi-color-custom bg-custom-100 dark:bg-custom-500/20',
                                                },
                                                is_string($iconColor) ? "fi-color-{$iconColor}" : null,
                                                match ($alignment) {
                                                    Alignment::Start, Alignment::Left => 'p-2',
                                                    Alignment::Center => 'p-3',
                                                    default => null,
                                                },
                                            ]); ?>"
                                            style="<?php echo \Illuminate\Support\Arr::toCssStyles([
                                                \Filament\Support\get_color_css_variables(
                                                    $iconColor,
                                                    shades: [100, 400, 500, 600],
                                                    alias: 'modal.icon',
                                                ) => $iconColor !== 'gray',
                                            ]) ?>"
                                        >
                                            <?php if (isset($component)) { $__componentOriginalbfc641e0710ce04e5fe02876ffc6f950 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.icon','data' => ['alias' => $iconAlias,'icon' => $icon,'class' => \Illuminate\Support\Arr::toCssClasses([
                                                    'fi-modal-icon h-6 w-6',
                                                    match ($iconColor) {
                                                        'gray' => 'text-gray-500 dark:text-gray-400',
                                                        default => 'text-custom-600 dark:text-custom-400',
                                                    },
                                                ])]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['alias' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($iconAlias),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($icon),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\Illuminate\Support\Arr::toCssClasses([
                                                    'fi-modal-icon h-6 w-6',
                                                    match ($iconColor) {
                                                        'gray' => 'text-gray-500 dark:text-gray-400',
                                                        default => 'text-custom-600 dark:text-custom-400',
                                                    },
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
                                        </div>
                                    </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                <div
                                    class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                        'text-center' => $alignment === Alignment::Center,
                                    ]); ?>"
                                >
                                    <?php if (isset($component)) { $__componentOriginald7a9f81547afa3e8c64344ab5afc13c2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald7a9f81547afa3e8c64344ab5afc13c2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.modal.heading','data' => ['class' => \Illuminate\Support\Arr::toCssClasses([
                                            'me-6' => $closeButton && ((! $hasIcon) || in_array($alignment, [Alignment::Start, Alignment::Left])),
                                            'ms-6' => $closeButton && (! $hasIcon) && ($alignment === Alignment::Center),
                                        ])]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::modal.heading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\Illuminate\Support\Arr::toCssClasses([
                                            'me-6' => $closeButton && ((! $hasIcon) || in_array($alignment, [Alignment::Start, Alignment::Left])),
                                            'ms-6' => $closeButton && (! $hasIcon) && ($alignment === Alignment::Center),
                                        ]))]); ?>
                                        <?php echo e($heading); ?>

                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald7a9f81547afa3e8c64344ab5afc13c2)): ?>
<?php $attributes = $__attributesOriginald7a9f81547afa3e8c64344ab5afc13c2; ?>
<?php unset($__attributesOriginald7a9f81547afa3e8c64344ab5afc13c2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald7a9f81547afa3e8c64344ab5afc13c2)): ?>
<?php $component = $__componentOriginald7a9f81547afa3e8c64344ab5afc13c2; ?>
<?php unset($__componentOriginald7a9f81547afa3e8c64344ab5afc13c2); ?>
<?php endif; ?>

                                    <!--[if BLOCK]><![endif]--><?php if($hasDescription): ?>
                                        <?php if (isset($component)) { $__componentOriginal97b96faab0e6cbb838ae7fea15042b0e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal97b96faab0e6cbb838ae7fea15042b0e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.modal.description','data' => ['class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::modal.description'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-2']); ?>
                                            <?php echo e($description); ?>

                                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal97b96faab0e6cbb838ae7fea15042b0e)): ?>
<?php $attributes = $__attributesOriginal97b96faab0e6cbb838ae7fea15042b0e; ?>
<?php unset($__attributesOriginal97b96faab0e6cbb838ae7fea15042b0e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal97b96faab0e6cbb838ae7fea15042b0e)): ?>
<?php $component = $__componentOriginal97b96faab0e6cbb838ae7fea15042b0e; ?>
<?php unset($__componentOriginal97b96faab0e6cbb838ae7fea15042b0e); ?>
<?php endif; ?>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <!--[if BLOCK]><![endif]--><?php if($hasSlot): ?>
                        <div
                            class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                'fi-modal-content flex flex-col gap-y-4 py-6',
                                'flex-1' => ($width === MaxWidth::Screen) || $slideOver,
                                'pe-6 ps-[5.25rem]' => $hasIcon && ($alignment === Alignment::Start) && (! $stickyHeader),
                                'px-6' => ! ($hasIcon && ($alignment === Alignment::Start) && (! $stickyHeader)),
                            ]); ?>"
                        >
                            <?php echo e($slot); ?>

                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <!--[if BLOCK]><![endif]--><?php if($hasFooter): ?>
                        <div
                            class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                'fi-modal-footer w-full',
                                'pe-6 ps-[5.25rem]' => $hasIcon && ($alignment === Alignment::Start) && ($footerActionsAlignment !== Alignment::Center) && (! $stickyFooter),
                                'px-6' => ! ($hasIcon && ($alignment === Alignment::Start) && ($footerActionsAlignment !== Alignment::Center) && (! $stickyFooter)),
                                'fi-sticky sticky bottom-0 border-t border-gray-200 bg-white py-5 dark:border-white/10 dark:bg-gray-900' => $stickyFooter,
                                'rounded-b-xl' => $stickyFooter && ! ($slideOver || ($width === MaxWidth::Screen)),
                                'pb-6' => ! $stickyFooter,
                                'mt-6' => (! $stickyFooter) && (! $hasSlot),
                                'mt-auto' => $slideOver,
                            ]); ?>"
                        >
                            <!--[if BLOCK]><![endif]--><?php if(! \Filament\Support\is_slot_empty($footer)): ?>
                                <?php echo e($footer); ?>

                            <?php else: ?>
                                <div
                                    class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                        'fi-modal-footer-actions gap-3',
                                        match ($footerActionsAlignment) {
                                            Alignment::Start, Alignment::Left => 'flex flex-wrap items-center',
                                            Alignment::Center => 'flex flex-col-reverse sm:grid sm:grid-cols-[repeat(auto-fit,minmax(0,1fr))]',
                                            Alignment::End, Alignment::Right => 'flex flex-row-reverse flex-wrap items-center',
                                            default => null,
                                        },
                                    ]); ?>"
                                >
                                    <!--[if BLOCK]><![endif]--><?php if(is_array($footerActions)): ?>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $footerActions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php echo e($action); ?>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    <?php else: ?>
                                        <?php echo e($footerActions); ?>

                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\support\src\/../resources/views/components/modal/index.blade.php ENDPATH**/ ?>