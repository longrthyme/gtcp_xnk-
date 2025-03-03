
<div class="p-3 border-bottom text-center">
  <h6 class="mb-0">Tin đăng đã lưu</h6>
</div>
  @if($wishlist!='' && count($wishlist)>0)
    @php
      if(auth()->check())
        $products = \App\Product::with('getWishList')->whereHas('getWishList', function($query){
          return $query->where('user_id', auth()->user()->id);
        })->limit(2)->get();
      else
        $products = \App\Product::wherein('id', $wishlist)->limit(2)->get();

    @endphp
    @if(count($products)>0)
      @foreach($products as $product)
      @php
         $product_link = route('products.single', ['id' => $product->id, 'slug' => $product->slug]);
      @endphp
      <div class="row wishlist-item py-2 align-items-top mx-0">
        <div class="col-4">
          <div class="img position-relative">
            <div class="dummy"></div>
            <div class="my-dummy"><img src="{{ asset($product->image) }}" alt=""></div>
          </div>
        </div>
        <div class="col-8">
          <a class="text-dark" href="{{ $product_link }}"><b>{{ $product->title }}</b></a>
          <a class="d-flex font-sm text-dark" href="{{ $product_link }}">{{ $product->getTimeAgo() }}</a>
        </div>
        <i class='remove-wishlist bx bx-x' data="{{ $product->id }}"></i>
      </div>
      @endforeach
    @endif
    <div class="col-12 border-top p-2 text-center">
      <a href="{{ route('customer.wishlist') }}" title="">@lang('Xem tất cả')</a>
    </div>
  @else
  <div class="p-5 text-center">
    <img src="{{ asset('theme/images/EmptyState.svg') }}">
  </div>
  @endif