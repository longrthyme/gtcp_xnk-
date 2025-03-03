@extends($templatePath .'.layout')

@section('seo')
@include($templatePath .'.layouts.seo', $seo??[] )
@endsection

@section('content')
    @php
        //$data = $category->getContentExcelFile();
    @endphp
    <div class="container text-center">
        {!! htmlspecialchars_decode($category->content) !!}
    </div>

    @includeIf($templatePath .'.news.tabs')

    <div class="container">

        @if(auth()->check())
            @if($category->image)
            <div id="container">
                <div id="overlay"></div>
                {{--<iframe id="readexcel" src='https://view.officeapps.live.com/op/embed.aspx?src={{ asset($category->image) }}' width='100%' height='800px' frameborder='0'> </iframe>--}}

                <div class="html-content position-relative">
                    {!! $html??'' !!}
                </div>

                @if(count($files)>1)
                <div>
                    <nav class="mt-3">
                        <ul class="pagination justify-content-center">
                            @foreach($files as $page => $item)
                            <li class="page-item"><a class="page-link page-link-ajax {{ request('page') == $page + 1 ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['page' => $page+1]) }}">{{ $page+1 }}</a></li>
                            @endforeach
                        </ul>
                    </nav>
                </div>
                @endif
            </div>
            @else
                <p>Rất tiếc, thông tin bạn tìm kiếm chưa có sẵn.</p>
            @endif
        @else
            <!-- <p>Chúng tôi rất lấy làm tiếc vì tài khoản của bạn hiện tại không đủ điều kiện để xem thông tin này. Vui lòng <a href="{{ sc_route('account_upgrade') }}" target="_blank">nâng cấp tài khoản</a> lên mức cao hơn để xem thông tìn này.</p> -->
            <p>Chúng tôi rất lấy làm tiếc vì hiện tại bạn chưa đủ điều kiện để xem thông tin này. Vui lòng <a href="{{ sc_route('login') }}">đăng nhập</a> hoặc <a href="{{ sc_route('account_upgrade') }}" target="_blank">nâng cấp tài khoản</a> lên mức cao hơn để xem thông tin này.</p>
        @endif

        {{--
        @if(auth()->check() && auth()->user()->checkViewXNK())
            @if($data)
                <div class="table-responsive">
                    <table class="table table-bordered mb-0 tablefilter">
                        <thead class="table-light align-middle">
                            <tr>
                                <th>Date</th>
                                <th>HS Code</th>
                                <th class="text-nowrap">Goods Description</th>
                                <th>Exporter</th>
                                <th>Exporter Address</th>
                                <th>Exporter Contact</th>
                                <th>Importer</th>
                                <th>Importer Address</th>
                                <th>Importer Contact</th>
                                <th>Origin Country</th>
                                <th>Destination Country</th>
                                <th>incoterms</th>
                                <th>Quantity</th>
                                <th>Quantity Unit</th>
                            </tr>
                        </thead>
                        <tbody class="align-middle">
                            @foreach($data as $index => $item)
                                @if($item['date'])
                                <tr>
                                    <td class="text-nowrap">{{ $item['date'] }}</td>
                                    <td>{{ $item['hs_code'] }}</td>
                                    <td>{{ $item['goods_description'] }}</td>
                                    <td>{{ $item['exporter'] }}</td>
                                    <td>{{ $item['exporter_address'] }}</td>
                                    <td>{{ $item['exporter_contact'] }}</td>
                                    <td>{{ $item['importer'] }}</td>
                                    <td>{{ $item['importer_address'] }}</td>
                                    <td class="text-nowrap">{{ $item['importer_contact'] }}</td>
                                    <td>{{ $item['origin_country'] }}</td>
                                    <td>{{ $item['destination_country'] }}</td>
                                    <td>{{ $item['incoterms'] }}</td>
                                    <td>{{ $item['quantity'] }}</td>
                                    <td>{{ $item['quantity_unit'] }}</td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p>Rất tiếc, thông tin bạn tìm kiếm chưa có sẵn.</p>
            @endif
        @else
            <!-- <p>Chúng tôi rất lấy làm tiếc vì tài khoản của bạn hiện tại không đủ điều kiện để xem thông tin này. Vui lòng <a href="{{ sc_route('account_upgrade') }}" target="_blank">nâng cấp tài khoản</a> lên mức cao hơn để xem thông tìn này.</p> -->
            <p>Chúng tôi rất lấy làm tiếc vì hiện tại bạn chưa đủ điều kiện để xem thông tin này. Vui lòng <a href="{{ sc_route('login') }}">đăng nhập</a> hoặc <a href="{{ sc_route('account_upgrade') }}" target="_blank">nâng cấp tài khoản</a> lên mức cao hơn để xem thông tin này.</p>
        @endif
        --}}
    </div>
@endsection


@push('styles')
    <style>
        .table_arrow {
            position: absolute;
            top: 14%;
            left: -30px;
            font-size: 30px;
            cursor: pointer;
        }
        .table_arrow:hover{
            color: #f00;
        }
        .table_arrow.table_arrow_right {
            left: unset;
            right: -30px;
        }
        @media(max-width: 767px)
        {
            .table_arrow {
                display: none;
            }
        }
    </style>    
@endpush
@push('scripts')
    <script>
        jQuery(document).ready(function($) {
            $(document).on('click', '.page-link-ajax', function(){
                $('.page-link-ajax').removeClass('active');
                $(this).addClass('active');
                var this_href = $(this).prop('href');
                axios({
                    method: 'get',
                    url: $(this).prop('href'),
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                    },
                }).then(res => {
                    if(res.data.html != '')
                    {
                        $('.html-content').html(res.data.html);
                        window.history.pushState('', '', this_href);
                        buttonTable();
                        if($('.tablefilter').length)
                        {
                            $('.tablefilter').DataTable({
                             'aoColumnDefs': [{
                                 'bSortable': false,
                                 'aTargets': ['action', 'nosort']
                             }],
                             "order": [], 
                             "aaSorting": [], 
                             'searching': false, 
                             'lengthChange': false, 
                             "paging": false, 
                             "info": false, 
                             "decimal": ",", 
                             "thousands": ".",
                            });
                        }
                    }
                })
                .catch(function (error) {
                    if (error.response) {
                      if(error.response.status == 419)
                        location.reload();
                    } 
                });
                return false;
            })
            buttonTable();
            function buttonTable() {
                var table_xnk = $('.table-xnk');
                if(table_xnk.length)
                {
                  var table = table_xnk.find('.table');
                  if(table.width() > 1200)
                  {
                    // console.log(table_xnk.width());
                    table_xnk.parent().append('<span class="table_arrow table_arrow_left"><i class="bi bi-chevron-left"></i></span><span class="table_arrow table_arrow_right"><i class="bi bi-chevron-right"></i></span>');
                  }
                }
            }
            var scroll_right = '+=300px',
                scroll_left = '-=300px',
                table = $('.table-xnk').find('.table');
            $(document).on('click', ".table_arrow_right", function() {
                event.preventDefault();
                var elem = $(this).parent().find(".table-responsive");
                
                if(scroll_right != '')
                {
                  $(this).parent().find(".table-responsive").animate({
                    scrollLeft: scroll_right
                  },"slow");
                }
                if(elem.scrollLeft() + elem.width() >= table.width()) {
                     scroll_right = '';
                }
                else
                {
                  scroll_right = '+=300px';
                }
              });

              $(document).on('click', ".table_arrow_left", function() {
                event.preventDefault();

                var elem = $(this).parent().find(".table-responsive");
                
                if(elem.scrollLeft() > 0) {
                  $(this).parent().find(".table-responsive").animate({
                    scrollLeft: scroll_left
                  },"slow");
                }

            });

            
        });
    </script>   
@endpush