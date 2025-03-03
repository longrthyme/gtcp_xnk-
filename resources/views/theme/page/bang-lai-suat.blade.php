@extends($templatePath .'.layout')


@section('content')
@php
    $rates  = (new \App\Model\CoinRate)->getListAll()->groupBy('coin_id');
    $limits = (new \App\Model\CoinLimit)->getList();
    $months = (new \App\Model\CoinMonth)->getList();
@endphp
<div class="container my-lg-4 my-3">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="mb-2">
              <nav aria-label="breadcrumb animated slideInDown">
                 <ol class="breadcrumb text-capitalize ">
                     <li class="breadcrumb-item"><a href="/" class="text-white">@lang('Trang chủ')</a></li>
                     <li class="breadcrumb-item text-white active" aria-current="page">{{ $page->title }}</li>
                 </ol>
              </nav>

            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table_index">
                            <tbody>
                                @foreach($rates as $coin_id => $data)
                                @php
                                    $coin = \App\Model\Coin::find($coin_id);
                                @endphp
                                <tr>
                                    <td class="text-center">
                                        <a class="row-title" href="javascript:;">
                                            <b>{{ $coin->name }}</b>
                                        </a>
                                        <table>
                                            <tr>
                                                <td></td>
                                                @foreach($months as $month)
                                                <td class="text-center">{{ $month->name }}</td>
                                                @endforeach
                                            </tr>
                                            @foreach($limits as $limit)
                                            <tr>
                                                <td class="text-center">{{ $limit->limit }}</td>
                                                @foreach($months as $month)
                                                    @php
                                                        $rate = $data->where('coin_id', $coin_id)->where('limit_id', $limit->id)->where('month_id', $month->id)->first();
                                                    @endphp
                                                    <td><input type="text" readonly class="form-control text-center" name="rate[{{ $limit->id }}][{{ $month->id }}]" value="{{ $rate->rate??'' }}"></td>
                                                @endforeach
                                            </tr>
                                            @endforeach
                                        </table>
                                        <p>(%/năm)</p>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection