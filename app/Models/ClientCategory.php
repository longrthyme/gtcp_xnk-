<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientCategory extends Model
{
    public $timestamps = false;
    protected $table = 'client_categories';
    protected $guarded =[];

    protected static $getListTitleAdmin = null;
    protected static $getListCategoryGroupByParentAdmin = null;

    public function post()
    {
        return $this->belongsToMany(Client::class, 'client_category_join', 'category_id', 'post_id');
    }

    public function description()
    {
        return $this->hasMany(ClientCategoryDescription::class, 'category_id', 'id');
    }

    public function getDetail($key = null, $type = null, $checkActive = 1)
    {
        if (empty($key)) {
            return null;
        }
        
        $tableDescription = (new ClientCategoryDescription)->getTable();

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

    /**
     * Insert data description
     *
     * @param   array  $dataInsert  [$dataInsert description]
     *
     * @return  [type]              [return description]
     */
    public static function insertDescription(array $dataInsert)
    {
        return ClientCategoryDescription::create($dataInsert);
    }

    protected static function boot()
    {
        parent::boot();
        // before delete() method call this
        static::deleting(
            function ($post) {
                $post->description()->delete();
                $post->post()->detach();
            }
        );
    }
}
