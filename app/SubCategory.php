<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $table = "sub_category";
    protected $guarded = ['id'];
    public $timestamps = false;
    public function product()
    {
        return $this->hasMany(Product::class, 'sub_kategori', 'id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, "id_category", "id");
    }
    public function sub_sub_category()
    {
        return $this->hasMany(SubSubCategory::class, "id_sub_category", "id");
    }
}
