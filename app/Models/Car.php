<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Car extends Model {

    protected $fillable = [
        'model_id',
        'model_name',
        'brand_id',
        'brand_name',
        'engine_type',
        'main_axe'
    ];

    protected $table = 'car';

    public static function getFull() {
        return Car::select(DB::raw('car.*, model.id as model_id, model.name as model_name, brand.id as brand_id, brand.name as brand_name'))
            ->leftJoin('model', 'model.id', '=', 'model_id')
            ->leftJoin('brand', 'brand.id', '=', 'brand_id');
    }

}
