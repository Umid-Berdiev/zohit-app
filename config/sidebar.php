<?php

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most templating systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views. Of course
    | the usual Laravel view path has already been registered for you.
    |
    */
  'menu' => [[
      'icon' => 'fa fa-th-large',
      'title' => 'Рабочий стол',
      'url' => '/admin/dashboard',
		],[
      'icon' => 'fa fa-table',
      'title' => 'Фермеры',
      'url' => '/admin/farmers',
    ],[
      'icon' => 'fa fa-chart-line',
      'title' => 'Показатели качества',
      'url' => '/admin/indicators',
    ],[
    'icon' => 'fa fa-history',
    'title' => 'Ежегодная история контуров',
    'url' => '/admin/histories',
  ],[
    'icon' => 'fa fa-table',
    'title' => 'Shape file',
    'url' => '/admin/shape-file',
  ],[
    'icon' => 'fa fa-th-large',
    'title' => 'Справочники',
    'url' => 'javascript:;',
    'caret' => true,
    'sub_menu' => [[
      'url' => '/admin/basic/regions',
      'title' => 'Регионы'
    ],[
      'url' => '/admin/basic/districts',
      'title' => 'Районы'
    ],[
      'url' => '/admin/basic/matrix',
      'title' => 'Массив'
    ]]
  ]]
];
