<?php

Breadcrumbs::register('admin.physiciantwos.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.physiciantwos.management'), route('admin.physiciantwos.index'));
});

Breadcrumbs::register('admin.physiciantwos.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.physiciantwos.index');
    $breadcrumbs->push(trans('menus.backend.physiciantwos.create'), route('admin.physiciantwos.create'));
});

Breadcrumbs::register('admin.physiciantwos.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.physiciantwos.index');
    $breadcrumbs->push(trans('menus.backend.physiciantwos.edit'), route('admin.physiciantwos.edit', $id));
});
