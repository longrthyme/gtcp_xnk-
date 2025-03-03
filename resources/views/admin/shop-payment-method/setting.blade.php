@php
    $spec = $setting ?? '';
    if($spec != ''){
        //$spec = json_decode($spec, true);
        end($spec);         // move the internal pointer to the end of the array
        $key_index = 1;
    }
@endphp
<div class="spec">
    <div class="row mb-2">
        <div class="col-3 border-bottom pb-1 font-weight-bold">{{ sc_language_quickly('admin.admin_custom_config.add_new_detail', 'Key detail') }}</div>
        <div class="col-3 border-bottom pb-1 font-weight-bold">{{ sc_language_quickly('admin.admin_custom_config.add_new_detail', 'Key') }}</div>
        <div class="col-4 border-bottom pb-1 font-weight-bold">{{ sc_language_quickly('admin.admin_custom_config.add_new_detail', 'Value') }}</div>
        <div class="col-2 border-bottom pb-1 font-weight-bold"></div>
    </div>
    <div class="spec-short-clone" data="{{ $key_index ?? 0 }}" style="display: none;">
        <div class="form-group row group-item">
            <div class="col-3">
                <input type="text" class="form-control spec-short-name" name="">
            </div>
            <div class="col-3">
                <input type="text" class="form-control spec-short-key" name="">
            </div>
            <div class="col-4">
                <!-- <input type="text" class="form-control spec-short-desc" name=""> -->
                <textarea name="" class="form-control spec-short-desc"></textarea>
            </div>
            <div class="col-2">
                <button type="button" class="btn btn-danger w-100 text-center">Xóa</button>
            </div>
        </div>
    </div>
    <div class="spec-short-group">
        @if($spec != '' && is_array($spec))
            @foreach($spec as $index => $item)
                <div class="form-group row group-item">
                    <div class="col-3">
                        <input type="text" class="form-control spec-short-name" name="spec_short[{{ $index }}][name]" value="{{ $item['name'] ?? '' }}">
                    </div>
                    <div class="col-3">
                        <input type="text" disabled class="form-control spec-short-key" name="spec_short[{{ $index }}][key]" value="{{ $item['key'] ?? '' }}">
                    </div>
                    <div class="col-4">
                        <!-- <input type="text" class="form-control spec-short-desc" name="spec_short[{{ $index }}][value]" value="{{ $item['value'] ?? '' }}"> -->
                        <textarea name="spec_short[{{ $index }}][value]" class="form-control spec-short-desc">{{ $item['value'] ?? '' }}</textarea>
                    </div>
                    <div class="col-2">
                        <button type="button" class="btn btn-danger w-100 text-center" onclick="deleteKey('{{ $item['key'] }}');">Xóa</button>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
    <div class="spec-btn text-right">
        <button type="button" class="btn btn-primary spec-short-add">Thêm trường</button>
    </div>
</div>


@push('scripts')
<script>
    function deleteKey(key){
        Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-success',
              cancelButton: 'btn btn-danger'
            },
            buttonsStyling: true,
          }).fire({
            title: '{{ sc_language_render('action.delete_confirm') }}',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: '{{ sc_language_render('action.confirm_yes') }}',
            confirmButtonColor: "#c82333",
            cancelButtonText: '{{ sc_language_render('action.confirm_no') }}',
            reverseButtons: true,

            preConfirm: function() {
                return new Promise(function(resolve) {
                    $.ajax({
                        method: 'post',
                        url: '{{ sc_route_admin('admin_payment_method.setting_delete') }}',
                        data: {
                          key:key,
                            _token: '{{ csrf_token() }}',
                        },
                        success: function (data) {
                            if(data.error == 1){
                              alertMsg('error', data.msg, '{{ sc_language_render('action.warning') }}');
                              $.pjax.reload('#pjax-container');
                              return;
                            }else{
                              alertMsg('success', data.msg);
                              location.reload();
                            }

                        }
                    });
                });
            }

          }).then((result) => {
            if (result.value) {
              alertMsg('success', '{{ sc_language_render('action.delete_confirm_deleted_msg') }}', '{{ sc_language_render('action.delete_confirm_deleted') }}');
            } else if (
              // Read more about handling dismissals
              result.dismiss === Swal.DismissReason.cancel
            ) {
              // swalWithBootstrapButtons.fire(
              //   'Cancelled',
              //   'Your imaginary file is safe :)',
              //   'error'
              // )
            }
        })
    }


    jQuery(document).ready(function($) {
        /*====================
    thong so ky thuat
    ====================*/
    
    var spec = $('.spec');
    if(spec.length > 0){
        $('.spec-short-add').click(function(){
            var id = spec.find('.spec-short-clone').attr('data');
            id = parseInt(id) + 1;
            spec.find('.spec-short-clone').attr('data', id);
            
            var html = spec.find('.spec-short-clone').find('.group-item').clone();
            html.find('input.spec-short-name').attr('name', 'spec_short[' + id + '][name]');
            html.find('input.spec-short-key').attr('name', 'spec_short[' + id + '][key]');
            html.find('textarea.spec-short-desc').attr('name', 'spec_short[' + id + '][value]');
            spec.find('.spec-short-group').append(html);
        });
    }

    /*====================
    end thong so ky thuat
    ====================*/
    });
</script>
@endpush