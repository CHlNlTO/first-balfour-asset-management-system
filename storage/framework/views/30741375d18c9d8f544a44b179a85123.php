<?php if (isset($component)) { $__componentOriginal166a02a7c5ef5a9331faf66fa665c256 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.page.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::page'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="grid grid-cols-1 gap-8 p-2 md:p-4 lg:p-6 md:grid-cols-3">
        <a href="<?php echo e(route('filament.admin.resources.assets.create-hardware')); ?>" class="block">
            <div
                class="p-4 transition-shadow bg-white rounded-lg shadow-lg md:p-4 lg:p-6 hover:shadow-xl ring-1 ring-gray-950/5 dark:divide-white/10 dark:bg-gray-900 dark:ring-white/10">
                <div class="flex flex-col items-center">
                    <img src="<?php echo e(asset('images/hardware-logo.png')); ?>" class="w-full h-auto rounded-lg"
                        alt="Create Hardware" />
                    
                </div>
            </div>
        </a>

        <a href="<?php echo e(route('filament.admin.resources.assets.create-software')); ?>" class="block">
            <div
                class="p-4 transition-shadow bg-white rounded-lg shadow-lg md:p-4 lg:p-6 hover:shadow-xl ring-1 ring-gray-950/5 dark:divide-white/10 dark:bg-gray-900 dark:ring-white/10">
                <div class="flex flex-col items-center">
                    <img src="<?php echo e(asset('images/software-logo.png')); ?>" class="w-full h-auto rounded-lg"
                        alt="Create Software" />
                    
                </div>
            </div>
        </a>

        <a href="<?php echo e(route('filament.admin.resources.assets.create-peripherals')); ?>" class="block">
            <div
                class="p-4 transition-shadow bg-white rounded-lg shadow-lg md:p-4 lg:p-6 hover:shadow-xl ring-1 ring-gray-950/5 dark:divide-white/10 dark:bg-gray-900 dark:ring-white/10">
                <div class="flex flex-col items-center">
                    <img src="<?php echo e(asset('images/peripherals-logo.png')); ?>" class="w-full h-auto rounded-lg"
                        alt="Create Peripherals" />
                    
                </div>
            </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $attributes = $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $component = $__componentOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\resources\views/filament/pages/select-asset-type.blade.php ENDPATH**/ ?>