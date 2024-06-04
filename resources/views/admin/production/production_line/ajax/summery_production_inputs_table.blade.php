<table style="width: 100%" class="table-sm  table-bordered">
    <thead>
    <tr>
        <th class="">باركود</th>
        <th>اسم الصنف المخرج</th>
        <th>عدد وحدات الانتاج</th>
        <th class="text-center bg-warning">تفاصيل تكاليف الانتاج</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>{{ $production_lines->product->barcode }}</td>
        <td>{{ $production_lines->product->product_name_ar }}</td>
        <td>{{ $production_lines->production_output_count }}</td>
        <td>
            <table style="width: 100%" class="table-sm ">
                <thead>
                <tr class="bg-secondary">
                    <th>اسم المدخل</th>
                    <th>العدد</th>
                    <th>التكلفة</th>
                    <th>المجموع</th>
                    <th>وزن بروفيل</th>
                    <th>وزن زاوية</th>
                    <th>تكلفة الزاوية</th>
                </tr>
                </thead>
                <tbody>
                @if($data->isEmpty())
                    <tr>
                        <td colspan="10" class="text-center">لا توجد بيانات</td>
                    </tr>
                @else
                    @php
                        $total_sum = 0;
                    @endphp
                    @foreach($data as $key)

                        <tr>
                            <td>{{ $key->production_input_name }}</td>
                            <td>
                                {{ $key->qty }}
                            </td>
                            <td>
                                @if($key->product_id == -1)
                                    {{ $key->estimated_cost }}
                                @else
                                    {{ $key->product->cost_price }}
                                @endif
                            </td>
                            <td>{{ ($key->qty) * (($key->product_id == -1)?$key->estimated_cost:$key->product->cost_price) }}</td>
                            <td>
                                {{ $key->product->weight??'' }}
                            </td>
                            <td class="bg-success">
                                @if(!empty($key->product->weight) && !empty($production_lines->production_output_count))
                                    {!! number_format((float)($key->product->weight/$production_lines->production_output_count), 2) !!}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="bg-success">

                                @if(!empty($key->product->cost_price) && !empty($production_lines->production_output_count))
                                    @php
                                        $total_sum +=  (($key->qty * $key->product->cost_price)/$production_lines->production_output_count);
                                    @endphp
                                    {!! number_format((float)(($key->qty * $key->product->cost_price)/$production_lines->production_output_count), 2) !!}
                                @else
                                    @php
                                        $total_sum +=  ((($key->qty) * (($key->product_id == -1)?$key->estimated_cost:$key->product->cost_price)) / ($production_lines->production_output_count));
                                    @endphp
                                    {!! number_format((float)(($key->qty) * (($key->product_id == -1)?$key->estimated_cost:$key->product->cost_price)) / ($production_lines->production_output_count),3) !!}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    <tr class="bg-secondary">
                        <td colspan="6" class="text-center">مجموع تكلفة انتاج الوحدة الواحدة</td>
                        <td>
                            @php
                                echo number_format((float)$total_sum,2);
                            @endphp
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
