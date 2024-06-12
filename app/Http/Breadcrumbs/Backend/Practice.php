<?php

Breadcrumbs::register('admin.practices.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.practices.management'), route('admin.practices.index'));
});

Breadcrumbs::register('admin.practices.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.practices.index');
    $breadcrumbs->push(trans('menus.backend.practices.create'), route('admin.practices.create'));
});

Breadcrumbs::register('admin.practices.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.practices.index');
    $breadcrumbs->push(trans('menus.backend.practices.edit'), route('admin.practices.edit', $id));
});
