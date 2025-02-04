<!--[if BLOCK]><![endif]--><?php if($this instanceof \Filament\Actions\Contracts\HasActions && (! $this->hasActionsModalRendered)): ?>
    <form wire:submit.prevent="callMountedAction">
        <?php
            $action = $this->getMountedAction();
        ?>

        <?php if (isset($component)) { $__componentOriginal0942a211c37469064369f887ae8d1cef = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0942a211c37469064369f887ae8d1cef = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.modal.index','data' => ['alignment' => $action?->getModalAlignment(),'autofocus' => $action?->isModalAutofocused(),'closeButton' => $action?->hasModalCloseButton(),'closeByClickingAway' => $action?->isModalClosedByClickingAway(),'closeByEscaping' => $action?->isModalClosedByEscaping(),'description' => $action?->getModalDescription(),'displayClasses' => 'block','extraModalWindowAttributeBag' => $action?->getExtraModalWindowAttributeBag(),'footerActions' => $action?->getVisibleModalFooterActions(),'footerActionsAlignment' => $action?->getModalFooterActionsAlignment(),'heading' => $action?->getModalHeading(),'icon' => $action?->getModalIcon(),'iconColor' => $action?->getModalIconColor(),'id' => $this->getId() . '-action','slideOver' => $action?->isModalSlideOver(),'stickyFooter' => $action?->isModalFooterSticky(),'stickyHeader' => $action?->isModalHeaderSticky(),'visible' => filled($action),'width' => $action?->getModalWidth(),'wire:key' => $action ? $this->getId() . '.actions.' . $action->getName() . '.modal' : null,'xOn:closedFormComponentActionModal.window' => 'if (($event.detail.id === \''.e($this->getId()).'\') && $wire.mountedActions.length) open()','xOn:modalClosed.stop' => '
                const mountedActionShouldOpenModal = '.e(\Illuminate\Support\Js::from($action && $this->mountedActionShouldOpenModal(mountedAction: $action))).'


                if (! mountedActionShouldOpenModal) {
                    return
                }

                if ($wire.mountedFormComponentActions.length) {
                    return
                }

                $wire.unmountAction(false, false)
            ','xOn:openedFormComponentActionModal.window' => 'if ($event.detail.id === \''.e($this->getId()).'\') close()']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['alignment' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->getModalAlignment()),'autofocus' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->isModalAutofocused()),'close-button' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->hasModalCloseButton()),'close-by-clicking-away' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->isModalClosedByClickingAway()),'close-by-escaping' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->isModalClosedByEscaping()),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->getModalDescription()),'display-classes' => 'block','extra-modal-window-attribute-bag' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->getExtraModalWindowAttributeBag()),'footer-actions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->getVisibleModalFooterActions()),'footer-actions-alignment' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->getModalFooterActionsAlignment()),'heading' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->getModalHeading()),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->getModalIcon()),'icon-color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->getModalIconColor()),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($this->getId() . '-action'),'slide-over' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->isModalSlideOver()),'sticky-footer' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->isModalFooterSticky()),'sticky-header' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->isModalHeaderSticky()),'visible' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(filled($action)),'width' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->getModalWidth()),'wire:key' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action ? $this->getId() . '.actions.' . $action->getName() . '.modal' : null),'x-on:closed-form-component-action-modal.window' => 'if (($event.detail.id === \''.e($this->getId()).'\') && $wire.mountedActions.length) open()','x-on:modal-closed.stop' => '
                const mountedActionShouldOpenModal = '.e(\Illuminate\Support\Js::from($action && $this->mountedActionShouldOpenModal(mountedAction: $action))).'


                if (! mountedActionShouldOpenModal) {
                    return
                }

                if ($wire.mountedFormComponentActions.length) {
                    return
                }

                $wire.unmountAction(false, false)
            ','x-on:opened-form-component-action-modal.window' => 'if ($event.detail.id === \''.e($this->getId()).'\') close()']); ?>
            <!--[if BLOCK]><![endif]--><?php if($action): ?>
                <?php echo e($action->getModalContent()); ?>


                <!--[if BLOCK]><![endif]--><?php if(count(($infolist = $action->getInfolist())?->getComponents() ?? [])): ?>
                    <?php echo e($infolist); ?>

                <?php elseif($this->mountedActionHasForm(mountedAction: $action)): ?>
                    <?php echo e($this->getMountedActionForm(mountedAction: $action)); ?>

                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <?php echo e($action->getModalContentFooter()); ?>

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
    </form>

    <?php
        $this->hasActionsModalRendered = true;
    ?>
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->

<!--[if BLOCK]><![endif]--><?php if($this instanceof \Filament\Tables\Contracts\HasTable && (! $this->hasTableModalRendered)): ?>
    <form wire:submit.prevent="callMountedTableAction">
        <?php
            $action = $this->getMountedTableAction();
        ?>

        <?php if (isset($component)) { $__componentOriginal0942a211c37469064369f887ae8d1cef = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0942a211c37469064369f887ae8d1cef = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.modal.index','data' => ['alignment' => $action?->getModalAlignment(),'autofocus' => $action?->isModalAutofocused(),'closeButton' => $action?->hasModalCloseButton(),'closeByClickingAway' => $action?->isModalClosedByClickingAway(),'closeByEscaping' => $action?->isModalClosedByEscaping(),'description' => $action?->getModalDescription(),'displayClasses' => 'block','extraModalWindowAttributeBag' => $action?->getExtraModalWindowAttributeBag(),'footerActions' => $action?->getVisibleModalFooterActions(),'footerActionsAlignment' => $action?->getModalFooterActionsAlignment(),'heading' => $action?->getModalHeading(),'icon' => $action?->getModalIcon(),'iconColor' => $action?->getModalIconColor(),'id' => $this->getId() . '-table-action','slideOver' => $action?->isModalSlideOver(),'stickyFooter' => $action?->isModalFooterSticky(),'stickyHeader' => $action?->isModalHeaderSticky(),'visible' => filled($action),'width' => $action?->getModalWidth(),'wire:key' => $action ? $this->getId() . '.table.actions.' . $action->getName() . '.modal' : null,'xOn:closedFormComponentActionModal.window' => 'if (($event.detail.id === \''.e($this->getId()).'\') && $wire.mountedTableActions.length) open()','xOn:modalClosed.stop' => '
                const mountedTableActionShouldOpenModal = '.e(\Illuminate\Support\Js::from($action && $this->mountedTableActionShouldOpenModal(mountedAction: $action))).'


                if (! mountedTableActionShouldOpenModal) {
                    return
                }

                if ($wire.mountedFormComponentActions.length) {
                    return
                }

                $wire.unmountTableAction(false, false)
            ','xOn:openedFormComponentActionModal.window' => 'if ($event.detail.id === \''.e($this->getId()).'\') close()']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['alignment' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->getModalAlignment()),'autofocus' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->isModalAutofocused()),'close-button' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->hasModalCloseButton()),'close-by-clicking-away' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->isModalClosedByClickingAway()),'close-by-escaping' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->isModalClosedByEscaping()),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->getModalDescription()),'display-classes' => 'block','extra-modal-window-attribute-bag' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->getExtraModalWindowAttributeBag()),'footer-actions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->getVisibleModalFooterActions()),'footer-actions-alignment' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->getModalFooterActionsAlignment()),'heading' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->getModalHeading()),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->getModalIcon()),'icon-color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->getModalIconColor()),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($this->getId() . '-table-action'),'slide-over' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->isModalSlideOver()),'sticky-footer' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->isModalFooterSticky()),'sticky-header' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->isModalHeaderSticky()),'visible' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(filled($action)),'width' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->getModalWidth()),'wire:key' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action ? $this->getId() . '.table.actions.' . $action->getName() . '.modal' : null),'x-on:closed-form-component-action-modal.window' => 'if (($event.detail.id === \''.e($this->getId()).'\') && $wire.mountedTableActions.length) open()','x-on:modal-closed.stop' => '
                const mountedTableActionShouldOpenModal = '.e(\Illuminate\Support\Js::from($action && $this->mountedTableActionShouldOpenModal(mountedAction: $action))).'


                if (! mountedTableActionShouldOpenModal) {
                    return
                }

                if ($wire.mountedFormComponentActions.length) {
                    return
                }

                $wire.unmountTableAction(false, false)
            ','x-on:opened-form-component-action-modal.window' => 'if ($event.detail.id === \''.e($this->getId()).'\') close()']); ?>
            <!--[if BLOCK]><![endif]--><?php if($action): ?>
                <?php echo e($action->getModalContent()); ?>


                <!--[if BLOCK]><![endif]--><?php if(count(($infolist = $action->getInfolist())?->getComponents() ?? [])): ?>
                    <?php echo e($infolist); ?>

                <?php elseif($this->mountedTableActionHasForm(mountedAction: $action)): ?>
                    <?php echo e($this->getMountedTableActionForm()); ?>

                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <?php echo e($action->getModalContentFooter()); ?>

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
    </form>

    <form wire:submit.prevent="callMountedTableBulkAction">
        <?php
            $action = $this->getMountedTableBulkAction();
        ?>

        <?php if (isset($component)) { $__componentOriginal0942a211c37469064369f887ae8d1cef = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0942a211c37469064369f887ae8d1cef = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.modal.index','data' => ['alignment' => $action?->getModalAlignment(),'autofocus' => $action?->isModalAutofocused(),'closeButton' => $action?->hasModalCloseButton(),'closeByClickingAway' => $action?->isModalClosedByClickingAway(),'closeByEscaping' => $action?->isModalClosedByEscaping(),'description' => $action?->getModalDescription(),'displayClasses' => 'block','extraModalWindowAttributeBag' => $action?->getExtraModalWindowAttributeBag(),'footerActions' => $action?->getVisibleModalFooterActions(),'footerActionsAlignment' => $action?->getModalFooterActionsAlignment(),'heading' => $action?->getModalHeading(),'icon' => $action?->getModalIcon(),'iconColor' => $action?->getModalIconColor(),'id' => $this->getId() . '-table-bulk-action','slideOver' => $action?->isModalSlideOver(),'stickyFooter' => $action?->isModalFooterSticky(),'stickyHeader' => $action?->isModalHeaderSticky(),'visible' => filled($action),'width' => $action?->getModalWidth(),'wire:key' => $action ? $this->getId() . '.table.bulk-actions.' . $action->getName() . '.modal' : null,'xOn:closedFormComponentActionModal.window' => 'if (($event.detail.id === \''.e($this->getId()).'\') && $wire.mountedTableBulkAction) open()','xOn:modalClosed.stop' => '
                const mountedTableBulkActionShouldOpenModal = '.e(\Illuminate\Support\Js::from($action && $this->mountedTableBulkActionShouldOpenModal(mountedBulkAction: $action))).'


                if (! mountedTableBulkActionShouldOpenModal) {
                    return
                }

                if ($wire.mountedFormComponentActions.length) {
                    return
                }

                $wire.unmountTableBulkAction(false)
            ','xOn:openedFormComponentActionModal.window' => 'if ($event.detail.id === \''.e($this->getId()).'\') close()']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['alignment' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->getModalAlignment()),'autofocus' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->isModalAutofocused()),'close-button' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->hasModalCloseButton()),'close-by-clicking-away' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->isModalClosedByClickingAway()),'close-by-escaping' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->isModalClosedByEscaping()),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->getModalDescription()),'display-classes' => 'block','extra-modal-window-attribute-bag' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->getExtraModalWindowAttributeBag()),'footer-actions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->getVisibleModalFooterActions()),'footer-actions-alignment' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->getModalFooterActionsAlignment()),'heading' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->getModalHeading()),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->getModalIcon()),'icon-color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->getModalIconColor()),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($this->getId() . '-table-bulk-action'),'slide-over' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->isModalSlideOver()),'sticky-footer' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->isModalFooterSticky()),'sticky-header' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->isModalHeaderSticky()),'visible' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(filled($action)),'width' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->getModalWidth()),'wire:key' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action ? $this->getId() . '.table.bulk-actions.' . $action->getName() . '.modal' : null),'x-on:closed-form-component-action-modal.window' => 'if (($event.detail.id === \''.e($this->getId()).'\') && $wire.mountedTableBulkAction) open()','x-on:modal-closed.stop' => '
                const mountedTableBulkActionShouldOpenModal = '.e(\Illuminate\Support\Js::from($action && $this->mountedTableBulkActionShouldOpenModal(mountedBulkAction: $action))).'


                if (! mountedTableBulkActionShouldOpenModal) {
                    return
                }

                if ($wire.mountedFormComponentActions.length) {
                    return
                }

                $wire.unmountTableBulkAction(false)
            ','x-on:opened-form-component-action-modal.window' => 'if ($event.detail.id === \''.e($this->getId()).'\') close()']); ?>
            <!--[if BLOCK]><![endif]--><?php if($action): ?>
                <?php echo e($action->getModalContent()); ?>


                <!--[if BLOCK]><![endif]--><?php if(count(($infolist = $action->getInfolist())?->getComponents() ?? [])): ?>
                    <?php echo e($infolist); ?>

                <?php elseif($this->mountedTableBulkActionHasForm(mountedBulkAction: $action)): ?>
                    <?php echo e($this->getMountedTableBulkActionForm(mountedBulkAction: $action)); ?>

                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <?php echo e($action->getModalContentFooter()); ?>

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
    </form>

    <?php
        $this->hasTableModalRendered = true;
    ?>
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->

<!--[if BLOCK]><![endif]--><?php if($this instanceof \Filament\Infolists\Contracts\HasInfolists && (! $this->hasInfolistsModalRendered)): ?>
    <form wire:submit.prevent="callMountedInfolistAction">
        <?php
            $action = $this->getMountedInfolistAction();
        ?>

        <?php if (isset($component)) { $__componentOriginal0942a211c37469064369f887ae8d1cef = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0942a211c37469064369f887ae8d1cef = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.modal.index','data' => ['alignment' => $action?->getModalAlignment(),'autofocus' => $action?->isModalAutofocused(),'closeButton' => $action?->hasModalCloseButton(),'closeByClickingAway' => $action?->isModalClosedByClickingAway(),'closeByEscaping' => $action?->isModalClosedByEscaping(),'description' => $action?->getModalDescription(),'displayClasses' => 'block','extraModalWindowAttributeBag' => $action?->getExtraModalWindowAttributeBag(),'footerActions' => $action?->getVisibleModalFooterActions(),'footerActionsAlignment' => $action?->getModalFooterActionsAlignment(),'heading' => $action?->getModalHeading(),'icon' => $action?->getModalIcon(),'iconColor' => $action?->getModalIconColor(),'id' => $this->getId() . '-infolist-action','slideOver' => $action?->isModalSlideOver(),'stickyFooter' => $action?->isModalFooterSticky(),'stickyHeader' => $action?->isModalHeaderSticky(),'visible' => filled($action),'width' => $action?->getModalWidth(),'wire:key' => $action ? $this->getId() . '.infolist.actions.' . $action->getName() . '.modal' : null,'xOn:closedFormComponentActionModal.window' => 'if (($event.detail.id === \''.e($this->getId()).'\') && $wire.mountedInfolistActions.length) open()','xOn:modalClosed.stop' => '
                const mountedInfolistActionShouldOpenModal = '.e(\Illuminate\Support\Js::from($action && $this->mountedInfolistActionShouldOpenModal(mountedAction: $action))).'


                if (! mountedInfolistActionShouldOpenModal) {
                    return
                }

                if ($wire.mountedFormComponentActions.length) {
                    return
                }

                $wire.unmountInfolistAction(false, false)
            ','xOn:openedFormComponentActionModal.window' => 'if ($event.detail.id === \''.e($this->getId()).'\') close()']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['alignment' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->getModalAlignment()),'autofocus' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->isModalAutofocused()),'close-button' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->hasModalCloseButton()),'close-by-clicking-away' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->isModalClosedByClickingAway()),'close-by-escaping' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->isModalClosedByEscaping()),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->getModalDescription()),'display-classes' => 'block','extra-modal-window-attribute-bag' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->getExtraModalWindowAttributeBag()),'footer-actions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->getVisibleModalFooterActions()),'footer-actions-alignment' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->getModalFooterActionsAlignment()),'heading' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->getModalHeading()),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->getModalIcon()),'icon-color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->getModalIconColor()),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($this->getId() . '-infolist-action'),'slide-over' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->isModalSlideOver()),'sticky-footer' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->isModalFooterSticky()),'sticky-header' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->isModalHeaderSticky()),'visible' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(filled($action)),'width' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->getModalWidth()),'wire:key' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action ? $this->getId() . '.infolist.actions.' . $action->getName() . '.modal' : null),'x-on:closed-form-component-action-modal.window' => 'if (($event.detail.id === \''.e($this->getId()).'\') && $wire.mountedInfolistActions.length) open()','x-on:modal-closed.stop' => '
                const mountedInfolistActionShouldOpenModal = '.e(\Illuminate\Support\Js::from($action && $this->mountedInfolistActionShouldOpenModal(mountedAction: $action))).'


                if (! mountedInfolistActionShouldOpenModal) {
                    return
                }

                if ($wire.mountedFormComponentActions.length) {
                    return
                }

                $wire.unmountInfolistAction(false, false)
            ','x-on:opened-form-component-action-modal.window' => 'if ($event.detail.id === \''.e($this->getId()).'\') close()']); ?>
            <!--[if BLOCK]><![endif]--><?php if($action): ?>
                <?php echo e($action->getModalContent()); ?>


                <!--[if BLOCK]><![endif]--><?php if(count(($infolist = $action->getInfolist())?->getComponents() ?? [])): ?>
                    <?php echo e($infolist); ?>

                <?php elseif($this->mountedInfolistActionHasForm(mountedAction: $action)): ?>
                    <?php echo e($this->getMountedInfolistActionForm(mountedAction: $action)); ?>

                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <?php echo e($action->getModalContentFooter()); ?>

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
    </form>

    <?php
        $this->hasInfolistsModalRendered = true;
    ?>
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->

<!--[if BLOCK]><![endif]--><?php if(! $this->hasFormsModalRendered): ?>
    <?php
        $action = $this->getMountedFormComponentAction();
    ?>

    <form wire:submit.prevent="callMountedFormComponentAction">
        <?php if (isset($component)) { $__componentOriginal0942a211c37469064369f887ae8d1cef = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0942a211c37469064369f887ae8d1cef = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.modal.index','data' => ['alignment' => $action?->getModalAlignment(),'autofocus' => $action?->isModalAutofocused(),'closeButton' => $action?->hasModalCloseButton(),'closeByClickingAway' => $action?->isModalClosedByClickingAway(),'closeByEscaping' => $action?->isModalClosedByEscaping(),'description' => $action?->getModalDescription(),'displayClasses' => 'block','extraModalWindowAttributeBag' => $action?->getExtraModalWindowAttributeBag(),'footerActions' => $action?->getVisibleModalFooterActions(),'footerActionsAlignment' => $action?->getModalFooterActionsAlignment(),'heading' => $action?->getModalHeading(),'icon' => $action?->getModalIcon(),'iconColor' => $action?->getModalIconColor(),'id' => $this->getId() . '-form-component-action','slideOver' => $action?->isModalSlideOver(),'stickyFooter' => $action?->isModalFooterSticky(),'stickyHeader' => $action?->isModalHeaderSticky(),'visible' => filled($action),'width' => $action?->getModalWidth(),'wire:key' => $action ? $this->getId() . '.' . $action->getComponent()->getStatePath() . '.actions.' . $action->getName() . '.modal' : null,'xOn:modalClosed.stop' => '
                const mountedFormComponentActionShouldOpenModal = '.e(\Illuminate\Support\Js::from($action && $this->mountedFormComponentActionShouldOpenModal())).'


                if (mountedFormComponentActionShouldOpenModal) {
                    $wire.unmountFormComponentAction(false, false)
                }
            ']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['alignment' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->getModalAlignment()),'autofocus' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->isModalAutofocused()),'close-button' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->hasModalCloseButton()),'close-by-clicking-away' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->isModalClosedByClickingAway()),'close-by-escaping' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->isModalClosedByEscaping()),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->getModalDescription()),'display-classes' => 'block','extra-modal-window-attribute-bag' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->getExtraModalWindowAttributeBag()),'footer-actions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->getVisibleModalFooterActions()),'footer-actions-alignment' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->getModalFooterActionsAlignment()),'heading' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->getModalHeading()),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->getModalIcon()),'icon-color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->getModalIconColor()),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($this->getId() . '-form-component-action'),'slide-over' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->isModalSlideOver()),'sticky-footer' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->isModalFooterSticky()),'sticky-header' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->isModalHeaderSticky()),'visible' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(filled($action)),'width' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action?->getModalWidth()),'wire:key' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action ? $this->getId() . '.' . $action->getComponent()->getStatePath() . '.actions.' . $action->getName() . '.modal' : null),'x-on:modal-closed.stop' => '
                const mountedFormComponentActionShouldOpenModal = '.e(\Illuminate\Support\Js::from($action && $this->mountedFormComponentActionShouldOpenModal())).'


                if (mountedFormComponentActionShouldOpenModal) {
                    $wire.unmountFormComponentAction(false, false)
                }
            ']); ?>
            <!--[if BLOCK]><![endif]--><?php if($action): ?>
                <?php echo e($action->getModalContent()); ?>


                <!--[if BLOCK]><![endif]--><?php if(count(($infolist = $action->getInfolist())?->getComponents() ?? [])): ?>
                    <?php echo e($infolist); ?>

                <?php elseif($this->mountedFormComponentActionHasForm(mountedAction: $action)): ?>
                    <?php echo e($this->getMountedFormComponentActionForm(mountedAction: $action)); ?>

                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <?php echo e($action->getModalContentFooter()); ?>

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
    </form>

    <?php
        $this->hasFormsModalRendered = true;
    ?>
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\actions\src\/../resources/views/components/modals.blade.php ENDPATH**/ ?>