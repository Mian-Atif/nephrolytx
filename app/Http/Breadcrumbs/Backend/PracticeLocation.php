<?php

Breadcrumbs::register('admin.practicelocations.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.practicelocations.management'), route('admin.practicelocations.index'));
});

Breadcrumbs::register('admin.practicelocations.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.practicelocations.index');
    $breadcrumbs->push(trans('menus.backend.practicelocations.create'), route('admin.practicelocations.create'));
});

Breadcrumbs::register('admin.practicelocations.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.practicelocations.index');
    $breadcrumbs->push(trans('menus.backend.practicelocations.edit'), route('admin.practicelocations.edit', $id));
});
