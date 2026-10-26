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
        <div class="col-lg-7 d-none d-lg-flex flex-column justify-content-center align-items-center px-0"
            style="
        background: linear-gradient(135deg, #0D2E2B 0%, #17564A 100%);
        height: 100vh;
        max-width: 100%;
        position: relative;
    ">
            <div class="d-flex align-items-center gap-5">
                <span class="d-flex align-items-center justify-content-center flex-shrink-0"
                    style="width:96px; height:96px; border-radius:24px; background-color:#E3F1EA;">
                    <svg width="54" height="54" viewBox="0 0 24 24" fill="none" stroke="#1F6B5A" stroke-width="2.2"
                        stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <g transform="rotate(-8 12 12)">
                            <path d="M14 3H8a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3V8z" />
                            <path d="M14 3v3a2 2 0 0 0 2 2h3" />
                        </g>
                    </svg>
                </span>
                <span class="fw-bolder text-white" style="font-size:3.5rem; letter-spacing:0.18em;">SIMPATI</span>
            </div>
        </div>


        <!-- Right: Login Form -->
        <div class="col-lg-5 d-flex flex-column justify-content-center align-items-center bg-white px-4 px-lg-0">
            <div class="w-100" style="max-width:370px;">
                <div class="text-center mb-4">
                    <span class="d-inline-flex align-items-center gap-3">
                        <img src="<?php echo e(asset('assets/img/simpati-icon.svg')); ?>" alt="Logo SIMPATI" style="height:52px;">
                        <span class="fw-bolder fs-1" style="color:#0D2E2B; letter-spacing:0.18em;">SIMPATI</span>
                    </span>
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
                                <a href="#" class="small" style="color:#1F6B5A">Lupa password?</a>
                            </div>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Ingat Saya</label>
                        </div>
                        <button type="submit" class="btn w-100 text-white fw-bold"
                            style="background:#1F6B5A; height: 44px;">
                            <span>Masuk</span>
                        </button>
                    </form>
                </div>
                
                <div class="text-end text-muted small mt-4">
                    © 2025 SIMPATI. Hak Cipta Dilindungi.
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\.instalation\laragon\www\web-koni\resources\views/auth/login.blade.php ENDPATH**/ ?>