<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'active' => false,
    'activeChildItems' => false,
    'activeIcon' => null,
    'badge' => null,
    'badgeColor' => null,
    'badgeTooltip' => null,
    'childItems' => [],
    'first' => false,
    'grouped' => false,
    'icon' => null,
    'last' => false,
    'shouldOpenUrlInNewTab' => false,
    'sidebarCollapsible' => true,
    'subGrouped' => false,
    'url',
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
    'active' => false,
    'activeChildItems' => false,
    'activeIcon' => null,
    'badge' => null,
    'badgeColor' => null,
    'badgeTooltip' => null,
    'childItems' => [],
    'first' => false,
    'grouped' => false,
    'icon' => null,
    'last' => false,
    'shouldOpenUrlInNewTab' => false,
    'sidebarCollapsible' => true,
    'subGrouped' => false,
    'url',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $sidebarCollapsible = $sidebarCollapsible && filament()->isSidebarCollapsibleOnDesktop();
?>

<li
    <?php echo e($attributes->class([
            'fi-sidebar-item',
            // @deprecated `fi-sidebar-item-active` has been replaced by `fi-active`.
            'fi-active fi-sidebar-item-active' => $active,
            'flex flex-col gap-y-1' => $active || $activeChildItems,
        ])); ?>

>
    <a
        <?php echo e(\Filament\Support\generate_href_html($url, $shouldOpenUrlInNewTab)); ?>

        x-on:click="window.matchMedia(`(max-width: 1024px)`).matches && $store.sidebar.close()"
        <?php if($sidebarCollapsible): ?>
            x-data="{ tooltip: false }"
            x-effect="
                tooltip = $store.sidebar.isOpen
                    ? false
                    : {
                          content: <?php echo \Illuminate\Support\Js::from($slot->toHtml())->toHtml() ?>,
                          placement: document.dir === 'rtl' ? 'left' : 'right',
                          theme: $store.theme,
                      }
            "
            x-tooltip.html="tooltip"
        <?php endif; ?>
        class="<?php echo \Illuminate\Support\Arr::toCssClasses([
            'fi-sidebar-item-button relative flex items-center justify-center gap-x-3 rounded-lg px-2 py-2 outline-none transition duration-75',
            'hover:bg-gray-100 focus-visible:bg-gray-100 dark:hover:bg-white/5 dark:focus-visible:bg-white/5' => filled($url),
            'bg-gray-100 dark:bg-white/5' => $active,
        ]); ?>"
    >
        <?php if(filled($icon) && ((! $subGrouped) || $sidebarCollapsible)): ?>
            <?php if (isset($component)) { $__componentOriginalbfc641e0710ce04e5fe02876ffc6f950 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.icon','data' => ['icon' => ($active && $activeIcon) ? $activeIcon : $icon,'xShow' => ($subGrouped && $sidebarCollapsible) ? '! $store.sidebar.isOpen' : false,'class' => \Illuminate\Support\Arr::toCssClasses([
                    'fi-sidebar-item-icon h-6 w-6',
                    'text-gray-400 dark:text-gray-500' => ! $active,
                    'text-primary-600 dark:text-primary-400' => $active,
                ])]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(($active && $activeIcon) ? $activeIcon : $icon),'x-show' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(($subGrouped && $sidebarCollapsible) ? '! $store.sidebar.isOpen' : false),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\Illuminate\Support\Arr::toCssClasses([
                    'fi-sidebar-item-icon h-6 w-6',
                    'text-gray-400 dark:text-gray-500' => ! $active,
                    'text-primary-600 dark:text-primary-400' => $active,
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
        <?php endif; ?>

        <?php if((blank($icon) && $grouped) || $subGrouped): ?>
            <div
                <?php if(filled($icon) && $subGrouped && $sidebarCollapsible): ?>
                    x-show="$store.sidebar.isOpen"
                <?php endif; ?>
                class="fi-sidebar-item-grouped-border relative flex h-6 w-6 items-center justify-center"
            >
                <?php if(! $first): ?>
                    <div
                        class="absolute -top-1/2 bottom-1/2 w-px bg-gray-300 dark:bg-gray-600"
                    ></div>
                <?php endif; ?>

                <?php if(! $last): ?>
                    <div
                        class="absolute -bottom-1/2 top-1/2 w-px bg-gray-300 dark:bg-gray-600"
                    ></div>
                <?php endif; ?>

                <div
                    class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                        'relative h-1.5 w-1.5 rounded-full',
                        'bg-gray-400 dark:bg-gray-500' => ! $active,
                        'bg-primary-600 dark:bg-primary-400' => $active,
                    ]); ?>"
                ></div>
            </div>
        <?php endif; ?>

        <span
            <?php if($sidebarCollapsible): ?>
                x-show="$store.sidebar.isOpen"
                x-transition:enter="lg:transition lg:delay-100"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
            <?php endif; ?>
            class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                'fi-sidebar-item-label flex-1 truncate text-sm font-medium',
                'text-gray-700 dark:text-gray-200' => ! $active,
                'text-primary-600 dark:text-primary-400' => $active,
            ]); ?>"
        >
            <?php echo e($slot); ?>

        </span>

        <?php if(filled($badge)): ?>
            <span
                <?php if($sidebarCollapsible): ?>
                    x-show="$store.sidebar.isOpen"
                    x-transition:enter="lg:transition lg:delay-100"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                <?php endif; ?>
            >
                <?php if (isset($component)) { $__componentOriginal986dce9114ddce94a270ab00ce6c273d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal986dce9114ddce94a270ab00ce6c273d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.badge','data' => ['color' => $badgeColor,'tooltip' => $badgeTooltip]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($badgeColor),'tooltip' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($badgeTooltip)]); ?>
                    <?php echo e($badge); ?>

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
            </span>
        <?php endif; ?>
    </a>

    <?php if(($active || $activeChildItems) && $childItems): ?>
        <ul class="fi-sidebar-sub-group-items flex flex-col gap-y-1">
            <?php $__currentLoopData = $childItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $childItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if (isset($component)) { $__componentOriginal7edbc33aaa546e1feb86647dcd0e4eb8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7edbc33aaa546e1feb86647dcd0e4eb8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.sidebar.item','data' => ['active' => $childItem->isActive(),'activeChildItems' => $childItem->isChildItemsActive(),'activeIcon' => $childItem->getActiveIcon(),'badge' => $childItem->getBadge(),'badgeColor' => $childItem->getBadgeColor(),'badgeTooltip' => $childItem->getBadgeTooltip(),'first' => $loop->first,'grouped' => true,'icon' => $childItem->getIcon(),'last' => $loop->last,'shouldOpenUrlInNewTab' => $childItem->shouldOpenUrlInNewTab(),'subGrouped' => true,'url' => $childItem->getUrl()]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::sidebar.item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($childItem->isActive()),'active-child-items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($childItem->isChildItemsActive()),'active-icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($childItem->getActiveIcon()),'badge' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($childItem->getBadge()),'badge-color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($childItem->getBadgeColor()),'badge-tooltip' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($childItem->getBadgeTooltip()),'first' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($loop->first),'grouped' => true,'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($childItem->getIcon()),'last' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($loop->last),'should-open-url-in-new-tab' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($childItem->shouldOpenUrlInNewTab()),'sub-grouped' => true,'url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($childItem->getUrl())]); ?>
                    <?php echo e($childItem->getLabel()); ?>

                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7edbc33aaa546e1feb86647dcd0e4eb8)): ?>
<?php $attributes = $__attributesOriginal7edbc33aaa546e1feb86647dcd0e4eb8; ?>
<?php unset($__attributesOriginal7edbc33aaa546e1feb86647dcd0e4eb8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7edbc33aaa546e1feb86647dcd0e4eb8)): ?>
<?php $component = $__componentOriginal7edbc33aaa546e1feb86647dcd0e4eb8; ?>
<?php unset($__componentOriginal7edbc33aaa546e1feb86647dcd0e4eb8); ?>
<?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    <?php endif; ?>
</li>
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\filament\src\/../resources/views/components/sidebar/item.blade.php ENDPATH**/ ?>