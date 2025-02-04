<div
    x-data="{ theme: null }"
    x-init="
        $watch('theme', () => {
            $dispatch('theme-changed', theme)
        })

        theme = localStorage.getItem('theme') || <?php echo \Illuminate\Support\Js::from(filament()->getDefaultThemeMode()->value)->toHtml() ?>
    "
    class="fi-theme-switcher grid grid-flow-col gap-x-1"
>
    <?php if (isset($component)) { $__componentOriginalad1f400c934be44fb66b397d4f7989b8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalad1f400c934be44fb66b397d4f7989b8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.theme-switcher.button','data' => ['icon' => 'heroicon-m-sun','theme' => 'light']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::theme-switcher.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'heroicon-m-sun','theme' => 'light']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalad1f400c934be44fb66b397d4f7989b8)): ?>
<?php $attributes = $__attributesOriginalad1f400c934be44fb66b397d4f7989b8; ?>
<?php unset($__attributesOriginalad1f400c934be44fb66b397d4f7989b8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalad1f400c934be44fb66b397d4f7989b8)): ?>
<?php $component = $__componentOriginalad1f400c934be44fb66b397d4f7989b8; ?>
<?php unset($__componentOriginalad1f400c934be44fb66b397d4f7989b8); ?>
<?php endif; ?>

    <?php if (isset($component)) { $__componentOriginalad1f400c934be44fb66b397d4f7989b8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalad1f400c934be44fb66b397d4f7989b8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.theme-switcher.button','data' => ['icon' => 'heroicon-m-moon','theme' => 'dark']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::theme-switcher.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'heroicon-m-moon','theme' => 'dark']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalad1f400c934be44fb66b397d4f7989b8)): ?>
<?php $attributes = $__attributesOriginalad1f400c934be44fb66b397d4f7989b8; ?>
<?php unset($__attributesOriginalad1f400c934be44fb66b397d4f7989b8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalad1f400c934be44fb66b397d4f7989b8)): ?>
<?php $component = $__componentOriginalad1f400c934be44fb66b397d4f7989b8; ?>
<?php unset($__componentOriginalad1f400c934be44fb66b397d4f7989b8); ?>
<?php endif; ?>

    <?php if (isset($component)) { $__componentOriginalad1f400c934be44fb66b397d4f7989b8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalad1f400c934be44fb66b397d4f7989b8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.theme-switcher.button','data' => ['icon' => 'heroicon-m-computer-desktop','theme' => 'system']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::theme-switcher.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'heroicon-m-computer-desktop','theme' => 'system']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalad1f400c934be44fb66b397d4f7989b8)): ?>
<?php $attributes = $__attributesOriginalad1f400c934be44fb66b397d4f7989b8; ?>
<?php unset($__attributesOriginalad1f400c934be44fb66b397d4f7989b8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalad1f400c934be44fb66b397d4f7989b8)): ?>
<?php $component = $__componentOriginalad1f400c934be44fb66b397d4f7989b8; ?>
<?php unset($__componentOriginalad1f400c934be44fb66b397d4f7989b8); ?>
<?php endif; ?>
</div>
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\filament\src\/../resources/views/components/theme-switcher/index.blade.php ENDPATH**/ ?>