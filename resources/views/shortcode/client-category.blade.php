@php
    $posts = (new \App\Client)->setCategory($id)->getList([
        'limit' => $limit
    ]);
@endphp
<section class="client-category">
    <div class="container py-5">
        <div class="row justify-content-center">
            @foreach($posts as $post)
            <div class="col-6 col-md-6 col-lg-4">
                <div class="client-category-item p-3 shadow rounded-2">
                    <img src="{{ asset($post->image) }}" alt="" width="50px">
                    <h6 class="title fw-bold mt-3">{{ $post->name }}</h6>
                    <div class="client-desc">
                        {!! htmlspecialchars_decode( $post->description ) !!}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>