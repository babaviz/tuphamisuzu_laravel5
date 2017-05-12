<?php

namespace App\Models\Product;

use App\Models\Product\Traits\Attribute\ProductAttribute;
use App\Models\Product\Traits\Relationship\ProductRelationship;
use App\Models\Product\Traits\Scope\ProductScope;
use Arcanedev\Support\Bases\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class User.
 */
class Product extends Model
{
    use
//        ProductScope,
//        Notifiable,
//        SoftDeletes,
        ProductAttribute;
//        ProductRelationship;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('product.products_table');
    }
}
