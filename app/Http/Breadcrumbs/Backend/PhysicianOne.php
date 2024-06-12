<?php

Breadcrumbs::register('admin.physicianones.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.physicianones.management'), route('admin.physicianones.index'));
});

Breadcrumbs::register('admin.physicianones.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.physicianones.index');
    $breadcrumbs->push(trans('menus.backend.physicianones.create'), route('admin.physicianones.create'));
});

Breadcrumbs::register('admin.physicianones.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.physicianones.index');
    $breadcrumbs->push(trans('menus.backend.physicianones.edit'), route('admin.physicianones.edit', $id));
});
