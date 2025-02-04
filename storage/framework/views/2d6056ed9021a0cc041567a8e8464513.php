<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'navigation',
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
    'navigation',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $openSidebarClasses = 'fi-sidebar-open w-[--sidebar-width] translate-x-0 shadow-xl ring-1 ring-gray-950/5 dark:ring-white/10 rtl:-translate-x-0';
    $isRtl = __('filament-panels::layout.direction') === 'rtl';
?>


<aside
    x-data="{}"
    <?php if(filament()->isSidebarCollapsibleOnDesktop() && (! filament()->hasTopNavigation())): ?>
        x-cloak
        x-bind:class="
            $store.sidebar.isOpen
                ? <?php echo \Illuminate\Support\Js::from($openSidebarClasses . ' ' . 'lg:sticky')->toHtml() ?>
                : '-translate-x-full rtl:translate-x-full lg:sticky lg:translate-x-0 rtl:lg:-translate-x-0'
        "
    <?php else: ?>
        <?php if(filament()->hasTopNavigation()): ?>
            x-cloak
            x-bind:class="$store.sidebar.isOpen ? <?php echo \Illuminate\Support\Js::from($openSidebarClasses)->toHtml() ?> : '-translate-x-full rtl:translate-x-full'"
        <?php elseif(filament()->isSidebarFullyCollapsibleOnDesktop()): ?>
            x-cloak
            x-bind:class="$store.sidebar.isOpen ? <?php echo \Illuminate\Support\Js::from($openSidebarClasses . ' ' . 'lg:sticky')->toHtml() ?> : '-translate-x-full rtl:translate-x-full'"
        <?php else: ?>
            x-cloak="-lg"
            x-bind:class="
                $store.sidebar.isOpen
                    ? <?php echo \Illuminate\Support\Js::from($openSidebarClasses . ' ' . 'lg:sticky')->toHtml() ?>
                    : 'w-[--sidebar-width] -translate-x-full rtl:translate-x-full lg:sticky'
            "
        <?php endif; ?>
    <?php endif; ?>
    <?php echo e($attributes->class([
            'fi-sidebar fixed inset-y-0 start-0 z-30 flex flex-col h-screen content-start bg-white transition-all dark:bg-gray-900 lg:z-0 lg:bg-transparent lg:shadow-none lg:ring-0 lg:transition-none dark:lg:bg-transparent',
            'lg:translate-x-0 rtl:lg:-translate-x-0' => ! (filament()->isSidebarCollapsibleOnDesktop() || filament()->isSidebarFullyCollapsibleOnDesktop() || filament()->hasTopNavigation()),
            'lg:-translate-x-full rtl:lg:translate-x-full' => filament()->hasTopNavigation(),
        ])); ?>

>
    <div class="overflow-x-clip">
        <header
            class="fi-sidebar-header flex h-16 items-center bg-white px-6 ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 lg:shadow-sm"
        >
            <div
                <?php if(filament()->isSidebarCollapsibleOnDesktop()): ?>
                    x-show="$store.sidebar.isOpen"
                    x-transition:enter="lg:transition lg:delay-100"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                <?php endif; ?>
            >
                <?php if($homeUrl = filament()->getHomeUrl()): ?>
                    <a <?php echo e(\Filament\Support\generate_href_html($homeUrl)); ?>>
                        <?php if (isset($component)) { $__componentOriginalb501e8c73315a10eb0eb5fd14fda0d94 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb501e8c73315a10eb0eb5fd14fda0d94 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.logo','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb501e8c73315a10eb0eb5fd14fda0d94)): ?>
<?php $attributes = $__attributesOriginalb501e8c73315a10eb0eb5fd14fda0d94; ?>
<?php unset($__attributesOriginalb501e8c73315a10eb0eb5fd14fda0d94); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb501e8c73315a10eb0eb5fd14fda0d94)): ?>
<?php $component = $__componentOriginalb501e8c73315a10eb0eb5fd14fda0d94; ?>
<?php unset($__componentOriginalb501e8c73315a10eb0eb5fd14fda0d94); ?>
<?php endif; ?>
                    </a>
                <?php else: ?>
                    <?php if (isset($component)) { $__componentOriginalb501e8c73315a10eb0eb5fd14fda0d94 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb501e8c73315a10eb0eb5fd14fda0d94 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.logo','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb501e8c73315a10eb0eb5fd14fda0d94)): ?>
<?php $attributes = $__attributesOriginalb501e8c73315a10eb0eb5fd14fda0d94; ?>
<?php unset($__attributesOriginalb501e8c73315a10eb0eb5fd14fda0d94); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb501e8c73315a10eb0eb5fd14fda0d94)): ?>
<?php $component = $__componentOriginalb501e8c73315a10eb0eb5fd14fda0d94; ?>
<?php unset($__componentOriginalb501e8c73315a10eb0eb5fd14fda0d94); ?>
<?php endif; ?>
                <?php endif; ?>
            </div>

            <?php if(filament()->isSidebarCollapsibleOnDesktop()): ?>
                <?php if (isset($component)) { $__componentOriginalf0029cce6d19fd6d472097ff06a800a1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf0029cce6d19fd6d472097ff06a800a1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.icon-button','data' => ['color' => 'gray','icon' => $isRtl ? 'heroicon-o-chevron-left' : 'heroicon-o-chevron-right','iconAlias' => $isRtl ? ['panels::sidebar.expand-button.rtl', 'panels::sidebar.expand-button'] : 'panels::sidebar.expand-button','iconSize' => 'lg','label' => __('filament-panels::layout.actions.sidebar.expand.label'),'xCloak' => true,'xData' => '{}','xOn:click' => '$store.sidebar.open()','xShow' => '! $store.sidebar.isOpen','class' => 'mx-auto']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::icon-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => 'gray','icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isRtl ? 'heroicon-o-chevron-left' : 'heroicon-o-chevron-right'),'icon-alias' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isRtl ? ['panels::sidebar.expand-button.rtl', 'panels::sidebar.expand-button'] : 'panels::sidebar.expand-button'),'icon-size' => 'lg','label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('filament-panels::layout.actions.sidebar.expand.label')),'x-cloak' => true,'x-data' => '{}','x-on:click' => '$store.sidebar.open()','x-show' => '! $store.sidebar.isOpen','class' => 'mx-auto']); ?>
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

            <?php if(filament()->isSidebarCollapsibleOnDesktop() || filament()->isSidebarFullyCollapsibleOnDesktop()): ?>
                <?php if (isset($component)) { $__componentOriginalf0029cce6d19fd6d472097ff06a800a1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf0029cce6d19fd6d472097ff06a800a1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.icon-button','data' => ['color' => 'gray','icon' => $isRtl ? 'heroicon-o-chevron-right' : 'heroicon-o-chevron-left','iconAlias' => $isRtl ? ['panels::sidebar.collapse-button.rtl', 'panels::sidebar.collapse-button'] : 'panels::sidebar.collapse-button','iconSize' => 'lg','label' => __('filament-panels::layout.actions.sidebar.collapse.label'),'xCloak' => true,'xData' => '{}','xOn:click' => '$store.sidebar.close()','xShow' => '$store.sidebar.isOpen','class' => 'ms-auto hidden lg:flex']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::icon-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => 'gray','icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isRtl ? 'heroicon-o-chevron-right' : 'heroicon-o-chevron-left'),'icon-alias' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isRtl ? ['panels::sidebar.collapse-button.rtl', 'panels::sidebar.collapse-button'] : 'panels::sidebar.collapse-button'),'icon-size' => 'lg','label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('filament-panels::layout.actions.sidebar.collapse.label')),'x-cloak' => true,'x-data' => '{}','x-on:click' => '$store.sidebar.close()','x-show' => '$store.sidebar.isOpen','class' => 'ms-auto hidden lg:flex']); ?>
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
        </header>
    </div>

    <nav
        class="fi-sidebar-nav flex-grow flex flex-col gap-y-7 overflow-y-auto overflow-x-hidden px-6 py-8"
        style="scrollbar-gutter: stable"
    >
        <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::SIDEBAR_NAV_START)); ?>


        <?php if(filament()->hasTenancy() && filament()->hasTenantMenu()): ?>
            <div
                class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                    'fi-sidebar-nav-tenant-menu-ctn',
                    '-mx-2' => ! filament()->isSidebarCollapsibleOnDesktop(),
                ]); ?>"
                <?php if(filament()->isSidebarCollapsibleOnDesktop()): ?>
                    x-bind:class="$store.sidebar.isOpen ? '-mx-2' : '-mx-4'"
                <?php endif; ?>
            >
                <?php if (isset($component)) { $__componentOriginal32b9f4abfc80490155cb7c5dfaf8790d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal32b9f4abfc80490155cb7c5dfaf8790d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.tenant-menu','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::tenant-menu'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal32b9f4abfc80490155cb7c5dfaf8790d)): ?>
<?php $attributes = $__attributesOriginal32b9f4abfc80490155cb7c5dfaf8790d; ?>
<?php unset($__attributesOriginal32b9f4abfc80490155cb7c5dfaf8790d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal32b9f4abfc80490155cb7c5dfaf8790d)): ?>
<?php $component = $__componentOriginal32b9f4abfc80490155cb7c5dfaf8790d; ?>
<?php unset($__componentOriginal32b9f4abfc80490155cb7c5dfaf8790d); ?>
<?php endif; ?>
            </div>
        <?php endif; ?>

        <ul class="fi-sidebar-nav-groups -mx-2 flex flex-col gap-y-7">
            <?php $__currentLoopData = $navigation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if (isset($component)) { $__componentOriginal59b772cc9788bdb14bf9872624b4f33a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal59b772cc9788bdb14bf9872624b4f33a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.sidebar.group','data' => ['active' => $group->isActive(),'collapsible' => $group->isCollapsible(),'icon' => $group->getIcon(),'items' => $group->getItems(),'label' => $group->getLabel(),'attributes' => \Filament\Support\prepare_inherited_attributes($group->getExtraSidebarAttributeBag())]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::sidebar.group'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($group->isActive()),'collapsible' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($group->isCollapsible()),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($group->getIcon()),'items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($group->getItems()),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($group->getLabel()),'attributes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\Filament\Support\prepare_inherited_attributes($group->getExtraSidebarAttributeBag()))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal59b772cc9788bdb14bf9872624b4f33a)): ?>
<?php $attributes = $__attributesOriginal59b772cc9788bdb14bf9872624b4f33a; ?>
<?php unset($__attributesOriginal59b772cc9788bdb14bf9872624b4f33a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal59b772cc9788bdb14bf9872624b4f33a)): ?>
<?php $component = $__componentOriginal59b772cc9788bdb14bf9872624b4f33a; ?>
<?php unset($__componentOriginal59b772cc9788bdb14bf9872624b4f33a); ?>
<?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>

        <script>
            var collapsedGroups = JSON.parse(
                localStorage.getItem('collapsedGroups'),
            )

            if (collapsedGroups === null || collapsedGroups === 'null') {
                localStorage.setItem(
                    'collapsedGroups',
                    JSON.stringify(<?php echo \Illuminate\Support\Js::from(
                        collect($navigation)
                            ->filter(fn (\Filament\Navigation\NavigationGroup $group): bool => $group->isCollapsed())
                            ->map(fn (\Filament\Navigation\NavigationGroup $group): string => $group->getLabel())
                            ->values()
                            ->all()
                    )->toHtml() ?>),
                )
            }

            collapsedGroups = JSON.parse(
                localStorage.getItem('collapsedGroups'),
            )

            document
                .querySelectorAll('.fi-sidebar-group')
                .forEach((group) => {
                    if (
                        !collapsedGroups.includes(group.dataset.groupLabel)
                    ) {
                        return
                    }

                    // Alpine.js loads too slow, so attempt to hide a
                    // collapsed sidebar group earlier.
                    group.querySelector(
                        '.fi-sidebar-group-items',
                    ).style.display = 'none'
                    group
                        .querySelector('.fi-sidebar-group-collapse-button')
                        .classList.add('rotate-180')
                })
        </script>

        <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::SIDEBAR_NAV_END)); ?>

    </nav>

    <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::SIDEBAR_FOOTER)); ?>

</aside>

<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\filament\src\/../resources/views/components/sidebar/index.blade.php ENDPATH**/ ?>