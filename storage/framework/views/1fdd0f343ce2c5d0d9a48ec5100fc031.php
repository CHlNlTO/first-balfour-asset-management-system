<?php if (isset($component)) { $__componentOriginal0582040fe960eff09c1461f7f86a8187 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0582040fe960eff09c1461f7f86a8187 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.cell','data' => ['attributes' => 
        \Filament\Support\prepare_inherited_attributes($attributes)
            ->class(['fi-ta-actions-cell'])
    ]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::cell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['attributes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(
        \Filament\Support\prepare_inherited_attributes($attributes)
            ->class(['fi-ta-actions-cell'])
    )]); ?>
    <div class="whitespace-nowrap px-3 py-4">
        <?php echo e($slot); ?>

    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0582040fe960eff09c1461f7f86a8187)): ?>
<?php $attributes = $__attributesOriginal0582040fe960eff09c1461f7f86a8187; ?>
<?php unset($__attributesOriginal0582040fe960eff09c1461f7f86a8187); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0582040fe960eff09c1461f7f86a8187)): ?>
<?php $component = $__componentOriginal0582040fe960eff09c1461f7f86a8187; ?>
<?php unset($__componentOriginal0582040fe960eff09c1461f7f86a8187); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\tables\src\/../resources/views/components/actions/cell.blade.php ENDPATH**/ ?>