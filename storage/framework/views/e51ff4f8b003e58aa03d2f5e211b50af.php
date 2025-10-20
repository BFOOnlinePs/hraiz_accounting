<table class="table table-bordered table-hover table-sm">
    <thead class="bg-dark">
        <tr>
            <th>المستند</th>
            <th>التاريخ</th>
            <th>دائن</th>
            <th>مدين</th>
            <th>الرصيد</th>
            <th>الملاحظات</th>
            <th style="width: 200px">البيان</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $sumCreditor = [];
            $sumDebtor = [];
            $balances = []; // To hold balance per currency
        ?>

        <?php if($data->isEmpty()): ?>
            <tr>
                <td colspan="7" class="text-center">لا توجد بيانات</td>
            </tr>
        <?php else: ?>
            <?php if(!empty($firstTermBalance)): ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td>
                        <?php if($firstTermBalance['amount'] < 0): ?>
                            <?php echo e($firstTermBalance['amount']); ?>

                        <?php else: ?>
                        0
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($firstTermBalance['amount'] > 0): ?>
                            <?php echo e($firstTermBalance['amount']); ?>

                        <?php else: ?>
                        0
                        <?php endif; ?>
                    </td>
                    <td><?php echo e($firstTermBalance['amount']); ?></td>
                    <td>رصيد اول المدة  </td>
                    <td></td>
                </tr>
            <?php endif; ?>
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $currencySymbol = $key->currency_info->currency_symbol ?? 'بدون عملة';

                    // Initialize sums and balances for this currency if not already set
                    $sumCreditor[$currencySymbol] = $sumCreditor[$currencySymbol] ?? 0;
                    $sumDebtor[$currencySymbol] = $sumDebtor[$currencySymbol] ?? 0;
                    $balances[$currencySymbol] = $balances[$currencySymbol] ?? 0;
                ?>

                <tr class="<?php if(!$key->invoice_items->isEmpty() && $request->account_statment_type == 'detailed'): ?> bg-secondary <?php endif; ?>">
                    <td><?php echo e($key->reference_number); ?></td>
                    <td><?php echo e(\Carbon\Carbon::parse($key->created_at)->format('Y-m-d')); ?></td>
                    <td>
                        <?php if(in_array($key->type, ['purchase', 'payment_bond', 'return_sales', 'registration_bond_credit'])): ?>
                            <?php echo e($currencySymbol); ?> <?php echo e($key->amount); ?>

                            <?php
                                $sumCreditor[$currencySymbol] += $key->amount;
                                $balances[$currencySymbol] -= $key->amount;
                            ?>
                        <?php else: ?>
                            <?php echo e($currencySymbol); ?> 0
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if(in_array($key->type, ['sales', 'performance_bond', 'return_purchase', 'registration_bond_debt'])): ?>
                            <?php echo e($currencySymbol); ?> <?php echo e($key->amount); ?>

                            <?php
                                $sumDebtor[$currencySymbol] += $key->amount;
                                $balances[$currencySymbol] += $key->amount;
                            ?>
                        <?php else: ?>
                            <?php echo e($currencySymbol); ?> 0
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php
                            // Format balances for display with badge class
                            $balanceDisplay = collect($balances)
                                ->map(function ($value, $currency) {
                                    return '<span class="">' . $currency . ' ' . number_format($value) . '</span>';
                                })
                                ->join(' , ');
                        ?>
                        <?php echo $balanceDisplay; ?>

                    </td>
                    <td><?php echo e($key->notes ?? ''); ?></td>
                    <td>
                        <?php if($key->type == 'sales'): ?>
                            <div style="width:13px;height:13px" class="bg-success d-inline-block ml-2 rounded"></div><a
                                class="text-dark" target="_blank"
                                href="<?php echo e(route('accounting.sales_invoices.invoice_view', ['id' => $key->invoice_id])); ?>">فاتورة
                                مبيعات</a>
                        <?php elseif($key->type == 'payment_bond'): ?>
                            <div style="width:13px;height:13px" class="bg-secondary d-inline-block ml-2 rounded"></div>
                            <a class="text-dark" target="_blank"
                                href="<?php echo e(route('accounting.bonds.details', ['id' => $key->invoice_id])); ?>">
                                <span>سند قبض</span>
                                
                            </a>

                            
                            
                            
                        <?php elseif($key->type == 'return_sales'): ?>
                            <div style="width:13px;height:13px" class="bg-danger d-inline-block ml-2 rounded"></div><a
                                class="text-dark" target="_blank"
                                href="<?php echo e(route('accounting.returns.returns_details', ['id' => $key->invoice_id])); ?>">
                                <span>مردود مبيعات</span>
                                
                            </a>
                        <?php elseif($key->type == 'return_purchase'): ?>
                            <div style="width:13px;height:13px" class="bg-warning d-inline-block ml-2 rounded"></div><a
                                class="text-dark" target="_blank"
                                href="<?php echo e(route('accounting.returns.returns_details', ['id' => $key->invoice_id])); ?>">
                                <span>مردود مشتريات</span>
                                
                            </a>
                        <?php elseif($key->type == 'performance_bond'): ?>
                            <div style="width:13px;height:13px" class="bg-dark d-inline-block ml-2 rounded"></div><a
                                class="text-dark" target="_blank"
                                href="<?php echo e(route('accounting.bonds.details', ['id' => $key->invoice_id])); ?>">
                                <span>سند صرف</span>
                                
                            </a>
                        <?php elseif($key->type == 'purchase'): ?>
                            <div style="width:13px;height:13px" class="bg-info d-inline-block ml-2 rounded"></div><a
                                class="text-dark" target="_blank"
                                href="<?php echo e(route('accounting.purchase_invoices.invoice_view', ['id' => $key->invoice_id])); ?>">فاتورة
                                مشتريات</a>
                        <?php elseif($key->type == 'performance_bond'): ?>
                        <?php endif; ?>
                    </td>
                </tr>

                <?php if($key->type == 'sales' || $key->type == 'purchase'): ?>
                    <?php if($request->account_statment_type == 'detailed'): ?>
                        <?php if(!empty($key->invoice_items)): ?>
                            <tr class="bg-light">
                                <td colspan="7">
                                    <table class="table-sm w-100">
                                        <tbody>
                                            <?php $__currentLoopData = $key->invoice_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td style="width: 15%"><?php echo e($item->product->barcode); ?></td>
                                                    <td><?php echo e($item->product->product_name_ar); ?></td>
                                                    <td style="width: 10%"><?php echo e($item->quantity); ?></td>
                                                    <td style="width: 10%"><?php echo e($item->rate); ?></td>
                                                    <td class="bg-success" style="width: 10%">
                                                        <?php echo e($item->quantity * $item->rate); ?></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        </tbody>

                                    </table>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <tr class="bg-success">
                <td></td>
                <td colspan="1" class="text-center">المجموع</td>
                <td>
                    <?php
                        $creditorDisplay = collect($sumCreditor)
                            ->map(function ($total, $currency) {
                                if ($total != 0) {
                                    return $currency . ' ' . number_format($total) . '<br>';
                                }
                            })
                            ->join('');
                    ?>
                    <?php echo $creditorDisplay; ?>

                </td>
                <td>
                    <?php
                        $debtorDisplay = collect($sumDebtor)
                            ->map(function ($total, $currency) {
                                if ($total != 0) {
                                    return $currency . ' ' . number_format($total) . '<br>';
                                }
                            })
                            ->join('');
                    ?>
                    <?php echo $debtorDisplay; ?>

                </td>
                <td colspan="3">
                    <?php
                        $balanceDisplay = collect($balances)
                            ->map(function ($value, $currency) {
                                if ($value != 0) {
                                    return $currency . ' ' . number_format($value) . '<br>';
                                }
                            })
                            ->join('');
                    ?>
                    <?php echo $balanceDisplay; ?>

                </td>
            </tr>

            
        <?php endif; ?>
    </tbody>
</table>


<?php /**PATH C:\xampp2\htdocs\projects\hraiz_accounting\resources\views/admin/accounting/account_statement/ajax/account_statement_details_table.blade.php ENDPATH**/ ?>