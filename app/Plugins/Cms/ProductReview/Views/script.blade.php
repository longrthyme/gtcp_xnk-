@php
    $points = (new App\Plugins\Cms\ProductReview\Models\PluginModel)->getPointProduct($product->id);
    $pathPlugin = (new App\Plugins\Cms\ProductReview\AppConfig)->pathPlugin;
@endphp
<script>
    jQuery(document).ready(function($) {
        $('#button-review').click(function(){
           $('#form-review').submit();
        });

        $('.r-remove').click(function(){
           var cf = confirm('{{ trans($pathPlugin.'::lang.confirm_remove') }}');
           if (cf) {
              var id = $(this).data('id');
              $.ajax({
                 url: '{{ route('product_review.removeReview') }}',
                 type: 'POST',
                 dataType: 'json',
                 data: {
                     _token: "{{ csrf_token() }}",
                     'id': id,
                 },
             })
             .done(function(result) {
                 if(result.error == 0) {
                    location.reload();
                 } else {
                    //
                 }
             })
             .fail(function() {
                 console.log("error");
             })
          }
        
        });
    });
</script>