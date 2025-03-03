@php
	$level = $level??0;
@endphp
<tr class="tr-item item-level-{{ $level }}">
    <td class="text-center">
        <input type="checkbox" id="{{ $post->id }}" class="grid-row-checkbox" data-id="{{ $post->id }}">
    </td>
    <td class="title">
        <a href="{{ route('admin_video.edit', $post->id) }}" title=""><b>{{ $post->name }}</b></a>
    </td>
    <td class="text-center">
        @if($post->image)
        <img src="{{ asset($post->image) }}" width="80">
        @endif
    </td>
    <td class="text-center">
        <div>
            {{ $post->created_at }}
        </div>
        @if($post->status)
        <span class="badge bg-label-primary">Public</span>
        @else
        <span class="badge bg-label-dark">Draft</span>
        @endif
    </td>
    <td>
        <div>
            <span onclick="deleteItem('{{ $post->id }}');" title="{{ sc_language_render('action.delete') }}" class="btn btn-flat btn-sm btn-danger">
                <i class="fas fa-trash-alt"></i>
            </span>
        </div>  
    </td>
</tr>
@php
    $post_childs = (new \App\Models\ShopVideo)->getListAdmin([
        'parent'     => $post->id,
    ]);
@endphp
@if($post_childs->count())
	@foreach($post_childs as $item)
	    @include('admin.shop-video.video-item', ['post' => $item, 'level' => $level+1])
	@endforeach
@endif