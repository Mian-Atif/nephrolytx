<?php

Breadcrumbs::register('admin.procedures.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.procedures.management'), route('admin.procedures.index'));
});

Breadcrumbs::register('admin.procedures.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.procedures.index');
    $breadcrumbs->push(trans('menus.backend.procedures.create'), route('admin.procedures.create'));
});

Breadcrumbs::register('admin.procedures.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.procedures.index');
    $breadcrumbs->push(trans('menus.backend.procedures.edit'), route('admin.procedures.edit', $id));
});
