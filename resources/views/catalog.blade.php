<?php

use App\Components\Select;
use App\Components\CheckList;
use Illuminate\Support\Collection;
use App\Components\CarTable;

/**
 * @var $brands Collection
 * @var $models Collection
 * @var $currentBrand
 * @var $currentModel
 * @var $engineTypes
 * @var $mainAxes
 * @var $params stdClass
 *
 * @var $cars Collection
*/

$title = config('user.title')
    . ($params['brand'] ? ' — ' . $params['brand'] : '')
    . ($params['model'] ? ' ' . $params['model'] : '');


?>

@extends('_templates/app')

@section('page-title', $title)

<div class="container">

<h1 class="p-2"><?= $title ?></h1>
<hr>

<div class="row mb-4">
    <div class="col-lg-2">
        <?= Select::widget([
            'title' => 'Бренды',
            'name' => 'brand',
            'selected' => $params['brand'],
            'options' => $brands
        ]) ?>

        <?= Select::widget([
            'title' => 'Модели',
            'name' => 'model',
            'selected' => $params['model'],
            'options' => $models
        ]) ?>

        <?= CheckList::widget([
            'title' => 'Тип двигателя',
            'name' => 'engine-type',
            'selected' => $params['engineType'],
            'options' => $engineTypes
        ]) ?>

        <?= CheckList::widget([
            'title' => 'Привод',
            'name' => 'main-axe',
            'selected' => $params['mainAxe'],
            'options' => $mainAxes
        ]) ?>
    </div>

    <div class="col-lg-10">
        <div class="panel panel-primary">
            <div class="car-table">
                <?= CarTable::widget([
                    'data' => $cars
                ]) ?>
            </div>
        </div>

    </div>

</div>

</div>

@section('bottom-script')
    let queryString = "<?= !empty($_SERVER['QUERY_STRING']) ? ('/?' . $_SERVER['QUERY_STRING']) : '' ?>"

    let brands = <?= json_encode($brands->keyBy('id')) ?>;
    let models = <?= json_encode($models) ?>;
    let brand = "<?= $params['brand'] ?>"

    $('[name="brand"]').change((el) => {
        location = "<?= route('catalog') ?>" + '/' + el.target.value
    })
    $('[name="model"]').change((el) => {
        location = "<?= route('catalog') ?>" + (brand ? '/' + brand : '/' + models.find((o) => o.name == el.target.value)['brand_name']) + '/' + el.target.value
    })

    let engineTypes = $('[name="engine-type"]').find('input')
    let mainAxes = $('[name="main-axe"]').find('input')

    function sendAjaxFiltering() {
        let engineType = [], mainAxe = [],
            urlParts = []

        engineTypes.get().forEach((el) => {
            if ($(el).prop('checked')) {
                engineType.push(el.value)
            }
        })

        if (engineType.length) {
            urlParts.push("engine=" + engineType.join())
        }

        mainAxes.get().forEach((el) => {
            if ($(el).prop('checked')) {
                mainAxe.push(el.value)
            }
        })

        if (mainAxe.length) {
            urlParts.push("axe=" + mainAxe.join())
        }

        let url = location.pathname.replace(/\/(engine|axe)=(.*)/g, '')
            .replace(/\/$/gi, '') + (urlParts.length ? '/' + urlParts.join('/') : '') + queryString


        history.pushState({}, null, url)

        $.post(url, null, function(res) {
            $('.car-table').html(res)
        })
    }

    engineTypes.click(() => {
        sendAjaxFiltering()
    })

    mainAxes.click(() => {
        sendAjaxFiltering()
    })

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
@endsection
