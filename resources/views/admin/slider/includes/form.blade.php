@php
    if(isset($slider))
    {
        extract($slider->toArray());
        $description = $slider->description ? $slider->description->keyBy('lang')->toArray(): [];
        //dd($description);
    }
@endphp

<form id="form-editSlider" action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="{{ $id??0 }}">
    <input type="hidden" name="slider_id" value="{{ $parent??0 }}">

    @include('admin.partials.tab-lang-head', ['type' => 'item'])

    @php
        $i=0;
    @endphp
    @if(!empty($languages))
    <div class="tab-content px-0">
        @foreach($languages as $code => $lang)
        <div class="tab-pane fade {{ $i==0 ? 'show active':'' }}" id="item{{ $code }}" role="tabpanel" aria-labelledby="item{{ $code }}-tab">
            <div class="form-group">
                <label for="name_{{ $code }}">Tiêu đề ({{ $code }})</label>
                <input type="text" class="form-control title_slugify" id="name_{{ $code }}" name="description[{{ $code }}][name]" placeholder="Tiêu đề" value="{{ $description[$code]['name'] ?? '' }}">
            </div>
            <div class="form-group">
                <label for="description_{{ $code }}">Trích dẫn  ({{ $code }})</label>
                <textarea id="description_{{ $code }}" name="description[{{ $code }}][description]" class="form-control">{!! $description[$code]['description'] ?? '' !!}</textarea>
            </div>
        </div>
        @php
        $i++;
        @endphp
        @endforeach
    </div>
    @endif
    <!-- <div class="form-group">
        <label for="name">Tên</label>
        <input type="text" class="form-control" id="name"  name="name" value="{{ $name??'' }}">
    </div> -->
    <div class="form-group">
        <label for="link">Link</label>
        <input type="text" class="form-control" name="link" value="{{ $link??'' }}">
    </div>
    <div class="form-group">
        <label for="link">Video</label>
        <input type="text" class="form-control" name="video" value="{{ $video??'' }}">
    </div>
    <div class="form-group">
        <label for="order">STT</label>
        <input id="order" type="text" name="order" class="form-control" value="{{ $order??'' }}">
    </div>
    <div class="form-group">
        <div class="inserIMG">
            <input type="hidden" name="src" id="src-img" value="{{ $src ?? '' }}">
            @if(isset($src) && $src!='')
                <img src="{{ asset($slider->src) }}" id="show-img" class="show-img src-img ckfinder-popup" data-show="show-img" data="src-img" width="200" onerror="this.onerror=null;this.src='{{ asset('assets/images/placeholder.png') }}';">
            @else
                <img src="{{ asset('assets/images/placeholder.png') }}" id="show-img" class="show-img src-img ckfinder-popup" data-show="show-img" data="src-img" width="200">
            @endif
            <span class="remove-icon" data-img="{{ asset('assets/images/placeholder.png') }}">X</span>
        </div>
    </div>
    
</form>