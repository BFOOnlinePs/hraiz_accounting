@if ($bfo_attendances->isEmpty())
    <tr>
        <td colspan="8" class="text-center">لا توجد نتائج لهذا الشهر</td>
    </tr>
@else
    @foreach ($bfo_attendances as $key)
        @php
            $inTime = $key->in_time;
            $outTime = $key->out_time;
            $hoursDisplay = '-';

            if ($inTime && $outTime) {
                $inDateTime = \Carbon\Carbon::parse($inTime);
                $outDateTime = \Carbon\Carbon::parse($outTime);
                $diff = $inDateTime->diff($outDateTime);
                // تنسيق العرض: 05:30 ساعة
                $hoursDisplay = '<span class="badge badge-success">' . $diff->format('%H:%I') . ' ساعة</span>';
            } elseif (!$outTime) {
                 $hoursDisplay = '<span class="badge badge-warning">قيد العمل</span>';
            }

            $date = \Carbon\Carbon::parse($inTime)->toDateString();
            $dayName = \Carbon\Carbon::parse($inTime)->locale('ar')->dayName;
        @endphp
        <tr>
            <td class="text-center">{{ $loop->index + 1 }}</td>
            <td class="text-center">{{ $date }}</td>
            <td class="text-center">{{ $dayName }}</td>
            <td class="text-center">{{ \Carbon\Carbon::parse($inTime)->format('H:i') }}</td>
            <td class="text-center">{{ $outTime ? \Carbon\Carbon::parse($outTime)->format('H:i') : '-' }}</td>
            <td class="text-center">{!! $hoursDisplay !!}</td>
            <td class="text-center">{{ $key->status }}</td>
            <td class="text-center">
                @if(empty($key->out_time))
                    <button class="btn btn-sm btn-primary"
                            onclick="edit_out_time_attendance('{{$key->note}}' , {{$key->id}} , '{{$key->activity_type}}')">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                @endif
                <button class="btn btn-sm btn-warning"
                        onclick="edit_attendance({{$key->id}} , '{{$key->activity_type}}' , '{{$key->note}}' , '{{$inTime}}' , '{{$outTime}}')">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-sm btn-danger"
                        onclick="delete_bfo_attendance({{$key->id}})">
                    <i class="fa fa-trash"></i>
                </button>
            </td>
        </tr>
    @endforeach
@endif
