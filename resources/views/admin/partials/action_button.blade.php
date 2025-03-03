@php
    $status = $status ?? 1;
    $created_at = $created_at??date('Y-m-d H:i');
    $created_at = date('Y-m-d H:i', strtotime($created_at));
@endphp
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Publish</h5>

        <div class="form-group mb-3">
            <label>Ngày đăng:</label>
            <div class="input-group">
                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                <input type='text' class="form-control" name="created_at" id='created_at' value="{{ $created_at }}" />
            </div>
        </div>
        <div class="form-group d-flex justify-content-end text-end mb-3">
            <div class="form-check me-3">
                <input type="radio" id="radioDraft" name="status" class="form-check-input" value="0" {{ $status == 0 ? 'checked' : ''  }}>
                <label class="form-check-label" for="radioDraft"> Ẩn tin </label>
            </div>
            <div class="form-check">
                <input type="radio" id="radioPublic" name="status" class="form-check-input" value="1" {{ $status == 1 ? 'checked' : ''  }}>
                <label class="form-check-label" for="radioPublic"> Hiện tin </label>
            </div>
        </div>
        <div class="form-group text-end">
            <button type="submit" name="submit" value="save" class="btn btn-info">Lưu</button>
            <button type="submit" name="submit" value="apply" class="btn btn-success">Lưu và sửa</button>
        </div>
    </div> <!-- /.card-body -->
</div><!-- /.card -->
