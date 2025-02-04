<?php
    use Filament\Support\Enums\IconPosition;
    use Filament\Support\Facades\FilamentView;

    $chartColor = $getChartColor() ?? 'gray';
    $descriptionColor = $getDescriptionColor() ?? 'gray';
    $descriptionIcon = $getDescriptionIcon();
    $descriptionIconPosition = $getDescriptionIconPosition();
    $url = $getUrl();
    $tag = $url ? 'a' : 'div';
    $dataChecksum = $generateDataChecksum();

    $descriptionIconClasses = \Illuminate\Support\Arr::toCssClasses([
        'fi-wi-stats-overview-stat-description-icon h-5 w-5',
        match ($descriptionColor) {
            'gray' => 'text-gray-400 dark:text-gray-500',
            default => 'text-custom-500',
        },
    ]);

    $descriptionIconStyles = \Illuminate\Support\Arr::toCssStyles([
        \Filament\Support\get_color_css_variables(
            $descriptionColor,
            shades: [500],
            alias: 'widgets::stats-overview-widget.stat.description.icon',
        ) => $descriptionColor !== 'gray',
    ]);
?>

<<?php echo $tag; ?>

    <?php if($url): ?>
        <?php echo e(\Filament\Support\generate_href_html($url, $shouldOpenUrlInNewTab())); ?>

    <?php endif; ?>
    <?php echo e($getExtraAttributeBag()
            ->class([
                'fi-wi-stats-overview-stat relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10',
            ])); ?>

>
    <div class="grid gap-y-2">
        <div class="flex items-center gap-x-2">
            <!--[if BLOCK]><![endif]--><?php if($icon = $getIcon()): ?>
                <?php if (isset($component)) { $__componentOriginalbfc641e0710ce04e5fe02876ffc6f950 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.icon','data' => ['icon' => $icon,'class' => 'fi-wi-stats-overview-stat-icon h-5 w-5 text-gray-400 dark:text-gray-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($icon),'class' => 'fi-wi-stats-overview-stat-icon h-5 w-5 text-gray-400 dark:text-gray-500']); ?>
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
                class="fi-wi-stats-overview-stat-label text-sm font-medium text-gray-500 dark:text-gray-400"
            >
                <?php echo e($getLabel()); ?>

            </span>
        </div>

        <div
            class="fi-wi-stats-overview-stat-value text-3xl font-semibold tracking-tight text-gray-950 dark:text-white"
        >
            <?php echo e($getValue()); ?>

        </div>

        <!--[if BLOCK]><![endif]--><?php if($description = $getDescription()): ?>
            <div class="flex items-center gap-x-1">
                <!--[if BLOCK]><![endif]--><?php if($descriptionIcon && in_array($descriptionIconPosition, [IconPosition::Before, 'before'])): ?>
                    <?php if (isset($component)) { $__componentOriginalbfc641e0710ce04e5fe02876ffc6f950 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.icon','data' => ['icon' => $descriptionIcon,'class' => $descriptionIconClasses,'style' => $descriptionIconStyles]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($descriptionIcon),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($descriptionIconClasses),'style' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($descriptionIconStyles)]); ?>
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
                        'fi-wi-stats-overview-stat-description text-sm',
                        match ($descriptionColor) {
                            'gray' => 'text-gray-500 dark:text-gray-400',
                            default => 'fi-color-custom text-custom-600 dark:text-custom-400',
                        },
                        is_string($descriptionColor) ? "fi-color-{$descriptionColor}" : null,
                    ]); ?>"
                    style="<?php echo \Illuminate\Support\Arr::toCssStyles([
                        \Filament\Support\get_color_css_variables(
                            $descriptionColor,
                            shades: [400, 600],
                            alias: 'widgets::stats-overview-widget.stat.description',
                        ) => $descriptionColor !== 'gray',
                    ]) ?>"
                >
                    <?php echo e($description); ?>

                </span>

                <!--[if BLOCK]><![endif]--><?php if($descriptionIcon && in_array($descriptionIconPosition, [IconPosition::After, 'after'])): ?>
                    <?php if (isset($component)) { $__componentOriginalbfc641e0710ce04e5fe02876ffc6f950 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.icon','data' => ['icon' => $descriptionIcon,'class' => $descriptionIconClasses,'style' => $descriptionIconStyles]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($descriptionIcon),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($descriptionIconClasses),'style' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($descriptionIconStyles)]); ?>
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
    </div>

    <!--[if BLOCK]><![endif]--><?php if($chart = $getChart()): ?>
        
        <div x-data="{ statsOverviewStatChart: function () {} }">
            <div
                <?php if(FilamentView::hasSpaMode()): ?>
                    ax-load="visible"
                <?php else: ?>
                    ax-load
                <?php endif; ?>
                ax-load-src="<?php echo e(\Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('stats-overview/stat/chart', 'filament/widgets')); ?>"
                x-data="statsOverviewStatChart({
                            dataChecksum: <?php echo \Illuminate\Support\Js::from($dataChecksum)->toHtml() ?>,
                            labels: <?php echo \Illuminate\Support\Js::from(array_keys($chart))->toHtml() ?>,
                            values: <?php echo \Illuminate\Support\Js::from(array_values($chart))->toHtml() ?>,
                        })"
                class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                    'fi-wi-stats-overview-stat-chart absolute inset-x-0 bottom-0 overflow-hidden rounded-b-xl',
                    match ($chartColor) {
                        'gray' => null,
                        default => 'fi-color-custom',
                    },
                    is_string($chartColor) ? "fi-color-{$chartColor}" : null,
                ]); ?>"
                style="<?php echo \Illuminate\Support\Arr::toCssStyles([
                    \Filament\Support\get_color_css_variables(
                        $chartColor,
                        shades: [50, 400, 500],
                        alias: 'widgets::stats-overview-widget.stat.chart',
                    ) => $chartColor !== 'gray',
                ]) ?>"
            >
                <canvas x-ref="canvas" class="h-6"></canvas>

                <span
                    x-ref="backgroundColorElement"
                    class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                        match ($chartColor) {
                            'gray' => 'text-gray-100 dark:text-gray-800',
                            default => 'text-custom-50 dark:text-custom-400/10',
                        },
                    ]); ?>"
                ></span>

                <span
                    x-ref="borderColorElement"
                    class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                        match ($chartColor) {
                            'gray' => 'text-gray-400',
                            default => 'text-custom-500 dark:text-custom-400',
                        },
                    ]); ?>"
                ></span>
            </div>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</<?php echo $tag; ?>>
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\widgets\src\/../resources/views/stats-overview-widget/stat.blade.php ENDPATH**/ ?>