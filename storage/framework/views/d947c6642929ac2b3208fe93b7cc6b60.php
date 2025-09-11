<style>
    html,
    body {
        overflow: hidden;
        height: 100%;
    }
</style>

<?php $__env->startSection('content'); ?>
    <div class="row g-0 flex-grow-1 w-100" style="min-height:100vh; overflow: hidden;">
        <!-- Left: Illustration & Welcome -->
        <div class="col-lg-7 d-none d-lg-flex flex-column justify-content-start align-items-center px-0 pt-7"
            style="
        background: url('<?php echo e(asset('assets/img/kantor-koni.png')); ?>') 10% center / cover no-repeat;
        height: 100vh;
        max-width: 100%;
        position: relative;
    ">
        </div>


        <!-- Right: Login Form -->
        <div class="col-lg-5 d-flex flex-column justify-content-center align-items-center bg-white px-4 px-lg-0">
            <div class="w-100" style="max-width:370px;">
                <div class="text-center mb-4">
                    <img src="<?php echo e(asset('assets/img/koni.png')); ?>" alt="Logo KONI" style="height:70px;">
                </div>
                <div class="card shadow-sm border-0 rounded-4 p-4">
                    <h5 class="fw-bold mb-3 text-center">Masuk</h5>
                    <form method="POST" action="<?php echo e(route('login-post')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email"
                                class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="email@example.com"
                                value="<?php echo e(old('email')); ?>" required autofocus>
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password"
                                class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="********"
                                required>
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <div class="d-flex justify-content-end mt-1">
                                <a href="#" class="small" style="color:#D20A11">Lupa password?</a>
                            </div>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Ingat Saya</label>
                        </div>
                        <button type="submit" class="btn w-100 text-white fw-bold"
                            style="background:#D20A11; height: 44px;">
                            <span>Masuk</span>
                        </button>
                    </form>
                </div>
                
                <div class="text-end text-muted small mt-4">
                    © 2025 KONI Tabalong. Hak Cipta Dilindungi.
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/gustibagus/Documents/GitHub/web-koni/resources/views/auth/login.blade.php ENDPATH**/ ?>