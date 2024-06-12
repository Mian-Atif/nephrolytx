<?php

Breadcrumbs::register('admin.practicedoctors.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.practicedoctors.management'), route('admin.practicedoctors.index'));
});

Breadcrumbs::register('admin.practicedoctors.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.practicedoctors.index');
    $breadcrumbs->push(trans('menus.backend.practicedoctors.create'), route('admin.practicedoctors.create'));
});

Breadcrumbs::register('admin.practicedoctors.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.practicedoctors.index');
    $breadcrumbs->push(trans('menus.backend.practicedoctors.edit'), route('admin.practicedoctors.edit', $id));
});
