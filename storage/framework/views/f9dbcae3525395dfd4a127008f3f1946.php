<?php
    use Filament\Notifications\Livewire\Notifications;
    use Filament\Support\Enums\Alignment;
    use Filament\Support\Enums\VerticalAlignment;
    use Illuminate\Support\Arr;

    $color = $getColor() ?? 'gray';
    $isInline = $isInline();
    $status = $getStatus();
    $title = $getTitle();
    $hasTitle = filled($title);
    $date = $getDate();
    $hasDate = filled($date);
    $body = $getBody();
    $hasBody = filled($body);
?>

<?php if (isset($component)) { $__componentOriginal3aec810dc0b7b6031e787147bbf29c75 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3aec810dc0b7b6031e787147bbf29c75 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-notifications::components.notification','data' => ['notification' => $notification,'xTransition:enterStart' => 
        Arr::toCssClasses([
            'opacity-0',
            ($this instanceof Notifications)
            ? match (static::$alignment) {
                Alignment::Start, Alignment::Left => '-translate-x-12',
                Alignment::End, Alignment::Right => 'translate-x-12',
                Alignment::Center => match (static::$verticalAlignment) {
                    VerticalAlignment::Start => '-translate-y-12',
                    VerticalAlignment::End => 'translate-y-12',
                    default => null,
                },
                default => null,
            }
            : null,
        ])
    ,'xTransition:leaveEnd' => 
        Arr::toCssClasses([
            'opacity-0',
            'scale-95' => ! $isInline,
        ])
    ,'class' => \Illuminate\Support\Arr::toCssClasses([
        'fi-no-notification w-full overflow-hidden transition duration-300',
        ...match ($isInline) {
            true => [
                'fi-inline',
            ],
            false => [
                'max-w-sm rounded-xl bg-white shadow-lg ring-1 dark:bg-gray-900',
                match ($color) {
                    'gray' => 'ring-gray-950/5 dark:ring-white/10',
                    default => 'fi-color-custom ring-custom-600/20 dark:ring-custom-400/30',
                },
                is_string($color) ? 'fi-color-' . $color : null,
                'fi-status-' . $status => $status,
            ],
        },
    ]),'style' => \Illuminate\Support\Arr::toCssStyles([
        \Filament\Support\get_color_css_variables(
            $color,
            shades: [50, 400, 600],
            alias: 'notifications::notification',
        ) => ! ($isInline || $color === 'gray'),
    ])]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-notifications::notification'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['notification' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($notification),'x-transition:enter-start' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(
        Arr::toCssClasses([
            'opacity-0',
            ($this instanceof Notifications)
            ? match (static::$alignment) {
                Alignment::Start, Alignment::Left => '-translate-x-12',
                Alignment::End, Alignment::Right => 'translate-x-12',
                Alignment::Center => match (static::$verticalAlignment) {
                    VerticalAlignment::Start => '-translate-y-12',
                    VerticalAlignment::End => 'translate-y-12',
                    default => null,
                },
                default => null,
            }
            : null,
        ])
    ),'x-transition:leave-end' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(
        Arr::toCssClasses([
            'opacity-0',
            'scale-95' => ! $isInline,
        ])
    ),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\Illuminate\Support\Arr::toCssClasses([
        'fi-no-notification w-full overflow-hidden transition duration-300',
        ...match ($isInline) {
            true => [
                'fi-inline',
            ],
            false => [
                'max-w-sm rounded-xl bg-white shadow-lg ring-1 dark:bg-gray-900',
                match ($color) {
                    'gray' => 'ring-gray-950/5 dark:ring-white/10',
                    default => 'fi-color-custom ring-custom-600/20 dark:ring-custom-400/30',
                },
                is_string($color) ? 'fi-color-' . $color : null,
                'fi-status-' . $status => $status,
            ],
        },
    ])),'style' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\Illuminate\Support\Arr::toCssStyles([
        \Filament\Support\get_color_css_variables(
            $color,
            shades: [50, 400, 600],
            alias: 'notifications::notification',
        ) => ! ($isInline || $color === 'gray'),
    ]))]); ?>
    <div
        class="<?php echo \Illuminate\Support\Arr::toCssClasses([
            'flex w-full gap-3 p-4',
            match ($color) {
                'gray' => null,
                default => 'bg-custom-50 dark:bg-custom-400/10',
            },
        ]); ?>"
    >
        <!--[if BLOCK]><![endif]--><?php if($icon = $getIcon()): ?>
            <?php if (isset($component)) { $__componentOriginalf02cb4921775e86c03ae335599adc986 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf02cb4921775e86c03ae335599adc986 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-notifications::components.icon','data' => ['color' => $getIconColor(),'icon' => $icon,'size' => $getIconSize()]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-notifications::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getIconColor()),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($icon),'size' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getIconSize())]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf02cb4921775e86c03ae335599adc986)): ?>
<?php $attributes = $__attributesOriginalf02cb4921775e86c03ae335599adc986; ?>
<?php unset($__attributesOriginalf02cb4921775e86c03ae335599adc986); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf02cb4921775e86c03ae335599adc986)): ?>
<?php $component = $__componentOriginalf02cb4921775e86c03ae335599adc986; ?>
<?php unset($__componentOriginalf02cb4921775e86c03ae335599adc986); ?>
<?php endif; ?>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <div class="mt-0.5 grid flex-1">
            <!--[if BLOCK]><![endif]--><?php if($hasTitle): ?>
                <?php if (isset($component)) { $__componentOriginal7db3daa6cb21d2d6e134a68caddc4280 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7db3daa6cb21d2d6e134a68caddc4280 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-notifications::components.title','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-notifications::title'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                    <?php echo e(str($title)->sanitizeHtml()->toHtmlString()); ?>

                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7db3daa6cb21d2d6e134a68caddc4280)): ?>
<?php $attributes = $__attributesOriginal7db3daa6cb21d2d6e134a68caddc4280; ?>
<?php unset($__attributesOriginal7db3daa6cb21d2d6e134a68caddc4280); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7db3daa6cb21d2d6e134a68caddc4280)): ?>
<?php $component = $__componentOriginal7db3daa6cb21d2d6e134a68caddc4280; ?>
<?php unset($__componentOriginal7db3daa6cb21d2d6e134a68caddc4280); ?>
<?php endif; ?>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            <!--[if BLOCK]><![endif]--><?php if($hasDate): ?>
                <?php if (isset($component)) { $__componentOriginal3148f3d244bda71926d7f1c92697ed87 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3148f3d244bda71926d7f1c92697ed87 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-notifications::components.date','data' => ['class' => \Illuminate\Support\Arr::toCssClasses(['mt-1' => $hasTitle])]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-notifications::date'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\Illuminate\Support\Arr::toCssClasses(['mt-1' => $hasTitle]))]); ?>
                    <?php echo e($date); ?>

                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3148f3d244bda71926d7f1c92697ed87)): ?>
<?php $attributes = $__attributesOriginal3148f3d244bda71926d7f1c92697ed87; ?>
<?php unset($__attributesOriginal3148f3d244bda71926d7f1c92697ed87); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3148f3d244bda71926d7f1c92697ed87)): ?>
<?php $component = $__componentOriginal3148f3d244bda71926d7f1c92697ed87; ?>
<?php unset($__componentOriginal3148f3d244bda71926d7f1c92697ed87); ?>
<?php endif; ?>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            <!--[if BLOCK]><![endif]--><?php if($hasBody): ?>
                <?php if (isset($component)) { $__componentOriginal27460770b0e710a69ee227f4482c43ef = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal27460770b0e710a69ee227f4482c43ef = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-notifications::components.body','data' => ['class' => \Illuminate\Support\Arr::toCssClasses(['mt-1' => $hasTitle || $hasDate])]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-notifications::body'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\Illuminate\Support\Arr::toCssClasses(['mt-1' => $hasTitle || $hasDate]))]); ?>
                    <?php echo e(str($body)->sanitizeHtml()->toHtmlString()); ?>

                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal27460770b0e710a69ee227f4482c43ef)): ?>
<?php $attributes = $__attributesOriginal27460770b0e710a69ee227f4482c43ef; ?>
<?php unset($__attributesOriginal27460770b0e710a69ee227f4482c43ef); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal27460770b0e710a69ee227f4482c43ef)): ?>
<?php $component = $__componentOriginal27460770b0e710a69ee227f4482c43ef; ?>
<?php unset($__componentOriginal27460770b0e710a69ee227f4482c43ef); ?>
<?php endif; ?>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            <!--[if BLOCK]><![endif]--><?php if($actions = $getActions()): ?>
                <?php if (isset($component)) { $__componentOriginalab02eb41cb8d8c4163c985cb21a53002 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalab02eb41cb8d8c4163c985cb21a53002 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-notifications::components.actions','data' => ['actions' => $actions,'class' => \Illuminate\Support\Arr::toCssClasses(['mt-3' => $hasTitle || $hasDate || $hasBody])]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-notifications::actions'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['actions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($actions),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\Illuminate\Support\Arr::toCssClasses(['mt-3' => $hasTitle || $hasDate || $hasBody]))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalab02eb41cb8d8c4163c985cb21a53002)): ?>
<?php $attributes = $__attributesOriginalab02eb41cb8d8c4163c985cb21a53002; ?>
<?php unset($__attributesOriginalab02eb41cb8d8c4163c985cb21a53002); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalab02eb41cb8d8c4163c985cb21a53002)): ?>
<?php $component = $__componentOriginalab02eb41cb8d8c4163c985cb21a53002; ?>
<?php unset($__componentOriginalab02eb41cb8d8c4163c985cb21a53002); ?>
<?php endif; ?>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        <?php if (isset($component)) { $__componentOriginal5bcde53997b77b5ac492fb6b61c26c09 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bcde53997b77b5ac492fb6b61c26c09 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-notifications::components.close-button','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-notifications::close-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bcde53997b77b5ac492fb6b61c26c09)): ?>
<?php $attributes = $__attributesOriginal5bcde53997b77b5ac492fb6b61c26c09; ?>
<?php unset($__attributesOriginal5bcde53997b77b5ac492fb6b61c26c09); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bcde53997b77b5ac492fb6b61c26c09)): ?>
<?php $component = $__componentOriginal5bcde53997b77b5ac492fb6b61c26c09; ?>
<?php unset($__componentOriginal5bcde53997b77b5ac492fb6b61c26c09); ?>
<?php endif; ?>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3aec810dc0b7b6031e787147bbf29c75)): ?>
<?php $attributes = $__attributesOriginal3aec810dc0b7b6031e787147bbf29c75; ?>
<?php unset($__attributesOriginal3aec810dc0b7b6031e787147bbf29c75); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3aec810dc0b7b6031e787147bbf29c75)): ?>
<?php $component = $__componentOriginal3aec810dc0b7b6031e787147bbf29c75; ?>
<?php unset($__componentOriginal3aec810dc0b7b6031e787147bbf29c75); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\notifications\src\/../resources/views/notification.blade.php ENDPATH**/ ?>