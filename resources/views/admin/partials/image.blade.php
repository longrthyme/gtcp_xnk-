<div class="card">
    <div class="card-body">
        <h5>{{ $title ?? 'Image Thumbnail'}}</h5>
            <div class="input-group">
                <input type="text" class="form-control" name="{{ $name ?? 'image' }}" id="{{ $name ?? 'image' }}" value="{{$image}}">
                <button class="btn btn-outline-secondary ckfinder-popup" type="button" id="{{ $id ?? 'img' }}"  data-show="{{ $id ?? 'img' }}_view" data="{{ $name ?? 'image' }}">Upload</button>
            </div>
            <div class="demo-img bg-light" style="padding-top: 10px;">
                @if($image != "")
                    <img class="{{ $id ?? 'img' }}_view" src="{{asset($image)}}">
                @else
                    <img class="{{ $id ?? 'img' }}_view" src="{{asset('assets/images/placeholder.png')}}">
                @endif
            </div>
    </div> <!-- /.card-body -->
</div><!-- /.card -->