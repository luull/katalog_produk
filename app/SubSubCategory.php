<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubSubCategory extends Model
{
    protected $table = "sub_sub_category";
    protected $guarded = ['id'];
    public $timestamps = false;
    public function product()
    {
        return $this->hasMany(Product::class, 'sub_sub_kategory', 'id');
    }
    public function sub_category()
    {
        return $this->belongsTo(SubCategory::class, "id_sub_category", "id");
    }
    public function category()
    {
        return $this->belongsTo(Category::class, "id_category", "id");
    }
}
