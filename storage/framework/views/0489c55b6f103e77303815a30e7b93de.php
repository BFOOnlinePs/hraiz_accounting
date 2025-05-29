<html dir="<?php if($language == 'en'): ?> ltr <?php else: ?> rtl <?php endif; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>عرض سعر</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">

    <style>
        @page{
            <?php if(!empty(\App\Models\SystemSettingModel::first()->letter_head_image)): ?>
                background-image: url("<?php echo e(asset('storage/setting/'.\App\Models\SystemSettingModel::first()->letter_head_image)); ?>");
            <?php endif; ?>
            background-image-resize:6;
            margin-bottom:50px;
            margin-top:150px;
        }

        @page :first{
            <?php if(!empty(\App\Models\SystemSettingModel::first()->letter_head_image)): ?>
                background-image: url("<?php echo e(asset('storage/setting/'.\App\Models\SystemSettingModel::first()->letter_head_image)); ?>");
            <?php endif; ?>
            background-image-resize:6;
            margin-bottom:50px;
        }
        .title{

        }
        table, td, th {
            border: 1px solid black;
            font-size: 14px;
        }
        .table{
            padding-top: 150px;
            border-collapse: collapse;
            width: 100%;
            text-align: center;
        }
        th{
            height: 70%;
            background-color: #6c757d;
            color: white;
        }

        .float-container {
        }

        .float-child {
            width: 43.4%;
            float: left;
        }

        .sum{
            background-color: #6c757d;
            color: white;
        }
    </style>
</head>
<body>
<h2 align="center">
    <?php if($language == 'ar'): ?>
        <p style="text-align: center">عرض سعر</p>
    <?php elseif($language == 'en'): ?>
        <p style="text-align: center">Price Offer</p>
    <?php elseif($language == 'he'): ?>
        <p style="text-align: center">הצעת מחיר</p>
    <?php endif; ?>
</h2>
<div class="float-container">
    <div class="float-child" style="float: right">
        <h5>
            <?php if($language == 'ar'): ?>
                الى :
            <?php elseif($language == 'en'): ?>
                to :
            <?php elseif($language == 'he'): ?>
                ל :
            <?php endif; ?>
        </h5>
        <h5><?php echo e($price_offer_sales->customer->name); ?></h5>
    </div>
    <div class="float-child" style="float: left;text-align: center">
        <h5>
            <?php if($language == 'ar'): ?>
                عرض سعر رقم :
            <?php elseif($language == 'en'): ?>
                Price Offer Number :
            <?php elseif($language == 'he'): ?>
                צפו במחיר מס :
            <?php endif; ?>
            <span><?php echo e($price_offer_sales->id); ?></span></h5>
        <h5>
            <?php if($language == 'ar'): ?>
                تاريخ :
            <?php elseif($language == 'en'): ?>
                Date :
            <?php elseif($language == 'he'): ?>
                תאריך :
            <?php endif; ?>
            <span><?php echo e(\Carbon\Carbon::parse($price_offer_sales->insert_at)->toDateString()); ?></span></h5>
    </div>
</div>
<table class="table" cellpadding="10">
    <tr>
        <th>
            <?php if($language == 'ar'): ?>
                باركود
            <?php elseif($language == 'en'): ?>
                Barcode
            <?php elseif($language == 'he'): ?>
                ברקוד
            <?php endif; ?>
        </th>
        <th>
            <?php if($language == 'ar'): ?>
                اسم الصنف
            <?php elseif($language == 'en'): ?>
                Product name
            <?php elseif($language == 'he'): ?>
                שם מוצר
            <?php endif; ?>
        </th>
        <th></th>









        <th>
            <?php if($language == 'ar'): ?>
                السعر
            <?php elseif($language == 'en'): ?>
                Price
            <?php elseif($language == 'he'): ?>
                המחיר
            <?php endif; ?>
        </th>









        <th>
            <?php if($language == 'ar'): ?>
                الملاحظات
            <?php elseif($language == 'en'): ?>
                Notes
            <?php elseif($language == 'he'): ?>
                הערות
            <?php endif; ?>
        </th>
    </tr>
    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td>
                <?php echo e($key->product->barcode); ?>

            </td>
            <td>
                <?php if($language == 'ar'): ?>
                    <?php echo e($key->product->product_name_ar); ?>

                <?php elseif($language == 'en'): ?>
                    <?php echo e($key->product->product_name_en); ?>

                <?php elseif($language == 'he'): ?>
                    <?php echo e($key->product->product_name_he); ?>

                <?php endif; ?>
            </td>
            <td>
                <img style="width: 40px" src="<?php echo e(asset('storage/product/'.$key->product->product_photo)); ?>" alt="">
            </td>



            <td><?php echo e($key->price); ?></td>



            <td><?php echo e($key->notes); ?></td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>













</table>
<div style="margin-top: 20px">
    <h5>
        <?php if($language == 'ar'): ?>
            الملاحظات
        <?php elseif($language == 'en'): ?>
            Notes
        <?php elseif($language == 'he'): ?>
            הערות
        <?php endif; ?>
    </h5>
    <p><?php echo e($price_offer_sales->notes); ?></p>
</div>
</body>
</html>
<?php /**PATH C:\xampp2\htdocs\projects\hraiz_accounting\resources\views/admin/sales/price_offer_sales/price_offer_sales_items/pdf/price_offer_sales_items.blade.php ENDPATH**/ ?>