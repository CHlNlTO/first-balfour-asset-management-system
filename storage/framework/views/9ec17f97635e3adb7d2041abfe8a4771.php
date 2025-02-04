<?php
    $isAside = $isAside();
?>

<?php if (isset($component)) { $__componentOriginalee08b1367eba38734199cf7829b1d1e9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalee08b1367eba38734199cf7829b1d1e9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.section.index','data' => ['aside' => $isAside,'collapsed' => $isCollapsed(),'collapsible' => $isCollapsible() && (! $isAside),'compact' => $isCompact(),'contentBefore' => $isFormBefore(),'description' => $getDescription(),'footerActions' => $getFooterActions(),'footerActionsAlignment' => $getFooterActionsAlignment(),'headerActions' => $getHeaderActions(),'heading' => $getHeading(),'icon' => $getIcon(),'iconColor' => $getIconColor(),'iconSize' => $getIconSize(),'persistCollapsed' => $shouldPersistCollapsed(),'attributes' => 
        \Filament\Support\prepare_inherited_attributes($attributes)
            ->merge([
                'id' => $getId(),
            ], escape: false)
            ->merge($getExtraAttributes(), escape: false)
            ->merge($getExtraAlpineAttributes(), escape: false)
    ]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::section'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['aside' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isAside),'collapsed' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isCollapsed()),'collapsible' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isCollapsible() && (! $isAside)),'compact' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isCompact()),'content-before' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isFormBefore()),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getDescription()),'footer-actions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getFooterActions()),'footer-actions-alignment' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getFooterActionsAlignment()),'header-actions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getHeaderActions()),'heading' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getHeading()),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getIcon()),'icon-color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getIconColor()),'icon-size' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getIconSize()),'persist-collapsed' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($shouldPersistCollapsed()),'attributes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(
        \Filament\Support\prepare_inherited_attributes($attributes)
            ->merge([
                'id' => $getId(),
            ], escape: false)
            ->merge($getExtraAttributes(), escape: false)
            ->merge($getExtraAlpineAttributes(), escape: false)
    )]); ?>
    <?php echo e($getChildComponentContainer()); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalee08b1367eba38734199cf7829b1d1e9)): ?>
<?php $attributes = $__attributesOriginalee08b1367eba38734199cf7829b1d1e9; ?>
<?php unset($__attributesOriginalee08b1367eba38734199cf7829b1d1e9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalee08b1367eba38734199cf7829b1d1e9)): ?>
<?php $component = $__componentOriginalee08b1367eba38734199cf7829b1d1e9; ?>
<?php unset($__componentOriginalee08b1367eba38734199cf7829b1d1e9); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\forms\src\/../resources/views/components/section.blade.php ENDPATH**/ ?>