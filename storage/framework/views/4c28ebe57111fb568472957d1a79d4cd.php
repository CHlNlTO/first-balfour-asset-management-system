<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'columns' => [
        'lg' => 2,
    ],
    'data' => [],
    'widgets' => [],
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
    'columns' => [
        'lg' => 2,
    ],
    'data' => [],
    'widgets' => [],
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php if (isset($component)) { $__componentOriginal30dbd75eb120a380110a2b340cd88f46 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30dbd75eb120a380110a2b340cd88f46 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.grid.index','data' => ['default' => $columns['default'] ?? 1,'sm' => $columns['sm'] ?? null,'md' => $columns['md'] ?? null,'lg' => $columns['lg'] ?? ($columns ? (is_array($columns) ? null : $columns) : 2),'xl' => $columns['xl'] ?? null,'twoXl' => $columns['2xl'] ?? null,'attributes' => \Filament\Support\prepare_inherited_attributes($attributes)->class('fi-wi gap-6')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::grid'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['default' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columns['default'] ?? 1),'sm' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columns['sm'] ?? null),'md' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columns['md'] ?? null),'lg' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columns['lg'] ?? ($columns ? (is_array($columns) ? null : $columns) : 2)),'xl' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columns['xl'] ?? null),'two-xl' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columns['2xl'] ?? null),'attributes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\Filament\Support\prepare_inherited_attributes($attributes)->class('fi-wi gap-6'))]); ?>
    <?php
        $normalizeWidgetClass = function (string | Filament\Widgets\WidgetConfiguration $widget): string {
            if ($widget instanceof \Filament\Widgets\WidgetConfiguration) {
                return $widget->widget;
            }

            return $widget;
        };
    ?>

    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $widgets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $widgetKey => $widget): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $widgetClass = $normalizeWidgetClass($widget);
        ?>

        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split($widgetClass,
            [...(($widget instanceof \Filament\Widgets\WidgetConfiguration) ? [...$widget->widget::getDefaultProperties(), ...$widget->getProperties()] : $widget::getDefaultProperties()), ...$data],);

$__html = app('livewire')->mount($__name, $__params, "{$widgetClass}-{$widgetKey}", $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal30dbd75eb120a380110a2b340cd88f46)): ?>
<?php $attributes = $__attributesOriginal30dbd75eb120a380110a2b340cd88f46; ?>
<?php unset($__attributesOriginal30dbd75eb120a380110a2b340cd88f46); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal30dbd75eb120a380110a2b340cd88f46)): ?>
<?php $component = $__componentOriginal30dbd75eb120a380110a2b340cd88f46; ?>
<?php unset($__componentOriginal30dbd75eb120a380110a2b340cd88f46); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\widgets\src\/../resources/views/components/widgets.blade.php ENDPATH**/ ?>