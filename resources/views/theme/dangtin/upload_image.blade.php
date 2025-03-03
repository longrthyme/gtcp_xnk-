@php
    $gallerys = '';
    if(!empty($product))
        $gallerys = $product->getGallery()??'';
        $video = $post->video??'';
        $video_image = $post->video_image??'';
@endphp
    <div class="step step-upload mt-0">
        <div class="form-group d-flex mb-0">
            <label class="content-img w-100 {{ $gallerys!='' && is_array($gallerys) ? 'is_gallery' : '' }}">
                <div class="upload-images"></div>
            </label>
        </div>
    </div>