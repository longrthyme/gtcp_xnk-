@php
  $text = $text??setting_option('company_name');
  $url_current = url()->current();
@endphp
<div class="social-icon d-flex align-items-center">
  <span class="me-2">Chia sẻ:</span>
  <div class="share-box">
    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $url_current }}&amp;t={{ $text }}" target="_blank"> <i class="fab fa-facebook-f"></i> </a>
    <a target="_blank" href="http://twitter.com/share?text=text goes here&url={{ $url_current }}"><i class="fab fa-twitter"></i></a>
    <a target="_blank" href="https://www.instagram.com/?url={{ $url_current }}"><i class="fab fa-instagram"></i></a>
    <a href="whatsapp://send?text={{ $url_current }}" data-action="share/whatsapp/share"><i class="fab fa-whatsapp"></i></a>
  </div>
</div>