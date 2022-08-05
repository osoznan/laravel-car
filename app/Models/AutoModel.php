<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AutoModel extends Model
{

    protected $fillable = [
        'name',
        'brand_id',
        'brand_name',
    ];

    protected $table = 'model';

    public static function getFull() {
        return AutoModel::select(DB::raw('model.*, brand.name as brand_name'))
            ->leftJoin('brand', 'brand.id', '=', 'brand_id');
    }

}
