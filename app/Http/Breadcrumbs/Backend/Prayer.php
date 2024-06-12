<?php

Breadcrumbs::register('admin.prayers.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.prayers.management'), route('admin.prayers.index'));
});

Breadcrumbs::register('admin.prayers.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.prayers.index');
    $breadcrumbs->push(trans('menus.backend.prayers.create'), route('admin.prayers.create'));
});

Breadcrumbs::register('admin.prayers.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.prayers.index');
    $breadcrumbs->push(trans('menus.backend.prayers.edit'), route('admin.prayers.edit', $id));
});
