<?php

Breadcrumbs::register('admin.latepatientbalances.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.latepatientbalances.management'), route('admin.latepatientbalances.index'));
});

Breadcrumbs::register('admin.latepatientbalances.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.latepatientbalances.index');
    $breadcrumbs->push(trans('menus.backend.latepatientbalances.create'), route('admin.latepatientbalances.create'));
});

Breadcrumbs::register('admin.latepatientbalances.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.latepatientbalances.index');
    $breadcrumbs->push(trans('menus.backend.latepatientbalances.edit'), route('admin.latepatientbalances.edit', $id));
});
