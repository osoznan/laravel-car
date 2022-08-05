<?php

namespace App\Console\Commands;

use App\Components\AppHelper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GenerateDb extends Command
{
    protected $signature = 'generate:db';

    protected $description = 'сгенерировать базу данных автомобилей';

    /**
     * Fills the db with "car records"
     *
     * @return int
     */
    public function handle() {
        DB::table('brand')->delete();

        $configData = config('user');

        $brands = [];

        foreach (array_keys($configData['models']) as $key => $brand) {
            $brands[] = [
                'id' => $key + 1,
                'name' => $brand,
            ];
        }

        DB::table('brand')
            ->insert($brands);

        $models = [];
        $count = 0;

        foreach ($brands as $brand) {
            foreach ($configData['models'][$brand['name']] as $model) {
                $count++;
                $models[] = [
                    'id' => $count,
                    'brand_id' => $brand['id'],
                    'name' => $model,
                ];
            }
        }

        DB::table('model')
            ->insert($models);

        $carData = [];

        foreach ($models as $model) {
            $carCount = random_int($configData['minCarCountForModel'], $configData['maxCarCountForModel']);

            for ($i = 0; $i < $carCount; $i++) {
                $carData[] = [
                    'model_id' => $model['id'],
                    'engine_type' => random_int(0, count(AppHelper::getEngineTypes()) - 1),
                    'main_axe' => random_int(0, count(AppHelper::getMainAxes()) - 1),
                ];
            }
        }

        DB::table('car')
            ->insert($carData);

        return 0;
    }
}
