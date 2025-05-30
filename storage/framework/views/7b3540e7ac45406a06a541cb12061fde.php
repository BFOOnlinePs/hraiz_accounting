<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />

    <title><?php echo $__env->yieldContent('title'); ?></title>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/fontawesome-free/css/all.css')); ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/dist/css/adminlte.min.css')); ?>">
    <!-- Google Font: Source Sans Pro -->
    
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/bootstrap_rtl-v4.2.1/bootstrap.min.css')); ?>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo e(asset('assets/css/bootstrap_rtl-v4.2.1/custom_rtl.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/mycustomstyle.css')); ?>">

    <link rel="stylesheet" href="<?php echo e(asset('assets/jquery-ui/jquery-ui.css')); ?>">
    <?php echo $__env->yieldContent('style'); ?>
    <style>
        * {
            font-family: 'Tajawal', sans-serif;
        }

        #calendar {
            direction: ltr !important;
        }

        .pagination .page-item .page-link {
            color: black;
            /* Change text color */
        }

        .pagination .page-item.active .page-link,
        .pagination .page-item.active .page-link:focus,
        .pagination .page-item.active .page-link:hover {
            background-color: black;
            /* Change background color of active page */
            border-color: black;
            color: white;
            /* Change border color of active page */
        }

        .btn-xs{
            padding: .25rem .5rem;
            font-size: 10px;
            line-height: 1.5;
            border-radius: .2rem;
        }

        /* Customizing the Select2 field for smaller height */

.form-control-sm {
    font-size: 12px; /* Adjust to your desired size */
    height: 30px;    /* Adjust the height */
    padding: 0.2rem 0.5rem; /* Adjust padding */
    line-height: 1.5;
}

.table-xs {
    font-size: 14px; /* Extra small font */
}

.table-rounded {
    border-radius: 4px; /* Custom rounded corners */
    overflow: hidden;    /* Prevent borders from breaking */
}
    </style>
</head>

<body class="layout-top-nav" style="height: auto;" data-new-gr-c-s-check-loaded="14.1147.0" data-gr-ext-installed
    cz-shortcut-listen="true">
    <div class="wrapper">
        <!-- Navbar -->
        <?php echo $__env->make('layouts.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        
        <!-- Content Wrapper. Contains page content -->
        <?php echo $__env->make('layouts.content', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="modal fade" id="modal-lg-view_attachment">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-body">
                        <iframe id="view_attachment_result" src="" frameborder="0" width="100%"
                            style="height: 550px">

                        </iframe>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->

        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="<?php echo e(asset('assets/plugins/jquery/jquery.min.js')); ?>"></script>
    <!-- Bootstrap 4 -->
    <script src="<?php echo e(asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo e(asset('assets/dist/js/adminlte.min.js')); ?>"></script>

    <script src="<?php echo e(asset('assets/jquery-ui/jquery-ui.js')); ?>"></script>

    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })

        $(function() {
            // Select all input elements with type="date" and apply Datepicker
            $('.date_format').datepicker({
                dateFormat: 'yy-mm-dd'
            });
        });
    </script>

    <?php echo $__env->yieldContent('script'); ?>

    <script>

        function viewAttachment(url) {
            document.getElementById('view_attachment_result').src = url;
        }

        function numberFormat(value, decimals = 2) {
            // Convert the value to a float with specified decimals
            const floatValue = parseFloat(value);

            // Check if the conversion was successful
            if (isNaN(floatValue)) {
                throw new Error('Invalid value provided');
            }

            // Use toFixed to round to the specified number of decimals
            const roundedValue = floatValue.toFixed(decimals);

            // Use Number() to convert back to a number (removes trailing zeros)
            return Number(roundedValue);
        }

        function toEnglishNumber(strNum) {
            var ar = '٠١٢٣٤٥٦٧٨٩'.split(''); // الأرقام العربية
            var en = '0123456789'.split(''); // الأرقام الإنجليزية
            return strNum.replace(/[٠١٢٣٤٥٦٧٨٩]/g, function(x) {
                return en[ar.indexOf(x)];
            });
        }

        // تطبيق الدالة على جميع حقول number
        $(document).on('input', 'input[type="number"]', function() {
            var val = $(this).val();
            var newVal = toEnglishNumber(val); // تحويل الأرقام العربية إلى إنجليزية
            $(this).val(newVal); // تحديث القيمة
        });
    </script>
</body>

</html>
<?php /**PATH C:\xampp2\htdocs\projects\hraiz_accounting\resources\views/home.blade.php ENDPATH**/ ?>