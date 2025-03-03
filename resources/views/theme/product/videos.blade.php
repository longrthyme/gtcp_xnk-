@php
    $access = 0;
    if($product->checkAccessSection())
        $access = 1;
@endphp
<!-- list album video -->
<div class="list_album_video px-4">
    @foreach($videos as $video)
        <div class="mb-3">
            @php
                $post_childs = (new \App\ShopVideo)->getList([
                    'parent'     => $video->id,
                ]);
            @endphp
            <h6 class="fw-bold text_blue">{{ $video->name }}</h6>
            @foreach($post_childs as $item)
            <div class="border-bottom py-3">
                <div class="row">
                    <div class="col-5">
                        <div class="thumbnail">
                            <img src="{{ asset($item->image) }}" alt="" class="image_cover rounded-2">
                        </div>
                    </div>
                    <div class="col-7 d-flex flex-column">
                        <div>{{ $item->name }}</div>
                        <div class="d-flex justify-content-between mt-3">
                            <div class="py-2 fw-medium text_blue">
                                <i class="fa-regular fa-clock"></i>
                                <span class="ms-1 fs-14">{{ $item->duration }}</span>
                            </div>
                            <a href="{{ !$access ? '' : asset($item->file) }}" class="btn btn_orange rounded-pill fs-14 btn-view-file">Xem ngay</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endforeach
</div>