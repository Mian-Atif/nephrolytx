<?php

Breadcrumbs::register('admin.esrdpatients.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.esrdpatients.management'), route('admin.esrdpatients.index'));
});

Breadcrumbs::register('admin.esrdpatients.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.esrdpatients.index');
    $breadcrumbs->push(trans('menus.backend.esrdpatients.create'), route('admin.esrdpatients.create'));
});

Breadcrumbs::register('admin.esrdpatients.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.esrdpatients.index');
    $breadcrumbs->push(trans('menus.backend.esrdpatients.edit'), route('admin.esrdpatients.edit', $id));
});
