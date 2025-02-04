<!--[if BLOCK]><![endif]--><?php if(count($tabs = $this->getCachedTabs())): ?>
    <?php
        $activeTab = strval($this->activeTab);
        $renderHookScopes = $this->getRenderHookScopes();
    ?>

    <?php if (isset($component)) { $__componentOriginal447636fe67a19f9c79619fb5a3c0c28d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal447636fe67a19f9c79619fb5a3c0c28d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.tabs.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::tabs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
        <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::RESOURCE_TABS_START, scopes: $renderHookScopes)); ?>

        <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::RESOURCE_PAGES_LIST_RECORDS_TABS_START, scopes: $renderHookScopes)); ?>


        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $tabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tabKey => $tab): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $tabKey = strval($tabKey);
            ?>

            <?php if (isset($component)) { $__componentOriginal35d4caf141547fb7d125e4ebd3c1b66f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal35d4caf141547fb7d125e4ebd3c1b66f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.tabs.item','data' => ['active' => $activeTab === $tabKey,'badge' => $tab->getBadge(),'badgeColor' => $tab->getBadgeColor(),'badgeIcon' => $tab->getBadgeIcon(),'badgeIconPosition' => $tab->getBadgeIconPosition(),'icon' => $tab->getIcon(),'iconPosition' => $tab->getIconPosition(),'wire:click' => '$set(\'activeTab\', ' . (filled($tabKey) ? ('\'' . $tabKey . '\'') : 'null') . ')','attributes' => $tab->getExtraAttributeBag()]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::tabs.item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($activeTab === $tabKey),'badge' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tab->getBadge()),'badge-color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tab->getBadgeColor()),'badge-icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tab->getBadgeIcon()),'badge-icon-position' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tab->getBadgeIconPosition()),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tab->getIcon()),'icon-position' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tab->getIconPosition()),'wire:click' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('$set(\'activeTab\', ' . (filled($tabKey) ? ('\'' . $tabKey . '\'') : 'null') . ')'),'attributes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tab->getExtraAttributeBag())]); ?>
                <?php echo e($tab->getLabel() ?? $this->generateTabLabel($tabKey)); ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal35d4caf141547fb7d125e4ebd3c1b66f)): ?>
<?php $attributes = $__attributesOriginal35d4caf141547fb7d125e4ebd3c1b66f; ?>
<?php unset($__attributesOriginal35d4caf141547fb7d125e4ebd3c1b66f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal35d4caf141547fb7d125e4ebd3c1b66f)): ?>
<?php $component = $__componentOriginal35d4caf141547fb7d125e4ebd3c1b66f; ?>
<?php unset($__componentOriginal35d4caf141547fb7d125e4ebd3c1b66f); ?>
<?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

        <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::RESOURCE_TABS_END, scopes: $renderHookScopes)); ?>

        <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::RESOURCE_PAGES_LIST_RECORDS_TABS_END, scopes: $renderHookScopes)); ?>

     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal447636fe67a19f9c79619fb5a3c0c28d)): ?>
<?php $attributes = $__attributesOriginal447636fe67a19f9c79619fb5a3c0c28d; ?>
<?php unset($__attributesOriginal447636fe67a19f9c79619fb5a3c0c28d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal447636fe67a19f9c79619fb5a3c0c28d)): ?>
<?php $component = $__componentOriginal447636fe67a19f9c79619fb5a3c0c28d; ?>
<?php unset($__componentOriginal447636fe67a19f9c79619fb5a3c0c28d); ?>
<?php endif; ?>
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\filament\src\/../resources/views/components/resources/tabs.blade.php ENDPATH**/ ?>