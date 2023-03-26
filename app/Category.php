<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "category";
    protected $guarded = ['id'];
    public $timestamps = false;
    public function product()
    {
        return $this->hasMany(Product::class, 'kategori', 'id');
    }
    public function sub_category()
    {
        return $this->hasMany(SubCategory::class, "id_category", "id");
    }
    public function sub_sub_category()
    {
        return $this->hasMany(SubSubCategory::class, "id_category", "id");
    }
}
