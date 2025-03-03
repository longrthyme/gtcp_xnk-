@extends($templatePath.'.layout')

@section('seo')
@endsection

@section('content')
    @php
        $category_first = $category_sub??$categories->first();
        if($category_first)
            $category_filters = $modelCategory->getList(['parent' => $category_first->id]);

        $post_type = request('post_type')??'sell';

        
    @endphp

    <div class="container text-center">
        {!! htmlspecialchars_decode($category->content) !!}
    </div>

    <div class="block-archive">
        <div class="container my-lg-4 my-3">
            <div class='page-content'>
                <div class="page-wrapper">
                    @include($templatePath .'.product.category-tabs')
                    <div class="row">
                        <div class="col mx-auto">
                            @if(!empty($category_path) && \View::exists($category_path . '-filter-top'))
                                @include($category_path . '-filter-top')
                            @else
                                @includeIf($category_folder .".filter-top")
                            @endif

                            <div class="product-list">
                                @if(!empty($category_path))
                                    @includeIf($category_path)
                                @else
                                    @includeIf($templatePath .".product.product_list")
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            @includeIf($category_folder .".filter-right")
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    @include('shortcode.keyword', ['menu'=>"Keyword-hot"])
    @include('shortcode.contact')
@endsection

@push('styles')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
@endpush
@push('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/product.js?ver='. $templateVer) }}"></script>
    <script>
        jQuery(document).ready(function($) {
            $('.datepicker').datepicker({
                  format: 'dd/mm/yyyy',
                  autoclose: true
              });
        });
    </script>
@endpush