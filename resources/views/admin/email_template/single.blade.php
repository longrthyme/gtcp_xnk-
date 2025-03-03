@extends('admin.layouts.index')
    @php
        if(isset($data)){
            $data = $data->toArray();
            extract($data);
        }
    @endphp
@section('seo')
    @include('admin.layouts.seo')
@endsection
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
<h6 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Dashboard /</span> {{ $title_head }}</h6>

<form action="{{route('admin.email_template.post')}}" method="POST" id="frm-create-post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{ $id ?? 0 }}">
    <div class="row">
        <div class="col-9">
            <div class="card">
                <div class="card-header">
                    <h4>{{$title_head}}</h4>
                </div> <!-- /.card-header -->
                <div class="card-body">
                    <!-- show error form -->
                    @if(Session::has('error'))
                    <div class="errorTxt">{{ Session::get('error') }}</div>
                    @endif
                    <div class="errorTxt"></div>
                    <div class="form-group mb-3">
                        <select class="form-control group select2" style="width: 100%;" name="group" >
                            <option value="">Chọn group</option>
                            @foreach ($arrayGroup as $k => $v)
                                <option value="{{ $k }}" {{ isset($group) && $group ==$k ? 'selected':'' }}>{{ $v }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="subject">Subject email</label>
                        <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject" value="{{ $subject ?? '' }}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="price" class="title_txt">Nội dung</label>
                        <div class="input-group mb-3">
                            <textarea name="content" id="text">{!! isset($text) ? htmlspecialchars_decode($text) : '' !!}</textarea>
                        </div>
                    </div>
                    
                </div> <!-- /.card-body -->
            </div><!-- /.card -->
        </div> <!-- /.col-9 -->
        <div class="col-3">
            @include('admin.partials.action_button')
            
        </div> <!-- /.col-9 -->
    </div> <!-- /.row -->
</form>
</div></div></div></section>
@endsection

@push('styles')
<!-- Create a simple CodeMirror instance -->
<link rel="stylesheet" href="{{ asset('assets/mirror/lib/codemirror.css')}}">
    <style type="text/css">
        .select2-container .select2-selection--single{
            height: auto;
        }
    </style>
@endpush
@push('scripts')


<!-- <script src="{{ asset('assets/mirror/lib/codemirror.js')}}"></script> -->
<script src="{{ asset('assets/mirror/mode/javascript/javascript.js')}}"></script>
<script src="{{ asset('assets/mirror/mode/css/css.js')}}"></script>
<!-- <script src="{{ asset('assets/mirror/mode/htmlmixed/htmlmixed.js')}}"></script> -->

<script>
    editor('content');
</script>
@endpush