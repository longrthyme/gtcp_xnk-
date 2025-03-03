@php 
    $i=0;
    $description_show = $description_show??false;

    if(!empty($post_url))
        $post_url_ = str_replace(url('/'), '', $post_url);
@endphp
@if(!empty($languages))
    <div class="tab-content">
        @foreach($languages as $code => $lang)
        <div class="tab-pane fade {{ $i == 0 ? 'show active' : '' }}" id="{{ $code }}" role="tabpanel" aria-labelledby="{{ $code }}-tab">
            <div class="form-group">
                <label for="name_{{ $code }}">Tiêu đề ({{ $code }})</label>
                <input type="text" class="form-control title_slugify" id="name_{{ $code }}" name="description[{{ $code }}][name]" placeholder="Tiêu đề" value="{{ $description[$code]['name'] ?? '' }}">
            </div>

            @if($i==0)
            <div class="form-group">
                <label for="slug">Slug thể loại tin</label>
                <input type="text" class="form-control slug_slugify" id="slug" name="slug" placeholder="Slug" value="{{ $slug ?? '' }}">
            </div>
            @endif
            @if(!empty($post_url))
                @php
                    $post_url_lang = $post_url_;
                    if(!$lang->set_default)
                    {
                        $post_url_lang = '/' . $code . $post_url_;
                    }
                    
                @endphp
                <p class="p-3 bg-light">URL:
                    <a href="{{ $post_url_lang }}" class="text-danger" target="_blank"><b>{{ $post_url_lang }}</b></a>
                </p>
            @endif
            

            @if($description_show)
            <div class="form-group">
                <label for="description_{{ $code }}">Trích dẫn  ({{ $code }})</label>
                <textarea id="description_{{ $code }}" name="description[{{ $code }}][description]">{!! $description[$code]['description'] ?? '' !!}</textarea>
            </div>
            @endif

            <div class="form-group">
                <label for="content_{{ $code }}">Nội dung  ({{ $code }})</label>
                <textarea id="content_{{ $code }}" name="description[{{ $code }}][content]">{!! $description[$code]['content'] ?? '' !!}</textarea>
            </div>

            <hr>

            <div class="form-group">
                <label for="seo_title_{{ $code }}">Seo Title  ({{ $code }})</label>
                <input type="text" id="seo_title_{{ $code }}" name="description[{{ $code }}][seo_title]" class="form-control" value="{!! $description[$code]['seo_title'] ?? '' !!}">
            </div>

            <div class="form-group">
                <label for="seo_keyword_{{ $code }}">Seo Keyword  ({{ $code }})</label>
                <input type="text" id="seo_keyword_{{ $code }}" name="description[{{ $code }}][seo_keyword]" class="form-control" value="{!! $description[$code]['seo_keyword'] ?? '' !!}">
            </div>

            <div class="form-group">
                <label for="seo_description_{{ $code }}">Seo Description  ({{ $code }})</label>
                <textarea id="seo_description_{{ $code }}" name="description[{{ $code }}][seo_description]" class="form-control">{!! $description[$code]['seo_description'] ?? '' !!}</textarea>
            </div>
            
        </div>
        @php
        $i++;
        @endphp
        @endforeach
    </div>
@endif