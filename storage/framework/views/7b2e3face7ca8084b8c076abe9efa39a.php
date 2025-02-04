<?php
    use Filament\Support\Enums\MaxWidth;

    $navigation = filament()->getNavigation();
?>

<?php if (isset($component)) { $__componentOriginale960ae7ad1b1ce9e3596e483505fadc9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale960ae7ad1b1ce9e3596e483505fadc9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.layout.base','data' => ['livewire' => $livewire]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::layout.base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['livewire' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($livewire)]); ?>
    
    <div
        class="fi-layout flex min-h-screen w-full flex-row-reverse overflow-x-clip"
    >
        <div
            <?php if(filament()->isSidebarCollapsibleOnDesktop()): ?>
                x-data="{}"
                x-bind:class="{
                    'fi-main-ctn-sidebar-open': $store.sidebar.isOpen,
                }"
                x-bind:style="'display: flex; opacity:1;'" 
            <?php elseif(filament()->isSidebarFullyCollapsibleOnDesktop()): ?>
                x-data="{}"
                x-bind:class="{
                    'fi-main-ctn-sidebar-open': $store.sidebar.isOpen,
                }"
                x-bind:style="'display: flex; opacity:1;'" 
            <?php elseif(! (filament()->isSidebarCollapsibleOnDesktop() || filament()->isSidebarFullyCollapsibleOnDesktop() || filament()->hasTopNavigation() || (! filament()->hasNavigation()))): ?>
                x-data="{}"
                x-bind:style="'display: flex; opacity:1;'" 
            <?php endif; ?>
            class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                'fi-main-ctn w-screen flex-1 flex-col',
                'h-full opacity-0 transition-all' => filament()->isSidebarCollapsibleOnDesktop() || filament()->isSidebarFullyCollapsibleOnDesktop(),
                'opacity-0' => ! (filament()->isSidebarCollapsibleOnDesktop() || filament()->isSidebarFullyCollapsibleOnDesktop() || filament()->hasTopNavigation() || (! filament()->hasNavigation())),
                'flex' => filament()->hasTopNavigation() || (! filament()->hasNavigation()),
            ]); ?>"
        >
            <?php if(filament()->hasTopbar()): ?>
                <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::TOPBAR_BEFORE, scopes: $livewire->getRenderHookScopes())); ?>


                <?php if (isset($component)) { $__componentOriginal3730a29838011bd2ea530ae9e3b87bdd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3730a29838011bd2ea530ae9e3b87bdd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.topbar.index','data' => ['navigation' => $navigation]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::topbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['navigation' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($navigation)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3730a29838011bd2ea530ae9e3b87bdd)): ?>
<?php $attributes = $__attributesOriginal3730a29838011bd2ea530ae9e3b87bdd; ?>
<?php unset($__attributesOriginal3730a29838011bd2ea530ae9e3b87bdd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3730a29838011bd2ea530ae9e3b87bdd)): ?>
<?php $component = $__componentOriginal3730a29838011bd2ea530ae9e3b87bdd; ?>
<?php unset($__componentOriginal3730a29838011bd2ea530ae9e3b87bdd); ?>
<?php endif; ?>

                <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::TOPBAR_AFTER, scopes: $livewire->getRenderHookScopes())); ?>

            <?php endif; ?>

            <main
                class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                    'fi-main mx-auto h-full w-full px-4 md:px-6 lg:px-8',
                    match ($maxContentWidth ??= (filament()->getMaxContentWidth() ?? MaxWidth::SevenExtraLarge)) {
                        MaxWidth::ExtraSmall, 'xs' => 'max-w-xs',
                        MaxWidth::Small, 'sm' => 'max-w-sm',
                        MaxWidth::Medium, 'md' => 'max-w-md',
                        MaxWidth::Large, 'lg' => 'max-w-lg',
                        MaxWidth::ExtraLarge, 'xl' => 'max-w-xl',
                        MaxWidth::TwoExtraLarge, '2xl' => 'max-w-2xl',
                        MaxWidth::ThreeExtraLarge, '3xl' => 'max-w-3xl',
                        MaxWidth::FourExtraLarge, '4xl' => 'max-w-4xl',
                        MaxWidth::FiveExtraLarge, '5xl' => 'max-w-5xl',
                        MaxWidth::SixExtraLarge, '6xl' => 'max-w-6xl',
                        MaxWidth::SevenExtraLarge, '7xl' => 'max-w-7xl',
                        MaxWidth::Full, 'full' => 'max-w-full',
                        MaxWidth::MinContent, 'min' => 'max-w-min',
                        MaxWidth::MaxContent, 'max' => 'max-w-max',
                        MaxWidth::FitContent, 'fit' => 'max-w-fit',
                        MaxWidth::Prose, 'prose' => 'max-w-prose',
                        MaxWidth::ScreenSmall, 'screen-sm' => 'max-w-screen-sm',
                        MaxWidth::ScreenMedium, 'screen-md' => 'max-w-screen-md',
                        MaxWidth::ScreenLarge, 'screen-lg' => 'max-w-screen-lg',
                        MaxWidth::ScreenExtraLarge, 'screen-xl' => 'max-w-screen-xl',
                        MaxWidth::ScreenTwoExtraLarge, 'screen-2xl' => 'max-w-screen-2xl',
                        default => $maxContentWidth,
                    },
                ]); ?>"
            >
                <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::CONTENT_START, scopes: $livewire->getRenderHookScopes())); ?>


                <?php echo e($slot); ?>


                <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::CONTENT_END, scopes: $livewire->getRenderHookScopes())); ?>

            </main>

            <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::FOOTER, scopes: $livewire->getRenderHookScopes())); ?>

        </div>

        <?php if(filament()->hasNavigation()): ?>
            <div
                x-cloak
                x-data="{}"
                x-on:click="$store.sidebar.close()"
                x-show="$store.sidebar.isOpen"
                x-transition.opacity.300ms
                class="fi-sidebar-close-overlay fixed inset-0 z-30 bg-gray-950/50 transition duration-500 dark:bg-gray-950/75 lg:hidden"
            ></div>

            <?php if (isset($component)) { $__componentOriginal507b9338c225a118b42b83ae4f73ad2b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal507b9338c225a118b42b83ae4f73ad2b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.sidebar.index','data' => ['navigation' => $navigation,'class' => 'fi-main-sidebar']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['navigation' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($navigation),'class' => 'fi-main-sidebar']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal507b9338c225a118b42b83ae4f73ad2b)): ?>
<?php $attributes = $__attributesOriginal507b9338c225a118b42b83ae4f73ad2b; ?>
<?php unset($__attributesOriginal507b9338c225a118b42b83ae4f73ad2b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal507b9338c225a118b42b83ae4f73ad2b)): ?>
<?php $component = $__componentOriginal507b9338c225a118b42b83ae4f73ad2b; ?>
<?php unset($__componentOriginal507b9338c225a118b42b83ae4f73ad2b); ?>
<?php endif; ?>

            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    setTimeout(() => {
                        let activeSidebarItem = document.querySelector(
                            '.fi-main-sidebar .fi-sidebar-item.fi-active',
                        )

                        if (
                            !activeSidebarItem ||
                            activeSidebarItem.offsetParent === null
                        ) {
                            activeSidebarItem = document.querySelector(
                                '.fi-main-sidebar .fi-sidebar-group.fi-active',
                            )
                        }

                        if (
                            !activeSidebarItem ||
                            activeSidebarItem.offsetParent === null
                        ) {
                            return
                        }

                        const sidebarWrapper = document.querySelector(
                            '.fi-main-sidebar .fi-sidebar-nav',
                        )

                        if (!sidebarWrapper) {
                            return
                        }

                        sidebarWrapper.scrollTo(
                            0,
                            activeSidebarItem.offsetTop -
                                window.innerHeight / 2,
                        )
                    }, 10)
                })
            </script>
        <?php endif; ?>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale960ae7ad1b1ce9e3596e483505fadc9)): ?>
<?php $attributes = $__attributesOriginale960ae7ad1b1ce9e3596e483505fadc9; ?>
<?php unset($__attributesOriginale960ae7ad1b1ce9e3596e483505fadc9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale960ae7ad1b1ce9e3596e483505fadc9)): ?>
<?php $component = $__componentOriginale960ae7ad1b1ce9e3596e483505fadc9; ?>
<?php unset($__componentOriginale960ae7ad1b1ce9e3596e483505fadc9); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\website-development-business\clients\first-balfour\asset-management-system-v2\vendor\filament\filament\src\/../resources/views/components/layout/index.blade.php ENDPATH**/ ?>