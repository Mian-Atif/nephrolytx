<?php

Breadcrumbs::register('admin.profiles.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.profiles.management'), route('admin.profiles.index'));
});

Breadcrumbs::register('admin.profiles.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.profiles.index');
    $breadcrumbs->push(trans('menus.backend.profiles.create'), route('admin.profiles.create'));
});

Breadcrumbs::register('admin.profiles.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.profiles.index');
    $breadcrumbs->push(trans('menus.backend.profiles.edit'), route('admin.profiles.edit', $id));
});
