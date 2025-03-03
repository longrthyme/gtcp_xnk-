<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CallImport;

class PostCategory extends Model
{
    protected $table = 'post_category';
    protected $guarded = [];

    public function getSeoTitleAttribute($value)
    {
        if($value =='' || $value === null)
            return $this->name;
        return $value;
    }

    public function descriptions()
    {
        return $this->hasMany(PostCategoryDescription::class, 'category_id', 'id');
    }

    //Function get text description
    public function getText()
    {
        return $this->descriptions()->where('lang', sc_get_locale())->first();
    }

    /**
     * [getUrl description]
     * @return [type] [description]
     */
    public function getUrl($lang = null)
    {
        return sc_route('post.single', ['slug' => $this->slug]);
    }
    
    public function news(){
        return $this->belongsToMany('App\News', 'post_category_join', 'category_id', 'post_id');
    }

    public function getListData()
    {
        $tableDescription = (new PostCategoryDescription)->getTable();
        $tableCategory     = (new PostCategory)->getTable();

        $categoryList = (new PostCategory)
            ->leftJoin($tableDescription, $tableDescription . '.category_id', $tableCategory . '.id')
            ->where($tableDescription . '.lang', sc_get_locale());

        return $categoryList;
    }

    public function getList(array $dataSearch)
    {
        $keyword          = $dataSearch['keyword'] ?? '';
        $sort_order       = $dataSearch['sort_order'] ?? '';
        $arrSort          = $dataSearch['arrSort'] ?? '';
        $parent          = isset($dataSearch['parent']) ? $dataSearch['parent'] : '';
        $getAllActive          = $dataSearch['getAllActive'] ?? 0; //get all active

        $tableDescription = (new PostCategoryDescription)->getTable();
        $tableCategory     = (new PostCategory)->getTable();
        $categoryList = $this->getListData();
        
        if ($keyword) {
            $categoryList = $categoryList->where(function ($sql) use ($tableDescription, $keyword) {
                $sql->where($tableDescription . '.name', 'like', '%' . $keyword . '%');
            });
        }

        if($parent !== '')
        {
            $categoryList = $categoryList->where('parent', $parent);
        }

        if ($sort_order && array_key_exists($sort_order, $arrSort)) {
            $field = explode('__', $sort_order)[0];
            $sort_field = explode('__', $sort_order)[1];
            $categoryList = $categoryList->orderBy($field, $sort_field);
        } else {
            $categoryList = $categoryList->orderBy('created_at', 'desc');
        }
        $categoryList->groupBy($tableCategory.'.id');

        $categoryList = $categoryList->where('status', 1);
        $categoryList = $categoryList->paginate(20);

        return $categoryList;
    }
    
    public function getDetail($key = null, $type = null, $checkActive = 1)
    {
        if (empty($key)) {
            return null;
        }
        
        $tableDescription = (new \App\Models\PostCategoryDescription)->getTable();

        $dataSelect = $this->getTable().'.*, '.$tableDescription.'.*';

        $post = $this->leftJoin($tableDescription, $tableDescription . '.category_id', $this->getTable() . '.id');
        
        $post = $post->where($tableDescription . '.lang', sc_get_locale());

        if (empty($type)) {
            $post = $post->where($this->getTable().'.id', $key);
        } 
        elseif ($type == 'slug') {
            $post = $post->where($this->getTable().'.slug', $key);
        } 
        else {
            return null;
        }

        if ($checkActive) 
        {
            $post = $post->where($this->getTable() .'.status', 1);
        }
        $post = $post->selectRaw($dataSelect);

        $post = $post->first();
        return $post;
    }

    public function getContentExcelFile()
    {
        $file_name = $this->slug .'.xlsx';
        if(\File::exists(public_path('upload/files/'. $file_name)))
        {
            $array = Excel::toArray(new CallImport, public_path('upload/files/'. $file_name));
            return $array[0];
        }
        elseif($this->image)
        {
            $array = Excel::toArray(new CallImport, public_path($this->image));
            // dd($array[0]);
            return $array;
        }
        return;
    }
}
