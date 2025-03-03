
    <div class="gallery_body" data="{{ $index }}" data-name="gallery_attr">
        <div class="gallery_box grabbable-parent" id="gallery_sort">
            @if(!empty($gallery_attr))
                @foreach($gallery_attr as $key => $image)
                <div class="gallery_item">
                    <div class="gallery_content">
                        <span class="remove"><i class="fa fa-times-circle" aria-hidden="true"></i></span>
                        <input type="hidden" name="gallery_attr[{{ $index }}][]" value="{{ $image }}">
                        <img class="gallery-view{{ $key }}" src="{{ asset($image) }}">
                    </div>
                </div>
                @endforeach
            @endif
        </div>
        <div class="text-center">
            <button class="btn btn-outline-secondary btn-sm ckfinder-gallery" type="button">Chọn ảnh từ thư viện</button>
        </div>
    </div>
<!--End Post Gallery-->
@push('scripts-footer')
    <script src="{{ asset('assets/plugin/Sortable.js') }}"></script>
    <script type="text/javascript">
        
        jQuery(document).ready(function($){
            /*new Sortable(gallery_sort, {
                swapClass: 'highlight', // The class applied to the hovered swap item
                ghostClass: 'blue-background-class',
                animation: 150
            });*/
            $(document).on('click', '.gallery_item .remove', function(){
                $(this).closest('.gallery_item').remove();
            })

        });
    </script>
@endpush