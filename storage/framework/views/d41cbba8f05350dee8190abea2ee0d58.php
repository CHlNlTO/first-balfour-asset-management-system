<?php
    use Filament\Support\Enums\Alignment;
    use Filament\Support\Enums\VerticalAlignment;
    use Filament\Support\Facades\FilamentView;
    use Filament\Tables\Columns\Column;
    use Filament\Tables\Columns\ColumnGroup;
    use Filament\Tables\Enums\ActionsPosition;
    use Filament\Tables\Enums\FiltersLayout;
    use Filament\Tables\Enums\RecordCheckboxPosition;
    use Illuminate\Support\Str;

    $actions = $getActions();
    $flatActionsCount = count($getFlatActions());
    $actionsAlignment = $getActionsAlignment();
    $actionsPosition = $getActionsPosition();
    $actionsColumnLabel = $getActionsColumnLabel();
    $activeFiltersCount = $getActiveFiltersCount();
    $columns = $getVisibleColumns();
    $collapsibleColumnsLayout = $getCollapsibleColumnsLayout();
    $columnsLayout = $getColumnsLayout();
    $content = $getContent();
    $contentGrid = $getContentGrid();
    $contentFooter = $getContentFooter();
    $filterIndicators = $getFilterIndicators();
    $hasColumnGroups = $hasColumnGroups();
    $hasColumnsLayout = $hasColumnsLayout();
    $hasSummary = $hasSummary();
    $header = $getHeader();
    $headerActions = array_filter(
        $getHeaderActions(),
        fn (\Filament\Tables\Actions\Action | \Filament\Tables\Actions\BulkAction | \Filament\Tables\Actions\ActionGroup $action): bool => $action->isVisible(),
    );
    $headerActionsPosition = $getHeaderActionsPosition();
    $heading = $getHeading();
    $group = $getGrouping();
    $bulkActions = array_filter(
        $getBulkActions(),
        fn (\Filament\Tables\Actions\BulkAction | \Filament\Tables\Actions\ActionGroup $action): bool => $action->isVisible(),
    );
    $groups = $getGroups();
    $description = $getDescription();
    $isGroupsOnly = $isGroupsOnly() && $group;
    $isReorderable = $isReorderable();
    $isReordering = $isReordering();
    $areGroupingSettingsVisible = (! $isReordering) && count($groups) && (! $areGroupingSettingsHidden());
    $isGroupingDirectionSettingHidden = $isGroupingDirectionSettingHidden();
    $isColumnSearchVisible = $isSearchableByColumn();
    $isGlobalSearchVisible = $isSearchable();
    $isSearchOnBlur = $isSearchOnBlur();
    $isSelectionEnabled = $isSelectionEnabled() && (! $isGroupsOnly);
    $selectsCurrentPageOnly = $selectsCurrentPageOnly();
    $recordCheckboxPosition = $getRecordCheckboxPosition();
    $isStriped = $isStriped();
    $isLoaded = $isLoaded();
    $hasFilters = $isFilterable();
    $filtersLayout = $getFiltersLayout();
    $filtersTriggerAction = $getFiltersTriggerAction();
    $hasFiltersDialog = $hasFilters && in_array($filtersLayout, [FiltersLayout::Dropdown, FiltersLayout::Modal]);
    $hasFiltersAboveContent = $hasFilters && in_array($filtersLayout, [FiltersLayout::AboveContent, FiltersLayout::AboveContentCollapsible]);
    $hasFiltersAboveContentCollapsible = $hasFilters && ($filtersLayout === FiltersLayout::AboveContentCollapsible);
    $hasFiltersBelowContent = $hasFilters && ($filtersLayout === FiltersLayout::BelowContent);
    $hasColumnToggleDropdown = $hasToggleableColumns();
    $hasHeader = $header || $heading || $description || ($headerActions && (! $isReordering)) || $isReorderable || $areGroupingSettingsVisible || $isGlobalSearchVisible || $hasFilters || count($filterIndicators) || $hasColumnToggleDropdown;
    $hasHeaderToolbar = $isReorderable || $areGroupingSettingsVisible || $isGlobalSearchVisible || $hasFiltersDialog || $hasColumnToggleDropdown;
    $pluralModelLabel = $getPluralModelLabel();
    $records = $isLoaded ? $getRecords() : null;
    $searchDebounce = $getSearchDebounce();
    $allSelectableRecordsCount = ($isSelectionEnabled && $isLoaded) ? $getAllSelectableRecordsCount() : null;
    $columnsCount = count($columns);
    $reorderRecordsTriggerAction = $getReorderRecordsTriggerAction($isReordering);
    $toggleColumnsTriggerAction = $getToggleColumnsTriggerAction();
    $page = $this->getTablePage();
    $defaultSortOptionLabel = $getDefaultSortOptionLabel();

    if (count($actions) && (! $isReordering)) {
        $columnsCount++;
    }

    if ($isSelectionEnabled || $isReordering) {
        $columnsCount++;
    }

    if ($group) {
        $groupedSummarySelectedState = $this->getTableSummarySelectedState($this->getAllTableSummaryQuery(), modifyQueryUsing: fn (\Illuminate\Database\Query\Builder $query) => $group->groupQuery($query, model: $getQuery()->getModel()));
    }

    $getHiddenClasses = function (Column | ColumnGroup $column): ?string {
        if ($breakpoint = $column->getHiddenFrom()) {
            return match ($breakpoint) {
                'sm' => 'sm:hidden',
                'md' => 'md:hidden',
                'lg' => 'lg:hidden',
                'xl' => 'xl:hidden',
                '2xl' => '2xl:hidden',
            };
        }

        if ($breakpoint = $column->getVisibleFrom()) {
            return match ($breakpoint) {
                'sm' => 'hidden sm:table-cell',
                'md' => 'hidden md:table-cell',
                'lg' => 'hidden lg:table-cell',
                'xl' => 'hidden xl:table-cell',
                '2xl' => 'hidden 2xl:table-cell',
            };
        }

        return null;
    };
?>

<div
    <?php if(! $isLoaded): ?>
        wire:init="loadTable"
    <?php endif; ?>
    x-ignore
    <?php if(FilamentView::hasSpaMode()): ?>
        ax-load="visible"
    <?php else: ?>
        ax-load
    <?php endif; ?>
    ax-load-src="<?php echo e(\Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('table', 'filament/tables')); ?>"
    x-data="table"
    class="<?php echo \Illuminate\Support\Arr::toCssClasses([
        'fi-ta',
        'animate-pulse' => $records === null,
    ]); ?>"
>
    <?php if (isset($component)) { $__componentOriginal848259f0d87ae1451c78bda371b1fb91 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal848259f0d87ae1451c78bda371b1fb91 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.container','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::container'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
        <div
            <?php if(! $hasHeader): ?> x-cloak <?php endif; ?>
            x-bind:hidden="! (<?php echo \Illuminate\Support\Js::from($hasHeader)->toHtml() ?> || (selectedRecords.length && <?php echo \Illuminate\Support\Js::from(count($bulkActions))->toHtml() ?>))"
            x-show="<?php echo \Illuminate\Support\Js::from($hasHeader)->toHtml() ?> || (selectedRecords.length && <?php echo \Illuminate\Support\Js::from(count($bulkActions))->toHtml() ?>)"
            class="fi-ta-header-ctn divide-y divide-gray-200 dark:divide-white/10"
        >
            <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\Tables\View\TablesRenderHook::HEADER_BEFORE, scopes: static::class)); ?>


            <!--[if BLOCK]><![endif]--><?php if($header): ?>
                <?php echo e($header); ?>

            <?php elseif(($heading || $description || $headerActions) && ! $isReordering): ?>
                <?php if (isset($component)) { $__componentOriginalef9fb53ceabf567a28c14d984e5af8d7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalef9fb53ceabf567a28c14d984e5af8d7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.header','data' => ['actions' => $isReordering ? [] : $headerActions,'actionsPosition' => $headerActionsPosition,'description' => $description,'heading' => $heading]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['actions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isReordering ? [] : $headerActions),'actions-position' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($headerActionsPosition),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($description),'heading' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($heading)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalef9fb53ceabf567a28c14d984e5af8d7)): ?>
<?php $attributes = $__attributesOriginalef9fb53ceabf567a28c14d984e5af8d7; ?>
<?php unset($__attributesOriginalef9fb53ceabf567a28c14d984e5af8d7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalef9fb53ceabf567a28c14d984e5af8d7)): ?>
<?php $component = $__componentOriginalef9fb53ceabf567a28c14d984e5af8d7; ?>
<?php unset($__componentOriginalef9fb53ceabf567a28c14d984e5af8d7); ?>
<?php endif; ?>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\Tables\View\TablesRenderHook::HEADER_AFTER, scopes: static::class)); ?>


            <!--[if BLOCK]><![endif]--><?php if($hasFiltersAboveContent): ?>
                <div
                    x-data="{ areFiltersOpen: <?php echo \Illuminate\Support\Js::from(! $hasFiltersAboveContentCollapsible)->toHtml() ?> }"
                    class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                        'fi-ta-filters-above-content-ctn grid px-4 py-4 sm:px-6',
                    ]); ?>"
                >
                    <?php if (isset($component)) { $__componentOriginal8fcc8bb3dcedd6e3c85ec7cd95e48b39 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8fcc8bb3dcedd6e3c85ec7cd95e48b39 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.filters.index','data' => ['applyAction' => $getFiltersApplyAction(),'form' => $getFiltersForm(),'xCloak' => true,'xShow' => 'areFiltersOpen']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::filters'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['apply-action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getFiltersApplyAction()),'form' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getFiltersForm()),'x-cloak' => true,'x-show' => 'areFiltersOpen']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8fcc8bb3dcedd6e3c85ec7cd95e48b39)): ?>
<?php $attributes = $__attributesOriginal8fcc8bb3dcedd6e3c85ec7cd95e48b39; ?>
<?php unset($__attributesOriginal8fcc8bb3dcedd6e3c85ec7cd95e48b39); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8fcc8bb3dcedd6e3c85ec7cd95e48b39)): ?>
<?php $component = $__componentOriginal8fcc8bb3dcedd6e3c85ec7cd95e48b39; ?>
<?php unset($__componentOriginal8fcc8bb3dcedd6e3c85ec7cd95e48b39); ?>
<?php endif; ?>

                    <!--[if BLOCK]><![endif]--><?php if($hasFiltersAboveContentCollapsible): ?>
                        <span
                            x-on:click="areFiltersOpen = ! areFiltersOpen"
                            x-bind:class="{ <?php echo \Illuminate\Support\Js::from($hasDeferredFilters() ? '-mt-7' : 'mt-3')->toHtml() ?>: areFiltersOpen }"
                            class="ms-auto"
                        >
                            <?php echo e($filtersTriggerAction->badge($activeFiltersCount)); ?>

                        </span>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\Tables\View\TablesRenderHook::TOOLBAR_BEFORE, scopes: static::class)); ?>


            <div
                <?php if(! $hasHeaderToolbar): ?> x-cloak <?php endif; ?>
                x-show="<?php echo \Illuminate\Support\Js::from($hasHeaderToolbar)->toHtml() ?> || (selectedRecords.length && <?php echo \Illuminate\Support\Js::from(count($bulkActions))->toHtml() ?>)"
                class="fi-ta-header-toolbar flex items-center justify-between gap-x-4 px-4 py-3 sm:px-6"
            >
                <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\Tables\View\TablesRenderHook::TOOLBAR_START, scopes: static::class)); ?>


                <div class="flex shrink-0 items-center gap-x-4">
                    <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\Tables\View\TablesRenderHook::TOOLBAR_REORDER_TRIGGER_BEFORE, scopes: static::class)); ?>


                    <!--[if BLOCK]><![endif]--><?php if($isReorderable): ?>
                        <span x-show="! selectedRecords.length">
                            <?php echo e($reorderRecordsTriggerAction); ?>

                        </span>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\Tables\View\TablesRenderHook::TOOLBAR_REORDER_TRIGGER_AFTER, scopes: static::class)); ?>


                    <!--[if BLOCK]><![endif]--><?php if((! $isReordering) && count($bulkActions)): ?>
                        <?php if (isset($component)) { $__componentOriginal32a2358b99de73a2a27625c392d6fe38 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal32a2358b99de73a2a27625c392d6fe38 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.actions','data' => ['actions' => $bulkActions,'xCloak' => 'x-cloak','xShow' => 'selectedRecords.length']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::actions'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['actions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($bulkActions),'x-cloak' => 'x-cloak','x-show' => 'selectedRecords.length']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal32a2358b99de73a2a27625c392d6fe38)): ?>
<?php $attributes = $__attributesOriginal32a2358b99de73a2a27625c392d6fe38; ?>
<?php unset($__attributesOriginal32a2358b99de73a2a27625c392d6fe38); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal32a2358b99de73a2a27625c392d6fe38)): ?>
<?php $component = $__componentOriginal32a2358b99de73a2a27625c392d6fe38; ?>
<?php unset($__componentOriginal32a2358b99de73a2a27625c392d6fe38); ?>
<?php endif; ?>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\Tables\View\TablesRenderHook::TOOLBAR_GROUPING_SELECTOR_BEFORE, scopes: static::class)); ?>


                    <!--[if BLOCK]><![endif]--><?php if($areGroupingSettingsVisible): ?>
                        <?php if (isset($component)) { $__componentOriginala566838def908aaa4b134b9484794278 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala566838def908aaa4b134b9484794278 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.groups','data' => ['directionSetting' => $isGroupingDirectionSettingHidden,'dropdownOnDesktop' => $areGroupingSettingsInDropdownOnDesktop(),'groups' => $groups,'triggerAction' => $getGroupRecordsTriggerAction()]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::groups'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['direction-setting' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isGroupingDirectionSettingHidden),'dropdown-on-desktop' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($areGroupingSettingsInDropdownOnDesktop()),'groups' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($groups),'trigger-action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getGroupRecordsTriggerAction())]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala566838def908aaa4b134b9484794278)): ?>
<?php $attributes = $__attributesOriginala566838def908aaa4b134b9484794278; ?>
<?php unset($__attributesOriginala566838def908aaa4b134b9484794278); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala566838def908aaa4b134b9484794278)): ?>
<?php $component = $__componentOriginala566838def908aaa4b134b9484794278; ?>
<?php unset($__componentOriginala566838def908aaa4b134b9484794278); ?>
<?php endif; ?>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\Tables\View\TablesRenderHook::TOOLBAR_GROUPING_SELECTOR_AFTER, scopes: static::class)); ?>

                </div>

                <!--[if BLOCK]><![endif]--><?php if($isGlobalSearchVisible || $hasFiltersDialog || $hasColumnToggleDropdown): ?>
                    <div class="ms-auto flex items-center gap-x-4">
                        <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\Tables\View\TablesRenderHook::TOOLBAR_SEARCH_BEFORE, scopes: static::class)); ?>


                        <!--[if BLOCK]><![endif]--><?php if($isGlobalSearchVisible): ?>
                            <?php if (isset($component)) { $__componentOriginal7ccc00a3eaa8946ec9c0ec17f5ab229b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7ccc00a3eaa8946ec9c0ec17f5ab229b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.search-field','data' => ['debounce' => $searchDebounce,'onBlur' => $isSearchOnBlur,'placeholder' => $getSearchPlaceholder()]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::search-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['debounce' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($searchDebounce),'on-blur' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isSearchOnBlur),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getSearchPlaceholder())]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7ccc00a3eaa8946ec9c0ec17f5ab229b)): ?>
<?php $attributes = $__attributesOriginal7ccc00a3eaa8946ec9c0ec17f5ab229b; ?>
<?php unset($__attributesOriginal7ccc00a3eaa8946ec9c0ec17f5ab229b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7ccc00a3eaa8946ec9c0ec17f5ab229b)): ?>
<?php $component = $__componentOriginal7ccc00a3eaa8946ec9c0ec17f5ab229b; ?>
<?php unset($__componentOriginal7ccc00a3eaa8946ec9c0ec17f5ab229b); ?>
<?php endif; ?>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                        <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\Tables\View\TablesRenderHook::TOOLBAR_SEARCH_AFTER, scopes: static::class)); ?>


                        <!--[if BLOCK]><![endif]--><?php if($hasFiltersDialog || $hasColumnToggleDropdown): ?>
                            <!--[if BLOCK]><![endif]--><?php if($hasFiltersDialog): ?>
                                <?php if (isset($component)) { $__componentOriginal067a65195e5146173dca4799c8ccf123 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal067a65195e5146173dca4799c8ccf123 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.filters.dialog','data' => ['activeFiltersCount' => $activeFiltersCount,'applyAction' => $getFiltersApplyAction(),'form' => $getFiltersForm(),'layout' => $filtersLayout,'maxHeight' => $getFiltersFormMaxHeight(),'triggerAction' => $filtersTriggerAction,'width' => $getFiltersFormWidth()]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::filters.dialog'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['active-filters-count' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($activeFiltersCount),'apply-action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getFiltersApplyAction()),'form' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getFiltersForm()),'layout' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filtersLayout),'max-height' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getFiltersFormMaxHeight()),'trigger-action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filtersTriggerAction),'width' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getFiltersFormWidth())]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal067a65195e5146173dca4799c8ccf123)): ?>
<?php $attributes = $__attributesOriginal067a65195e5146173dca4799c8ccf123; ?>
<?php unset($__attributesOriginal067a65195e5146173dca4799c8ccf123); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal067a65195e5146173dca4799c8ccf123)): ?>
<?php $component = $__componentOriginal067a65195e5146173dca4799c8ccf123; ?>
<?php unset($__componentOriginal067a65195e5146173dca4799c8ccf123); ?>
<?php endif; ?>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                            <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\Tables\View\TablesRenderHook::TOOLBAR_TOGGLE_COLUMN_TRIGGER_BEFORE, scopes: static::class)); ?>


                            <!--[if BLOCK]><![endif]--><?php if($hasColumnToggleDropdown): ?>
                                <?php if (isset($component)) { $__componentOriginal819b24f9f8a080df7cdd61b9f97a96fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal819b24f9f8a080df7cdd61b9f97a96fc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.column-toggle.dropdown','data' => ['form' => $getColumnToggleForm(),'maxHeight' => $getColumnToggleFormMaxHeight(),'triggerAction' => $toggleColumnsTriggerAction,'width' => $getColumnToggleFormWidth()]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::column-toggle.dropdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['form' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getColumnToggleForm()),'max-height' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getColumnToggleFormMaxHeight()),'trigger-action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($toggleColumnsTriggerAction),'width' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getColumnToggleFormWidth())]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal819b24f9f8a080df7cdd61b9f97a96fc)): ?>
<?php $attributes = $__attributesOriginal819b24f9f8a080df7cdd61b9f97a96fc; ?>
<?php unset($__attributesOriginal819b24f9f8a080df7cdd61b9f97a96fc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal819b24f9f8a080df7cdd61b9f97a96fc)): ?>
<?php $component = $__componentOriginal819b24f9f8a080df7cdd61b9f97a96fc; ?>
<?php unset($__componentOriginal819b24f9f8a080df7cdd61b9f97a96fc); ?>
<?php endif; ?>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                            <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\Tables\View\TablesRenderHook::TOOLBAR_TOGGLE_COLUMN_TRIGGER_AFTER, scopes: static::class)); ?>

                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\Tables\View\TablesRenderHook::TOOLBAR_END)); ?>

            </div>

            <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\Tables\View\TablesRenderHook::TOOLBAR_AFTER)); ?>

        </div>

        <!--[if BLOCK]><![endif]--><?php if($isReordering): ?>
            <?php if (isset($component)) { $__componentOriginal9544fb8e3a33805419fe3af6ca5104a0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9544fb8e3a33805419fe3af6ca5104a0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.reorder.indicator','data' => ['colspan' => $columnsCount]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::reorder.indicator'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['colspan' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnsCount)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9544fb8e3a33805419fe3af6ca5104a0)): ?>
<?php $attributes = $__attributesOriginal9544fb8e3a33805419fe3af6ca5104a0; ?>
<?php unset($__attributesOriginal9544fb8e3a33805419fe3af6ca5104a0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9544fb8e3a33805419fe3af6ca5104a0)): ?>
<?php $component = $__componentOriginal9544fb8e3a33805419fe3af6ca5104a0; ?>
<?php unset($__componentOriginal9544fb8e3a33805419fe3af6ca5104a0); ?>
<?php endif; ?>
        <?php elseif($isSelectionEnabled && $isLoaded): ?>
            <?php if (isset($component)) { $__componentOriginal351cd8fd9541a7f7d30623e7253eb988 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal351cd8fd9541a7f7d30623e7253eb988 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.selection.indicator','data' => ['allSelectableRecordsCount' => $allSelectableRecordsCount,'colspan' => $columnsCount,'page' => $page,'selectCurrentPageOnly' => $selectsCurrentPageOnly,'xBind:hidden' => '! selectedRecords.length','xShow' => 'selectedRecords.length']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::selection.indicator'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['all-selectable-records-count' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($allSelectableRecordsCount),'colspan' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnsCount),'page' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($page),'select-current-page-only' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($selectsCurrentPageOnly),'x-bind:hidden' => '! selectedRecords.length','x-show' => 'selectedRecords.length']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal351cd8fd9541a7f7d30623e7253eb988)): ?>
<?php $attributes = $__attributesOriginal351cd8fd9541a7f7d30623e7253eb988; ?>
<?php unset($__attributesOriginal351cd8fd9541a7f7d30623e7253eb988); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal351cd8fd9541a7f7d30623e7253eb988)): ?>
<?php $component = $__componentOriginal351cd8fd9541a7f7d30623e7253eb988; ?>
<?php unset($__componentOriginal351cd8fd9541a7f7d30623e7253eb988); ?>
<?php endif; ?>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <!--[if BLOCK]><![endif]--><?php if(count($filterIndicators)): ?>
            <?php if (isset($component)) { $__componentOriginal5726bbe65accd879ed70a6baa694294d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5726bbe65accd879ed70a6baa694294d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.filters.indicators','data' => ['indicators' => $filterIndicators]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::filters.indicators'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['indicators' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filterIndicators)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5726bbe65accd879ed70a6baa694294d)): ?>
<?php $attributes = $__attributesOriginal5726bbe65accd879ed70a6baa694294d; ?>
<?php unset($__attributesOriginal5726bbe65accd879ed70a6baa694294d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5726bbe65accd879ed70a6baa694294d)): ?>
<?php $component = $__componentOriginal5726bbe65accd879ed70a6baa694294d; ?>
<?php unset($__componentOriginal5726bbe65accd879ed70a6baa694294d); ?>
<?php endif; ?>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <div
            <?php if((! $isReordering) && ($pollingInterval = $getPollingInterval())): ?>
                wire:poll.<?php echo e($pollingInterval); ?>

            <?php endif; ?>
            class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                'fi-ta-content relative divide-y divide-gray-200 overflow-x-auto dark:divide-white/10 dark:border-t-white/10',
                '!border-t-0' => ! $hasHeader,
            ]); ?>"
        >
            <!--[if BLOCK]><![endif]--><?php if(($content || $hasColumnsLayout) && ($records !== null) && count($records)): ?>
                <!--[if BLOCK]><![endif]--><?php if(! $isReordering): ?>
                    <?php
                        $sortableColumns = array_filter(
                            $columns,
                            fn (\Filament\Tables\Columns\Column $column): bool => $column->isSortable(),
                        );
                    ?>

                    <!--[if BLOCK]><![endif]--><?php if($isSelectionEnabled || count($sortableColumns)): ?>
                        <div
                            class="flex items-center gap-4 gap-x-6 bg-gray-50 px-4 dark:bg-white/5 sm:px-6"
                        >
                            <!--[if BLOCK]><![endif]--><?php if($isSelectionEnabled && (! $isReordering)): ?>
                                <?php if (isset($component)) { $__componentOriginal36f68fca2c6625d1435d035c49146213 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal36f68fca2c6625d1435d035c49146213 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.selection.checkbox','data' => ['wire:key' => $this->getId() . '.table.bulk-select-page.checkbox.' . Str::random(),'label' => __('filament-tables::table.fields.bulk_select_page.label'),'xBind:checked' => '
                                        const recordsOnPage = getRecordsOnPage()

                                        if (recordsOnPage.length && areRecordsSelected(recordsOnPage)) {
                                            $el.checked = true

                                            return \'checked\'
                                        }

                                        $el.checked = false

                                        return null
                                    ','xOn:click' => 'toggleSelectRecordsOnPage','class' => 'fi-ta-page-checkbox my-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::selection.checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:key' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($this->getId() . '.table.bulk-select-page.checkbox.' . Str::random()),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('filament-tables::table.fields.bulk_select_page.label')),'x-bind:checked' => '
                                        const recordsOnPage = getRecordsOnPage()

                                        if (recordsOnPage.length && areRecordsSelected(recordsOnPage)) {
                                            $el.checked = true

                                            return \'checked\'
                                        }

                                        $el.checked = false

                                        return null
                                    ','x-on:click' => 'toggleSelectRecordsOnPage','class' => 'fi-ta-page-checkbox my-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal36f68fca2c6625d1435d035c49146213)): ?>
<?php $attributes = $__attributesOriginal36f68fca2c6625d1435d035c49146213; ?>
<?php unset($__attributesOriginal36f68fca2c6625d1435d035c49146213); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal36f68fca2c6625d1435d035c49146213)): ?>
<?php $component = $__componentOriginal36f68fca2c6625d1435d035c49146213; ?>
<?php unset($__componentOriginal36f68fca2c6625d1435d035c49146213); ?>
<?php endif; ?>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                            <!--[if BLOCK]><![endif]--><?php if(count($sortableColumns)): ?>
                                <div
                                    x-data="{
                                        column: $wire.$entangle('tableSortColumn', true),
                                        direction: $wire.$entangle('tableSortDirection', true),
                                    }"
                                    x-init="
                                        $watch('column', function (newColumn, oldColumn) {
                                            if (! newColumn) {
                                                direction = null

                                                return
                                            }

                                            if (oldColumn) {
                                                return
                                            }

                                            direction = 'asc'
                                        })
                                    "
                                    class="flex gap-x-3 py-3"
                                >
                                    <label>
                                        <?php if (isset($component)) { $__componentOriginal505efd9768415fdb4543e8c564dad437 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal505efd9768415fdb4543e8c564dad437 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.input.wrapper','data' => ['prefix' => __('filament-tables::table.sorting.fields.column.label')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::input.wrapper'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['prefix' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('filament-tables::table.sorting.fields.column.label'))]); ?>
                                            <?php if (isset($component)) { $__componentOriginal97dc683fe4ff7acce9e296503563dd85 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal97dc683fe4ff7acce9e296503563dd85 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.input.select','data' => ['xModel' => 'column']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::input.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['x-model' => 'column']); ?>
                                                <option value="">
                                                    <?php echo e($defaultSortOptionLabel); ?>

                                                </option>

                                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $sortableColumns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option
                                                        value="<?php echo e($column->getName()); ?>"
                                                    >
                                                        <?php echo e($column->getLabel()); ?>

                                                    </option>
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
                                    </label>

                                    <label x-cloak x-show="column">
                                        <span class="sr-only">
                                            <?php echo e(__('filament-tables::table.sorting.fields.direction.label')); ?>

                                        </span>

                                        <?php if (isset($component)) { $__componentOriginal505efd9768415fdb4543e8c564dad437 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal505efd9768415fdb4543e8c564dad437 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.input.wrapper','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::input.wrapper'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                                            <?php if (isset($component)) { $__componentOriginal97dc683fe4ff7acce9e296503563dd85 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal97dc683fe4ff7acce9e296503563dd85 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.input.select','data' => ['xModel' => 'direction']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::input.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['x-model' => 'direction']); ?>
                                                <option value="asc">
                                                    <?php echo e(__('filament-tables::table.sorting.fields.direction.options.asc')); ?>

                                                </option>

                                                <option value="desc">
                                                    <?php echo e(__('filament-tables::table.sorting.fields.direction.options.desc')); ?>

                                                </option>
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
                                    </label>
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <!--[if BLOCK]><![endif]--><?php if($content): ?>
                    <?php echo e($content->with(['records' => $records])); ?>

                <?php else: ?>
                    <?php if (isset($component)) { $__componentOriginal30dbd75eb120a380110a2b340cd88f46 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30dbd75eb120a380110a2b340cd88f46 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.grid.index','data' => ['default' => $contentGrid['default'] ?? 1,'sm' => $contentGrid['sm'] ?? null,'md' => $contentGrid['md'] ?? null,'lg' => $contentGrid['lg'] ?? null,'xl' => $contentGrid['xl'] ?? null,'twoXl' => $contentGrid['2xl'] ?? null,'xOn:end.stop' => '$wire.reorderTable($event.target.sortable.toArray())','xSortable' => true,'dataSortableAnimationDuration' => $getReorderAnimationDuration(),'class' => \Illuminate\Support\Arr::toCssClasses([
                            'fi-ta-content-grid gap-4 p-4 sm:px-6' => $contentGrid,
                            'pt-0' => $contentGrid && $this->getTableGrouping(),
                            'gap-y-px bg-gray-200 dark:bg-white/5' => ! $contentGrid,
                        ])]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::grid'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['default' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($contentGrid['default'] ?? 1),'sm' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($contentGrid['sm'] ?? null),'md' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($contentGrid['md'] ?? null),'lg' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($contentGrid['lg'] ?? null),'xl' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($contentGrid['xl'] ?? null),'two-xl' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($contentGrid['2xl'] ?? null),'x-on:end.stop' => '$wire.reorderTable($event.target.sortable.toArray())','x-sortable' => true,'data-sortable-animation-duration' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getReorderAnimationDuration()),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\Illuminate\Support\Arr::toCssClasses([
                            'fi-ta-content-grid gap-4 p-4 sm:px-6' => $contentGrid,
                            'pt-0' => $contentGrid && $this->getTableGrouping(),
                            'gap-y-px bg-gray-200 dark:bg-white/5' => ! $contentGrid,
                        ]))]); ?>
                        <?php
                            $previousRecord = null;
                            $previousRecordGroupKey = null;
                            $previousRecordGroupTitle = null;
                        ?>

                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $recordAction = $getRecordAction($record);
                                $recordKey = $getRecordKey($record);
                                $recordUrl = $getRecordUrl($record);
                                $openRecordUrlInNewTab = $shouldOpenRecordUrlInNewTab($record);
                                $recordGroupKey = $group?->getStringKey($record);
                                $recordGroupTitle = $group?->getTitle($record);

                                $collapsibleColumnsLayout?->record($record);
                                $hasCollapsibleColumnsLayout = (bool) $collapsibleColumnsLayout?->isVisible();
                            ?>

                            <!--[if BLOCK]><![endif]--><?php if($recordGroupTitle !== $previousRecordGroupTitle): ?>
                                <!--[if BLOCK]><![endif]--><?php if($hasSummary && (! $isReordering) && filled($previousRecordGroupTitle)): ?>
                                    <?php if (isset($component)) { $__componentOriginalce46e569391542b4e56f032ac7380f79 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce46e569391542b4e56f032ac7380f79 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.table','data' => ['class' => 'col-span-full']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'col-span-full']); ?>
                                        <?php if (isset($component)) { $__componentOriginala3ad14087ab6b316cf1e1d1a634acbeb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala3ad14087ab6b316cf1e1d1a634acbeb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.summary.row','data' => ['columns' => $columns,'extraHeadingColumn' => true,'heading' => 
                                                __('filament-tables::table.summary.subheadings.group', [
                                                    'group' => $previousRecordGroupTitle,
                                                    'label' => $pluralModelLabel,
                                                ])
                                            ,'placeholderColumns' => false,'query' => $group->scopeQuery($this->getAllTableSummaryQuery(), $previousRecord),'selectedState' => $groupedSummarySelectedState[$previousRecordGroupKey] ?? []]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::summary.row'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['columns' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columns),'extra-heading-column' => true,'heading' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(
                                                __('filament-tables::table.summary.subheadings.group', [
                                                    'group' => $previousRecordGroupTitle,
                                                    'label' => $pluralModelLabel,
                                                ])
                                            ),'placeholder-columns' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'query' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($group->scopeQuery($this->getAllTableSummaryQuery(), $previousRecord)),'selected-state' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($groupedSummarySelectedState[$previousRecordGroupKey] ?? [])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala3ad14087ab6b316cf1e1d1a634acbeb)): ?>
<?php $attributes = $__attributesOriginala3ad14087ab6b316cf1e1d1a634acbeb; ?>
<?php unset($__attributesOriginala3ad14087ab6b316cf1e1d1a634acbeb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala3ad14087ab6b316cf1e1d1a634acbeb)): ?>
<?php $component = $__componentOriginala3ad14087ab6b316cf1e1d1a634acbeb; ?>
<?php unset($__componentOriginala3ad14087ab6b316cf1e1d1a634acbeb); ?>
<?php endif; ?>
                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce46e569391542b4e56f032ac7380f79)): ?>
<?php $attributes = $__attributesOriginalce46e569391542b4e56f032ac7380f79; ?>
<?php unset($__attributesOriginalce46e569391542b4e56f032ac7380f79); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce46e569391542b4e56f032ac7380f79)): ?>
<?php $component = $__componentOriginalce46e569391542b4e56f032ac7380f79; ?>
<?php unset($__componentOriginalce46e569391542b4e56f032ac7380f79); ?>
<?php endif; ?>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                <?php if (isset($component)) { $__componentOriginal751169a5d74d7c8401df85650564cafc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal751169a5d74d7c8401df85650564cafc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.group.header','data' => ['collapsible' => $group->isCollapsible(),'description' => $group->getDescription($record, $recordGroupTitle),'label' => $group->isTitlePrefixedWithLabel() ? $group->getLabel() : null,'title' => $recordGroupTitle,'class' => \Illuminate\Support\Arr::toCssClasses([
                                        'col-span-full',
                                        '-mx-4 w-[calc(100%+2rem)] border-y border-gray-200 first:border-t-0 dark:border-white/5 sm:-mx-6 sm:w-[calc(100%+3rem)]' => $contentGrid,
                                    ]),'xBind:class' => $hasSummary ? null : '{ \'-mb-4 border-b-0\': isGroupCollapsed(' . \Illuminate\Support\Js::from($recordGroupTitle) . ') }']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::group.header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['collapsible' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($group->isCollapsible()),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($group->getDescription($record, $recordGroupTitle)),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($group->isTitlePrefixedWithLabel() ? $group->getLabel() : null),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($recordGroupTitle),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\Illuminate\Support\Arr::toCssClasses([
                                        'col-span-full',
                                        '-mx-4 w-[calc(100%+2rem)] border-y border-gray-200 first:border-t-0 dark:border-white/5 sm:-mx-6 sm:w-[calc(100%+3rem)]' => $contentGrid,
                                    ])),'x-bind:class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($hasSummary ? null : '{ \'-mb-4 border-b-0\': isGroupCollapsed(' . \Illuminate\Support\Js::from($recordGroupTitle) . ') }')]); ?>
                                    <!--[if BLOCK]><![endif]--><?php if($isSelectionEnabled): ?>
                                         <?php $__env->slot('start', null, []); ?> 
                                            <div class="px-3">
                                                <?php if (isset($component)) { $__componentOriginal1d4fa51bf7f7ed15068efea290223e8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1d4fa51bf7f7ed15068efea290223e8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.selection.group-checkbox','data' => ['page' => $page,'key' => $recordGroupKey,'title' => $recordGroupTitle]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::selection.group-checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['page' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($page),'key' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($recordGroupKey),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($recordGroupTitle)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1d4fa51bf7f7ed15068efea290223e8e)): ?>
<?php $attributes = $__attributesOriginal1d4fa51bf7f7ed15068efea290223e8e; ?>
<?php unset($__attributesOriginal1d4fa51bf7f7ed15068efea290223e8e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1d4fa51bf7f7ed15068efea290223e8e)): ?>
<?php $component = $__componentOriginal1d4fa51bf7f7ed15068efea290223e8e; ?>
<?php unset($__componentOriginal1d4fa51bf7f7ed15068efea290223e8e); ?>
<?php endif; ?>
                                            </div>
                                         <?php $__env->endSlot(); ?>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal751169a5d74d7c8401df85650564cafc)): ?>
<?php $attributes = $__attributesOriginal751169a5d74d7c8401df85650564cafc; ?>
<?php unset($__attributesOriginal751169a5d74d7c8401df85650564cafc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal751169a5d74d7c8401df85650564cafc)): ?>
<?php $component = $__componentOriginal751169a5d74d7c8401df85650564cafc; ?>
<?php unset($__componentOriginal751169a5d74d7c8401df85650564cafc); ?>
<?php endif; ?>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                            <div
                                <?php if($hasCollapsibleColumnsLayout): ?>
                                    x-data="{ isCollapsed: <?php echo \Illuminate\Support\Js::from($collapsibleColumnsLayout->isCollapsed())->toHtml() ?> }"
                                    x-init="$dispatch('collapsible-table-row-initialized')"
                                    x-on:collapse-all-table-rows.window="isCollapsed = true"
                                    x-on:expand-all-table-rows.window="isCollapsed = false"
                                    x-bind:class="isCollapsed && 'fi-collapsed'"
                                <?php endif; ?>
                                wire:key="<?php echo e($this->getId()); ?>.table.records.<?php echo e($recordKey); ?>"
                                <?php if($isReordering): ?>
                                    x-sortable-item="<?php echo e($recordKey); ?>"
                                    x-sortable-handle
                                <?php endif; ?>
                                class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                    'fi-ta-record relative h-full bg-white transition duration-75 dark:bg-gray-900',
                                    'hover:bg-gray-50 dark:hover:bg-white/5' => ($recordUrl || $recordAction) && (! $contentGrid),
                                    'hover:bg-gray-50 dark:hover:bg-white/10 dark:hover:ring-white/20' => ($recordUrl || $recordAction) && $contentGrid,
                                    'rounded-xl shadow-sm ring-1 ring-gray-950/5 dark:bg-white/5 dark:ring-white/10' => $contentGrid,
                                    ...$getRecordClasses($record),
                                ]); ?>"
                                x-bind:class="{
                                    'hidden':
                                        <?php echo e($group?->isCollapsible() ? 'true' : 'false'); ?> &&
                                        isGroupCollapsed(
                                            <?php echo e(\Illuminate\Support\Js::from($recordGroupTitle)); ?>,
                                        ),
                                    <?php echo e(($contentGrid ? '\'bg-gray-50 dark:bg-white/10 dark:ring-white/20\'' : '\'bg-gray-50 dark:bg-white/5 before:absolute before:start-0 before:inset-y-0 before:w-0.5 before:bg-primary-600 dark:before:bg-primary-500\'') . ': isRecordSelected(\'' . $recordKey . '\')'); ?>,
                                    <?php echo e($contentGrid ? '\'bg-white dark:bg-white/5 dark:ring-white/10\': ! isRecordSelected(\'' . $recordKey . '\')' : '\'\':\'\''); ?>,
                                }"
                            >
                                <?php
                                    $hasItemBeforeRecordContent = $isReordering || ($isSelectionEnabled && $isRecordSelectable($record));
                                    $isRecordCollapsible = $hasCollapsibleColumnsLayout && (! $isReordering);
                                    $hasItemAfterRecordContent = $isRecordCollapsible;
                                    $recordHasActions = count($actions) && (! $isReordering);

                                    $recordContentHorizontalPaddingClasses = \Illuminate\Support\Arr::toCssClasses([
                                        'ps-3' => (! $contentGrid) && $hasItemBeforeRecordContent,
                                        'ps-4 sm:ps-6' => (! $contentGrid) && (! $hasItemBeforeRecordContent),
                                        'pe-3' => (! $contentGrid) && $hasItemAfterRecordContent,
                                        'pe-4 sm:pe-6' => (! $contentGrid) && (! $hasItemAfterRecordContent),
                                        'ps-2' => $contentGrid && $hasItemBeforeRecordContent,
                                        'ps-4' => $contentGrid && (! $hasItemBeforeRecordContent),
                                        'pe-2' => $contentGrid && $hasItemAfterRecordContent,
                                        'pe-4' => $contentGrid && (! $hasItemAfterRecordContent),
                                    ]);

                                    $recordActionsClasses = \Illuminate\Support\Arr::toCssClasses([
                                        'md:ps-3' => (! $contentGrid),
                                        'order-first' => $actionsPosition === ActionsPosition::BeforeColumns,
                                        'ps-3' => (! $contentGrid) && $hasItemBeforeRecordContent,
                                        'ps-4 sm:ps-6' => (! $contentGrid) && (! $hasItemBeforeRecordContent),
                                        'pe-3' => (! $contentGrid) && $hasItemAfterRecordContent,
                                        'pe-4 sm:pe-6' => (! $contentGrid) && (! $hasItemAfterRecordContent),
                                        'ps-2' => $contentGrid && $hasItemBeforeRecordContent,
                                        'ps-4' => $contentGrid && (! $hasItemBeforeRecordContent),
                                        'pe-2' => $contentGrid && $hasItemAfterRecordContent,
                                        'pe-4' => $contentGrid && (! $hasItemAfterRecordContent),
                                    ]);
                                ?>

                                <div
                                    class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                        'flex items-center',
                                        'ps-1 sm:ps-3' => (! $contentGrid) && $hasItemBeforeRecordContent,
                                        'pe-1 sm:pe-3' => (! $contentGrid) && $hasItemAfterRecordContent,
                                        'ps-1' => $contentGrid && $hasItemBeforeRecordContent,
                                        'pe-1' => $contentGrid && $hasItemAfterRecordContent,
                                    ]); ?>"
                                >
                                    <!--[if BLOCK]><![endif]--><?php if($isReordering): ?>
                                        <?php if (isset($component)) { $__componentOriginal642b587c9495f7dd9ec654aae03995e8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal642b587c9495f7dd9ec654aae03995e8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.reorder.handle','data' => ['class' => 'mx-1 my-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::reorder.handle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mx-1 my-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal642b587c9495f7dd9ec654aae03995e8)): ?>
<?php $attributes = $__attributesOriginal642b587c9495f7dd9ec654aae03995e8; ?>
<?php unset($__attributesOriginal642b587c9495f7dd9ec654aae03995e8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal642b587c9495f7dd9ec654aae03995e8)): ?>
<?php $component = $__componentOriginal642b587c9495f7dd9ec654aae03995e8; ?>
<?php unset($__componentOriginal642b587c9495f7dd9ec654aae03995e8); ?>
<?php endif; ?>
                                    <?php elseif($isSelectionEnabled && $isRecordSelectable($record)): ?>
                                        <?php if (isset($component)) { $__componentOriginal36f68fca2c6625d1435d035c49146213 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal36f68fca2c6625d1435d035c49146213 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.selection.checkbox','data' => ['label' => __('filament-tables::table.fields.bulk_select_record.label', ['key' => $recordKey]),'value' => $recordKey,'xModel' => 'selectedRecords','dataGroup' => $recordGroupKey,'class' => 'fi-ta-record-checkbox mx-3 my-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::selection.checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('filament-tables::table.fields.bulk_select_record.label', ['key' => $recordKey])),'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($recordKey),'x-model' => 'selectedRecords','data-group' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($recordGroupKey),'class' => 'fi-ta-record-checkbox mx-3 my-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal36f68fca2c6625d1435d035c49146213)): ?>
<?php $attributes = $__attributesOriginal36f68fca2c6625d1435d035c49146213; ?>
<?php unset($__attributesOriginal36f68fca2c6625d1435d035c49146213); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal36f68fca2c6625d1435d035c49146213)): ?>
<?php $component = $__componentOriginal36f68fca2c6625d1435d035c49146213; ?>
<?php unset($__componentOriginal36f68fca2c6625d1435d035c49146213); ?>
<?php endif; ?>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                    <?php
                                        $recordContentClasses = \Illuminate\Support\Arr::toCssClasses([
                                            $recordContentHorizontalPaddingClasses,
                                            'block w-full',
                                        ]);
                                    ?>

                                    <div
                                        class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                            'flex w-full flex-col gap-y-3 py-4',
                                            'md:flex-row md:items-center' => ! $contentGrid,
                                        ]); ?>"
                                    >
                                        <div class="flex-1">
                                            <!--[if BLOCK]><![endif]--><?php if($recordUrl): ?>
                                                <a
                                                    <?php echo e(\Filament\Support\generate_href_html($recordUrl, $openRecordUrlInNewTab)); ?>

                                                    class="<?php echo e($recordContentClasses); ?>"
                                                >
                                                    <?php if (isset($component)) { $__componentOriginalb4a47f3f1d204ce572aba77586ad2030 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb4a47f3f1d204ce572aba77586ad2030 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.columns.layout','data' => ['components' => $columnsLayout,'record' => $record,'recordKey' => $recordKey,'rowLoop' => $loop]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::columns.layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['components' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnsLayout),'record' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($record),'record-key' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($recordKey),'row-loop' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($loop)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb4a47f3f1d204ce572aba77586ad2030)): ?>
<?php $attributes = $__attributesOriginalb4a47f3f1d204ce572aba77586ad2030; ?>
<?php unset($__attributesOriginalb4a47f3f1d204ce572aba77586ad2030); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb4a47f3f1d204ce572aba77586ad2030)): ?>
<?php $component = $__componentOriginalb4a47f3f1d204ce572aba77586ad2030; ?>
<?php unset($__componentOriginalb4a47f3f1d204ce572aba77586ad2030); ?>
<?php endif; ?>
                                                </a>
                                            <?php elseif($recordAction): ?>
                                                <?php
                                                    $recordWireClickAction = $getAction($recordAction)
                                                        ? "mountTableAction('{$recordAction}', '{$recordKey}')"
                                                        : $recordWireClickAction = "{$recordAction}('{$recordKey}')";
                                                ?>

                                                <button
                                                    type="button"
                                                    wire:click="<?php echo e($recordWireClickAction); ?>"
                                                    wire:loading.attr="disabled"
                                                    wire:target="<?php echo e($recordWireClickAction); ?>"
                                                    class="<?php echo e($recordContentClasses); ?>"
                                                >
                                                    <?php if (isset($component)) { $__componentOriginalb4a47f3f1d204ce572aba77586ad2030 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb4a47f3f1d204ce572aba77586ad2030 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.columns.layout','data' => ['components' => $columnsLayout,'record' => $record,'recordKey' => $recordKey,'rowLoop' => $loop]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::columns.layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['components' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnsLayout),'record' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($record),'record-key' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($recordKey),'row-loop' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($loop)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb4a47f3f1d204ce572aba77586ad2030)): ?>
<?php $attributes = $__attributesOriginalb4a47f3f1d204ce572aba77586ad2030; ?>
<?php unset($__attributesOriginalb4a47f3f1d204ce572aba77586ad2030); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb4a47f3f1d204ce572aba77586ad2030)): ?>
<?php $component = $__componentOriginalb4a47f3f1d204ce572aba77586ad2030; ?>
<?php unset($__componentOriginalb4a47f3f1d204ce572aba77586ad2030); ?>
<?php endif; ?>
                                                </button>
                                            <?php else: ?>
                                                <div
                                                    class="<?php echo e($recordContentClasses); ?>"
                                                >
                                                    <?php if (isset($component)) { $__componentOriginalb4a47f3f1d204ce572aba77586ad2030 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb4a47f3f1d204ce572aba77586ad2030 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.columns.layout','data' => ['components' => $columnsLayout,'record' => $record,'recordKey' => $recordKey,'rowLoop' => $loop]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::columns.layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['components' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnsLayout),'record' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($record),'record-key' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($recordKey),'row-loop' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($loop)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb4a47f3f1d204ce572aba77586ad2030)): ?>
<?php $attributes = $__attributesOriginalb4a47f3f1d204ce572aba77586ad2030; ?>
<?php unset($__attributesOriginalb4a47f3f1d204ce572aba77586ad2030); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb4a47f3f1d204ce572aba77586ad2030)): ?>
<?php $component = $__componentOriginalb4a47f3f1d204ce572aba77586ad2030; ?>
<?php unset($__componentOriginalb4a47f3f1d204ce572aba77586ad2030); ?>
<?php endif; ?>
                                                </div>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                            <!--[if BLOCK]><![endif]--><?php if($hasCollapsibleColumnsLayout && (! $isReordering)): ?>
                                                <div
                                                    x-collapse
                                                    x-show="! isCollapsed"
                                                    class="<?php echo e($recordContentHorizontalPaddingClasses); ?> mt-3"
                                                >
                                                    <?php echo e($collapsibleColumnsLayout->viewData(['recordKey' => $recordKey])); ?>

                                                </div>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </div>

                                        <!--[if BLOCK]><![endif]--><?php if($recordHasActions): ?>
                                            <?php if (isset($component)) { $__componentOriginal32a2358b99de73a2a27625c392d6fe38 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal32a2358b99de73a2a27625c392d6fe38 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.actions','data' => ['actions' => $actions,'alignment' => (! $contentGrid) ? 'start md:end' : Alignment::Start,'record' => $record,'wrap' => '-sm','class' => $recordActionsClasses]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::actions'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['actions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($actions),'alignment' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute((! $contentGrid) ? 'start md:end' : Alignment::Start),'record' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($record),'wrap' => '-sm','class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($recordActionsClasses)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal32a2358b99de73a2a27625c392d6fe38)): ?>
<?php $attributes = $__attributesOriginal32a2358b99de73a2a27625c392d6fe38; ?>
<?php unset($__attributesOriginal32a2358b99de73a2a27625c392d6fe38); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal32a2358b99de73a2a27625c392d6fe38)): ?>
<?php $component = $__componentOriginal32a2358b99de73a2a27625c392d6fe38; ?>
<?php unset($__componentOriginal32a2358b99de73a2a27625c392d6fe38); ?>
<?php endif; ?>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>

                                    <!--[if BLOCK]><![endif]--><?php if($isRecordCollapsible): ?>
                                        <?php if (isset($component)) { $__componentOriginalf0029cce6d19fd6d472097ff06a800a1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf0029cce6d19fd6d472097ff06a800a1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.icon-button','data' => ['color' => 'gray','iconAlias' => 'tables::columns.collapse-button','icon' => 'heroicon-m-chevron-down','xOn:click' => 'isCollapsed = ! isCollapsed','class' => 'mx-1 my-2 shrink-0','xBind:class' => '{ \'rotate-180\': isCollapsed }']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::icon-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => 'gray','icon-alias' => 'tables::columns.collapse-button','icon' => 'heroicon-m-chevron-down','x-on:click' => 'isCollapsed = ! isCollapsed','class' => 'mx-1 my-2 shrink-0','x-bind:class' => '{ \'rotate-180\': isCollapsed }']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf0029cce6d19fd6d472097ff06a800a1)): ?>
<?php $attributes = $__attributesOriginalf0029cce6d19fd6d472097ff06a800a1; ?>
<?php unset($__attributesOriginalf0029cce6d19fd6d472097ff06a800a1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf0029cce6d19fd6d472097ff06a800a1)): ?>
<?php $component = $__componentOriginalf0029cce6d19fd6d472097ff06a800a1; ?>
<?php unset($__componentOriginalf0029cce6d19fd6d472097ff06a800a1); ?>
<?php endif; ?>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>

                            <?php
                                $previousRecordGroupKey = $recordGroupKey;
                                $previousRecordGroupTitle = $recordGroupTitle;
                                $previousRecord = $record;
                            ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

                        <?php if($hasSummary && (! $isReordering) && filled($previousRecordGroupTitle) && ((! $records instanceof \Illuminate\Contracts\Pagination\Paginator) || (! $records->hasMorePages()))): ?>
                            <?php if (isset($component)) { $__componentOriginalce46e569391542b4e56f032ac7380f79 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce46e569391542b4e56f032ac7380f79 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.table','data' => ['class' => 'col-span-full']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'col-span-full']); ?>
                                <?php if (isset($component)) { $__componentOriginala3ad14087ab6b316cf1e1d1a634acbeb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala3ad14087ab6b316cf1e1d1a634acbeb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.summary.row','data' => ['columns' => $columns,'extraHeadingColumn' => true,'heading' => __('filament-tables::table.summary.subheadings.group', ['group' => $previousRecordGroupTitle, 'label' => $pluralModelLabel]),'placeholderColumns' => false,'query' => $group->scopeQuery($this->getAllTableSummaryQuery(), $previousRecord),'selectedState' => $groupedSummarySelectedState[$previousRecordGroupKey] ?? []]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::summary.row'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['columns' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columns),'extra-heading-column' => true,'heading' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('filament-tables::table.summary.subheadings.group', ['group' => $previousRecordGroupTitle, 'label' => $pluralModelLabel])),'placeholder-columns' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'query' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($group->scopeQuery($this->getAllTableSummaryQuery(), $previousRecord)),'selected-state' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($groupedSummarySelectedState[$previousRecordGroupKey] ?? [])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala3ad14087ab6b316cf1e1d1a634acbeb)): ?>
<?php $attributes = $__attributesOriginala3ad14087ab6b316cf1e1d1a634acbeb; ?>
<?php unset($__attributesOriginala3ad14087ab6b316cf1e1d1a634acbeb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala3ad14087ab6b316cf1e1d1a634acbeb)): ?>
<?php $component = $__componentOriginala3ad14087ab6b316cf1e1d1a634acbeb; ?>
<?php unset($__componentOriginala3ad14087ab6b316cf1e1d1a634acbeb); ?>
<?php endif; ?>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce46e569391542b4e56f032ac7380f79)): ?>
<?php $attributes = $__attributesOriginalce46e569391542b4e56f032ac7380f79; ?>
<?php unset($__attributesOriginalce46e569391542b4e56f032ac7380f79); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce46e569391542b4e56f032ac7380f79)): ?>
<?php $component = $__componentOriginalce46e569391542b4e56f032ac7380f79; ?>
<?php unset($__componentOriginalce46e569391542b4e56f032ac7380f79); ?>
<?php endif; ?>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
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
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <?php if(($content || $hasColumnsLayout) && $contentFooter): ?>
                    <?php echo e($contentFooter->with([
                            'columns' => $columns,
                            'records' => $records,
                        ])); ?>

                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <?php if($hasSummary && (! $isReordering)): ?>
                    <?php if (isset($component)) { $__componentOriginalce46e569391542b4e56f032ac7380f79 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce46e569391542b4e56f032ac7380f79 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.table','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                        <?php if (isset($component)) { $__componentOriginala8bb2de295dfa9cddf00151a9ea585e7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala8bb2de295dfa9cddf00151a9ea585e7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.summary.index','data' => ['columns' => $columns,'extraHeadingColumn' => true,'placeholderColumns' => false,'pluralModelLabel' => $pluralModelLabel,'records' => $records]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::summary'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['columns' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columns),'extra-heading-column' => true,'placeholder-columns' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'plural-model-label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pluralModelLabel),'records' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($records)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala8bb2de295dfa9cddf00151a9ea585e7)): ?>
<?php $attributes = $__attributesOriginala8bb2de295dfa9cddf00151a9ea585e7; ?>
<?php unset($__attributesOriginala8bb2de295dfa9cddf00151a9ea585e7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala8bb2de295dfa9cddf00151a9ea585e7)): ?>
<?php $component = $__componentOriginala8bb2de295dfa9cddf00151a9ea585e7; ?>
<?php unset($__componentOriginala8bb2de295dfa9cddf00151a9ea585e7); ?>
<?php endif; ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce46e569391542b4e56f032ac7380f79)): ?>
<?php $attributes = $__attributesOriginalce46e569391542b4e56f032ac7380f79; ?>
<?php unset($__attributesOriginalce46e569391542b4e56f032ac7380f79); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce46e569391542b4e56f032ac7380f79)): ?>
<?php $component = $__componentOriginalce46e569391542b4e56f032ac7380f79; ?>
<?php unset($__componentOriginalce46e569391542b4e56f032ac7380f79); ?>
<?php endif; ?>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <?php elseif(($records !== null) && count($records)): ?>
                <?php if (isset($component)) { $__componentOriginalce46e569391542b4e56f032ac7380f79 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce46e569391542b4e56f032ac7380f79 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.table','data' => ['reorderable' => $isReorderable,'reorderAnimationDuration' => $getReorderAnimationDuration()]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['reorderable' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isReorderable),'reorder-animation-duration' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getReorderAnimationDuration())]); ?>
                    <!--[if BLOCK]><![endif]--><?php if($hasColumnGroups): ?>
                         <?php $__env->slot('headerGroups', null, []); ?> 
                            <!--[if BLOCK]><![endif]--><?php if($isReordering): ?>
                                <th></th>
                            <?php else: ?>
                                <!--[if BLOCK]><![endif]--><?php if(count($actions) && in_array($actionsPosition, [ActionsPosition::BeforeCells, ActionsPosition::BeforeColumns])): ?>
                                    <th></th>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                <!--[if BLOCK]><![endif]--><?php if($isSelectionEnabled && $recordCheckboxPosition === RecordCheckboxPosition::BeforeCells): ?>
                                    <th></th>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $columnsLayout; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $columnGroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <!--[if BLOCK]><![endif]--><?php if($columnGroup instanceof Column): ?>
                                    <!--[if BLOCK]><![endif]--><?php if($columnGroup->isVisible() && (! $columnGroup->isToggledHidden())): ?>
                                        <th></th>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <?php elseif($columnGroup instanceof ColumnGroup): ?>
                                    <?php
                                        $columnGroupAlignment = $columnGroup->getAlignment();
                                        $columnGroupColumnsCount = count($columnGroup->getVisibleColumns());
                                        $isColumnGroupHeaderWrapped = $columnGroup->isHeaderWrapped();
                                    ?>

                                    <!--[if BLOCK]><![endif]--><?php if($columnGroupColumnsCount): ?>
                                        <th
                                            colspan="<?php echo e($columnGroupColumnsCount); ?>"
                                            <?php echo e($columnGroup->getExtraHeaderAttributeBag()->class([
                                                    'fi-table-header-group-cell border-gray-200 px-3 py-2 dark:border-white/5 sm:first-of-type:ps-6 sm:last-of-type:pe-6 [&:not(:first-of-type)]:border-s [&:not(:last-of-type)]:border-e',
                                                ])); ?>

                                        >
                                            <div
                                                class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                                    'flex w-full items-center',
                                                    'whitespace-nowrap' => ! $isColumnGroupHeaderWrapped,
                                                    'whitespace-normal' => $isColumnGroupHeaderWrapped,
                                                    match ($columnGroupAlignment) {
                                                        Alignment::Start => 'justify-start',
                                                        Alignment::Center => 'justify-center',
                                                        Alignment::End => 'justify-end',
                                                        Alignment::Left => 'justify-start rtl:flex-row-reverse',
                                                        Alignment::Right => 'justify-end rtl:flex-row-reverse',
                                                        Alignment::Justify, Alignment::Between => 'justify-between',
                                                        default => $columnGroupAlignment,
                                                    },
                                                    $getHiddenClasses($columnGroup),
                                                ]); ?>"
                                            >
                                                <span
                                                    class="text-sm font-semibold text-gray-950 dark:text-white"
                                                >
                                                    <?php echo e($columnGroup->getLabel()); ?>

                                                </span>
                                            </div>
                                        </th>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

                            <!--[if BLOCK]><![endif]--><?php if(! $isReordering): ?>
                                <?php if(count($actions) && in_array($actionsPosition, [ActionsPosition::AfterColumns, ActionsPosition::AfterCells])): ?>
                                    <th></th>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                <!--[if BLOCK]><![endif]--><?php if($isSelectionEnabled && $recordCheckboxPosition === RecordCheckboxPosition::AfterCells): ?>
                                    <th></th>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                         <?php $__env->endSlot(); ?>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                     <?php $__env->slot('header', null, []); ?> 
                        <!--[if BLOCK]><![endif]--><?php if($isReordering): ?>
                            <th></th>
                        <?php else: ?>
                            <?php if(count($actions) && $actionsPosition === ActionsPosition::BeforeCells): ?>
                                <!--[if BLOCK]><![endif]--><?php if($actionsColumnLabel): ?>
                                    <?php if (isset($component)) { $__componentOriginalc946417715b60679750e91f5abf4cc2e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc946417715b60679750e91f5abf4cc2e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.header-cell','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::header-cell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                                        <?php echo e($actionsColumnLabel); ?>

                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc946417715b60679750e91f5abf4cc2e)): ?>
<?php $attributes = $__attributesOriginalc946417715b60679750e91f5abf4cc2e; ?>
<?php unset($__attributesOriginalc946417715b60679750e91f5abf4cc2e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc946417715b60679750e91f5abf4cc2e)): ?>
<?php $component = $__componentOriginalc946417715b60679750e91f5abf4cc2e; ?>
<?php unset($__componentOriginalc946417715b60679750e91f5abf4cc2e); ?>
<?php endif; ?>
                                <?php else: ?>
                                    <th
                                        aria-label="<?php echo e(trans_choice('filament-tables::table.columns.actions.label', $flatActionsCount)); ?>"
                                        class="fi-ta-actions-header-cell w-1"
                                    ></th>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                            <!--[if BLOCK]><![endif]--><?php if($isSelectionEnabled && $recordCheckboxPosition === RecordCheckboxPosition::BeforeCells): ?>
                                <?php if (isset($component)) { $__componentOriginal07ac246849ddb88fbe4391e1bdc4df73 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal07ac246849ddb88fbe4391e1bdc4df73 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.selection.cell','data' => ['tag' => 'th']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::selection.cell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tag' => 'th']); ?>
                                    <?php if (isset($component)) { $__componentOriginal36f68fca2c6625d1435d035c49146213 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal36f68fca2c6625d1435d035c49146213 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.selection.checkbox','data' => ['wire:key' => $this->getId() . '.table.bulk-select-page.checkbox.' . Str::random(),'label' => __('filament-tables::table.fields.bulk_select_page.label'),'xBind:checked' => '
                                            const recordsOnPage = getRecordsOnPage()

                                            if (recordsOnPage.length && areRecordsSelected(recordsOnPage)) {
                                                $el.checked = true

                                                return \'checked\'
                                            }

                                            $el.checked = false

                                            return null
                                        ','xOn:click' => 'toggleSelectRecordsOnPage','class' => 'fi-ta-page-checkbox']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::selection.checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:key' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($this->getId() . '.table.bulk-select-page.checkbox.' . Str::random()),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('filament-tables::table.fields.bulk_select_page.label')),'x-bind:checked' => '
                                            const recordsOnPage = getRecordsOnPage()

                                            if (recordsOnPage.length && areRecordsSelected(recordsOnPage)) {
                                                $el.checked = true

                                                return \'checked\'
                                            }

                                            $el.checked = false

                                            return null
                                        ','x-on:click' => 'toggleSelectRecordsOnPage','class' => 'fi-ta-page-checkbox']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal36f68fca2c6625d1435d035c49146213)): ?>
<?php $attributes = $__attributesOriginal36f68fca2c6625d1435d035c49146213; ?>
<?php unset($__attributesOriginal36f68fca2c6625d1435d035c49146213); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal36f68fca2c6625d1435d035c49146213)): ?>
<?php $component = $__componentOriginal36f68fca2c6625d1435d035c49146213; ?>
<?php unset($__componentOriginal36f68fca2c6625d1435d035c49146213); ?>
<?php endif; ?>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal07ac246849ddb88fbe4391e1bdc4df73)): ?>
<?php $attributes = $__attributesOriginal07ac246849ddb88fbe4391e1bdc4df73; ?>
<?php unset($__attributesOriginal07ac246849ddb88fbe4391e1bdc4df73); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal07ac246849ddb88fbe4391e1bdc4df73)): ?>
<?php $component = $__componentOriginal07ac246849ddb88fbe4391e1bdc4df73; ?>
<?php unset($__componentOriginal07ac246849ddb88fbe4391e1bdc4df73); ?>
<?php endif; ?>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                            <?php if(count($actions) && $actionsPosition === ActionsPosition::BeforeColumns): ?>
                                <!--[if BLOCK]><![endif]--><?php if($actionsColumnLabel): ?>
                                    <?php if (isset($component)) { $__componentOriginalc946417715b60679750e91f5abf4cc2e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc946417715b60679750e91f5abf4cc2e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.header-cell','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::header-cell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                                        <?php echo e($actionsColumnLabel); ?>

                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc946417715b60679750e91f5abf4cc2e)): ?>
<?php $attributes = $__attributesOriginalc946417715b60679750e91f5abf4cc2e; ?>
<?php unset($__attributesOriginalc946417715b60679750e91f5abf4cc2e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc946417715b60679750e91f5abf4cc2e)): ?>
<?php $component = $__componentOriginalc946417715b60679750e91f5abf4cc2e; ?>
<?php unset($__componentOriginalc946417715b60679750e91f5abf4cc2e); ?>
<?php endif; ?>
                                <?php else: ?>
                                    <th
                                        aria-label="<?php echo e(trans_choice('filament-tables::table.columns.actions.label', $flatActionsCount)); ?>"
                                        class="fi-ta-actions-header-cell w-1"
                                    ></th>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $columnWidth = $column->getWidth();
                            ?>

                            <?php if (isset($component)) { $__componentOriginalc946417715b60679750e91f5abf4cc2e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc946417715b60679750e91f5abf4cc2e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.header-cell','data' => ['activelySorted' => $getSortColumn() === $column->getName(),'alignment' => $column->getAlignment(),'name' => $column->getName(),'sortable' => $column->isSortable() && (! $isReordering),'sortDirection' => $getSortDirection(),'wrap' => $column->isHeaderWrapped(),'attributes' => 
                                    \Filament\Support\prepare_inherited_attributes($column->getExtraHeaderAttributeBag())
                                        ->class([
                                            'fi-table-header-cell-' . str($column->getName())->camel()->kebab(),
                                            'w-full' => blank($columnWidth) && $column->canGrow(default: false),
                                            $getHiddenClasses($column),
                                        ])
                                        ->style([
                                            ('width: ' . $columnWidth) => filled($columnWidth),
                                        ])
                                ]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::header-cell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['actively-sorted' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getSortColumn() === $column->getName()),'alignment' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($column->getAlignment()),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($column->getName()),'sortable' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($column->isSortable() && (! $isReordering)),'sort-direction' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getSortDirection()),'wrap' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($column->isHeaderWrapped()),'attributes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(
                                    \Filament\Support\prepare_inherited_attributes($column->getExtraHeaderAttributeBag())
                                        ->class([
                                            'fi-table-header-cell-' . str($column->getName())->camel()->kebab(),
                                            'w-full' => blank($columnWidth) && $column->canGrow(default: false),
                                            $getHiddenClasses($column),
                                        ])
                                        ->style([
                                            ('width: ' . $columnWidth) => filled($columnWidth),
                                        ])
                                )]); ?>
                                <?php echo e($column->getLabel()); ?>

                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc946417715b60679750e91f5abf4cc2e)): ?>
<?php $attributes = $__attributesOriginalc946417715b60679750e91f5abf4cc2e; ?>
<?php unset($__attributesOriginalc946417715b60679750e91f5abf4cc2e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc946417715b60679750e91f5abf4cc2e)): ?>
<?php $component = $__componentOriginalc946417715b60679750e91f5abf4cc2e; ?>
<?php unset($__componentOriginalc946417715b60679750e91f5abf4cc2e); ?>
<?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

                        <!--[if BLOCK]><![endif]--><?php if(! $isReordering): ?>
                            <?php if(count($actions) && $actionsPosition === ActionsPosition::AfterColumns): ?>
                                <!--[if BLOCK]><![endif]--><?php if($actionsColumnLabel): ?>
                                    <?php if (isset($component)) { $__componentOriginalc946417715b60679750e91f5abf4cc2e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc946417715b60679750e91f5abf4cc2e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.header-cell','data' => ['alignment' => Alignment::Right]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::header-cell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['alignment' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(Alignment::Right)]); ?>
                                        <?php echo e($actionsColumnLabel); ?>

                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc946417715b60679750e91f5abf4cc2e)): ?>
<?php $attributes = $__attributesOriginalc946417715b60679750e91f5abf4cc2e; ?>
<?php unset($__attributesOriginalc946417715b60679750e91f5abf4cc2e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc946417715b60679750e91f5abf4cc2e)): ?>
<?php $component = $__componentOriginalc946417715b60679750e91f5abf4cc2e; ?>
<?php unset($__componentOriginalc946417715b60679750e91f5abf4cc2e); ?>
<?php endif; ?>
                                <?php else: ?>
                                    <th
                                        aria-label="<?php echo e(trans_choice('filament-tables::table.columns.actions.label', $flatActionsCount)); ?>"
                                        class="fi-ta-actions-header-cell w-1"
                                    ></th>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                            <!--[if BLOCK]><![endif]--><?php if($isSelectionEnabled && $recordCheckboxPosition === RecordCheckboxPosition::AfterCells): ?>
                                <?php if (isset($component)) { $__componentOriginal07ac246849ddb88fbe4391e1bdc4df73 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal07ac246849ddb88fbe4391e1bdc4df73 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.selection.cell','data' => ['tag' => 'th']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::selection.cell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tag' => 'th']); ?>
                                    <?php if (isset($component)) { $__componentOriginal36f68fca2c6625d1435d035c49146213 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal36f68fca2c6625d1435d035c49146213 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.selection.checkbox','data' => ['wire:key' => $this->getId() . '.table.bulk-select-page.checkbox.' . Str::random(),'label' => __('filament-tables::table.fields.bulk_select_page.label'),'xBind:checked' => '
                                            const recordsOnPage = getRecordsOnPage()

                                            if (recordsOnPage.length && areRecordsSelected(recordsOnPage)) {
                                                $el.checked = true

                                                return \'checked\'
                                            }

                                            $el.checked = false

                                            return null
                                        ','xOn:click' => 'toggleSelectRecordsOnPage','class' => 'fi-ta-page-checkbox']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::selection.checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:key' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($this->getId() . '.table.bulk-select-page.checkbox.' . Str::random()),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('filament-tables::table.fields.bulk_select_page.label')),'x-bind:checked' => '
                                            const recordsOnPage = getRecordsOnPage()

                                            if (recordsOnPage.length && areRecordsSelected(recordsOnPage)) {
                                                $el.checked = true

                                                return \'checked\'
                                            }

                                            $el.checked = false

                                            return null
                                        ','x-on:click' => 'toggleSelectRecordsOnPage','class' => 'fi-ta-page-checkbox']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal36f68fca2c6625d1435d035c49146213)): ?>
<?php $attributes = $__attributesOriginal36f68fca2c6625d1435d035c49146213; ?>
<?php unset($__attributesOriginal36f68fca2c6625d1435d035c49146213); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal36f68fca2c6625d1435d035c49146213)): ?>
<?php $component = $__componentOriginal36f68fca2c6625d1435d035c49146213; ?>
<?php unset($__componentOriginal36f68fca2c6625d1435d035c49146213); ?>
<?php endif; ?>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal07ac246849ddb88fbe4391e1bdc4df73)): ?>
<?php $attributes = $__attributesOriginal07ac246849ddb88fbe4391e1bdc4df73; ?>
<?php unset($__attributesOriginal07ac246849ddb88fbe4391e1bdc4df73); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal07ac246849ddb88fbe4391e1bdc4df73)): ?>
<?php $component = $__componentOriginal07ac246849ddb88fbe4391e1bdc4df73; ?>
<?php unset($__componentOriginal07ac246849ddb88fbe4391e1bdc4df73); ?>
<?php endif; ?>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                            <?php if(count($actions) && $actionsPosition === ActionsPosition::AfterCells): ?>
                                <!--[if BLOCK]><![endif]--><?php if($actionsColumnLabel): ?>
                                    <?php if (isset($component)) { $__componentOriginalc946417715b60679750e91f5abf4cc2e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc946417715b60679750e91f5abf4cc2e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.header-cell','data' => ['alignment' => Alignment::Right]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::header-cell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['alignment' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(Alignment::Right)]); ?>
                                        <?php echo e($actionsColumnLabel); ?>

                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc946417715b60679750e91f5abf4cc2e)): ?>
<?php $attributes = $__attributesOriginalc946417715b60679750e91f5abf4cc2e; ?>
<?php unset($__attributesOriginalc946417715b60679750e91f5abf4cc2e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc946417715b60679750e91f5abf4cc2e)): ?>
<?php $component = $__componentOriginalc946417715b60679750e91f5abf4cc2e; ?>
<?php unset($__componentOriginalc946417715b60679750e91f5abf4cc2e); ?>
<?php endif; ?>
                                <?php else: ?>
                                    <th
                                        aria-label="<?php echo e(trans_choice('filament-tables::table.columns.actions.label', $flatActionsCount)); ?>"
                                        class="fi-ta-actions-header-cell w-1"
                                    ></th>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                     <?php $__env->endSlot(); ?>

                    <!--[if BLOCK]><![endif]--><?php if($isColumnSearchVisible): ?>
                        <?php if (isset($component)) { $__componentOriginalb06932e913f01497313cb0ed448cecad = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb06932e913f01497313cb0ed448cecad = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.row','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::row'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                            <!--[if BLOCK]><![endif]--><?php if($isReordering): ?>
                                <td></td>
                            <?php else: ?>
                                <!--[if BLOCK]><![endif]--><?php if(count($actions) && in_array($actionsPosition, [ActionsPosition::BeforeCells, ActionsPosition::BeforeColumns])): ?>
                                    <td></td>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                <!--[if BLOCK]><![endif]--><?php if($isSelectionEnabled && $recordCheckboxPosition === RecordCheckboxPosition::BeforeCells): ?>
                                    <td></td>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if (isset($component)) { $__componentOriginal0582040fe960eff09c1461f7f86a8187 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0582040fe960eff09c1461f7f86a8187 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.cell','data' => ['class' => \Illuminate\Support\Arr::toCssClasses([
                                        'fi-table-individual-search-cell-' . str($column->getName())->camel()->kebab(),
                                        'min-w-48 px-3 py-2' => $isIndividuallySearchable = $column->isIndividuallySearchable(),
                                    ])]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::cell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\Illuminate\Support\Arr::toCssClasses([
                                        'fi-table-individual-search-cell-' . str($column->getName())->camel()->kebab(),
                                        'min-w-48 px-3 py-2' => $isIndividuallySearchable = $column->isIndividuallySearchable(),
                                    ]))]); ?>
                                    <!--[if BLOCK]><![endif]--><?php if($isIndividuallySearchable): ?>
                                        <?php if (isset($component)) { $__componentOriginal7ccc00a3eaa8946ec9c0ec17f5ab229b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7ccc00a3eaa8946ec9c0ec17f5ab229b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.search-field','data' => ['debounce' => $searchDebounce,'onBlur' => $isSearchOnBlur,'wireModel' => 'tableColumnSearches.'.e($column->getName()).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::search-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['debounce' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($searchDebounce),'on-blur' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isSearchOnBlur),'wire-model' => 'tableColumnSearches.'.e($column->getName()).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7ccc00a3eaa8946ec9c0ec17f5ab229b)): ?>
<?php $attributes = $__attributesOriginal7ccc00a3eaa8946ec9c0ec17f5ab229b; ?>
<?php unset($__attributesOriginal7ccc00a3eaa8946ec9c0ec17f5ab229b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7ccc00a3eaa8946ec9c0ec17f5ab229b)): ?>
<?php $component = $__componentOriginal7ccc00a3eaa8946ec9c0ec17f5ab229b; ?>
<?php unset($__componentOriginal7ccc00a3eaa8946ec9c0ec17f5ab229b); ?>
<?php endif; ?>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
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
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

                            <!--[if BLOCK]><![endif]--><?php if(! $isReordering): ?>
                                <?php if(count($actions) && in_array($actionsPosition, [ActionsPosition::AfterColumns, ActionsPosition::AfterCells])): ?>
                                    <td></td>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                <!--[if BLOCK]><![endif]--><?php if($isSelectionEnabled && $recordCheckboxPosition === RecordCheckboxPosition::AfterCells): ?>
                                    <td></td>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb06932e913f01497313cb0ed448cecad)): ?>
<?php $attributes = $__attributesOriginalb06932e913f01497313cb0ed448cecad; ?>
<?php unset($__attributesOriginalb06932e913f01497313cb0ed448cecad); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb06932e913f01497313cb0ed448cecad)): ?>
<?php $component = $__componentOriginalb06932e913f01497313cb0ed448cecad; ?>
<?php unset($__componentOriginalb06932e913f01497313cb0ed448cecad); ?>
<?php endif; ?>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <!--[if BLOCK]><![endif]--><?php if(($records !== null) && count($records)): ?>
                        <?php
                            $isRecordRowStriped = false;
                            $previousRecord = null;
                            $previousRecordGroupKey = null;
                            $previousRecordGroupTitle = null;
                        ?>

                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $recordAction = $getRecordAction($record);
                                $recordKey = $getRecordKey($record);
                                $recordUrl = $getRecordUrl($record);
                                $openRecordUrlInNewTab = $shouldOpenRecordUrlInNewTab($record);
                                $recordGroupKey = $group?->getStringKey($record);
                                $recordGroupTitle = $group?->getTitle($record);
                            ?>

                            <!--[if BLOCK]><![endif]--><?php if($recordGroupTitle !== $previousRecordGroupTitle): ?>
                                <!--[if BLOCK]><![endif]--><?php if($hasSummary && (! $isReordering) && filled($previousRecordGroupTitle)): ?>
                                    <?php if (isset($component)) { $__componentOriginala3ad14087ab6b316cf1e1d1a634acbeb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala3ad14087ab6b316cf1e1d1a634acbeb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.summary.row','data' => ['actions' => count($actions),'actionsPosition' => $actionsPosition,'columns' => $columns,'groupColumn' => $group?->getColumn(),'groupsOnly' => $isGroupsOnly,'heading' => $isGroupsOnly ? $previousRecordGroupTitle : __('filament-tables::table.summary.subheadings.group', ['group' => $previousRecordGroupTitle, 'label' => $pluralModelLabel]),'query' => $group->scopeQuery($this->getAllTableSummaryQuery(), $previousRecord),'recordCheckboxPosition' => $recordCheckboxPosition,'selectedState' => $groupedSummarySelectedState[$previousRecordGroupKey] ?? [],'selectionEnabled' => $isSelectionEnabled]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::summary.row'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['actions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(count($actions)),'actions-position' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($actionsPosition),'columns' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columns),'group-column' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($group?->getColumn()),'groups-only' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isGroupsOnly),'heading' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isGroupsOnly ? $previousRecordGroupTitle : __('filament-tables::table.summary.subheadings.group', ['group' => $previousRecordGroupTitle, 'label' => $pluralModelLabel])),'query' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($group->scopeQuery($this->getAllTableSummaryQuery(), $previousRecord)),'record-checkbox-position' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($recordCheckboxPosition),'selected-state' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($groupedSummarySelectedState[$previousRecordGroupKey] ?? []),'selection-enabled' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isSelectionEnabled)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala3ad14087ab6b316cf1e1d1a634acbeb)): ?>
<?php $attributes = $__attributesOriginala3ad14087ab6b316cf1e1d1a634acbeb; ?>
<?php unset($__attributesOriginala3ad14087ab6b316cf1e1d1a634acbeb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala3ad14087ab6b316cf1e1d1a634acbeb)): ?>
<?php $component = $__componentOriginala3ad14087ab6b316cf1e1d1a634acbeb; ?>
<?php unset($__componentOriginala3ad14087ab6b316cf1e1d1a634acbeb); ?>
<?php endif; ?>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                <!--[if BLOCK]><![endif]--><?php if(! $isGroupsOnly): ?>
                                    <?php if (isset($component)) { $__componentOriginalb06932e913f01497313cb0ed448cecad = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb06932e913f01497313cb0ed448cecad = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.row','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::row'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                                        <?php
                                            $groupHeaderColspan = $columnsCount;

                                            if ($isSelectionEnabled) {
                                                $groupHeaderColspan--;

                                                if (
                                                    ($recordCheckboxPosition === RecordCheckboxPosition::BeforeCells) &&
                                                    count($actions) &&
                                                    ($actionsPosition === ActionsPosition::BeforeCells)
                                                ) {
                                                    $groupHeaderColspan--;
                                                }
                                            }
                                        ?>

                                        <!--[if BLOCK]><![endif]--><?php if($isSelectionEnabled && $recordCheckboxPosition === RecordCheckboxPosition::BeforeCells): ?>
                                            <?php if(count($actions) && $actionsPosition === ActionsPosition::BeforeCells): ?>
                                                <td
                                                    class="bg-gray-50 dark:bg-white/5"
                                                ></td>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                            <?php if (isset($component)) { $__componentOriginala04fd2d12a1a3e3b0d02513168388c6b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala04fd2d12a1a3e3b0d02513168388c6b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.selection.group-cell','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::selection.group-cell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                                                <?php if (isset($component)) { $__componentOriginal1d4fa51bf7f7ed15068efea290223e8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1d4fa51bf7f7ed15068efea290223e8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.selection.group-checkbox','data' => ['page' => $page,'key' => $recordGroupKey,'title' => $recordGroupTitle]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::selection.group-checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['page' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($page),'key' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($recordGroupKey),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($recordGroupTitle)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1d4fa51bf7f7ed15068efea290223e8e)): ?>
<?php $attributes = $__attributesOriginal1d4fa51bf7f7ed15068efea290223e8e; ?>
<?php unset($__attributesOriginal1d4fa51bf7f7ed15068efea290223e8e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1d4fa51bf7f7ed15068efea290223e8e)): ?>
<?php $component = $__componentOriginal1d4fa51bf7f7ed15068efea290223e8e; ?>
<?php unset($__componentOriginal1d4fa51bf7f7ed15068efea290223e8e); ?>
<?php endif; ?>
                                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala04fd2d12a1a3e3b0d02513168388c6b)): ?>
<?php $attributes = $__attributesOriginala04fd2d12a1a3e3b0d02513168388c6b; ?>
<?php unset($__attributesOriginala04fd2d12a1a3e3b0d02513168388c6b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala04fd2d12a1a3e3b0d02513168388c6b)): ?>
<?php $component = $__componentOriginala04fd2d12a1a3e3b0d02513168388c6b; ?>
<?php unset($__componentOriginala04fd2d12a1a3e3b0d02513168388c6b); ?>
<?php endif; ?>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                        <td
                                            colspan="<?php echo e($groupHeaderColspan); ?>"
                                            class="p-0"
                                        >
                                            <?php if (isset($component)) { $__componentOriginal751169a5d74d7c8401df85650564cafc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal751169a5d74d7c8401df85650564cafc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.group.header','data' => ['collapsible' => $group->isCollapsible(),'description' => $group->getDescription($record, $recordGroupTitle),'label' => $group->isTitlePrefixedWithLabel() ? $group->getLabel() : null,'title' => $recordGroupTitle]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::group.header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['collapsible' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($group->isCollapsible()),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($group->getDescription($record, $recordGroupTitle)),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($group->isTitlePrefixedWithLabel() ? $group->getLabel() : null),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($recordGroupTitle)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal751169a5d74d7c8401df85650564cafc)): ?>
<?php $attributes = $__attributesOriginal751169a5d74d7c8401df85650564cafc; ?>
<?php unset($__attributesOriginal751169a5d74d7c8401df85650564cafc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal751169a5d74d7c8401df85650564cafc)): ?>
<?php $component = $__componentOriginal751169a5d74d7c8401df85650564cafc; ?>
<?php unset($__componentOriginal751169a5d74d7c8401df85650564cafc); ?>
<?php endif; ?>
                                        </td>

                                        <!--[if BLOCK]><![endif]--><?php if($isSelectionEnabled && $recordCheckboxPosition === RecordCheckboxPosition::AfterCells): ?>
                                            <?php if (isset($component)) { $__componentOriginala04fd2d12a1a3e3b0d02513168388c6b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala04fd2d12a1a3e3b0d02513168388c6b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.selection.group-cell','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::selection.group-cell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                                                <?php if (isset($component)) { $__componentOriginal1d4fa51bf7f7ed15068efea290223e8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1d4fa51bf7f7ed15068efea290223e8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.selection.group-checkbox','data' => ['page' => $page,'key' => $recordGroupKey,'title' => $recordGroupTitle]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::selection.group-checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['page' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($page),'key' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($recordGroupKey),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($recordGroupTitle)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1d4fa51bf7f7ed15068efea290223e8e)): ?>
<?php $attributes = $__attributesOriginal1d4fa51bf7f7ed15068efea290223e8e; ?>
<?php unset($__attributesOriginal1d4fa51bf7f7ed15068efea290223e8e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1d4fa51bf7f7ed15068efea290223e8e)): ?>
<?php $component = $__componentOriginal1d4fa51bf7f7ed15068efea290223e8e; ?>
<?php unset($__componentOriginal1d4fa51bf7f7ed15068efea290223e8e); ?>
<?php endif; ?>
                                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala04fd2d12a1a3e3b0d02513168388c6b)): ?>
<?php $attributes = $__attributesOriginala04fd2d12a1a3e3b0d02513168388c6b; ?>
<?php unset($__attributesOriginala04fd2d12a1a3e3b0d02513168388c6b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala04fd2d12a1a3e3b0d02513168388c6b)): ?>
<?php $component = $__componentOriginala04fd2d12a1a3e3b0d02513168388c6b; ?>
<?php unset($__componentOriginala04fd2d12a1a3e3b0d02513168388c6b); ?>
<?php endif; ?>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb06932e913f01497313cb0ed448cecad)): ?>
<?php $attributes = $__attributesOriginalb06932e913f01497313cb0ed448cecad; ?>
<?php unset($__attributesOriginalb06932e913f01497313cb0ed448cecad); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb06932e913f01497313cb0ed448cecad)): ?>
<?php $component = $__componentOriginalb06932e913f01497313cb0ed448cecad; ?>
<?php unset($__componentOriginalb06932e913f01497313cb0ed448cecad); ?>
<?php endif; ?>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                <?php
                                    $isRecordRowStriped = false;
                                ?>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                            <!--[if BLOCK]><![endif]--><?php if(! $isGroupsOnly): ?>
                                <?php if (isset($component)) { $__componentOriginalb06932e913f01497313cb0ed448cecad = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb06932e913f01497313cb0ed448cecad = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.row','data' => ['alpineHidden' => ($group?->isCollapsible() ? 'true' : 'false') . ' && isGroupCollapsed(' . \Illuminate\Support\Js::from($recordGroupTitle) . ')','alpineSelected' => 'isRecordSelected(\'' . $recordKey . '\')','recordAction' => $recordAction,'recordUrl' => $recordUrl,'striped' => $isStriped && $isRecordRowStriped,'wire:key' => $this->getId() . '.table.records.' . $recordKey,'xSortableHandle' => $isReordering,'xSortableItem' => $isReordering ? $recordKey : null,'class' => \Illuminate\Support\Arr::toCssClasses([
                                        'group cursor-move' => $isReordering,
                                        ...$getRecordClasses($record),
                                    ])]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::row'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['alpine-hidden' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(($group?->isCollapsible() ? 'true' : 'false') . ' && isGroupCollapsed(' . \Illuminate\Support\Js::from($recordGroupTitle) . ')'),'alpine-selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('isRecordSelected(\'' . $recordKey . '\')'),'record-action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($recordAction),'record-url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($recordUrl),'striped' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isStriped && $isRecordRowStriped),'wire:key' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($this->getId() . '.table.records.' . $recordKey),'x-sortable-handle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isReordering),'x-sortable-item' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isReordering ? $recordKey : null),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\Illuminate\Support\Arr::toCssClasses([
                                        'group cursor-move' => $isReordering,
                                        ...$getRecordClasses($record),
                                    ]))]); ?>
                                    <!--[if BLOCK]><![endif]--><?php if($isReordering): ?>
                                        <?php if (isset($component)) { $__componentOriginal9c6f3a3a23c38bf2a2648e925d56d579 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9c6f3a3a23c38bf2a2648e925d56d579 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.reorder.cell','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::reorder.cell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                                            <?php if (isset($component)) { $__componentOriginal642b587c9495f7dd9ec654aae03995e8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal642b587c9495f7dd9ec654aae03995e8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.reorder.handle','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::reorder.handle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal642b587c9495f7dd9ec654aae03995e8)): ?>
<?php $attributes = $__attributesOriginal642b587c9495f7dd9ec654aae03995e8; ?>
<?php unset($__attributesOriginal642b587c9495f7dd9ec654aae03995e8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal642b587c9495f7dd9ec654aae03995e8)): ?>
<?php $component = $__componentOriginal642b587c9495f7dd9ec654aae03995e8; ?>
<?php unset($__componentOriginal642b587c9495f7dd9ec654aae03995e8); ?>
<?php endif; ?>
                                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9c6f3a3a23c38bf2a2648e925d56d579)): ?>
<?php $attributes = $__attributesOriginal9c6f3a3a23c38bf2a2648e925d56d579; ?>
<?php unset($__attributesOriginal9c6f3a3a23c38bf2a2648e925d56d579); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9c6f3a3a23c38bf2a2648e925d56d579)): ?>
<?php $component = $__componentOriginal9c6f3a3a23c38bf2a2648e925d56d579; ?>
<?php unset($__componentOriginal9c6f3a3a23c38bf2a2648e925d56d579); ?>
<?php endif; ?>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                    <?php if(count($actions) && $actionsPosition === ActionsPosition::BeforeCells && (! $isReordering)): ?>
                                        <?php if (isset($component)) { $__componentOriginalc950258a370e70f1827bd55e98c3ced8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc950258a370e70f1827bd55e98c3ced8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.actions.cell','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::actions.cell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                                            <?php if (isset($component)) { $__componentOriginal32a2358b99de73a2a27625c392d6fe38 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal32a2358b99de73a2a27625c392d6fe38 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.actions','data' => ['actions' => $actions,'alignment' => $actionsAlignment,'record' => $record]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::actions'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['actions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($actions),'alignment' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($actionsAlignment),'record' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($record)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal32a2358b99de73a2a27625c392d6fe38)): ?>
<?php $attributes = $__attributesOriginal32a2358b99de73a2a27625c392d6fe38; ?>
<?php unset($__attributesOriginal32a2358b99de73a2a27625c392d6fe38); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal32a2358b99de73a2a27625c392d6fe38)): ?>
<?php $component = $__componentOriginal32a2358b99de73a2a27625c392d6fe38; ?>
<?php unset($__componentOriginal32a2358b99de73a2a27625c392d6fe38); ?>
<?php endif; ?>
                                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc950258a370e70f1827bd55e98c3ced8)): ?>
<?php $attributes = $__attributesOriginalc950258a370e70f1827bd55e98c3ced8; ?>
<?php unset($__attributesOriginalc950258a370e70f1827bd55e98c3ced8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc950258a370e70f1827bd55e98c3ced8)): ?>
<?php $component = $__componentOriginalc950258a370e70f1827bd55e98c3ced8; ?>
<?php unset($__componentOriginalc950258a370e70f1827bd55e98c3ced8); ?>
<?php endif; ?>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                    <!--[if BLOCK]><![endif]--><?php if($isSelectionEnabled && ($recordCheckboxPosition === RecordCheckboxPosition::BeforeCells) && (! $isReordering)): ?>
                                        <?php if (isset($component)) { $__componentOriginal07ac246849ddb88fbe4391e1bdc4df73 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal07ac246849ddb88fbe4391e1bdc4df73 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.selection.cell','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::selection.cell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                                            <!--[if BLOCK]><![endif]--><?php if($isRecordSelectable($record)): ?>
                                                <?php if (isset($component)) { $__componentOriginal36f68fca2c6625d1435d035c49146213 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal36f68fca2c6625d1435d035c49146213 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.selection.checkbox','data' => ['label' => __('filament-tables::table.fields.bulk_select_record.label', ['key' => $recordKey]),'value' => $recordKey,'xModel' => 'selectedRecords','dataGroup' => $recordGroupKey,'class' => 'fi-ta-record-checkbox']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::selection.checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('filament-tables::table.fields.bulk_select_record.label', ['key' => $recordKey])),'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($recordKey),'x-model' => 'selectedRecords','data-group' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($recordGroupKey),'class' => 'fi-ta-record-checkbox']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal36f68fca2c6625d1435d035c49146213)): ?>
<?php $attributes = $__attributesOriginal36f68fca2c6625d1435d035c49146213; ?>
<?php unset($__attributesOriginal36f68fca2c6625d1435d035c49146213); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal36f68fca2c6625d1435d035c49146213)): ?>
<?php $component = $__componentOriginal36f68fca2c6625d1435d035c49146213; ?>
<?php unset($__componentOriginal36f68fca2c6625d1435d035c49146213); ?>
<?php endif; ?>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal07ac246849ddb88fbe4391e1bdc4df73)): ?>
<?php $attributes = $__attributesOriginal07ac246849ddb88fbe4391e1bdc4df73; ?>
<?php unset($__attributesOriginal07ac246849ddb88fbe4391e1bdc4df73); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal07ac246849ddb88fbe4391e1bdc4df73)): ?>
<?php $component = $__componentOriginal07ac246849ddb88fbe4391e1bdc4df73; ?>
<?php unset($__componentOriginal07ac246849ddb88fbe4391e1bdc4df73); ?>
<?php endif; ?>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                    <?php if(count($actions) && $actionsPosition === ActionsPosition::BeforeColumns && (! $isReordering)): ?>
                                        <?php if (isset($component)) { $__componentOriginalc950258a370e70f1827bd55e98c3ced8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc950258a370e70f1827bd55e98c3ced8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.actions.cell','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::actions.cell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                                            <?php if (isset($component)) { $__componentOriginal32a2358b99de73a2a27625c392d6fe38 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal32a2358b99de73a2a27625c392d6fe38 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.actions','data' => ['actions' => $actions,'alignment' => $actionsAlignment,'record' => $record]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::actions'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['actions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($actions),'alignment' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($actionsAlignment),'record' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($record)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal32a2358b99de73a2a27625c392d6fe38)): ?>
<?php $attributes = $__attributesOriginal32a2358b99de73a2a27625c392d6fe38; ?>
<?php unset($__attributesOriginal32a2358b99de73a2a27625c392d6fe38); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal32a2358b99de73a2a27625c392d6fe38)): ?>
<?php $component = $__componentOriginal32a2358b99de73a2a27625c392d6fe38; ?>
<?php unset($__componentOriginal32a2358b99de73a2a27625c392d6fe38); ?>
<?php endif; ?>
                                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc950258a370e70f1827bd55e98c3ced8)): ?>
<?php $attributes = $__attributesOriginalc950258a370e70f1827bd55e98c3ced8; ?>
<?php unset($__attributesOriginalc950258a370e70f1827bd55e98c3ced8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc950258a370e70f1827bd55e98c3ced8)): ?>
<?php $component = $__componentOriginalc950258a370e70f1827bd55e98c3ced8; ?>
<?php unset($__componentOriginalc950258a370e70f1827bd55e98c3ced8); ?>
<?php endif; ?>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $column->record($record);
                                            $column->rowLoop($loop->parent);
                                        ?>

                                        <?php if (isset($component)) { $__componentOriginal0582040fe960eff09c1461f7f86a8187 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0582040fe960eff09c1461f7f86a8187 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.cell','data' => ['wire:key' => $this->getId() . '.table.record.' . $recordKey . '.column.' . $column->getName(),'attributes' => 
                                                \Filament\Support\prepare_inherited_attributes($column->getExtraCellAttributeBag())
                                                    ->class([
                                                        'fi-table-cell-' . str($column->getName())->camel()->kebab(),
                                                        match ($column->getVerticalAlignment()) {
                                                            VerticalAlignment::Start => 'align-top',
                                                            VerticalAlignment::Center => 'align-middle',
                                                            VerticalAlignment::End => 'align-bottom',
                                                            default => null,
                                                        },
                                                        $getHiddenClasses($column),
                                                    ])
                                            ]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::cell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:key' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($this->getId() . '.table.record.' . $recordKey . '.column.' . $column->getName()),'attributes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(
                                                \Filament\Support\prepare_inherited_attributes($column->getExtraCellAttributeBag())
                                                    ->class([
                                                        'fi-table-cell-' . str($column->getName())->camel()->kebab(),
                                                        match ($column->getVerticalAlignment()) {
                                                            VerticalAlignment::Start => 'align-top',
                                                            VerticalAlignment::Center => 'align-middle',
                                                            VerticalAlignment::End => 'align-bottom',
                                                            default => null,
                                                        },
                                                        $getHiddenClasses($column),
                                                    ])
                                            )]); ?>
                                            <?php if (isset($component)) { $__componentOriginal9e6c25ad176a3fd7bc1fa75b239c0fc8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9e6c25ad176a3fd7bc1fa75b239c0fc8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.columns.column','data' => ['column' => $column,'isClickDisabled' => $column->isClickDisabled() || $isReordering,'record' => $record,'recordAction' => $recordAction,'recordKey' => $recordKey,'recordUrl' => $recordUrl,'shouldOpenRecordUrlInNewTab' => $openRecordUrlInNewTab]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::columns.column'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['column' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($column),'is-click-disabled' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($column->isClickDisabled() || $isReordering),'record' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($record),'record-action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($recordAction),'record-key' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($recordKey),'record-url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($recordUrl),'should-open-record-url-in-new-tab' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($openRecordUrlInNewTab)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9e6c25ad176a3fd7bc1fa75b239c0fc8)): ?>
<?php $attributes = $__attributesOriginal9e6c25ad176a3fd7bc1fa75b239c0fc8; ?>
<?php unset($__attributesOriginal9e6c25ad176a3fd7bc1fa75b239c0fc8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9e6c25ad176a3fd7bc1fa75b239c0fc8)): ?>
<?php $component = $__componentOriginal9e6c25ad176a3fd7bc1fa75b239c0fc8; ?>
<?php unset($__componentOriginal9e6c25ad176a3fd7bc1fa75b239c0fc8); ?>
<?php endif; ?>
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
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

                                    <?php if(count($actions) && $actionsPosition === ActionsPosition::AfterColumns && (! $isReordering)): ?>
                                        <?php if (isset($component)) { $__componentOriginalc950258a370e70f1827bd55e98c3ced8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc950258a370e70f1827bd55e98c3ced8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.actions.cell','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::actions.cell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                                            <?php if (isset($component)) { $__componentOriginal32a2358b99de73a2a27625c392d6fe38 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal32a2358b99de73a2a27625c392d6fe38 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.actions','data' => ['actions' => $actions,'alignment' => $actionsAlignment ?? Alignment::End,'record' => $record]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::actions'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['actions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($actions),'alignment' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($actionsAlignment ?? Alignment::End),'record' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($record)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal32a2358b99de73a2a27625c392d6fe38)): ?>
<?php $attributes = $__attributesOriginal32a2358b99de73a2a27625c392d6fe38; ?>
<?php unset($__attributesOriginal32a2358b99de73a2a27625c392d6fe38); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal32a2358b99de73a2a27625c392d6fe38)): ?>
<?php $component = $__componentOriginal32a2358b99de73a2a27625c392d6fe38; ?>
<?php unset($__componentOriginal32a2358b99de73a2a27625c392d6fe38); ?>
<?php endif; ?>
                                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc950258a370e70f1827bd55e98c3ced8)): ?>
<?php $attributes = $__attributesOriginalc950258a370e70f1827bd55e98c3ced8; ?>
<?php unset($__attributesOriginalc950258a370e70f1827bd55e98c3ced8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc950258a370e70f1827bd55e98c3ced8)): ?>
<?php $component = $__componentOriginalc950258a370e70f1827bd55e98c3ced8; ?>
<?php unset($__componentOriginalc950258a370e70f1827bd55e98c3ced8); ?>
<?php endif; ?>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                    <!--[if BLOCK]><![endif]--><?php if($isSelectionEnabled && $recordCheckboxPosition === RecordCheckboxPosition::AfterCells && (! $isReordering)): ?>
                                        <?php if (isset($component)) { $__componentOriginal07ac246849ddb88fbe4391e1bdc4df73 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal07ac246849ddb88fbe4391e1bdc4df73 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.selection.cell','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::selection.cell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                                            <!--[if BLOCK]><![endif]--><?php if($isRecordSelectable($record)): ?>
                                                <?php if (isset($component)) { $__componentOriginal36f68fca2c6625d1435d035c49146213 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal36f68fca2c6625d1435d035c49146213 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.selection.checkbox','data' => ['label' => __('filament-tables::table.fields.bulk_select_record.label', ['key' => $recordKey]),'value' => $recordKey,'xModel' => 'selectedRecords','dataGroup' => $recordGroupKey,'class' => 'fi-ta-record-checkbox']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::selection.checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('filament-tables::table.fields.bulk_select_record.label', ['key' => $recordKey])),'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($recordKey),'x-model' => 'selectedRecords','data-group' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($recordGroupKey),'class' => 'fi-ta-record-checkbox']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal36f68fca2c6625d1435d035c49146213)): ?>
<?php $attributes = $__attributesOriginal36f68fca2c6625d1435d035c49146213; ?>
<?php unset($__attributesOriginal36f68fca2c6625d1435d035c49146213); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal36f68fca2c6625d1435d035c49146213)): ?>
<?php $component = $__componentOriginal36f68fca2c6625d1435d035c49146213; ?>
<?php unset($__componentOriginal36f68fca2c6625d1435d035c49146213); ?>
<?php endif; ?>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal07ac246849ddb88fbe4391e1bdc4df73)): ?>
<?php $attributes = $__attributesOriginal07ac246849ddb88fbe4391e1bdc4df73; ?>
<?php unset($__attributesOriginal07ac246849ddb88fbe4391e1bdc4df73); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal07ac246849ddb88fbe4391e1bdc4df73)): ?>
<?php $component = $__componentOriginal07ac246849ddb88fbe4391e1bdc4df73; ?>
<?php unset($__componentOriginal07ac246849ddb88fbe4391e1bdc4df73); ?>
<?php endif; ?>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                    <?php if(count($actions) && $actionsPosition === ActionsPosition::AfterCells): ?>
                                        <?php if (isset($component)) { $__componentOriginalc950258a370e70f1827bd55e98c3ced8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc950258a370e70f1827bd55e98c3ced8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.actions.cell','data' => ['class' => \Illuminate\Support\Arr::toCssClasses([
                                                'hidden' => $isReordering,
                                            ])]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::actions.cell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\Illuminate\Support\Arr::toCssClasses([
                                                'hidden' => $isReordering,
                                            ]))]); ?>
                                            <?php if (isset($component)) { $__componentOriginal32a2358b99de73a2a27625c392d6fe38 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal32a2358b99de73a2a27625c392d6fe38 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.actions','data' => ['actions' => $actions,'alignment' => $actionsAlignment ?? Alignment::End,'record' => $record]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::actions'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['actions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($actions),'alignment' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($actionsAlignment ?? Alignment::End),'record' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($record)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal32a2358b99de73a2a27625c392d6fe38)): ?>
<?php $attributes = $__attributesOriginal32a2358b99de73a2a27625c392d6fe38; ?>
<?php unset($__attributesOriginal32a2358b99de73a2a27625c392d6fe38); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal32a2358b99de73a2a27625c392d6fe38)): ?>
<?php $component = $__componentOriginal32a2358b99de73a2a27625c392d6fe38; ?>
<?php unset($__componentOriginal32a2358b99de73a2a27625c392d6fe38); ?>
<?php endif; ?>
                                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc950258a370e70f1827bd55e98c3ced8)): ?>
<?php $attributes = $__attributesOriginalc950258a370e70f1827bd55e98c3ced8; ?>
<?php unset($__attributesOriginalc950258a370e70f1827bd55e98c3ced8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc950258a370e70f1827bd55e98c3ced8)): ?>
<?php $component = $__componentOriginalc950258a370e70f1827bd55e98c3ced8; ?>
<?php unset($__componentOriginalc950258a370e70f1827bd55e98c3ced8); ?>
<?php endif; ?>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb06932e913f01497313cb0ed448cecad)): ?>
<?php $attributes = $__attributesOriginalb06932e913f01497313cb0ed448cecad; ?>
<?php unset($__attributesOriginalb06932e913f01497313cb0ed448cecad); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb06932e913f01497313cb0ed448cecad)): ?>
<?php $component = $__componentOriginalb06932e913f01497313cb0ed448cecad; ?>
<?php unset($__componentOriginalb06932e913f01497313cb0ed448cecad); ?>
<?php endif; ?>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                            <?php
                                $isRecordRowStriped = ! $isRecordRowStriped;
                                $previousRecord = $record;
                                $previousRecordGroupKey = $recordGroupKey;
                                $previousRecordGroupTitle = $recordGroupTitle;
                            ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

                        <?php if($hasSummary && (! $isReordering) && filled($previousRecordGroupTitle) && ((! $records instanceof \Illuminate\Contracts\Pagination\Paginator) || (! $records->hasMorePages()))): ?>
                            <?php if (isset($component)) { $__componentOriginala3ad14087ab6b316cf1e1d1a634acbeb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala3ad14087ab6b316cf1e1d1a634acbeb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.summary.row','data' => ['actions' => count($actions),'actionsPosition' => $actionsPosition,'columns' => $columns,'groupColumn' => $group?->getColumn(),'groupsOnly' => $isGroupsOnly,'heading' => $isGroupsOnly ? $previousRecordGroupTitle : __('filament-tables::table.summary.subheadings.group', ['group' => $previousRecordGroupTitle, 'label' => $pluralModelLabel]),'query' => $group->scopeQuery($this->getAllTableSummaryQuery(), $previousRecord),'recordCheckboxPosition' => $recordCheckboxPosition,'selectedState' => $groupedSummarySelectedState[$previousRecordGroupKey] ?? [],'selectionEnabled' => $isSelectionEnabled]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::summary.row'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['actions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(count($actions)),'actions-position' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($actionsPosition),'columns' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columns),'group-column' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($group?->getColumn()),'groups-only' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isGroupsOnly),'heading' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isGroupsOnly ? $previousRecordGroupTitle : __('filament-tables::table.summary.subheadings.group', ['group' => $previousRecordGroupTitle, 'label' => $pluralModelLabel])),'query' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($group->scopeQuery($this->getAllTableSummaryQuery(), $previousRecord)),'record-checkbox-position' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($recordCheckboxPosition),'selected-state' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($groupedSummarySelectedState[$previousRecordGroupKey] ?? []),'selection-enabled' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isSelectionEnabled)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala3ad14087ab6b316cf1e1d1a634acbeb)): ?>
<?php $attributes = $__attributesOriginala3ad14087ab6b316cf1e1d1a634acbeb; ?>
<?php unset($__attributesOriginala3ad14087ab6b316cf1e1d1a634acbeb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala3ad14087ab6b316cf1e1d1a634acbeb)): ?>
<?php $component = $__componentOriginala3ad14087ab6b316cf1e1d1a634acbeb; ?>
<?php unset($__componentOriginala3ad14087ab6b316cf1e1d1a634acbeb); ?>
<?php endif; ?>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                        <?php if($hasSummary && (! $isReordering)): ?>
                            <?php if (isset($component)) { $__componentOriginala8bb2de295dfa9cddf00151a9ea585e7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala8bb2de295dfa9cddf00151a9ea585e7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.summary.index','data' => ['actions' => count($actions),'actionsPosition' => $actionsPosition,'columns' => $columns,'groupColumn' => $group?->getColumn(),'groupsOnly' => $isGroupsOnly,'pluralModelLabel' => $pluralModelLabel,'recordCheckboxPosition' => $recordCheckboxPosition,'records' => $records,'selectionEnabled' => $isSelectionEnabled]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::summary'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['actions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(count($actions)),'actions-position' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($actionsPosition),'columns' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columns),'group-column' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($group?->getColumn()),'groups-only' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isGroupsOnly),'plural-model-label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pluralModelLabel),'record-checkbox-position' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($recordCheckboxPosition),'records' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($records),'selection-enabled' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isSelectionEnabled)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala8bb2de295dfa9cddf00151a9ea585e7)): ?>
<?php $attributes = $__attributesOriginala8bb2de295dfa9cddf00151a9ea585e7; ?>
<?php unset($__attributesOriginala8bb2de295dfa9cddf00151a9ea585e7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala8bb2de295dfa9cddf00151a9ea585e7)): ?>
<?php $component = $__componentOriginala8bb2de295dfa9cddf00151a9ea585e7; ?>
<?php unset($__componentOriginala8bb2de295dfa9cddf00151a9ea585e7); ?>
<?php endif; ?>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                        <!--[if BLOCK]><![endif]--><?php if($contentFooter): ?>
                             <?php $__env->slot('footer', null, []); ?> 
                                <?php echo e($contentFooter->with([
                                        'columns' => $columns,
                                        'records' => $records,
                                    ])); ?>

                             <?php $__env->endSlot(); ?>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce46e569391542b4e56f032ac7380f79)): ?>
<?php $attributes = $__attributesOriginalce46e569391542b4e56f032ac7380f79; ?>
<?php unset($__attributesOriginalce46e569391542b4e56f032ac7380f79); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce46e569391542b4e56f032ac7380f79)): ?>
<?php $component = $__componentOriginalce46e569391542b4e56f032ac7380f79; ?>
<?php unset($__componentOriginalce46e569391542b4e56f032ac7380f79); ?>
<?php endif; ?>
            <?php elseif($records === null): ?>
                <div class="h-32"></div>
            <?php elseif($emptyState = $getEmptyState()): ?>
                <?php echo e($emptyState); ?>

            <?php else: ?>
                <tr>
                    <td colspan="<?php echo e($columnsCount); ?>">
                        <?php if (isset($component)) { $__componentOriginal9608358ee6650b8d3d7c633eba6d028e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9608358ee6650b8d3d7c633eba6d028e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.empty-state.index','data' => ['actions' => $getEmptyStateActions(),'description' => $getEmptyStateDescription(),'heading' => $getEmptyStateHeading(),'icon' => $getEmptyStateIcon()]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['actions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getEmptyStateActions()),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getEmptyStateDescription()),'heading' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getEmptyStateHeading()),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getEmptyStateIcon())]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9608358ee6650b8d3d7c633eba6d028e)): ?>
<?php $attributes = $__attributesOriginal9608358ee6650b8d3d7c633eba6d028e; ?>
<?php unset($__attributesOriginal9608358ee6650b8d3d7c633eba6d028e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9608358ee6650b8d3d7c633eba6d028e)): ?>
<?php $component = $__componentOriginal9608358ee6650b8d3d7c633eba6d028e; ?>
<?php unset($__componentOriginal9608358ee6650b8d3d7c633eba6d028e); ?>
<?php endif; ?>
                    </td>
                </tr>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        <!--[if BLOCK]><![endif]--><?php if((($records instanceof \Illuminate\Contracts\Pagination\Paginator) || ($records instanceof \Illuminate\Contracts\Pagination\CursorPaginator)) &&
             ((! ($records instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)) || $records->total())): ?>
            <?php if (isset($component)) { $__componentOriginal0c287a00f29f01c8f977078ff96faed4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0c287a00f29f01c8f977078ff96faed4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.pagination.index','data' => ['extremeLinks' => $hasExtremePaginationLinks(),'pageOptions' => $getPaginationPageOptions(),'paginator' => $records,'class' => 'fi-ta-pagination px-3 py-3 sm:px-6']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::pagination'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['extreme-links' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($hasExtremePaginationLinks()),'page-options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getPaginationPageOptions()),'paginator' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($records),'class' => 'fi-ta-pagination px-3 py-3 sm:px-6']); ?>
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
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <!--[if BLOCK]><![endif]--><?php if($hasFiltersBelowContent): ?>
            <?php if (isset($component)) { $__componentOriginal8fcc8bb3dcedd6e3c85ec7cd95e48b39 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8fcc8bb3dcedd6e3c85ec7cd95e48b39 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.filters.index','data' => ['applyAction' => $getFiltersApplyAction(),'form' => $getFiltersForm(),'class' => 'fi-ta-filters-below-content p-4 sm:px-6']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-tables::filters'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['apply-action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getFiltersApplyAction()),'form' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($getFiltersForm()),'class' => 'fi-ta-filters-below-content p-4 sm:px-6']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8fcc8bb3dcedd6e3c85ec7cd95e48b39)): ?>
<?php $attributes = $__attributesOriginal8fcc8bb3dcedd6e3c85ec7cd95e48b39; ?>
<?php unset($__attributesOriginal8fcc8bb3dcedd6e3c85ec7cd95e48b39); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8fcc8bb3dcedd6e3c85ec7cd95e48b39)): ?>
<?php $component = $__componentOriginal8fcc8bb3dcedd6e3c85ec7cd95e48b39; ?>
<?php unset($__componentOriginal8fcc8bb3dcedd6e3c85ec7cd95e48b39); ?>
<?php endif; ?>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal848259f0d87ae1451c78bda371b1fb91)): ?>
<?php $attributes = $__attributesOriginal848259f0d87ae1451c78bda371b1fb91; ?>
<?php unset($__attributesOriginal848259f0d87ae1451c78bda371b1fb91); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal848259f0d87ae1451c78bda371b1fb91)): ?>
<?php $component = $__componentOriginal848259f0d87ae1451c78bda371b1fb91; ?>
<?php unset($__componentOriginal848259f0d87ae1451c78bda371b1fb91); ?>
<?php endif; ?>

    <?php if (isset($component)) { $__componentOriginal028e05680f6c5b1e293abd7fbe5f9758 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal028e05680f6c5b1e293abd7fbe5f9758 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-actions::components.modals','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-actions::modals'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal028e05680f6c5b1e293abd7fbe5f9758)): ?>
<?php $attributes = $__attributesOriginal028e05680f6c5b1e293abd7fbe5f9758; ?>
<?php unset($__attributesOriginal028e05680f6c5b1e293abd7fbe5f9758); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal028e05680f6c5b1e293abd7fbe5f9758)): ?>
<?php $component = $__componentOriginal028e05680f6c5b1e293abd7fbe5f9758; ?>
<?php unset($__componentOriginal028e05680f6c5b1e293abd7fbe5f9758); ?>
<?php endif; ?>
</div>
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\tables\src\/../resources/views/index.blade.php ENDPATH**/ ?>