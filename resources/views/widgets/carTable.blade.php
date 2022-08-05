<?php

use App\Components\AppHelper;

/** @var $data */

?>

<table class="table">
    <thead>
    <tr>
        <th>#ID</th>
        <th>#Бренд</th>
        <th>#Модель</th>
        <th>#Тип двигателя</th>
        <th>#Привод</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($data) && $data->count()): ?>
    <?php foreach ($data as $key => $value): ?>
    <tr>
        <td><?= $value->id ?></td>
        <td><?= $value->brand_name ?></td>
        <td><?= $value->model_name ?></td>
        <td><?= AppHelper::getEngineTypes()[$value->engine_type] ?></td>
        <td><?= AppHelper::getMainAxes()[$value->main_axe] ?></td>
    </tr>
    <?php endforeach; ?>
    <?php else: ?>
    <tr>
        <td colspan="10">Нет данных</td>
    </tr>
    <?php endif ?>
    </tbody>
</table>
<?php
echo $data->links();
