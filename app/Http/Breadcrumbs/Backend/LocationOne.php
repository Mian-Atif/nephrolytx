<?php

Breadcrumbs::register('admin.locationones.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.locationones.management'), route('admin.locationones.index'));
});

Breadcrumbs::register('admin.locationones.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.locationones.index');
    $breadcrumbs->push(trans('menus.backend.locationones.create'), route('admin.locationones.create'));
});

Breadcrumbs::register('admin.locationones.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.locationones.index');
    $breadcrumbs->push(trans('menus.backend.locationones.edit'), route('admin.locationones.edit', $id));
});
