<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'notifications',
    'unreadNotificationsCount',
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
    'notifications',
    'unreadNotificationsCount',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    use Filament\Support\Enums\Alignment;

    $hasNotifications = $notifications->count();
    $isPaginated = $notifications instanceof \Illuminate\Contracts\Pagination\Paginator && $notifications->hasPages();
?>

<?php if (isset($component)) { $__componentOriginal0942a211c37469064369f887ae8d1cef = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0942a211c37469064369f887ae8d1cef = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.modal.index','data' => ['alignment' => $hasNotifications ? null : Alignment::Center,'closeButton' => true,'description' => $hasNotifications ? null : __('filament-notifications::database.modal.empty.description'),'heading' => $hasNotifications ? null : __('filament-notifications::database.modal.empty.heading'),'icon' => $hasNotifications ? null : 'heroicon-o-bell-slash','iconAlias' => $hasNotifications ? null : 'notifications::database.modal.empty-state','iconColor' => $hasNotifications ? null : 'gray','id' => 'database-notifications','slideOver' => true,'stickyHeader' => $hasNotifications,'width' => 'md']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['alignment' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($hasNotifications ? null : Alignment::Center),'close-button' => true,'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($hasNotifications ? null : __('filament-notifications::database.modal.empty.description')),'heading' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($hasNotifications ? null : __('filament-notifications::database.modal.empty.heading')),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($hasNotifications ? null : 'heroicon-o-bell-slash'),'icon-alias' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($hasNotifications ? null : 'notifications::database.modal.empty-state'),'icon-color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($hasNotifications ? null : 'gray'),'id' => 'database-notifications','slide-over' => true,'sticky-header' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($hasNotifications),'width' => 'md']); ?>
    <!--[if BLOCK]><![endif]--><?php if($hasNotifications): ?>
         <?php $__env->slot('header', null, []); ?> 
            <div>
                <?php if (isset($component)) { $__componentOriginal29c6950974cc8bc0fb132203607bcdfe = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal29c6950974cc8bc0fb132203607bcdfe = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-notifications::components.database.modal.heading','data' => ['unreadNotificationsCount' => $unreadNotificationsCount]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-notifications::database.modal.heading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['unread-notifications-count' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($unreadNotificationsCount)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal29c6950974cc8bc0fb132203607bcdfe)): ?>
<?php $attributes = $__attributesOriginal29c6950974cc8bc0fb132203607bcdfe; ?>
<?php unset($__attributesOriginal29c6950974cc8bc0fb132203607bcdfe); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal29c6950974cc8bc0fb132203607bcdfe)): ?>
<?php $component = $__componentOriginal29c6950974cc8bc0fb132203607bcdfe; ?>
<?php unset($__componentOriginal29c6950974cc8bc0fb132203607bcdfe); ?>
<?php endif; ?>

                <?php if (isset($component)) { $__componentOriginalde860401b4f69165811f4158823259d8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalde860401b4f69165811f4158823259d8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-notifications::components.database.modal.actions','data' => ['notifications' => $notifications,'unreadNotificationsCount' => $unreadNotificationsCount]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-notifications::database.modal.actions'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['notifications' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($notifications),'unread-notifications-count' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($unreadNotificationsCount)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalde860401b4f69165811f4158823259d8)): ?>
<?php $attributes = $__attributesOriginalde860401b4f69165811f4158823259d8; ?>
<?php unset($__attributesOriginalde860401b4f69165811f4158823259d8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalde860401b4f69165811f4158823259d8)): ?>
<?php $component = $__componentOriginalde860401b4f69165811f4158823259d8; ?>
<?php unset($__componentOriginalde860401b4f69165811f4158823259d8); ?>
<?php endif; ?>
            </div>
         <?php $__env->endSlot(); ?>

        <div
            class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                '-mx-6 -mt-6 divide-y divide-gray-200 dark:divide-white/10',
                '-mb-6' => ! $isPaginated,
                'border-b border-gray-200 dark:border-white/10' => $isPaginated,
            ]); ?>"
        >
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div
                    class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                        'relative before:absolute before:start-0 before:h-full before:w-0.5 before:bg-primary-600 dark:before:bg-primary-500' => $notification->unread(),
                    ]); ?>"
                >
                    <?php echo e($this->getNotification($notification)->inline()); ?>

                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        <!--[if BLOCK]><![endif]--><?php if($isPaginated): ?>
             <?php $__env->slot('footer', null, []); ?> 
                <?php if (isset($component)) { $__componentOriginal0c287a00f29f01c8f977078ff96faed4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0c287a00f29f01c8f977078ff96faed4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.pagination.index','data' => ['paginator' => $notifications]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::pagination'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['paginator' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($notifications)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0c287a00f29f01c8f977078ff96faed4)): ?>
<?php $attributes = $__attributesOriginal0c287a00f29f01c8f977078ff96faed4; ?>
<?php unset($__attributesOriginal0c287a00f29f01c8f977078ff96faed4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0c287a00f29f01c8f977078ff96faed4)): ?>
<?php $component = $__componentOriginal0c287a00f29f01c8f977078ff96faed4; ?>
<?php unset($__componentOriginal0c287a00f29f01c8f977078ff96faed4); ?>
<?php endif; ?>
             <?php $__env->endSlot(); ?>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0942a211c37469064369f887ae8d1cef)): ?>
<?php $attributes = $__attributesOriginal0942a211c37469064369f887ae8d1cef; ?>
<?php unset($__attributesOriginal0942a211c37469064369f887ae8d1cef); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0942a211c37469064369f887ae8d1cef)): ?>
<?php $component = $__componentOriginal0942a211c37469064369f887ae8d1cef; ?>
<?php unset($__componentOriginal0942a211c37469064369f887ae8d1cef); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\notifications\src\/../resources/views/components/database/modal/index.blade.php ENDPATH**/ ?>