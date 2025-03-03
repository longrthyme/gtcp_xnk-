<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    public $timestamps = false;
    protected $table = 'sliders';
    protected $guarded =[];

    public function description()
    {
        return $this->hasMany(SliderDescription::class, 'post_id', 'id');
    }

    public function getList(array $dataSearch)
    {
        $keyword          = $dataSearch['keyword'] ?? '';
        $sort_order       = $dataSearch['sort_order'] ?? '';
        $arrSort          = $dataSearch['arrSort'] ?? '';
        $limit          = $dataSearch['limit'] ?? 0;
        $parent          = $dataSearch['parent'] ?? 0;

        $tableDescription = (new SliderDescription)->getTable();
        $tableProduct     = (new Slider)->getTable();

        //Select field
        $dataSelect = $tableProduct.'.*, '.$tableDescription.'.name, '.$tableDescription.'.description, '.$tableDescription.'.content';

        $list = (new Slider)
            ->selectRaw($dataSelect)
            ->leftJoin($tableDescription, $tableDescription . '.post_id', $tableProduct . '.id');

        $list = $list->where($tableDescription . '.lang', app()->getLocale());


        if ($keyword) {
            $list = $list->where(function ($sql) use ($tableDescription, $tableProduct, $keyword) {
                $sql->where($tableDescription . '.name', 'like', '%' . $keyword . '%');
            });
        }

        if($parent)
        {
            $list = $list->where('slider_id', $parent);
        }

        $list->groupBy($tableProduct.'.id');

        if ($sort_order) {
            $field = explode('__', $sort_order)[0];
            $sort_field = explode('__', $sort_order)[1];
            $list = $list->orderBy($field, $sort_field);
        } else {
            $list = $list->orderBy($tableProduct.'.created_at', 'desc');
        }
        if($limit)
            $list = $list->limit($limit)->get();
        else
            $list = $list->paginate(20);

        return $list;
    }

    public function getDetail($key = null, $type = null)
    {
        if (empty($key)) {
            return null;
        }
        
        $tableDescription = (new SliderDescription)->getTable();

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

        $post = $post->selectRaw($dataSelect);

        $post = $post->first();
        return $post;
    }

    protected static function boot()
    {
        parent::boot();
        // before delete() method call this
        static::deleting(
            function ($slider) {
                $slider->description()->delete();
            }
        );
    }
}
