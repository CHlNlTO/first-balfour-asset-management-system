<?php
    if ((! isset($columnSpan)) || (! is_array($columnSpan))) {
        $columnSpan = [
            'default' => $columnSpan ?? null,
        ];
    }

    if ((! isset($columnStart)) || (! is_array($columnStart))) {
        $columnStart = [
            'default' => $columnStart ?? null,
        ];
    }

    $height ??= '8rem';
?>

<?php if (isset($component)) { $__componentOriginal6f9d0ad23f77111c926012ad6ce09333 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6f9d0ad23f77111c926012ad6ce09333 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.grid.column','data' => ['default' => $columnSpan['default'] ?? 1,'sm' => $columnSpan['sm'] ?? null,'md' => $columnSpan['md'] ?? null,'lg' => $columnSpan['lg'] ?? null,'xl' => $columnSpan['xl'] ?? null,'twoXl' => $columnSpan['2xl'] ?? null,'defaultStart' => $columnStart['default'] ?? null,'smStart' => $columnStart['sm'] ?? null,'mdStart' => $columnStart['md'] ?? null,'lgStart' => $columnStart['lg'] ?? null,'xlStart' => $columnStart['xl'] ?? null,'twoXlStart' => $columnStart['2xl'] ?? null,'class' => 'fi-loading-section']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::grid.column'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['default' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnSpan['default'] ?? 1),'sm' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnSpan['sm'] ?? null),'md' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnSpan['md'] ?? null),'lg' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnSpan['lg'] ?? null),'xl' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnSpan['xl'] ?? null),'twoXl' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnSpan['2xl'] ?? null),'defaultStart' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnStart['default'] ?? null),'smStart' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnStart['sm'] ?? null),'mdStart' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnStart['md'] ?? null),'lgStart' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnStart['lg'] ?? null),'xlStart' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnStart['xl'] ?? null),'twoXlStart' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnStart['2xl'] ?? null),'class' => 'fi-loading-section']); ?>
    <?php if (isset($component)) { $__componentOriginalee08b1367eba38734199cf7829b1d1e9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalee08b1367eba38734199cf7829b1d1e9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.section.index','data' => ['class' => 'animate-pulse','style' => 'height: '.e($height).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::section'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'animate-pulse','style' => 'height: '.e($height).'']); ?>
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
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6f9d0ad23f77111c926012ad6ce09333)): ?>
<?php $attributes = $__attributesOriginal6f9d0ad23f77111c926012ad6ce09333; ?>
<?php unset($__attributesOriginal6f9d0ad23f77111c926012ad6ce09333); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6f9d0ad23f77111c926012ad6ce09333)): ?>
<?php $component = $__componentOriginal6f9d0ad23f77111c926012ad6ce09333; ?>
<?php unset($__componentOriginal6f9d0ad23f77111c926012ad6ce09333); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\support\src\/../resources/views/components/loading-section.blade.php ENDPATH**/ ?>