<!-- Auth Layout -->

<?php $__env->startSection('content'); ?>
    <!-- Wrapper -->
    <section class="min-h-screen flex items-center justify-center bg-green-100"
        style="background-size: cover; background-position: center; background-repeat: no-repeat;">
        <!-- Main container -->
        <div class="flex w-full max-w-4xl bg-gray-50 rounded-3xl shadow-lg overflow-hidden">
            <!-- two-column content directly inside main container so both halves fill the card -->
            <!-- Right side (image) - moved to first column -->
            <div class="w-1/2 flex items-center justify-center p-8">
                <div class="relative w-full h-full flex items-center justify-center">

                    <div class="relative">
                        <img src="<?php echo e(asset('img/card/auth.png')); ?>" alt="Login Illustration"
                            class="rounded-3xl w-[400px] h-auto object-contain animate-blink-slow">
                    </div>
                </div>
            </div>

            <!-- Left side (form) - moved to second column -->
            <div class="w-1/2 p-10">
                <!-- Logo -->
                <div class="flex justify-center mb-4">
                    <img src="<?php echo e(asset('img/logo/goloka.png')); ?>" alt="Goloka" class="w-24 h-auto">
                </div>

                <!-- Title -->
                <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Masuk ke Akun Anda</h2>

                <!-- Session Status -->
                <?php if (isset($component)) { $__componentOriginal7c1bf3a9346f208f66ee83b06b607fb5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7c1bf3a9346f208f66ee83b06b607fb5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.auth-session-status','data' => ['class' => 'mb-4','status' => session('status')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('auth-session-status'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mb-4','status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(session('status'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7c1bf3a9346f208f66ee83b06b607fb5)): ?>
<?php $attributes = $__attributesOriginal7c1bf3a9346f208f66ee83b06b607fb5; ?>
<?php unset($__attributesOriginal7c1bf3a9346f208f66ee83b06b607fb5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7c1bf3a9346f208f66ee83b06b607fb5)): ?>
<?php $component = $__componentOriginal7c1bf3a9346f208f66ee83b06b607fb5; ?>
<?php unset($__componentOriginal7c1bf3a9346f208f66ee83b06b607fb5); ?>
<?php endif; ?>

                <form method="POST" action="<?php echo e(route('login')); ?>">
                    <?php echo csrf_field(); ?>
                    <!-- Email Address -->
                    <div class="mb-5">
                        <div class="relative mt-1">
                            <span id="emailIconWrap"
                                class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 transition-colors duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-mail-icon lucide-mail">
                                    <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7" />
                                    <rect x="2" y="4" width="20" height="16" rx="2" />
                                </svg>
                            </span>
                            <input id="email" name="email" type="email" value="<?php echo e(old('email')); ?>" required
                                autofocus autocomplete="username"
                                class="block w-full pl-9 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm"
                                placeholder="Alamat Email" />
                        </div>
                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('email'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('email')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <div class="relative mt-1">
                            <!-- Icon kiri (lock) -->
                            <span id="passwordIconWrap"
                                class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-lock-keyhole-icon lucide-lock-keyhole">
                                    <circle cx="12" cy="16" r="1" />
                                    <rect x="3" y="10" width="18" height="12" rx="2" />
                                    <path d="M7 10V7a5 5 0 0 1 10 0v3" />
                                </svg>
                            </span>

                            <!-- Input password -->
                            <input id="password" name="password" type="password" required autocomplete="current-password"
                                class="block w-full pl-9 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm"
                                placeholder="Kata Sandi" />

                            <!-- Icon kanan (toggle visibility) -->
                            <button type="button" id="togglePassword"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 focus:outline-none">
                                <!-- Eye (default visible) -->
                                <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye">
                                    <path
                                        d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>

                                <!-- Eye Closed (hidden by default) -->
                                <svg id="eyeClosedIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-closed hidden">
                                    <path d="m15 18-.722-3.25" />
                                    <path d="M2 8a10.645 10.645 0 0 0 20 0" />
                                    <path d="m20 15-1.726-2.05" />
                                    <path d="m4 15 1.726-2.05" />
                                    <path d="m9 18 .722-3.25" />
                                </svg>
                            </button>
                        </div>
                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('password'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('password')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                    </div>

                    <!-- Forgot Password Link -->
                    <?php if(Route::has('password.request')): ?>
                        <div class="text-right mb-3">
                            <a href="<?php echo e(route('password.request')); ?>"
                                class="text-sm text-green-500 hover:text-green-800 font-medium">
                                Lupa Kata Sandi?
                            </a>
                        </div>
                    <?php endif; ?>

                    <!-- Login Button -->
                    <div class="mt-6">
                        <button type="submit"
                            class="w-full bg-green-500 hover:bg-green-600 text-white py-2 rounded-lg font-semibold shadow-sm transition duration-200">
                            Masuk
                        </button>
                    </div>

                    <!-- Login with Others -->
                    <div class="my-4 flex items-center">
                        <div class="flex-1 h-px bg-gray-300"></div>
                        <div class="px-4 text-center text-gray-500 text-sm">Atau masuk dengan</div>
                        <div class="flex-1 h-px bg-gray-300"></div>
                    </div>

                    <div class="space-y-3">
                        <a href="<?php echo e(route('auth.redirect')); ?>"
                            class="w-full flex items-center justify-center gap-2 border border-gray-300 rounded-lg py-2 hover:bg-gray-50 transition">
                            <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5"
                                alt="google">
                            <span class="text-sm text-gray-700">Masuk dengan Google</span>
                        </a>
                    </div>

                    <div class="text-center mt-10 text-sm text-gray-600">
                        Belum memiliki Akun? <a href="<?php echo e(route('register')); ?>"
                            class="text-green-600 hover:underline font-medium">Daftar</a>
                    </div>
                </form>
            </div>

            <?php echo app('Illuminate\Foundation\Vite')('resources/js/guest/login.js'); ?>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('auth.components.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\Goloka\resources\views/auth/login.blade.php ENDPATH**/ ?>