<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <!-- NAVBAR -->
    <?php echo $__env->make('user.components.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Hero / Intro Section -->
    <section class="pt-40 pb-24 min-h-screen bg-no-repeat bg-center bg-cover"
        style="background-image: url('<?php echo e(asset('img/background/dashboard-user.png')); ?>');">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
                <!-- Left column: content -->
                <div class="flex items-start">
                    <div class="w-full md:w-3/4 lg:w-2/3 bg-white/75 backdrop-blur-md p-8 rounded-lg shadow">
                        <h1 class="text-3xl font-bold text-gray-900 mb-4">Selamat datang di Goloka</h1>
                        <p class="text-gray-700 mb-6">
                            Goloka adalah platform pasar lokal yang menghubungkan pembeli dan penjual produk
                            berkualitas.
                            Jelajahi produk, tambahkan ke keranjang, dan nikmati pengalaman belanja yang mudah dan aman.
                        </p>
                        <div class="flex items-center gap-3">
                            <a href="<?php echo e(route('user.produk.index')); ?>"
                                class="inline-block bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-md font-medium">
                                Jelajahi Produk
                            </a>
                            <a href="<?php echo e(route('user.keranjang.index')); ?>"
                                class="inline-block bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-md font-medium">
                                Lihat Keranjang
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right column: intentionally empty to leave space / visual balance -->
                <div class=""></div>
            </div>
        </div>
    </section>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH D:\laragon\www\Goloka\resources\views/user/dashboard/index.blade.php ENDPATH**/ ?>