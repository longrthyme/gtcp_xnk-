@php
    $options = \App\Model\Variable::where('parent', 0)->get();
    $category_variable = $category_variable ?? [];
@endphp
<div class="card widget-category">
    <div class="card-header">
        <h3 class="card-title">Thông tin bổ sung</h3>
    </div> <!-- /.card-header -->
    <div class="card-body">
        @if(count($options)>0)
            @foreach($options as $item)
                <div class="form-check">
                    <label class="form-check-label item-parent">
                        <input type="checkbox" id="variable_id" name="variable_id[]" value="{{$item->id}}" title="{{$item->title}}" 
                        {{ in_array($item->id, $category_variable)?'checked':'' }}
                        ><span> {{$item->name}}</span></label>
                    </div>
            @endforeach
        @endif
    </div> <!-- /.card-body -->
</div><!-- /.card -->