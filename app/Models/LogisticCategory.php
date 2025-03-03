<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogisticCategory extends Model
{
    protected $table = 'logistic_category';
    protected $guarded = [];

    public function getSeoTitleAttribute($value)
    {
        if($value =='' || $value === null)
            return $this->name;
        return $value;
    }

    public function descriptions()
    {
        return $this->hasMany(LogisticCategoryDescription::class, 'category_id', 'id');
    }

    //Function get text description
    public function getText()
    {
        return $this->descriptions()->where('lang', sc_get_locale())->first();
    }
    //Function get text description
    public function getCategory()
    {
        return $this->hasOne(LogisticCategory::class, 'id', 'parent');
    }
    
    public function news(){
        return $this->belongsToMany(Logistic::class, 'post_category_join', 'category_id', 'post_id');
    }
    
    public function getDetail($key = null, $type = null, $checkActive = 1)
    {
        if (empty($key)) {
            return null;
        }
        
        $tableDescription = (new \App\Models\LogisticCategoryDescription)->getTable();

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
}
