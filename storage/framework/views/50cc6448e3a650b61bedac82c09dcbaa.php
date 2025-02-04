<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'fullHeight' => false,
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
    'fullHeight' => false,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    use Filament\Pages\SubNavigationPosition;

    $subNavigation = $this->getCachedSubNavigation();
    $subNavigationPosition = $this->getSubNavigationPosition();
    $widgetData = $this->getWidgetData();
?>

<div
    <?php echo e($attributes->class([
            'fi-page',
            'h-full' => $fullHeight,
        ])); ?>

>
    <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::PAGE_START, scopes: $this->getRenderHookScopes())); ?>


    <section
        class="<?php echo \Illuminate\Support\Arr::toCssClasses([
            'flex flex-col gap-y-8 py-8',
            'h-full' => $fullHeight,
        ]); ?>"
    >
        <!--[if BLOCK]><![endif]--><?php if($header = $this->getHeader()): ?>
            <?php echo e($header); ?>

        <?php elseif($heading = $this->getHeading()): ?>
            <?php
                $subheading = $this->getSubheading();
            ?>

            <?php if (isset($component)) { $__componentOriginal4af1e0a8ab5c0dda93279f6800da3911 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4af1e0a8ab5c0dda93279f6800da3911 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.header.index','data' => ['actions' => $this->getCachedHeaderActions(),'breadcrumbs' => filament()->hasBreadcrumbs() ? $this->getBreadcrumbs() : [],'heading' => $heading,'subheading' => $subheading]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['actions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($this->getCachedHeaderActions()),'breadcrumbs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(filament()->hasBreadcrumbs() ? $this->getBreadcrumbs() : []),'heading' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($heading),'subheading' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($subheading)]); ?>
                <!--[if BLOCK]><![endif]--><?php if($heading instanceof \Illuminate\Contracts\Support\Htmlable): ?>
                     <?php $__env->slot('heading', null, []); ?> 
                        <?php echo e($heading); ?>

                     <?php $__env->endSlot(); ?>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <!--[if BLOCK]><![endif]--><?php if($subheading instanceof \Illuminate\Contracts\Support\Htmlable): ?>
                     <?php $__env->slot('subheading', null, []); ?> 
                        <?php echo e($subheading); ?>

                     <?php $__env->endSlot(); ?>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4af1e0a8ab5c0dda93279f6800da3911)): ?>
<?php $attributes = $__attributesOriginal4af1e0a8ab5c0dda93279f6800da3911; ?>
<?php unset($__attributesOriginal4af1e0a8ab5c0dda93279f6800da3911); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4af1e0a8ab5c0dda93279f6800da3911)): ?>
<?php $component = $__componentOriginal4af1e0a8ab5c0dda93279f6800da3911; ?>
<?php unset($__componentOriginal4af1e0a8ab5c0dda93279f6800da3911); ?>
<?php endif; ?>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <div
            class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                'flex flex-col gap-8' => $subNavigation,
                match ($subNavigationPosition) {
                    SubNavigationPosition::Start, SubNavigationPosition::End => 'md:flex-row md:items-start',
                    default => null,
                } => $subNavigation,
                'h-full' => $fullHeight,
            ]); ?>"
        >
            <!--[if BLOCK]><![endif]--><?php if($subNavigation): ?>
                <div class="contents md:hidden">
                    <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::PAGE_SUB_NAVIGATION_SELECT_BEFORE, scopes: $this->getRenderHookScopes())); ?>

                </div>

                <?php if (isset($component)) { $__componentOriginal3fc6eb3fff6868bf8dfabef4dddb45c1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3fc6eb3fff6868bf8dfabef4dddb45c1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.page.sub-navigation.select','data' => ['navigation' => $subNavigation]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::page.sub-navigation.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['navigation' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($subNavigation)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3fc6eb3fff6868bf8dfabef4dddb45c1)): ?>
<?php $attributes = $__attributesOriginal3fc6eb3fff6868bf8dfabef4dddb45c1; ?>
<?php unset($__attributesOriginal3fc6eb3fff6868bf8dfabef4dddb45c1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3fc6eb3fff6868bf8dfabef4dddb45c1)): ?>
<?php $component = $__componentOriginal3fc6eb3fff6868bf8dfabef4dddb45c1; ?>
<?php unset($__componentOriginal3fc6eb3fff6868bf8dfabef4dddb45c1); ?>
<?php endif; ?>

                <div class="contents md:hidden">
                    <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::PAGE_SUB_NAVIGATION_SELECT_AFTER, scopes: $this->getRenderHookScopes())); ?>

                </div>

                <!--[if BLOCK]><![endif]--><?php if($subNavigationPosition === SubNavigationPosition::Start): ?>
                    <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::PAGE_SUB_NAVIGATION_START_BEFORE, scopes: $this->getRenderHookScopes())); ?>


                    <?php if (isset($component)) { $__componentOriginal57dd3516f8d124ccafb2ae72c664c7c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal57dd3516f8d124ccafb2ae72c664c7c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.page.sub-navigation.sidebar','data' => ['navigation' => $subNavigation]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::page.sub-navigation.sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['navigation' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($subNavigation)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal57dd3516f8d124ccafb2ae72c664c7c3)): ?>
<?php $attributes = $__attributesOriginal57dd3516f8d124ccafb2ae72c664c7c3; ?>
<?php unset($__attributesOriginal57dd3516f8d124ccafb2ae72c664c7c3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal57dd3516f8d124ccafb2ae72c664c7c3)): ?>
<?php $component = $__componentOriginal57dd3516f8d124ccafb2ae72c664c7c3; ?>
<?php unset($__componentOriginal57dd3516f8d124ccafb2ae72c664c7c3); ?>
<?php endif; ?>

                    <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::PAGE_SUB_NAVIGATION_START_AFTER, scopes: $this->getRenderHookScopes())); ?>

                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <!--[if BLOCK]><![endif]--><?php if($subNavigationPosition === SubNavigationPosition::Top): ?>
                    <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::PAGE_SUB_NAVIGATION_TOP_BEFORE, scopes: $this->getRenderHookScopes())); ?>


                    <?php if (isset($component)) { $__componentOriginala59fd7cea3e42dfea7d868b466385a01 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala59fd7cea3e42dfea7d868b466385a01 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.page.sub-navigation.tabs','data' => ['navigation' => $subNavigation]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::page.sub-navigation.tabs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['navigation' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($subNavigation)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala59fd7cea3e42dfea7d868b466385a01)): ?>
<?php $attributes = $__attributesOriginala59fd7cea3e42dfea7d868b466385a01; ?>
<?php unset($__attributesOriginala59fd7cea3e42dfea7d868b466385a01); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala59fd7cea3e42dfea7d868b466385a01)): ?>
<?php $component = $__componentOriginala59fd7cea3e42dfea7d868b466385a01; ?>
<?php unset($__componentOriginala59fd7cea3e42dfea7d868b466385a01); ?>
<?php endif; ?>

                    <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::PAGE_SUB_NAVIGATION_TOP_AFTER, scopes: $this->getRenderHookScopes())); ?>

                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            <div
                class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                    'grid flex-1 auto-cols-fr gap-y-8',
                    'h-full' => $fullHeight,
                ]); ?>"
            >
                <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::PAGE_HEADER_WIDGETS_BEFORE, scopes: $this->getRenderHookScopes())); ?>


                <!--[if BLOCK]><![endif]--><?php if($headerWidgets = $this->getVisibleHeaderWidgets()): ?>
                    <?php if (isset($component)) { $__componentOriginal7259e9ea993f43cfa75aaa166dfee38d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7259e9ea993f43cfa75aaa166dfee38d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-widgets::components.widgets','data' => ['columns' => $this->getHeaderWidgetsColumns(),'data' => $widgetData,'widgets' => $headerWidgets,'class' => 'fi-page-header-widgets']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-widgets::widgets'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['columns' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($this->getHeaderWidgetsColumns()),'data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($widgetData),'widgets' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($headerWidgets),'class' => 'fi-page-header-widgets']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7259e9ea993f43cfa75aaa166dfee38d)): ?>
<?php $attributes = $__attributesOriginal7259e9ea993f43cfa75aaa166dfee38d; ?>
<?php unset($__attributesOriginal7259e9ea993f43cfa75aaa166dfee38d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7259e9ea993f43cfa75aaa166dfee38d)): ?>
<?php $component = $__componentOriginal7259e9ea993f43cfa75aaa166dfee38d; ?>
<?php unset($__componentOriginal7259e9ea993f43cfa75aaa166dfee38d); ?>
<?php endif; ?>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::PAGE_HEADER_WIDGETS_AFTER, scopes: $this->getRenderHookScopes())); ?>


                <?php echo e($slot); ?>


                <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::PAGE_FOOTER_WIDGETS_BEFORE, scopes: $this->getRenderHookScopes())); ?>


                <!--[if BLOCK]><![endif]--><?php if($footerWidgets = $this->getVisibleFooterWidgets()): ?>
                    <?php if (isset($component)) { $__componentOriginal7259e9ea993f43cfa75aaa166dfee38d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7259e9ea993f43cfa75aaa166dfee38d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-widgets::components.widgets','data' => ['columns' => $this->getFooterWidgetsColumns(),'data' => $widgetData,'widgets' => $footerWidgets,'class' => 'fi-page-footer-widgets']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-widgets::widgets'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['columns' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($this->getFooterWidgetsColumns()),'data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($widgetData),'widgets' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($footerWidgets),'class' => 'fi-page-footer-widgets']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7259e9ea993f43cfa75aaa166dfee38d)): ?>
<?php $attributes = $__attributesOriginal7259e9ea993f43cfa75aaa166dfee38d; ?>
<?php unset($__attributesOriginal7259e9ea993f43cfa75aaa166dfee38d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7259e9ea993f43cfa75aaa166dfee38d)): ?>
<?php $component = $__componentOriginal7259e9ea993f43cfa75aaa166dfee38d; ?>
<?php unset($__componentOriginal7259e9ea993f43cfa75aaa166dfee38d); ?>
<?php endif; ?>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::PAGE_FOOTER_WIDGETS_AFTER, scopes: $this->getRenderHookScopes())); ?>

            </div>

            <!--[if BLOCK]><![endif]--><?php if($subNavigation && $subNavigationPosition === SubNavigationPosition::End): ?>
                <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::PAGE_SUB_NAVIGATION_END_BEFORE, scopes: $this->getRenderHookScopes())); ?>


                <?php if (isset($component)) { $__componentOriginal57dd3516f8d124ccafb2ae72c664c7c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal57dd3516f8d124ccafb2ae72c664c7c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.page.sub-navigation.sidebar','data' => ['navigation' => $subNavigation]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::page.sub-navigation.sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['navigation' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($subNavigation)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal57dd3516f8d124ccafb2ae72c664c7c3)): ?>
<?php $attributes = $__attributesOriginal57dd3516f8d124ccafb2ae72c664c7c3; ?>
<?php unset($__attributesOriginal57dd3516f8d124ccafb2ae72c664c7c3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal57dd3516f8d124ccafb2ae72c664c7c3)): ?>
<?php $component = $__componentOriginal57dd3516f8d124ccafb2ae72c664c7c3; ?>
<?php unset($__componentOriginal57dd3516f8d124ccafb2ae72c664c7c3); ?>
<?php endif; ?>

                <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::PAGE_SUB_NAVIGATION_END_AFTER, scopes: $this->getRenderHookScopes())); ?>

            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        <!--[if BLOCK]><![endif]--><?php if($footer = $this->getFooter()): ?>
            <?php echo e($footer); ?>

        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </section>

    <!--[if BLOCK]><![endif]--><?php if(! ($this instanceof \Filament\Tables\Contracts\HasTable)): ?>
        <?php if (isset($component)) { $__componentOriginal028e05680f6c5b1e293abd7fbe5f9758 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal028e05680f6c5b1e293abd7fbe5f9758 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-actions::components.modals','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-actions::modals'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal028e05680f6c5b1e293abd7fbe5f9758)): ?>
<?php $attributes = $__attributesOriginal028e05680f6c5b1e293abd7fbe5f9758; ?>
<?php unset($__attributesOriginal028e05680f6c5b1e293abd7fbe5f9758); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal028e05680f6c5b1e293abd7fbe5f9758)): ?>
<?php $component = $__componentOriginal028e05680f6c5b1e293abd7fbe5f9758; ?>
<?php unset($__componentOriginal028e05680f6c5b1e293abd7fbe5f9758); ?>
<?php endif; ?>
    <?php elseif($this->isTableLoaded() && filled($this->defaultTableAction)): ?>
        <div
            wire:init="mountTableAction(<?php echo \Illuminate\Support\Js::from($this->defaultTableAction)->toHtml() ?>, <?php if(filled($this->defaultTableActionRecord)): ?> <?php echo \Illuminate\Support\Js::from($this->defaultTableActionRecord)->toHtml() ?> <?php else: ?> <?php echo e('null'); ?> <?php endif; ?> <?php if(filled($this->defaultTableActionArguments)): ?> , <?php echo \Illuminate\Support\Js::from($this->defaultTableActionArguments)->toHtml() ?> <?php endif; ?>)"
        ></div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!--[if BLOCK]><![endif]--><?php if(filled($this->defaultAction)): ?>
        <div
            wire:init="mountAction(<?php echo \Illuminate\Support\Js::from($this->defaultAction)->toHtml() ?> <?php if(filled($this->defaultActionArguments)): ?> , <?php echo \Illuminate\Support\Js::from($this->defaultActionArguments)->toHtml() ?> <?php endif; ?>)"
        ></div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::PAGE_END, scopes: $this->getRenderHookScopes())); ?>


    <?php if (isset($component)) { $__componentOriginal29f738301ffa464f2646caa32428c50f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal29f738301ffa464f2646caa32428c50f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.unsaved-action-changes-alert','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::unsaved-action-changes-alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal29f738301ffa464f2646caa32428c50f)): ?>
<?php $attributes = $__attributesOriginal29f738301ffa464f2646caa32428c50f; ?>
<?php unset($__attributesOriginal29f738301ffa464f2646caa32428c50f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal29f738301ffa464f2646caa32428c50f)): ?>
<?php $component = $__componentOriginal29f738301ffa464f2646caa32428c50f; ?>
<?php unset($__componentOriginal29f738301ffa464f2646caa32428c50f); ?>
<?php endif; ?>
</div>
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\filament\src\/../resources/views/components/page/index.blade.php ENDPATH**/ ?>