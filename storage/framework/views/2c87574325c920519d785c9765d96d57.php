<div class="fi-resource-relation-manager flex flex-col gap-y-6">
    <?php if (isset($component)) { $__componentOriginale77d85bd24d039fa58cc32119f1d9bc5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale77d85bd24d039fa58cc32119f1d9bc5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.resources.tabs','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::resources.tabs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale77d85bd24d039fa58cc32119f1d9bc5)): ?>
<?php $attributes = $__attributesOriginale77d85bd24d039fa58cc32119f1d9bc5; ?>
<?php unset($__attributesOriginale77d85bd24d039fa58cc32119f1d9bc5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale77d85bd24d039fa58cc32119f1d9bc5)): ?>
<?php $component = $__componentOriginale77d85bd24d039fa58cc32119f1d9bc5; ?>
<?php unset($__componentOriginale77d85bd24d039fa58cc32119f1d9bc5); ?>
<?php endif; ?>

    <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::RESOURCE_RELATION_MANAGER_BEFORE, scopes: $this->getRenderHookScopes())); ?>


    <?php echo e($this->table); ?>


    <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::RESOURCE_RELATION_MANAGER_AFTER, scopes: $this->getRenderHookScopes())); ?>


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
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\filament\src\/../resources/views/resources/relation-manager.blade.php ENDPATH**/ ?>