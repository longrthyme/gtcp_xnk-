@extends('layouts.app')
@section('seo')
<?php
$title='Liên hệ | '.Helpers::get_option_minhnn('seo-title-add');
$description='Liên hệ - '.Helpers::get_option_minhnn('seo-description-add');
$keyword='lien he,'.Helpers::get_option_minhnn('seo-keywords-add');
$thumb_img_seo=url('/images/').'/logo_1397577072.png';
$data_seo = array(
    'title' => $title,
    'keywords' => $keyword,
    'description' =>$description,
    'og_title' => $title,
    'og_description' => $description,
    'og_url' => Request::url(),
    'og_img' => $thumb_img_seo,
    'current_url' =>Request::url(),
    'current_url_amp' => ''
);
$seo = WebService::getSEO($data_seo);
?>
@include('partials.seo')
@endsection
@section('content')
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDJzht6hik8TH8cRa2itU3-n_hGO4Hv604"></script>
<script type="text/javascript">
var myCenter=new google.maps.LatLng({!!Helpers::get_option_minhnn('lat')!!},{!!Helpers::get_option_minhnn('long')!!});
var myMarker=new google.maps.LatLng({!!Helpers::get_option_minhnn('lat')!!},{!!Helpers::get_option_minhnn('long')!!});
var marker;
function initialize()
{
  var mapProp = {center:myCenter,
  zoom:16,
  mapTypeId:google.maps.MapTypeId.ROADMAP
  };
  var map=new google.maps.Map(document.getElementById("map_canvas"),mapProp);
  marker=new google.maps.Marker({
  	position:myMarker,animation:google.maps.Animation.BOUNCE
  });
  marker.setMap(map);
  var infowindow = new google.maps.InfoWindow({
	  content:'<h3 style="text-align: center"><img alt="<?php echo Helpers::get_option_minhnn('name-company');?>" width="150" src="{{Helpers::get_option_minhnn('logo')}}"/></h3><h3><?php echo Helpers::get_option_minhnn('name-company');?></h3><p><b> Địa chỉ: </b><?php echo Helpers::get_option_minhnn('addrees');?><b></p><p>Email:</b> <a href="mailto:<?php echo Helpers::get_option_minhnn('email');?>" rel="nofollow"><?php echo Helpers::get_option_minhnn('email');?></a></p><p><b>Điện thoại: </b><?php echo Helpers::get_option_minhnn('hotline');?></p>'
   });
   infowindow.open(map,marker);
}
google.maps.event.addDomListener(window, "load", initialize);
</script>

    <div class="heading-container">
        <div class="container heading-standar">
            <div class="page-breadcrumb">
                <ul class="breadcrumb">
                    <li><span><a href="{{ url('/') }}" class="home"><span>Trang chủ</span></a></span></li>
                    <li><span>@lang('Liên hệ')</span></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="content-container">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 map-wrapper clear">
                    <div id="map_canvas"></div>
                </div><!--map-wrapper-->
                <div class="col-lg-6 tuvan-content">
                    <h4 class="custom_heading">ĐỂ LẠI THÔNG TIN LIÊN HỆ CỦA QUÝ KHÁCH</h4>
                    @include('page.includes.contact')
                </div>
                <div class="col-lg-6">
                    {!!setting_option('info-footer-address')!!}
                </div>
            </div>
        </div>
    </div>

@endsection