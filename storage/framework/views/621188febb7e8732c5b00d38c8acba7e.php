<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'active' => false,
    'collapsible' => true,
    'icon' => null,
    'items' => [],
    'label' => null,
    'sidebarCollapsible' => true,
    'subNavigation' => false,
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
    'collapsible' => true,
    'icon' => null,
    'items' => [],
    'label' => null,
    'sidebarCollapsible' => true,
    'subNavigation' => false,
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
    $hasDropdown = filled($label) && filled($icon) && $sidebarCollapsible;
?>

<li
    x-data="{ label: <?php echo \Illuminate\Support\Js::from($subNavigation ? "sub_navigation_{$label}" : $label)->toHtml() ?> }"
    data-group-label="<?php echo e($subNavigation ? "sub_navigation_{$label}" : $label); ?>"
    <?php echo e($attributes->class([
            'fi-sidebar-group flex flex-col gap-y-1',
            'fi-active' => $active,
        ])); ?>

>
    <?php if($label): ?>
        <div
            <?php if($collapsible): ?>
                x-on:click="$store.sidebar.toggleCollapsedGroup(label)"
            <?php endif; ?>
            <?php if($sidebarCollapsible): ?>
                x-show="$store.sidebar.isOpen"
                x-transition:enter="delay-100 lg:transition"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
            <?php endif; ?>
            class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                'fi-sidebar-group-button flex items-center gap-x-3 px-2 py-2',
                'cursor-pointer' => $collapsible,
            ]); ?>"
        >
            <?php if($icon): ?>
                <?php if (isset($component)) { $__componentOriginalbfc641e0710ce04e5fe02876ffc6f950 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.icon','data' => ['icon' => $icon,'class' => 'fi-sidebar-group-icon h-6 w-6 text-gray-400 dark:text-gray-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($icon),'class' => 'fi-sidebar-group-icon h-6 w-6 text-gray-400 dark:text-gray-500']); ?>
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

            <span
                class="fi-sidebar-group-label flex-1 text-sm font-medium leading-6 text-gray-500 dark:text-gray-400"
            >
                <?php echo e($label); ?>

            </span>

            <?php if($collapsible): ?>
                <?php if (isset($component)) { $__componentOriginalf0029cce6d19fd6d472097ff06a800a1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf0029cce6d19fd6d472097ff06a800a1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.icon-button','data' => ['color' => 'gray','icon' => 'heroicon-m-chevron-up','iconAlias' => 'panels::sidebar.group.collapse-button','label' => $label,'xBind:ariaExpanded' => '! $store.sidebar.groupIsCollapsed(label)','xOn:click.stop' => '$store.sidebar.toggleCollapsedGroup(label)','class' => 'fi-sidebar-group-collapse-button','xBind:class' => '{ \'-rotate-180\': $store.sidebar.groupIsCollapsed(label) }']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::icon-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => 'gray','icon' => 'heroicon-m-chevron-up','icon-alias' => 'panels::sidebar.group.collapse-button','label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($label),'x-bind:aria-expanded' => '! $store.sidebar.groupIsCollapsed(label)','x-on:click.stop' => '$store.sidebar.toggleCollapsedGroup(label)','class' => 'fi-sidebar-group-collapse-button','x-bind:class' => '{ \'-rotate-180\': $store.sidebar.groupIsCollapsed(label) }']); ?>
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
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if($hasDropdown): ?>
        <?php if (isset($component)) { $__componentOriginal22ab0dbc2c6619d5954111bba06f01db = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal22ab0dbc2c6619d5954111bba06f01db = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.dropdown.index','data' => ['placement' => (__('filament-panels::layout.direction') === 'rtl') ? 'left-start' : 'right-start','teleport' => true,'xShow' => '! $store.sidebar.isOpen']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::dropdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['placement' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute((__('filament-panels::layout.direction') === 'rtl') ? 'left-start' : 'right-start'),'teleport' => true,'x-show' => '! $store.sidebar.isOpen']); ?>
             <?php $__env->slot('trigger', null, []); ?> 
                <button
                    x-data="{ tooltip: false }"
                    x-effect="
                        tooltip = $store.sidebar.isOpen
                            ? false
                            : {
                                  content: <?php echo \Illuminate\Support\Js::from($label)->toHtml() ?>,
                                  placement: document.dir === 'rtl' ? 'left' : 'right',
                                  theme: $store.theme,
                              }
                    "
                    x-tooltip.html="tooltip"
                    class="relative flex flex-1 items-center justify-center gap-x-3 rounded-lg px-2 py-2 outline-none transition duration-75 hover:bg-gray-100 focus-visible:bg-gray-100 dark:hover:bg-white/5 dark:focus-visible:bg-white/5"
                >
                    <?php if (isset($component)) { $__componentOriginalbfc641e0710ce04e5fe02876ffc6f950 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.icon','data' => ['icon' => $icon,'class' => \Illuminate\Support\Arr::toCssClasses([
                            'h-6 w-6',
                            'text-gray-400 dark:text-gray-500' => ! $active,
                            'text-primary-600 dark:text-primary-400' => $active,
                        ])]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($icon),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\Illuminate\Support\Arr::toCssClasses([
                            'h-6 w-6',
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
                </button>
             <?php $__env->endSlot(); ?>

            <?php
                $lists = [];

                foreach ($items as $item) {
                    if ($childItems = $item->getChildItems()) {
                        $lists[] = [
                            $item,
                            ...$childItems,
                        ];
                        $lists[] = [];

                        continue;
                    }

                    if (empty($lists)) {
                        $lists[] = [$item];

                        continue;
                    }

                    $lists[count($lists) - 1][] = $item;
                }

                if (empty($lists[count($lists) - 1])) {
                    array_pop($lists);
                }
            ?>

            <?php if(filled($label)): ?>
                <?php if (isset($component)) { $__componentOriginal7a83b62094aac4ed8d85f403cf23f250 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7a83b62094aac4ed8d85f403cf23f250 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.dropdown.header','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::dropdown.header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                    <?php echo e($label); ?>

                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7a83b62094aac4ed8d85f403cf23f250)): ?>
<?php $attributes = $__attributesOriginal7a83b62094aac4ed8d85f403cf23f250; ?>
<?php unset($__attributesOriginal7a83b62094aac4ed8d85f403cf23f250); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7a83b62094aac4ed8d85f403cf23f250)): ?>
<?php $component = $__componentOriginal7a83b62094aac4ed8d85f403cf23f250; ?>
<?php unset($__componentOriginal7a83b62094aac4ed8d85f403cf23f250); ?>
<?php endif; ?>
            <?php endif; ?>

            <?php $__currentLoopData = $lists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if (isset($component)) { $__componentOriginal66687bf0670b9e16f61e667468dc8983 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal66687bf0670b9e16f61e667468dc8983 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.dropdown.list.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::dropdown.list'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                    <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $itemIsActive = $item->isActive();
                        ?>

                        <?php if (isset($component)) { $__componentOriginal1bd4d8e254cc40cdb05bd99df3e63f78 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1bd4d8e254cc40cdb05bd99df3e63f78 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.dropdown.list.item','data' => ['badge' => $item->getBadge(),'badgeColor' => $item->getBadgeColor(),'badgeTooltip' => $item->getBadgeTooltip(),'color' => $itemIsActive ? 'primary' : 'gray','href' => $item->getUrl(),'icon' => $itemIsActive ? ($item->getActiveIcon() ?? $item->getIcon()) : $item->getIcon(),'tag' => 'a','target' => $item->shouldOpenUrlInNewTab() ? '_blank' : null]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::dropdown.list.item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['badge' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item->getBadge()),'badge-color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item->getBadgeColor()),'badge-tooltip' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item->getBadgeTooltip()),'color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($itemIsActive ? 'primary' : 'gray'),'href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item->getUrl()),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($itemIsActive ? ($item->getActiveIcon() ?? $item->getIcon()) : $item->getIcon()),'tag' => 'a','target' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item->shouldOpenUrlInNewTab() ? '_blank' : null)]); ?>
                            <?php echo e($item->getLabel()); ?>

                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1bd4d8e254cc40cdb05bd99df3e63f78)): ?>
<?php $attributes = $__attributesOriginal1bd4d8e254cc40cdb05bd99df3e63f78; ?>
<?php unset($__attributesOriginal1bd4d8e254cc40cdb05bd99df3e63f78); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1bd4d8e254cc40cdb05bd99df3e63f78)): ?>
<?php $component = $__componentOriginal1bd4d8e254cc40cdb05bd99df3e63f78; ?>
<?php unset($__componentOriginal1bd4d8e254cc40cdb05bd99df3e63f78); ?>
<?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal66687bf0670b9e16f61e667468dc8983)): ?>
<?php $attributes = $__attributesOriginal66687bf0670b9e16f61e667468dc8983; ?>
<?php unset($__attributesOriginal66687bf0670b9e16f61e667468dc8983); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal66687bf0670b9e16f61e667468dc8983)): ?>
<?php $component = $__componentOriginal66687bf0670b9e16f61e667468dc8983; ?>
<?php unset($__componentOriginal66687bf0670b9e16f61e667468dc8983); ?>
<?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal22ab0dbc2c6619d5954111bba06f01db)): ?>
<?php $attributes = $__attributesOriginal22ab0dbc2c6619d5954111bba06f01db; ?>
<?php unset($__attributesOriginal22ab0dbc2c6619d5954111bba06f01db); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal22ab0dbc2c6619d5954111bba06f01db)): ?>
<?php $component = $__componentOriginal22ab0dbc2c6619d5954111bba06f01db; ?>
<?php unset($__componentOriginal22ab0dbc2c6619d5954111bba06f01db); ?>
<?php endif; ?>
    <?php endif; ?>

    <ul
        <?php if(filled($label)): ?>
            <?php if($sidebarCollapsible): ?>
                x-show="$store.sidebar.isOpen ? ! $store.sidebar.groupIsCollapsed(label) : ! <?php echo \Illuminate\Support\Js::from($hasDropdown)->toHtml() ?>"
            <?php else: ?>
                x-show="! $store.sidebar.groupIsCollapsed(label)"
            <?php endif; ?>
            x-collapse.duration.200ms
        <?php endif; ?>
        <?php if($sidebarCollapsible): ?>
            x-transition:enter="delay-100 lg:transition"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
        <?php endif; ?>
        class="fi-sidebar-group-items flex flex-col gap-y-1"
    >
        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $itemIcon = $item->getIcon();
                $itemActiveIcon = $item->getActiveIcon();

                if ($icon) {
                    if ($hasDropdown || (blank($itemIcon) && blank($itemActiveIcon))) {
                        $itemIcon = null;
                        $itemActiveIcon = null;
                    } else {
                        throw new \Exception('Navigation group [' . $label . '] has an icon but one or more of its items also have icons. Either the group or its items can have icons, but not both. This is to ensure a proper user experience.');
                    }
                }
            ?>

            <?php if (isset($component)) { $__componentOriginal7edbc33aaa546e1feb86647dcd0e4eb8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7edbc33aaa546e1feb86647dcd0e4eb8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.sidebar.item','data' => ['active' => $item->isActive(),'activeChildItems' => $item->isChildItemsActive(),'activeIcon' => $itemActiveIcon,'badge' => $item->getBadge(),'badgeColor' => $item->getBadgeColor(),'badgeTooltip' => $item->getBadgeTooltip(),'childItems' => $item->getChildItems(),'first' => $loop->first,'grouped' => filled($label),'icon' => $itemIcon,'last' => $loop->last,'shouldOpenUrlInNewTab' => $item->shouldOpenUrlInNewTab(),'sidebarCollapsible' => $sidebarCollapsible,'url' => $item->getUrl()]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::sidebar.item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item->isActive()),'active-child-items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item->isChildItemsActive()),'active-icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($itemActiveIcon),'badge' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item->getBadge()),'badge-color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item->getBadgeColor()),'badge-tooltip' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item->getBadgeTooltip()),'child-items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item->getChildItems()),'first' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($loop->first),'grouped' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(filled($label)),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($itemIcon),'last' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($loop->last),'should-open-url-in-new-tab' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item->shouldOpenUrlInNewTab()),'sidebar-collapsible' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($sidebarCollapsible),'url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item->getUrl())]); ?>
                <?php echo e($item->getLabel()); ?>


                <?php if($itemIcon instanceof \Illuminate\Contracts\Support\Htmlable): ?>
                     <?php $__env->slot('icon', null, []); ?> 
                        <?php echo e($itemIcon); ?>

                     <?php $__env->endSlot(); ?>
                <?php endif; ?>

                <?php if($itemActiveIcon instanceof \Illuminate\Contracts\Support\Htmlable): ?>
                     <?php $__env->slot('activeIcon', null, []); ?> 
                        <?php echo e($itemActiveIcon); ?>

                     <?php $__env->endSlot(); ?>
                <?php endif; ?>
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
</li>
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\filament\src\/../resources/views/components/sidebar/group.blade.php ENDPATH**/ ?>