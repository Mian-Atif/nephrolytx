<?php

Breadcrumbs::register('admin.locationthrees.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.locationthrees.management'), route('admin.locationthrees.index'));
});

Breadcrumbs::register('admin.locationthrees.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.locationthrees.index');
    $breadcrumbs->push(trans('menus.backend.locationthrees.create'), route('admin.locationthrees.create'));
});

Breadcrumbs::register('admin.locationthrees.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.locationthrees.index');
    $breadcrumbs->push(trans('menus.backend.locationthrees.edit'), route('admin.locationthrees.edit', $id));
});
