<div class="card">
    <div class="card-body">
        <h5>Nổi bật</h5>
        <label for="hot">
            <input type="checkbox" class="category_item_input" name="hot" value="1" id="hot" {{ isset($hot) && $hot==1?'checked':'' }} />
            Tin nổi bật
        </label>
    </div> <!-- /.card-body -->
</div><!-- /.card -->