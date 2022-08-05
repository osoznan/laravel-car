<?php

namespace App\Components;

class CarTable extends Widget {

    public $data;

    public function run() {
        echo view('widgets.carTable', [
           'data' => $this->data
        ]);
    }

}
