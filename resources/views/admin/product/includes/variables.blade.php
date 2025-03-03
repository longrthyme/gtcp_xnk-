@if(count($data)>0)
    @foreach($data as $item)
        <div class="card widget-category">
            <div class="card-header">
                <div>{{ $item->name }}</div>
            </div> <!-- /.card-header -->
            <div class="card-body">
                @if(count($item->get_child)>0)
                    @php
                        $childs = (new \App\Model\Variable)->getListAdmin(['parent' => $item->id]);
                    @endphp
                    @include('admin.product.includes.variable-item', [
                        'data' => $childs,
                        'type' => $item->type,
                        'id_selected' => $id_selected,
                        'variables_join' => $variables_join ?? ''
                    ])
                @endif
            </div> <!-- /.card-body -->
        </div><!-- /.card -->
    @endforeach
@endif