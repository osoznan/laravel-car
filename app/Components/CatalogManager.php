<?php

namespace App\Components;

use App\Models\AutoModel;
use App\Models\Car;
use Illuminate\Database\Query\Builder;

class CatalogManager {

    /**
     * Фильтрация табличных данных (и получение параметров двигателя и привода в удобном виде)
     *
     * @param $brand
     * @param $model
     * @param $properties
     * @return array
     */
    public static function process($brand, $model, $properties) {
        /** @var Builder $data */
        $data = Car::getFull();
        $propList = ['engineType' => null, 'mainAxe' => null];

        if ($brand) {
            $data = $data->where(['brand.name' => $brand]);
            if (!$data->count()) {
                return ['error' => 'Данный бренд авто не существует'];
            }
        }

        if ($model) {
            $data = $data->where(['model.name' => $model]);

            $modelRec = AutoModel::where(['name' => $model]);
            if (!$modelRec->get()->count()) {
                return ['error' => 'Данная модель авто не существует'];
            }
        }

        // обработка параметров двигателя и привода, если оные закинуты
        if (count($properties)) {
            $paramInfo = AppHelper::friendlyUrlParamsToDbParams($properties, [
                'engine' => AppHelper::getEngineTypes(),
                'axe' => AppHelper::getMainAxes()
            ]);

            foreach ($paramInfo as $info) {
                // фильтруем по двигателю и приводу
                if ($info['name'] == 'engine') {
                    $data = $data->whereIn('engine_type', $info['values']);
                    $propList['engineType'] = $info['names'];
                } elseif ($info['name'] == 'axe') {
                    $data = $data->whereIn('main_axe', $info['values']);
                    $propList['mainAxe'] = $info['names'];
                }
            }
        }

        return [
            'data' => $data,
            'props' => $propList,
        ];
    }

}
