<?php

namespace App\Components;

class CheckList extends Widget {

    public $title;
    public $name;
    public $selected;
    public $options;

    public function run() {
        echo "<div class='form-control mb-2' name=\"$this->name\">
            <label class='col-form-label'>$this->title</label>";

        foreach ($this->options as $key => $value) {
            echo "<div><input type=\"checkbox\" " . (in_array($value, $this->selected ?? []) ? 'checked' : '') . " class='col-form-control' id=\"$this->name-$key\"\" value=\"$value\"><label class='form-label ml-1' for=\"$this->name-$key\">$value</label></input></div>";
        }

        echo '</div>';
    }

}
