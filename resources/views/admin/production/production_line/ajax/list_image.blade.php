@foreach($data as $key)
    <button onclick="delete_image({{ $key->id }})" class="btn btn-danger"><span class="fa fa-trash"></span></button>
    <img style="width: 100px" src="{{ asset('storage/production/'.$key->attachment) }}" alt="">
@endforeach
