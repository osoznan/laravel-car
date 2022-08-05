<?php

namespace App\Components;

class Select extends Widget {

    public $title;
    public $name;
    public $selected;
    public $options;

    public function run() {
        echo "<div class='mb-2'>
            <label>$this->title</label>
            <select class='form-control' name=\"$this->name\">
                <option></option>";

        foreach ($this->options as $key => $value) {
            echo "<option value=\"{$value['name']}\" "
                . ($this->selected == $value['name'] ? 'selected ' : '')
                . ">{$value['name']}</option>";
        }

        echo '</select>
            </div>';
    }

}
