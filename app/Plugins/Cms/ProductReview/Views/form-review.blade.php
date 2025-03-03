@dd('fdfda')
<!-- Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Đánh giá {{ $product->name }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="form-review" method="POST" action="{{ sc_route('product_review.postReview') }}">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="form-group required {{ $errors->has('comment') ? ' has-error' : '' }}">
                       <div class="d-flex review-star" >
                            <label class="mr-3 mb-0">Chọn đánh giá của bạn: </label>
                            <div class="radio-group">
                                <div class="star-item">
                                    <input type="radio" {{ (old('point') == 1)?'checked':'' }} name="point" id="point1" value="1">
                                    <label for="point1"><i class='bx bxs-star' ></i></label>
                                </div>
                                <div class="star-item">
                                    <input type="radio" {{ (old('point') == 2)?'checked':'' }} name="point" id="point2" value="2">
                                    <label for="point2"><i class='bx bxs-star'></i></label>
                                </div>
                                <div class="star-item">
                                    <input type="radio" {{ (old('point') == 3)?'checked':'' }} name="point" id="point3" value="3">
                                    <label for="point3"><i class='bx bxs-star'></i></label>
                                </div>
                                <div class="star-item">
                                    <input type="radio" {{ (old('point') == 4)?'checked':'' }} name="point" id="point4" value="4">
                                    <label for="point4"><i class='bx bxs-star'></i></label>
                                </div>
                                <div class="star-item">
                                    <input type="radio" {{ (old('point') == 5)?'checked':'' }} name="point" id="point5" value="5">
                                    <label for="point5"><i class='bx bxs-star'></i></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-lg-12">
                            <div class="form-group required {{ $errors->has('comment') ? ' has-error' : '' }}">
                                <div class="count-comment" data="80"><span></span> (Tối thiểu 80 ký tự)</div>
                                <label class="control-label" for="input-review">{{ trans($pathPlugin.'::lang.your_review') }}</label>
                                <textarea name="comment" id="input-review" class="form-control" placeholder="Viết đánh giá của bạn" rows="5">{!! old('comment') !!}</textarea>
                                <div class="form-group">
                                    <div class="list_picture_rate">
                                        
                                    </div>

                                    <div class="up_picture_rate">
                                        <i class="fa fa-camera"></i>
                                        <label for="picture_rate">Đính kèm hình ảnh (tối đa 5 hình)</label>
                                        <input type="file" name="picture_rate[]" id="picture_rate" accept="image/*" multiple="">
                                    </div>

                                </div>
                                @if ($errors->has('comment'))
                                <span class="help-block">
                                  <i class="fa fa-info-circle" aria-hidden="true"></i> {{ $errors->first('comment') }}
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group required">
                                <input  type="text" name="name"  value="{{ auth()->user() ? auth()->user()->name : '' }}" id="input-name" class="form-control" placeholder="Nhập tên của bạn">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group required">
                                <input  type="text" name="phone"  value="{{ auth()->user() ? auth()->user()->phone : '' }}" id="input-phone" class="form-control" placeholder="Nhập SĐT của bạn">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group required">
                                <input  type="text" name="email"  value="{{ auth()->user() ? auth()->user()->email : '' }}" id="input-phone" class="form-control" placeholder="Email không bắt buộc">
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="form-group required {{ $errors->has('point') ? ' has-error' : '' }}">
                        

                        @if ($errors->has('point'))
                        <span class="help-block">
                            <i class="fa fa-info-circle" aria-hidden="true"></i> {{ $errors->first('point') }}
                        </span>
                        @endif
                    </div>
                    @if (sc_captcha_method() && in_array('review', sc_captcha_page()) && view()->exists(sc_captcha_method()->pathPlugin.'::render'))
                      @php
                         $titleButton = trans($pathPlugin.'::lang.submit');
                         $idForm = 'form-review';
                         $idButtonForm = 'button-review';
                      @endphp
                      @include(sc_captcha_method()->pathPlugin.'::render')
                    @endif
                    <div class="buttons clearfix">
                      <div class="pull-right">
                         <button type="button" id="button-review" data-loading-text="Loading..." class="btn btn-info">Gửi bình luận
                      </button>
                      </div>
                    </div>

                    <div class="list-content-loading">
                       <div class="half-circle-spinner">
                           <div class="circle circle-1"></div>
                           <div class="circle circle-2"></div>
                       </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>