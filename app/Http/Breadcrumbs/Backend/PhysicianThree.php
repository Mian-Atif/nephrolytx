<?php

Breadcrumbs::register('admin.physicianthrees.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.physicianthrees.management'), route('admin.physicianthrees.index'));
});

Breadcrumbs::register('admin.physicianthrees.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.physicianthrees.index');
    $breadcrumbs->push(trans('menus.backend.physicianthrees.create'), route('admin.physicianthrees.create'));
});

Breadcrumbs::register('admin.physicianthrees.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.physicianthrees.index');
    $breadcrumbs->push(trans('menus.backend.physicianthrees.edit'), route('admin.physicianthrees.edit', $id));
});
