<?php

Breadcrumbs::register('admin.practicemanagements.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.practicemanagements.management'), route('admin.practicemanagements.index'));
});

Breadcrumbs::register('admin.practicemanagements.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.practicemanagements.index');
    $breadcrumbs->push(trans('menus.backend.practicemanagements.create'), route('admin.practicemanagements.create'));
});

Breadcrumbs::register('admin.practicemanagements.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.practicemanagements.index');
    $breadcrumbs->push(trans('menus.backend.practicemanagements.edit'), route('admin.practicemanagements.edit', $id));
});
