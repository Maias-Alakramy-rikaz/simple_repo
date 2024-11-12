<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use CrudTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'min_quan',
        'price',
        'activated',
        'group_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'activated' => 'boolean',
        'group_id' => 'integer',
    ];

    public function productImages(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function exports(): HasMany
    {
        return $this->hasMany(Export::class);
    }

    public function imports(): HasMany
    {
        return $this->hasMany(Import::class);
    }
    
    public function updateCurrentQuantity($is_export,$quantity){
        if($is_export)
            $this->current_quantity = $this->current_quantity - $quantity;
        else
            $this->current_quantity = $this->current_quantity + $quantity;

        $this->save();
    }
}
