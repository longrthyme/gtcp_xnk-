{{-- review --}}
@php
    $points = (new App\Plugins\Cms\ProductReview\Models\PluginModel)->getPointProduct($product->id);
    //dd($points);
    $pathPlugin = (new App\Plugins\Cms\ProductReview\AppConfig)->pathPlugin;

    $star_5 = 0;
    $star_4 = 0;
    $star_3 = 0;
    $star_2 = 0;
    $star_1 = 0;
    if($points->count()){
        $round_star = round($points->sum('point')/$points->count(), 2); //làm tròn số sao
        foreach($points as $point){
            if($point->point == 5)
                $star_5++;
            elseif($point->point == 4)
                $star_4++;
            elseif($point->point == 3)
                $star_3++;
            elseif($point->point == 2)
                $star_2++;
            elseif($point->point == 1)
                $star_1++;
        }
    }

@endphp
<section class="mt-3 section-sm bg-default">
    <div  id="review">
        <div class="rate_thongke mb-3 p-3">
            <div class="row">
                <div class="col-lg-6 col-5 d-flex align-items-center justify-content-center">
                    <div class="thongke_star text-center">
                        <div class="rate_diem">{{ $round_star ?? 0 }} <i class="fa fa-star"></i></div>
                        @if($points->count())
                        <div class="">Có {{ $points->count() }} đánh giá</div>
                        @else
                        <div class="">Chưa có đánh giá</div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6 col-7">
                    <div class="thongke_star_detail text-center">
                        <ul>
                            <li>
                                <span class="tk_star">5 <i class="fa fa-star"></i></span>
                                <div class="tk_progress">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: {{ $points->count() ? $star_5 * 100 / $points->count() : 0 }}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="0"></div>
                                    </div>
                                </div>
                                <span class="tk_num">{{ $star_5 }}</span>
                            </li>

                            <li>
                                <span class="tk_star">4 <i class="fa fa-star"></i></span>
                                <div class="tk_progress">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width:  {{ $points->count() ? $star_4 * 100 / $points->count() : 0 }}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="0"></div>
                                    </div>
                                </div>
                                <span class="tk_num">{{ $star_4 }}</span>
                            </li>
                            <li>
                                <span class="tk_star">3 <i class="fa fa-star"></i></span>
                                <div class="tk_progress">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width:  {{ $points->count() ? $star_3 * 100 / $points->count() : 0 }}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="0"></div>
                                    </div>
                                </div>
                                <span class="tk_num">{{ $star_3 }}</span>
                            </li>
                            <li>
                                <span class="tk_star">2 <i class="fa fa-star"></i></span>
                                <div class="tk_progress">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width:  {{ $points->count() ? $star_2 * 100 / $points->count() : 0 }}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="0"></div>
                                    </div>
                                </div>
                                <span class="tk_num">{{ $star_2 }}</span>
                            </li>
                            <li>
                                <span class="tk_star">1 <i class="fa fa-star"></i></span>
                                <div class="tk_progress">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width:  {{ $points->count() ? $star_1 * 100 / $points->count() : 0 }}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="0"></div>
                                    </div>
                                </div>
                                <span class="tk_num">{{ $star_1 }}</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-12">
                    <hr>
                    <div id="review-detail" class="mb-3">
                        @if ($points->count())
                            @foreach ($points as $k => $point)
                                @if($k < 3)
                                <div class="review-detail" >
                                    <div class="r-name">
                                        <b>{{ $point->name }}</b> 
                                        <div class="review-star">
                                            @for ($i = 1;  $i <= $point->point; $i++)
                                                <i class="fa fa-star voted" aria-hidden="true"></i>
                                            @endfor
                                            @for ($k = 1;  $k <= (5- $point->point); $k++)
                                                <i class="fa fa-star-o" aria-hidden="true"></i>
                                            @endfor
                                        </div>
                                        @if (auth()->user() && $point->customer_id == auth()->user()->id)
                                        <span class="r-remove text-danger text-right btn"  data-id="{{ $point->id }}"><i class="fa fa-trash-o" aria-hidden="true"></i></span>
                                        @endif
                                    </div>

                                    @if($point->picture)
                                    @php
                                        $picture_cmt = json_decode($point->picture, true);
                                    @endphp
                                    <div class="list_rate_pic">
                                        <div id="aniimated-thumbnials">
                                            @foreach( $picture_cmt as $pic)
                                            <a href="{{ asset($pic) }}">
                                            <img src="{{ asset($pic) }}" with="65" alt=""></a>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif

                                    <div class="r-comment">{!! sc_html_render($point->comment) !!}</div>

                                    {{--<div class="r-date">{{ $point->created_at ?? date('d/m/Y H:i', $point->rate_date) }}</div>--}}
                                    @php
                                    $replies = (new App\Plugins\Cms\ProductReview\Models\PluginModel)->getReply($point->id);
                                    @endphp
                                    @if($replies->count())
                                        <span class="icon-replies-count"><i class="fa fa-comment-o" aria-hidden="true"></i> {{ $replies->count() }} phản hồi</span>
                                        @foreach($replies as $reply)
                                        <div class="box_reply">
                                            <div class="reply_item">
                                                <div class="list_rate_title"><span>CSKH </span> gửi vào lúc {{ $reply->created_at ?? date('d/m/Y H:i', $reply->rate_date) }}</div>
                                                <div class="reply_content">
                                                    {!! sc_html_render($reply->comment) !!}
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    @endif
                                </div>
                                @endif
                            @endforeach
                        @else
                            <p> {{ trans($pathPlugin.'::lang.no_review') }}</p>
                        @endif
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="d-flex justify-content-center">
                        <div class="thongke_post_rate mr-2"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#reviewModal"><i class='bx bx-message-rounded-dots' ></i> Gửi đánh giá</button></div>
                        @if($points->count())
                        <div class="thongke_post_rate"><button type="button" class="btn btn-info" onclick="location.href='{{ route('shop.preview', $product->alias) }}'">Xem {{ $points->count() }} đánh giá</button></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @includeIf((new App\Plugins\Cms\ProductReview\AppConfig)->pathPlugin.'::form-review')

    </div>
</section>
{{-- //end review --}}

@push('scripts')
<script>
    jQuery(document).ready(function($) {
        $('.icon-replies-count').click(function(){
            if($(this).hasClass('active')){
                $(this).removeClass('active');
                $(this).parent().find('.box_reply').hide();
            }
            else{
                $(this).addClass('active');
                $(this).parent().find('.box_reply').show();
            }
        });
    });
</script>
@endpush
