<?php if (isset($component)) { $__componentOriginalbdee036326cbc931a2e3bf686403ecb7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbdee036326cbc931a2e3bf686403ecb7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-actions::components.group','data' => ['badge' => $getBadge(),'badgeColor' => $getBadgeColor(),'dynamicComponent' => 'filament::button','group' => $group,'iconPosition' => $getIconPosition(),'labeledFrom' => $getLabeledFromBreakpoint(),'outlined' => $isOutlined(),'size' => $getSize(),'class' => 'fi-ac-btn-group']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-actions::group'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['badge' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getBadge()),'badge-color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getBadgeColor()),'dynamic-component' => 'filament::button','group' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($group),'icon-position' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getIconPosition()),'labeled-from' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getLabeledFromBreakpoint()),'outlined' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isOutlined()),'size' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getSize()),'class' => 'fi-ac-btn-group']); ?>
    <?php echo e($getLabel()); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbdee036326cbc931a2e3bf686403ecb7)): ?>
<?php $attributes = $__attributesOriginalbdee036326cbc931a2e3bf686403ecb7; ?>
<?php unset($__attributesOriginalbdee036326cbc931a2e3bf686403ecb7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbdee036326cbc931a2e3bf686403ecb7)): ?>
<?php $component = $__componentOriginalbdee036326cbc931a2e3bf686403ecb7; ?>
<?php unset($__componentOriginalbdee036326cbc931a2e3bf686403ecb7); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\actions\src\/../resources/views/button-group.blade.php ENDPATH**/ ?>