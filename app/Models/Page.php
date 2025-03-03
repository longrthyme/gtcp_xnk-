<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\PageDescription;

class Page extends Model
{
    protected $table = 'page';
    protected $guarded     = [];

    public static function search(string $keyword){
        $keyword = '%' . addslashes($keyword) . '%';
        $result = self::select('id', 'title', 'slug', 'description')
            ->where('title', 'like', $keyword)
            ->orWhere('parent', 'like', $keyword)
            ->get();
        return $result;
    }

    public function descriptions()
    {
        return $this->hasMany(PageDescription::class, 'post_id', 'id');
    }

    public function getUrl()
    {
        return sc_route('post.single', ['slug' => $this->slug]);
    }

    //Function get text description
    public function getText()
    {
        return $this->descriptions()->where('lang', sc_get_locale())->first();
    }

    public function getSeoTitleAttribute($value)
    {
        if(empty($value) || $value === null)
        {
            return $this->name;
        }
        return $value;
    }

    public function getListData()
    {
        $tableDescription = (new PageDescription)->getTable();
        $tableProduct     = (new Page)->getTable();

        //Select field
        $dataSelect = $tableProduct.'.*, '.$tableDescription.'.name, '.$tableDescription.'.description, '.$tableDescription.'.content';

        $productList = (new Page)
            ->selectRaw($dataSelect)
            ->leftJoin($tableDescription, $tableDescription . '.post_id', $tableProduct . '.id')
            ->where($tableDescription . '.lang', app()->getLocale());

        return $productList;
    }

    public function getList(array $dataSearch)
    {
        $keyword          = $dataSearch['keyword'] ?? '';
        $sort_order       = $dataSearch['sort_order'] ?? '';
        $arrSort          = $dataSearch['arrSort'] ?? '';
        $limit          = $dataSearch['limit'] ?? 0;
        $getAllActive          = $dataSearch['getAllActive'] ?? 0; //get all active

        $tableDescription = (new PageDescription)->getTable();
        $tableProduct     = (new Page)->getTable();

        $productList = $this->getListData();

        if ($keyword) {
            $productList = $productList->where(function ($sql) use ($tableDescription, $tableProduct, $keyword) {
                $sql->where($tableDescription . '.name', 'like', '%' . $keyword . '%');
            });
        }
        $productList->groupBy($tableProduct.'.id');

        if ($sort_order && array_key_exists($sort_order, $arrSort)) {
            $field = explode('__', $sort_order)[0];
            $sort_field = explode('__', $sort_order)[1];
            $productList = $productList->orderBy($field, $sort_field);
        } else {
            $productList = $productList->orderBy($tableProduct.'.created_at', 'desc');
        }
        if($limit)
            $productList = $productList->limit($limit)->get();
        elseif($getAllActive)
            $productList = $productList->get();
        else
            $productList = $productList->paginate(20);

        return $productList;
    }

    public function getDetail($key = null, $type = null, $checkActive = 1)
    {
        if (empty($key)) {
            return null;
        }
        
        $tableDescription = (new PageDescription)->getTable();

        $dataSelect = $this->getTable().'.*, '.$tableDescription.'.*';

        $post = $this->leftJoin($tableDescription, $tableDescription . '.post_id', $this->getTable() . '.id');
        
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

    protected static function boot()
    {
        parent::boot();
        // before delete() method call this
        static::deleting(
            function ($page) {
                $page->descriptions()->delete();
            }
        );
    }
}
