<table class="table table-sm table-hover table-bordered">
    <thead>
        <tr>
            <th>اسم المدخل</th>
            <th>التكلفة</th>
            <th>تكلفة الوحدة الواحدة</th>
        </tr>
    </thead>
    <tbody>
    @foreach($data as $key)
        <tr>
            <td>{{ $key->production_input_name }}</td>
            <td>
                <input id="estimated_cost_worker_{{ $key->id }}" @if(!$key->production_input_name == 'عامل') readonly @endif onchange="update_estimated_cost_ajax({{ $key->id }},this.value,'estimated_cost')" type="text" value="{{ $key->estimated_cost }}">
                <div id="estimated_cost_worker_loader_{{ $key->id }}" style="display: none;font-size: 7px" class="col text-center p-5"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>
            </td>
            <td>
                <input id="cost_per_unit_worker_{{$key->id}}"
                       @if(!$key->production_input_name == 'عامل') readonly @endif
                       type="text"
                       onchange="update_estimated_cost_ajax({{ $key->id }}, this.value, 'product')"
                       value="{{ ($key->production_lines->production_output_count != 0) ? number_format((float)($key->estimated_cost) / ($key->production_lines->production_output_count),2) : '' }}">
                <div id="cost_per_unit_worker_loader_{{$key->id}}" style="display: none;font-size: 7px" class="col text-center p-5"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
