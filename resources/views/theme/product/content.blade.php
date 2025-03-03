@extends($templatePath.'.layout')

@section('seo')
@endsection

@section('content')
    @php        
        
        $category_first = $category_sub??$categories->first();
        $category_filters = $modelCategory->getList(['parent' => $category_first->id]);

        if($category->slug == 'viec-lam')
        {
            $products = $modelProduct->setCategory($category_id)->getList(request()->all());
        }
        else
            $products = $modelProduct->setCategory($category_first->id)->getList(request()->all());
    @endphp
    
    <div class="container text-center">
        {!! htmlspecialchars_decode($category->content) !!}
    </div>

    <div class="block-archive">
        <div class="container my-lg-4 my-3">
            <div class='page-content'>
                <div class="page-wrapper">                    
                    <div class="row">
                        <div class="col-12 mx-auto">
                            @include($templatePath .'.product.category-tabs')

                            @if(!empty($customers))
                            <div class="row">
                                @foreach($customers as $customer)
                                    <div class="col-lg-6">
                                        @include($templatePath .'.author.author-item')
                                    </div>
                                @endforeach
                            </div>
                            @endif
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
    <script src="{{ asset( $templateFile .'/js/clipboard.min.js' ) }}"></script>
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