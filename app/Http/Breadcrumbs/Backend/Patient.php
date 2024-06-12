<?php

Breadcrumbs::register('admin.patients.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.patients.management'), route('admin.patients.index'));
});

Breadcrumbs::register('admin.patients.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.patients.index');
    $breadcrumbs->push(trans('menus.backend.patients.create'), route('admin.patients.create'));
});

Breadcrumbs::register('admin.patients.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.patients.index');
    $breadcrumbs->push(trans('menus.backend.patients.edit'), route('admin.patients.edit', $id));
});
