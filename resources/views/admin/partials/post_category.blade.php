<div class="card">
   <div class="card-body">
      <h5>Thể loại tin</h5>
      @php
      $listCate = [];
      $multiple = $multiple??'multiple';
      $input_name = 'category';
      if($multiple == 'multiple')
         $input_name = 'category[]';

      if(!empty($post))
      {
         $category = old('category', $post->categories->pluck('id')->toArray());
         if(is_array($category)){
             foreach($category as $value){
                 $listCate[] = $value;
             }
         }
      }
      @endphp
      <select class="form-control category select2" {{ $multiple }}
         data-placeholder="Chọn danh mục"
         name="{{ $input_name }}">
         <option value="">-----select-----</option>
         @foreach ($categories as $k => $v)
         <option value="{{ $k }}"
             {{ (count($listCate) && in_array($k, $listCate))?'selected':'' }}>{{ $v }}
         </option>
         @endforeach
       </select>
   </div> <!-- /.card-body -->
</div><!-- /.card -->