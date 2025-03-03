@php
    $page = $modelPage->getDetail(143);
    $ses = (int)$page->slug * 1000;
@endphp
@if($page)
<div class="modal fade" id="popupModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                @if($page->description != '')
                <div class="popup-top">
                    {!! htmlspecialchars_decode($page->description) !!}
                </div>
                @endif
                <div class="popup-body">
                {!! htmlspecialchars_decode($page->content) !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@push('scripts')
    <script>
        jQuery(document).ready(function($) {
            setTimeout(function(){
                $('#popupModal').modal('show');
            }, {{ $ses }})
        });
    </script>
@endpush