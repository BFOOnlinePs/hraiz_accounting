<table class="w-100 table-bordered table-hover table-striped">
    <thead class="bg-dark">
        <tr>
            <th style="width: 40px"></th>
            <th>باركود</th>
            <th>اسم الصنف</th>
            
            <th style="width: 100px" class="text-center">السعر</th>
            
            <th>الملاحظات</th>
            <th style="width: 10px" class="text-center">العمليات</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!$data->isEmpty()): ?>
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td>
                        <?php if(!empty($key->product->product_photo)): ?>
                            <img width="35px" src="<?php echo e(asset('storage/product/' . $key->product->product_photo)); ?>"
                                alt="">
                        <?php else: ?>
                            <img width="35px" src="<?php echo e(asset('img/no_img.jpeg')); ?>" alt="">
                        <?php endif; ?>
                    </td>
                    <td class="text-center"><?php echo e($key->product->barcode); ?></td>
                    <td>
                        <a
                            href="<?php echo e(route('product.details', ['id' => $key->product_id])); ?>"><?php echo e($key->product->product_name_ar); ?></a>
                    </td>
                    
                    
                    
                    
                    <td class="text-center">
                        <input style="width: 80px;background-color:palegoldenrod;border: 1px solid #ced4da" id="price_<?php echo e($key->id); ?>"
                            class="text-center <?php if($key->price == 0 || $key->price == ''): ?> bg-danger <?php endif; ?>"
                            onchange="update_qty_price_price_offer_sales_items_ajax(<?php echo e($key->id); ?>,this.value,'price')"
                            type="text" value="<?php echo e($key->price); ?>">
                        <div id="loader_price_<?php echo e($key->id); ?>" style="display: none" class="col text-center"><i
                                style="font-size: 16px" class="fas fa-3x fa-sync-alt fa-spin"></i></div>
                    </td>
                    
                    
                    
                    <td>
                        <textarea onchange="update_qty_price_price_offer_sales_items_ajax(<?php echo e($key->id); ?>,this.value,'notes')"
                            name="" class="form-control" id="" cols="30" rows="1" placeholder="اكتب ملاحظة ..."><?php echo e($key->notes); ?></textarea>
                        <div id="loader_notes_<?php echo e($key->id); ?>" style="display: none" class="col text-center"><i
                                style="font-size: 16px" class="fas fa-3x fa-sync-alt fa-spin"></i></div>
                    </td>
                    <td class="text-center">
                        <button onclick="delete_price_offer_sales_items(<?php echo e($key->id); ?>)"
                            class="btn btn-xs btn-danger"><span class="fa fa-close"></span></button>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
            
            
            
            
        <?php else: ?>
            <tr>
                <td colspan="6" class="text-center">لا توجد بيانات</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<?php /**PATH C:\xampp2\htdocs\projects\hraiz_accounting\resources\views/admin/sales/price_offer_sales/price_offer_sales_items/ajax/price_offer_sales_items_table.blade.php ENDPATH**/ ?>