<?php if (isset($component)) { $__componentOriginal6330f08526bbb3ce2a0da37da512a11f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.button.index','data' => ['href' => route('admin.socialite.redirect', ['provider' => 'microsoft']),'tag' => 'a','color' => 'gray','class' => 'justify-center w-full']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.socialite.redirect', ['provider' => 'microsoft'])),'tag' => 'a','color' => 'gray','class' => 'justify-center w-full']); ?>
    <div class="flex items-center justify-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="mr-2" width="16" height="16" viewBox="0 0 1024 1024"
            fill="none">
            <path d="M44.522 44.5217H489.739V489.739H44.522V44.5217Z" fill="#F35325" />
            <path d="M534.261 44.5217H979.478V489.739H534.261V44.5217Z" fill="#81BC06" />
            <path d="M44.522 534.261H489.739V979.478H44.522V534.261Z" fill="#05A6F0" />
            <path d="M534.261 534.261H979.478V979.478H534.261V534.261Z" fill="#FFBA08" />
        </svg>
        Sign in with Microsoft
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $attributes = $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $component = $__componentOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\resources\views/auth/socialite/admin-microsoft.blade.php ENDPATH**/ ?>