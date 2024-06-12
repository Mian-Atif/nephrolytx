<?php

Breadcrumbs::register('admin.providers.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.providers.management'), route('admin.providers.index'));
});

Breadcrumbs::register('admin.providers.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.providers.index');
    $breadcrumbs->push(trans('menus.backend.providers.create'), route('admin.providers.create'));
});

Breadcrumbs::register('admin.providers.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.providers.index');
    $breadcrumbs->push(trans('menus.backend.providers.edit'), route('admin.providers.edit', $id));
});
