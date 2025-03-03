@php
    $parent_id = $parent_id??0;

    $dategories = (new \App\Admin\Models\AdminShopCategory)->getCategoryListAdmin([
        'parent'     => $parent_id,
    ]);

@endphp

@if($dategories->count())
    @foreach($dategories as $data)
        <tr class="tr-item item-level-{{ isset($level) ? $level : 0 }}">
            <td class="text-center">
                <input type="checkbox" id="{{ $data->id }}" class="grid-row-checkbox" data-id="{{ $data->id }}">
            </td>

            
            <td class="title">
                <a class="row-title " href="{{route('admin_product.category_edit', array($data->id))}}">
                    <div><b>{{$data->name}}</b></div>
                </a>
                <div>URL: <a target='_blank' href="#">{{ $data->getUrl() }}</a></div>
            </td>
            <td class="text-center">
                @if($data->icon != '')
                    <img src="{{asset($data->icon)}}" style="height: 30px">
                @endif
            </td>
            <td class="text-center">
                @if($data->image != '')
                    <img src="{{asset($data->image)}}" style="height: 70px">
                @endif
            </td>
            <td class="text-center">
                <div>{{$data->created_at}}</div>
                @if($data->status == 1)
                    <span class="badge bg-label-primary">Public</span>
                @else
                    <span class="badge bg-label-dark">Draft</span>
                @endif
            </td>
        </tr>
        @if($data->children && $data->children()->count())
            @include('admin.product-category.includes.category_item', ['parent_id'=> $data->id, 'level'=>$level+1])
        @endif
    @endforeach
@endif