<?php
/**
 * User: Zemlyansky Alexander <astrolog@online.ua>
 */

namespace App\Components;

class Widget {

    public function __construct($data = []) {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }

        $this->init();
    }

    public static function widget(array $config = []) {
        $class = static::class;
        $object = new $class($config);

        ob_start();
        $object->run();
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    public static function renderView($viewName, $params = []) {
        ob_start();
        ob_implicit_flush(false);

        foreach ($params as $param => $value) {
            $$param = $value;
        }

        require("$viewName.php");

        return ob_get_clean();
    }

    public function init() {}

}

