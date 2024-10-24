<table class="table table-hover table-bordered table-sm">
    <thead>
        <tr>
            <th style="width: 7%"></th>
            <th>اسم الزبون</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @if ($data->isEmpty())
            <tr>
                <td colspan="3" class="text-center">لا توجد نتائج</td>
            </tr>
        @else
            @foreach ($data as $key)
                <tr>
                    <td>
                        @if (in_array(4, json_decode($key->user_role)))
                            <span class="badge badge-warning w-100">مورد</span>
                        @elseif (in_array(10, json_decode($key->user_role)))
                            <span class="badge badge-info w-100">زبون</span>
                        @endif
                    </td>
                    <td>{{ $key->name }}</td>
                    <td>
                        <a href="{{ route('accounting.account-statement.account_statement_details', ['id' => $key->id, 'user_type' => 'customer']) }}"
                            class="btn btn-dark btn-sm"><span class="fa fa-search"></span></a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
{{ $data->links() }}
<script>
    {{-- $(document).ready(function() { --}}
    {{--    $('.account-statement-details').click(function(event) { --}}
    {{--        event.preventDefault(); // Prevent default link behavior --}}

    {{--        var id = $(this).data('id'); // Get the ID from data-id attribute --}}
    {{--        var csrfToken = $('meta[name="csrf-token"]').attr('content'); // Get CSRF token --}}

    {{--        // AJAX POST request --}}
    {{--        $.ajax({ --}}
    {{--            url: '{{ route('accounting.account-statement.account_statement_details', ['id' => ':id']) }}'.replace(':id', id), --}}
    {{--            method: 'POST', --}}
    {{--            headers: { --}}
    {{--                "X-CSRF-Token": csrfToken --}}
    {{--            }, --}}
    {{--            data: { --}}
    {{--                '_token': csrfToken --}}
    {{--            }, --}}
    {{--            success: function(response) { --}}
    {{--                if (response.success) { --}}
    {{--                    window.location.href = response.redirect_url; --}}
    {{--                } else { --}}
    {{--                    // Handle other scenarios if needed --}}
    {{--                } --}}
    {{--            }, --}}
    {{--            error: function(jqXHR, textStatus, errorThrown) { --}}
    {{--                console.error(jqXHR.responseText); --}}
    {{--            } --}}
    {{--        }); --}}
    {{--    }); --}}
    {{-- }); --}}
</script>
