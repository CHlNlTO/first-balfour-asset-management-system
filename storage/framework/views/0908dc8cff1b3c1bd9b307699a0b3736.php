<?php
    use Filament\Support\Facades\FilamentView;

    $canSelectPlaceholder = $canSelectPlaceholder();
    $isDisabled = $isDisabled();
    $isPrefixInline = $isPrefixInline();
    $isSuffixInline = $isSuffixInline();
    $prefixActions = $getPrefixActions();
    $prefixIcon = $getPrefixIcon();
    $prefixLabel = $getPrefixLabel();
    $suffixActions = $getSuffixActions();
    $suffixIcon = $getSuffixIcon();
    $suffixLabel = $getSuffixLabel();
    $statePath = $getStatePath();
?>

<?php if (isset($component)) { $__componentOriginal511d4862ff04963c3c16115c05a86a9d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal511d4862ff04963c3c16115c05a86a9d = $attributes; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => $getFieldWrapperView()] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\DynamicComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field' => $field,'inline-label-vertical-alignment' => \Filament\Support\Enums\VerticalAlignment::Center]); ?>
    <?php if (isset($component)) { $__componentOriginal505efd9768415fdb4543e8c564dad437 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal505efd9768415fdb4543e8c564dad437 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.input.wrapper','data' => ['disabled' => $isDisabled,'inlinePrefix' => $isPrefixInline,'inlineSuffix' => $isSuffixInline,'prefix' => $prefixLabel,'prefixActions' => $prefixActions,'prefixIcon' => $prefixIcon,'prefixIconColor' => $getPrefixIconColor(),'suffix' => $suffixLabel,'suffixActions' => $suffixActions,'suffixIcon' => $suffixIcon,'suffixIconColor' => $getSuffixIconColor(),'valid' => ! $errors->has($statePath),'attributes' => 
            \Filament\Support\prepare_inherited_attributes($getExtraAttributeBag())
                ->class(['fi-fo-select'])
        ]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::input.wrapper'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['disabled' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isDisabled),'inline-prefix' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isPrefixInline),'inline-suffix' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isSuffixInline),'prefix' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($prefixLabel),'prefix-actions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($prefixActions),'prefix-icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($prefixIcon),'prefix-icon-color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getPrefixIconColor()),'suffix' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($suffixLabel),'suffix-actions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($suffixActions),'suffix-icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($suffixIcon),'suffix-icon-color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getSuffixIconColor()),'valid' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(! $errors->has($statePath)),'attributes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(
            \Filament\Support\prepare_inherited_attributes($getExtraAttributeBag())
                ->class(['fi-fo-select'])
        )]); ?>
        <!--[if BLOCK]><![endif]--><?php if((! ($isSearchable() || $isMultiple()) && $isNative())): ?>
            <?php if (isset($component)) { $__componentOriginal97dc683fe4ff7acce9e296503563dd85 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal97dc683fe4ff7acce9e296503563dd85 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.input.select','data' => ['autofocus' => $isAutofocused(),'disabled' => $isDisabled,'id' => $getId(),'inlinePrefix' => $isPrefixInline && (count($prefixActions) || $prefixIcon || filled($prefixLabel)),'inlineSuffix' => $isSuffixInline && (count($suffixActions) || $suffixIcon || filled($suffixLabel)),'required' => $isRequired() && (! $isConcealed()),'attributes' => 
                    $getExtraInputAttributeBag()
                        ->merge([
                            $applyStateBindingModifiers('wire:model') => $statePath,
                        ], escape: false)
                ]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::input.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['autofocus' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isAutofocused()),'disabled' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isDisabled),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getId()),'inline-prefix' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isPrefixInline && (count($prefixActions) || $prefixIcon || filled($prefixLabel))),'inline-suffix' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isSuffixInline && (count($suffixActions) || $suffixIcon || filled($suffixLabel))),'required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isRequired() && (! $isConcealed())),'attributes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(
                    $getExtraInputAttributeBag()
                        ->merge([
                            $applyStateBindingModifiers('wire:model') => $statePath,
                        ], escape: false)
                )]); ?>
                <?php
                    $isHtmlAllowed = $isHtmlAllowed();
                ?>

                <!--[if BLOCK]><![endif]--><?php if($canSelectPlaceholder): ?>
                    <option value="">
                        <!--[if BLOCK]><![endif]--><?php if(! $isDisabled): ?>
                            <?php echo e($getPlaceholder()); ?>

                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </option>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $getOptions(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <!--[if BLOCK]><![endif]--><?php if(is_array($label)): ?>
                        <optgroup label="<?php echo e($value); ?>">
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $label; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupedValue => $groupedLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option
                                    <?php if($isOptionDisabled($groupedValue, $groupedLabel)): echo 'disabled'; endif; ?>
                                    value="<?php echo e($groupedValue); ?>"
                                >
                                    <!--[if BLOCK]><![endif]--><?php if($isHtmlAllowed): ?>
                                        <?php echo $groupedLabel; ?>

                                    <?php else: ?>
                                        <?php echo e($groupedLabel); ?>

                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </optgroup>
                    <?php else: ?>
                        <option
                            <?php if($isOptionDisabled($value, $label)): echo 'disabled'; endif; ?>
                            value="<?php echo e($value); ?>"
                        >
                            <!--[if BLOCK]><![endif]--><?php if($isHtmlAllowed): ?>
                                <?php echo $label; ?>

                            <?php else: ?>
                                <?php echo e($label); ?>

                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </option>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal97dc683fe4ff7acce9e296503563dd85)): ?>
<?php $attributes = $__attributesOriginal97dc683fe4ff7acce9e296503563dd85; ?>
<?php unset($__attributesOriginal97dc683fe4ff7acce9e296503563dd85); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal97dc683fe4ff7acce9e296503563dd85)): ?>
<?php $component = $__componentOriginal97dc683fe4ff7acce9e296503563dd85; ?>
<?php unset($__componentOriginal97dc683fe4ff7acce9e296503563dd85); ?>
<?php endif; ?>
        <?php else: ?>
            <div
                class="hidden"
                x-data="{
                    isDisabled: <?php echo \Illuminate\Support\Js::from($isDisabled)->toHtml() ?>,
                    init: function () {
                        const container = $el.nextElementSibling
                        container.dispatchEvent(
                            new CustomEvent('set-select-property', {
                                detail: { isDisabled: this.isDisabled },
                            }),
                        )
                    },
                }"
            ></div>
            <div
                x-ignore
                <?php if(FilamentView::hasSpaMode()): ?>
                    ax-load="visible || event (ax-modal-opened)"
                <?php else: ?>
                    ax-load
                <?php endif; ?>
                ax-load-src="<?php echo e(\Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('select', 'filament/forms')); ?>"
                x-data="selectFormComponent({
                            canSelectPlaceholder: <?php echo \Illuminate\Support\Js::from($canSelectPlaceholder)->toHtml() ?>,
                            isHtmlAllowed: <?php echo \Illuminate\Support\Js::from($isHtmlAllowed())->toHtml() ?>,
                            getOptionLabelUsing: async () => {
                                return await $wire.getFormSelectOptionLabel(<?php echo \Illuminate\Support\Js::from($statePath)->toHtml() ?>)
                            },
                            getOptionLabelsUsing: async () => {
                                return await $wire.getFormSelectOptionLabels(<?php echo \Illuminate\Support\Js::from($statePath)->toHtml() ?>)
                            },
                            getOptionsUsing: async () => {
                                return await $wire.getFormSelectOptions(<?php echo \Illuminate\Support\Js::from($statePath)->toHtml() ?>)
                            },
                            getSearchResultsUsing: async (search) => {
                                return await $wire.getFormSelectSearchResults(<?php echo \Illuminate\Support\Js::from($statePath)->toHtml() ?>, search)
                            },
                            isAutofocused: <?php echo \Illuminate\Support\Js::from($isAutofocused())->toHtml() ?>,
                            isMultiple: <?php echo \Illuminate\Support\Js::from($isMultiple())->toHtml() ?>,
                            isSearchable: <?php echo \Illuminate\Support\Js::from($isSearchable())->toHtml() ?>,
                            livewireId: <?php echo \Illuminate\Support\Js::from($this->getId())->toHtml() ?>,
                            hasDynamicOptions: <?php echo \Illuminate\Support\Js::from($hasDynamicOptions())->toHtml() ?>,
                            hasDynamicSearchResults: <?php echo \Illuminate\Support\Js::from($hasDynamicSearchResults())->toHtml() ?>,
                            loadingMessage: <?php echo \Illuminate\Support\Js::from($getLoadingMessage())->toHtml() ?>,
                            maxItems: <?php echo \Illuminate\Support\Js::from($getMaxItems())->toHtml() ?>,
                            maxItemsMessage: <?php echo \Illuminate\Support\Js::from($getMaxItemsMessage())->toHtml() ?>,
                            noSearchResultsMessage: <?php echo \Illuminate\Support\Js::from($getNoSearchResultsMessage())->toHtml() ?>,
                            options: <?php echo \Illuminate\Support\Js::from($getOptionsForJs())->toHtml() ?>,
                            optionsLimit: <?php echo \Illuminate\Support\Js::from($getOptionsLimit())->toHtml() ?>,
                            placeholder: <?php echo \Illuminate\Support\Js::from($getPlaceholder())->toHtml() ?>,
                            position: <?php echo \Illuminate\Support\Js::from($getPosition())->toHtml() ?>,
                            searchDebounce: <?php echo \Illuminate\Support\Js::from($getSearchDebounce())->toHtml() ?>,
                            searchingMessage: <?php echo \Illuminate\Support\Js::from($getSearchingMessage())->toHtml() ?>,
                            searchPrompt: <?php echo \Illuminate\Support\Js::from($getSearchPrompt())->toHtml() ?>,
                            searchableOptionFields: <?php echo \Illuminate\Support\Js::from($getSearchableOptionFields())->toHtml() ?>,
                            state: $wire.<?php echo e($applyStateBindingModifiers("\$entangle('{$statePath}')")); ?>,
                            statePath: <?php echo \Illuminate\Support\Js::from($statePath)->toHtml() ?>,
                        })"
                wire:ignore
                x-on:keydown.esc="select.dropdown.isActive && $event.stopPropagation()"
                x-on:set-select-property="$event.detail.isDisabled ? select.disable() : select.enable()"
                <?php echo e($attributes
                        ->merge($getExtraAlpineAttributes(), escape: false)
                        ->class([
                            '[&_.choices\_\_inner]:ps-0' => $isPrefixInline && (count($prefixActions) || $prefixIcon || filled($prefixLabel)),
                        ])); ?>

            >
                <select
                    x-ref="input"
                    <?php echo e($getExtraInputAttributeBag()
                            ->merge([
                                'disabled' => $isDisabled,
                                'id' => $getId(),
                                'multiple' => $isMultiple(),
                            ], escape: false)
                            ->class([
                                'h-9 w-full rounded-lg border-none bg-transparent !bg-none',
                            ])); ?>

                ></select>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal505efd9768415fdb4543e8c564dad437)): ?>
<?php $attributes = $__attributesOriginal505efd9768415fdb4543e8c564dad437; ?>
<?php unset($__attributesOriginal505efd9768415fdb4543e8c564dad437); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal505efd9768415fdb4543e8c564dad437)): ?>
<?php $component = $__componentOriginal505efd9768415fdb4543e8c564dad437; ?>
<?php unset($__componentOriginal505efd9768415fdb4543e8c564dad437); ?>
<?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal511d4862ff04963c3c16115c05a86a9d)): ?>
<?php $attributes = $__attributesOriginal511d4862ff04963c3c16115c05a86a9d; ?>
<?php unset($__attributesOriginal511d4862ff04963c3c16115c05a86a9d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal511d4862ff04963c3c16115c05a86a9d)): ?>
<?php $component = $__componentOriginal511d4862ff04963c3c16115c05a86a9d; ?>
<?php unset($__componentOriginal511d4862ff04963c3c16115c05a86a9d); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\forms\src\/../resources/views/components/select.blade.php ENDPATH**/ ?>