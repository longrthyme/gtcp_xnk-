@php
   $packagedays = \App\Models\PackageDay::get();
@endphp
@if(Session::has('error'))
   <div class="text-danger mt-3">
      {{ Session::get('error') }}
   </div>
@endif
<div class="package-content py-3">
   <table class="table table-bordered font-weight-bold">
      <tbody>
         <tr class="table-danger text-center ">
            <th width="40%">Loại tài khoản</th>
            @foreach($packages as $package)
            <th>{{ $package->name }}</th>
            @endforeach
         </tr>
         @if(!empty($options))
            @foreach($options as $item)
            <tr>
               <td>{{ $item->name }}</td>

               @foreach($packages as $package)
                  @php
                     $package_options = $package->getOptions();
                  @endphp
                  <td class="text-center">
                     @if(in_array($item->id, $package_options))
                        <img src="{{ asset('assets/images/checked.png') }}" width="20">
                     @endif
                  </td>
               @endforeach

            </tr>
            @endforeach
         @endif
         @foreach($packagedays as $item)
         <tr>
            <td>
               <h5>Phí tài khoản {{ $item->name }}</h5>
               <p>(Khuyến mãi áp dụng cho {{ $item->qty }} tài khoản đăng ký đầu tiên)</p>
            </td>
            @foreach($packages as $package)
               @php
                  $package_item = \App\Models\PackageDayJoin::where('package_id', $package->id)->where('day_id', $item->id)->first();
               @endphp
               <td class="text-end">
                  <div class="text-danger"><span style="text-decoration-line: line-through; font-size:14px;">{!! render_price($package_item->price) !!}</span> (Giá gốc)</div>
                  <div><b>{!! render_price($package_item->promotion) !!} (Giá khuyến mãi)</b></div>
                  <a href="{{ $package->getUrl($item->id) }}" class="btn btn-custom" data="{{ $package_item->id }}">Nâng cấp ngay</a>
               </td>
            @endforeach
         </tr>
         @endforeach
         
      </tbody>
   </table>

</div>