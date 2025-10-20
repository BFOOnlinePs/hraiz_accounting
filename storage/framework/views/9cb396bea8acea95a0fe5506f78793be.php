
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>تسجيل الدخول</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/fontawesome-free/css/all.min.css')); ?>">

    <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')); ?>">

    <link rel="stylesheet" href="<?php echo e(asset('assets/dist/css/adminlte.min.css?v=3.2.0')); ?>">







    <style>
        @font-face {
            font-family: TajawalRegular;
            src: url('public/assets/fonts/Tajawal/Tajawal-Regular.ttf') format('truetype');
        }

        * {
            font-family: 'Tajawal', sans-serif;
        }
    </style>

    <script nonce="c56c3e82-46a3-4556-86b9-28eb8519800f">(function(w,d){!function(bg,bh,bi,bj){bg[bi]=bg[bi]||{};bg[bi].executed=[];bg.zaraz={deferred:[],listeners:[]};bg.zaraz.q=[];bg.zaraz._f=function(bk){return function(){var bl=Array.prototype.slice.call(arguments);bg.zaraz.q.push({m:bk,a:bl})}};for(const bm of["track","set","debug"])bg.zaraz[bm]=bg.zaraz._f(bm);bg.zaraz.init=()=>{var bn=bh.getElementsByTagName(bj)[0],bo=bh.createElement(bj),bp=bh.getElementsByTagName("title")[0];bp&&(bg[bi].t=bh.getElementsByTagName("title")[0].text);bg[bi].x=Math.random();bg[bi].w=bg.screen.width;bg[bi].h=bg.screen.height;bg[bi].j=bg.innerHeight;bg[bi].e=bg.innerWidth;bg[bi].l=bg.location.href;bg[bi].r=bh.referrer;bg[bi].k=bg.screen.colorDepth;bg[bi].n=bh.characterSet;bg[bi].o=(new Date).getTimezoneOffset();if(bg.dataLayer)for(const bt of Object.entries(Object.entries(dataLayer).reduce(((bu,bv)=>({...bu[1],...bv[1]})),{})))zaraz.set(bt[0],bt[1],{scope:"page"});bg[bi].q=[];for(;bg.zaraz.q.length;){const bw=bg.zaraz.q.shift();bg[bi].q.push(bw)}bo.defer=!0;for(const bx of[localStorage,sessionStorage])Object.keys(bx||{}).filter((bz=>bz.startsWith("_zaraz_"))).forEach((by=>{try{bg[bi]["z_"+by.slice(7)]=JSON.parse(bx.getItem(by))}catch{bg[bi]["z_"+by.slice(7)]=bx.getItem(by)}}));bo.referrerPolicy="origin";bo.src="/cdn-cgi/zaraz/s.js?z="+btoa(encodeURIComponent(JSON.stringify(bg[bi])));bn.parentNode.insertBefore(bo,bn)};["complete","interactive"].includes(bh.readyState)?zaraz.init():bg.addEventListener("DOMContentLoaded",zaraz.init)}(w,d,"zarazData","script");})(window,document);</script></head>
<body class="hold-transition login-page">
<div class="login-box">

    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="<?php echo e(asset('assets/index2.h  tml')); ?>" class="h1"><b><?php echo e($system_setting->company_name ?? 'اسم الشركة هنا'); ?></b></a>
        </div>
        <div class="card-body">

            <div class="text-center">
                <img class="text-center" src="<?php echo e(asset('storage/setting/'.$system_setting->company_logo)); ?>" style="width: 100px" alt="">
            </div>
            <form action="<?php echo e(route('login')); ?>" method="post" class="mt-2">
                <?php echo csrf_field(); ?>
                <div class="input-group ">
                    <input name="email" type="email" id="email" class="form-control" placeholder="Email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-danger"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <div class="input-group mt-3">
                    <input name="password" type="password" id="password" class="form-control" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="text-danger"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="text" name="login_date" class="form-control" value="<?php echo e(date('Y')); ?>">
                        </div>
                    </div>
                </div>
                <?php $__errorArgs = ['login_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="text-danger"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <div class="div pt-2">
                    <div class="div p-1 ">
                        <button onclick="login('admin@admin.com','123456789')" type="button" class="btn btn-dark btn-sm form-control">ادمن</button>
                    </div>









                </div>

                <div class="row mt-3">









                    <div class="col">
                        <button type="submit" class="btn btn-primary btn-block">تسجيل الدخول</button>
                    </div>
                </div>
            </form>















        </div>

    </div>

</div>


<script src="<?php echo e(asset('assets/plugins/jquery/jquery.min.js')); ?>"></script>

<script src="<?php echo e(asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>

<script src="<?php echo e(asset('assets/dist/js/adminlte.min.js?v=3.2.0')); ?>"></script>

<script>
    function login(username,password) {
        document.getElementById('email').value = username;
        document.getElementById('password').value = password;
    }
</script>
</body>
</html>
<?php /**PATH C:\xampp2\htdocs\projects\hraiz_accounting\resources\views/auth/login.blade.php ENDPATH**/ ?>