<?php

namespace App\Http\Controllers;

use App\Components\AppHelper;
use App\Components\CarTable;
use App\Components\CatalogManager;
use App\Models\AutoModel;
use App\Models\Brand;
use Illuminate\Support\Facades\Request;

class SiteController extends Controller
{

    public function catalog(...$params) {
        $brand = $model = $param1 = $param2 = null;
        $properties = [null, null];

        // Выясняем с урл: определяем бренд (если есть), модель (если есть), параметры (если есть, и с какой позиции)
        if (isset($params[0])) {
            if (!AppHelper::isUrlParamString($params[0])) {
                $brand = $params[0];
                if (isset($params[1])) {
                    if (!AppHelper::isUrlParamString($params[1])) {
                        $model = $params[1];
                        $properties = [$params[2] ?? null, $params[3] ?? null];
                    } else {
                        $properties = [$params[1], $params[2] ?? null];
                    }
                }
            } else {
                $properties = [$params[0], $params[1] ?? null];
            }
        }

        // получение всех данных согласно базовым параметрам: марка, модель, двигатель + привод
        $result = CatalogManager::process($brand, $model, $properties);

        abort_if(isset($result['error']), 404, $result['error'] ?? '');

        // если бренд выбран, то доступны к выбору модели только этого бренда
        if ($brand) {
            $brandRec = Brand::where(['name' => $brand])->get();
            $autoModels = AutoModel::getFull()
                ->where(['brand_id' => $brandRec[0]->id])->get();
        }

        if (!Request::ajax()) {
            return view('catalog', [
                'brands' => Brand::all(),
                'models' => $autoModels ?? AutoModel::getFull()->get(),
                'engineTypes' => AppHelper::getEngineTypes(),
                'mainAxes' => AppHelper::getMainAxes(),

                'cars' => $result['data']->paginate(10),

                'params' => ['brand' => $brand, 'model' => $model] + $result['props'],
            ]);
        }

        return CarTable::widget([
            'data' => $result['data']->paginate(10)
        ]);
    }

}
