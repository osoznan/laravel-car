<?php

namespace App\Components;

class AppHelper {
    const ALLOWED_URL_PARAMS = ['engine', 'axe'];

    public static $settings;

    public static function settings() {
        if (!static::$settings) {
            static::$settings = new \stdClass();
            static::$settings->engineTypes = config('user.engine_types');
            static::$settings->mainAxes = config('user.main_axes');
        }

        return static::$settings;
    }

    public static function getEngineTypes() {
        return static::settings()->engineTypes;
    }

    public static function getMainAxes() {
        return static::settings()->mainAxes;
    }

    /**
     * Считывает урл-параметре типа name=value1,value2, определяет name, а также ключи для значений valueN
     *
     * @param $paramString string Строка урл параметра
     * @param $paramNameList array Массив списков названий параметров, список - для каждого параметра
     * @return array|bool
     */
    public static function getFriendlyUrlParams($paramString, array $paramNameList) {
        $paramArr1 = explode('=', $paramString);
        $valueArr = explode(',', $paramArr1[1]);

        if (!array_key_exists($paramArr1[0], $paramNameList)) {
            return false;
        }

        $values = [];
        foreach ($valueArr as $item) {
            if (($key = array_search($item, $paramNameList[$paramArr1[0]])) !== false) {
                $values[] = $key;
            }
        }

        return [
            'name' => $paramArr1[0],
            'names' => $valueArr,
            'values' => $values
        ];
    }

    /**
     * Обработка параметров двигателя и привода, если оные закинуты
     *
     * @param $params array Дружественные урл параметры вида /param=value1,value2
     * @param $paramValues array Массив списков названий параметров, список - для каждого параметра
     * @return mixed array
     */
    public static function friendlyUrlParamsToDbParams($params, $paramValues) {
        $result = [];

        if (count($params)) {
            foreach ($params as $param) {
                if ($param) {
                    // получение ключей для строковых значений параметра
                    $paramInfo = AppHelper::getFriendlyUrlParams($param, $paramValues);

                    // неверный параметр отсекаем
                    if (!$paramInfo) {
                        break;
                    }

                    $result[$paramInfo['name']] = $paramInfo;
                }
            }
        }

        return $result;
    }

    public static function isUrlParamString($s){
        return strpos($s, '=');
    }

}
