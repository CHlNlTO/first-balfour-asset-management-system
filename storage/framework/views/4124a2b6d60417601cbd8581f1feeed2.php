<?php
    use Filament\Support\Enums\Alignment;
    use Filament\Support\Enums\FontFamily;
    use Filament\Support\Enums\FontWeight;
    use Filament\Support\Enums\IconPosition;
    use Filament\Tables\Columns\TextColumn\TextColumnSize;

    $alignment = $getAlignment();
    $canWrap = $canWrap();
    $descriptionAbove = $getDescriptionAbove();
    $descriptionBelow = $getDescriptionBelow();
    $iconPosition = $getIconPosition();
    $isBadge = $isBadge();
    $isBulleted = $isBulleted();
    $isListWithLineBreaks = $isListWithLineBreaks();
    $isLimitedListExpandable = $isLimitedListExpandable();
    $url = $getUrl();

    if (! $alignment instanceof Alignment) {
        $alignment = filled($alignment) ? (Alignment::tryFrom($alignment) ?? $alignment) : null;
    }

    $arrayState = $getState();

    if ($arrayState instanceof \Illuminate\Support\Collection) {
        $arrayState = $arrayState->all();
    }

    $listLimit = 1;

    if (is_array($arrayState)) {
        if ($listLimit = $getListLimit()) {
            $limitedArrayStateCount = (count($arrayState) > $listLimit) ? (count($arrayState) - $listLimit) : 0;

            if (! $isListWithLineBreaks) {
                $arrayState = array_slice($arrayState, 0, $listLimit);
            }
        }

        $listLimit ??= count($arrayState);

        if ((! $isListWithLineBreaks) && (! $isBadge)) {
            $arrayState = implode(
                ', ',
                array_map(
                    function ($value) {
                        if ($value instanceof \Filament\Support\Contracts\HasLabel) {
                            return $value->getLabel();
                        }

                        if (is_array($value)) {
                            return json_encode($value);
                        }

                        return $value;
                    },
                    $arrayState,
                ),
            );
        }
    }

    $arrayState = \Illuminate\Support\Arr::wrap($arrayState);
?>

<div
    <?php echo e($attributes
            ->merge($getExtraAttributes(), escape: false)
            ->class([
                'fi-ta-text grid w-full gap-y-1',
                'px-3 py-4' => ! $isInline(),
            ])); ?>

>
    <!--[if BLOCK]><![endif]--><?php if(count($arrayState)): ?>
        <!--[if BLOCK]><![endif]--><?php if(filled($descriptionAbove)): ?>
            <p
                class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                    'text-sm text-gray-500 dark:text-gray-400',
                    'whitespace-normal' => $canWrap,
                ]); ?>"
            >
                <?php echo e($descriptionAbove); ?>

            </p>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <<?php echo e($isListWithLineBreaks ? 'ul' : 'div'); ?>

            class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                'flex' => ! $isBulleted,
                'flex-col' => (! $isBulleted) && $isListWithLineBreaks,
                'list-inside list-disc' => $isBulleted,
                'gap-1.5' => $isBadge,
                'flex-wrap' => $isBadge && (! $isListWithLineBreaks),
                match ($alignment) {
                    Alignment::Start => 'text-start',
                    Alignment::Center => 'text-center',
                    Alignment::End => 'text-end',
                    Alignment::Left => 'text-left',
                    Alignment::Right => 'text-right',
                    Alignment::Justify, Alignment::Between => 'text-justify',
                    default => $alignment,
                },
                match ($alignment) {
                    Alignment::Start, Alignment::Left => 'justify-start',
                    Alignment::Center => 'justify-center',
                    Alignment::End, Alignment::Right => 'justify-end',
                    Alignment::Between, Alignment::Justify => 'justify-between',
                    default => null,
                } => $isBulleted || (! $isListWithLineBreaks),
                match ($alignment) {
                    Alignment::Start, Alignment::Left => 'items-start',
                    Alignment::Center => 'items-center',
                    Alignment::End, Alignment::Right => 'items-end',
                    Alignment::Between, Alignment::Justify => 'items-stretch',
                    default => null,
                } => $isListWithLineBreaks && (! $isBulleted),
            ]); ?>"
            <?php if($isListWithLineBreaks && $isLimitedListExpandable): ?>
                x-data="{ isLimited: true }"
            <?php endif; ?>
        >
            <?php $__currentLoopData = $arrayState; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <!--[if BLOCK]><![endif]--><?php if(filled($formattedState = $formatState($state)) &&
                     (! ($isListWithLineBreaks && (! $isLimitedListExpandable) && ($loop->iteration > $listLimit)))): ?>
                    <?php
                        $color = $getColor($state);
                        $copyableState = $getCopyableState($state) ?? $state;
                        $copyMessage = $getCopyMessage($state);
                        $copyMessageDuration = $getCopyMessageDuration($state);
                        $fontFamily = $getFontFamily($state);
                        $icon = $getIcon($state);
                        $iconColor = $getIconColor($state) ?? $color;
                        $itemIsCopyable = $isCopyable($state);
                        $lineClamp = $getLineClamp($state);
                        $size = $getSize($state);
                        $weight = $getWeight($state);

                        $iconClasses = \Illuminate\Support\Arr::toCssClasses([
                            'fi-ta-text-item-icon h-5 w-5',
                            match ($iconColor) {
                                'gray', null => 'text-gray-400 dark:text-gray-500',
                                default => 'text-custom-500',
                            },
                        ]);

                        $iconStyles = \Illuminate\Support\Arr::toCssStyles([
                            \Filament\Support\get_color_css_variables(
                                $iconColor,
                                shades: [500],
                                alias: 'tables::columns.text-column.item.icon',
                            ) => $iconColor !== 'gray',
                        ]);
                    ?>

                    <<?php echo e($isListWithLineBreaks ? 'li' : 'div'); ?>

                        <?php if($itemIsCopyable): ?>
                            x-on:click="
                                window.navigator.clipboard.writeText(<?php echo \Illuminate\Support\Js::from($copyableState)->toHtml() ?>)
                                $tooltip(<?php echo \Illuminate\Support\Js::from($copyMessage)->toHtml() ?>, {
                                    theme: $store.theme,
                                    timeout: <?php echo \Illuminate\Support\Js::from($copyMessageDuration)->toHtml() ?>,
                                })
                            "
                        <?php endif; ?>
                        <?php if($isListWithLineBreaks && ($loop->iteration > $listLimit)): ?>
                            x-cloak
                            x-show="! isLimited"
                            x-transition
                        <?php endif; ?>
                        class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                            'flex' => ! $isBulleted,
                            'max-w-max' => ! ($isBulleted || $isBadge),
                            'w-max' => $isBadge,
                            'cursor-pointer' => $itemIsCopyable,
                            match ($color) {
                                null => 'text-gray-950 dark:text-white',
                                'gray' => 'text-gray-500 dark:text-gray-400',
                                default => 'text-custom-600 dark:text-custom-400',
                            } => $isBulleted,
                        ]); ?>"
                        style="<?php echo \Illuminate\Support\Arr::toCssStyles([
                            \Filament\Support\get_color_css_variables(
                                $color,
                                shades: [400, 600],
                                alias: 'tables::columns.text-column.item.container',
                            ) => $isBulleted && (! in_array($color, [null, 'gray'])),
                        ]) ?>"
                    >
                        <!--[if BLOCK]><![endif]--><?php if($isBadge): ?>
                            <?php if (isset($component)) { $__componentOriginal986dce9114ddce94a270ab00ce6c273d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal986dce9114ddce94a270ab00ce6c273d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.badge','data' => ['color' => $color,'icon' => $icon,'iconPosition' => $iconPosition]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($color),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($icon),'icon-position' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($iconPosition)]); ?>
                                <?php echo e($formattedState); ?>

                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal986dce9114ddce94a270ab00ce6c273d)): ?>
<?php $attributes = $__attributesOriginal986dce9114ddce94a270ab00ce6c273d; ?>
<?php unset($__attributesOriginal986dce9114ddce94a270ab00ce6c273d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal986dce9114ddce94a270ab00ce6c273d)): ?>
<?php $component = $__componentOriginal986dce9114ddce94a270ab00ce6c273d; ?>
<?php unset($__componentOriginal986dce9114ddce94a270ab00ce6c273d); ?>
<?php endif; ?>
                        <?php else: ?>
                            <div
                                class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                    'fi-ta-text-item inline-flex items-center gap-1.5',
                                    'group/item' => $url,
                                    match ($color) {
                                        null, 'gray' => null,
                                        default => 'fi-color-custom',
                                    },
                                    is_string($color) ? "fi-color-{$color}" : null,
                                ]); ?>"
                            >
                                <!--[if BLOCK]><![endif]--><?php if($icon && in_array($iconPosition, [IconPosition::Before, 'before'])): ?>
                                    <?php if (isset($component)) { $__componentOriginalbfc641e0710ce04e5fe02876ffc6f950 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.icon','data' => ['icon' => $icon,'class' => $iconClasses,'style' => $iconStyles]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($icon),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($iconClasses),'style' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($iconStyles)]); ?>
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

                                <span
                                    class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                        'fi-ta-text-item-label',
                                        'group-hover/item:underline group-focus-visible/item:underline' => $url,
                                        'whitespace-normal' => $canWrap,
                                        'line-clamp-[--line-clamp]' => $lineClamp,
                                        match ($size) {
                                            TextColumnSize::ExtraSmall, 'xs' => 'text-xs',
                                            TextColumnSize::Small, 'sm', null => 'text-sm leading-6',
                                            TextColumnSize::Medium, 'base', 'md' => 'text-base',
                                            TextColumnSize::Large, 'lg' => 'text-lg',
                                            default => $size,
                                        },
                                        match ($color) {
                                            null => 'text-gray-950 dark:text-white',
                                            'gray' => 'text-gray-500 dark:text-gray-400',
                                            default => 'text-custom-600 dark:text-custom-400',
                                        },
                                        match ($weight) {
                                            FontWeight::Thin, 'thin' => 'font-thin',
                                            FontWeight::ExtraLight, 'extralight' => 'font-extralight',
                                            FontWeight::Light, 'light' => 'font-light',
                                            FontWeight::Medium, 'medium' => 'font-medium',
                                            FontWeight::SemiBold, 'semibold' => 'font-semibold',
                                            FontWeight::Bold, 'bold' => 'font-bold',
                                            FontWeight::ExtraBold, 'extrabold' => 'font-extrabold',
                                            FontWeight::Black, 'black' => 'font-black',
                                            default => $weight,
                                        },
                                        match ($fontFamily) {
                                            FontFamily::Sans, 'sans' => 'font-sans',
                                            FontFamily::Serif, 'serif' => 'font-serif',
                                            FontFamily::Mono, 'mono' => 'font-mono',
                                            default => $fontFamily,
                                        },
                                    ]); ?>"
                                    style="<?php echo \Illuminate\Support\Arr::toCssStyles([
                                        \Filament\Support\get_color_css_variables(
                                            $color,
                                            shades: [400, 600],
                                            alias: 'tables::columns.text-column.item.label',
                                        ) => ! in_array($color, [null, 'gray']),
                                        "--line-clamp: {$lineClamp}" => $lineClamp,
                                    ]) ?>"
                                >
                                    <?php echo e($formattedState); ?>

                                </span>

                                <!--[if BLOCK]><![endif]--><?php if($icon && in_array($iconPosition, [IconPosition::After, 'after'])): ?>
                                    <?php if (isset($component)) { $__componentOriginalbfc641e0710ce04e5fe02876ffc6f950 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.icon','data' => ['icon' => $icon,'class' => $iconClasses,'style' => $iconStyles]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($icon),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($iconClasses),'style' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($iconStyles)]); ?>
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
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </<?php echo e($isListWithLineBreaks ? 'li' : 'div'); ?>>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

            <!--[if BLOCK]><![endif]--><?php if($limitedArrayStateCount ?? 0): ?>
                <<?php echo e($isListWithLineBreaks ? 'li' : 'div'); ?>>
                    <!--[if BLOCK]><![endif]--><?php if($isLimitedListExpandable): ?>
                        <?php if (isset($component)) { $__componentOriginal549c94d872270b69c72bdf48cb183bc9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal549c94d872270b69c72bdf48cb183bc9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.link','data' => ['color' => 'gray','tag' => 'button','xOn:click.prevent' => 'isLimited = false','xShow' => 'isLimited']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => 'gray','tag' => 'button','x-on:click.prevent' => 'isLimited = false','x-show' => 'isLimited']); ?>
                            <?php echo e(trans_choice('filament-tables::table.columns.text.actions.expand_list', $limitedArrayStateCount)); ?>

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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.link','data' => ['color' => 'gray','tag' => 'button','xCloak' => true,'xOn:click.prevent' => 'isLimited = true','xShow' => '! isLimited']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => 'gray','tag' => 'button','x-cloak' => true,'x-on:click.prevent' => 'isLimited = true','x-show' => '! isLimited']); ?>
                            <?php echo e(trans_choice('filament-tables::table.columns.text.actions.collapse_list', $limitedArrayStateCount)); ?>

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
                    <?php else: ?>
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            <?php echo e(trans_choice('filament-tables::table.columns.text.more_list_items', $limitedArrayStateCount)); ?>

                        </span>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </<?php echo e($isListWithLineBreaks ? 'li' : 'div'); ?>>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </<?php echo e($isListWithLineBreaks ? 'ul' : 'div'); ?>>

        <!--[if BLOCK]><![endif]--><?php if(filled($descriptionBelow)): ?>
            <p
                class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                    'text-sm text-gray-500 dark:text-gray-400',
                    'whitespace-normal' => $canWrap,
                ]); ?>"
            >
                <?php echo e($descriptionBelow); ?>

            </p>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    <?php elseif(($placeholder = $getPlaceholder()) !== null): ?>
        <?php if (isset($component)) { $__componentOriginal2078c004f342b84f8f2b0f2ab3478754 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2078c004f342b84f8f2b0f2ab3478754 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.columns.placeholder','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::columns.placeholder'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
            <?php echo e($placeholder); ?>

         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2078c004f342b84f8f2b0f2ab3478754)): ?>
<?php $attributes = $__attributesOriginal2078c004f342b84f8f2b0f2ab3478754; ?>
<?php unset($__attributesOriginal2078c004f342b84f8f2b0f2ab3478754); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2078c004f342b84f8f2b0f2ab3478754)): ?>
<?php $component = $__componentOriginal2078c004f342b84f8f2b0f2ab3478754; ?>
<?php unset($__componentOriginal2078c004f342b84f8f2b0f2ab3478754); ?>
<?php endif; ?>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\tables\src\/../resources/views/columns/text-column.blade.php ENDPATH**/ ?>