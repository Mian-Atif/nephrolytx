<?php

Breadcrumbs::register('admin.performancereports.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.performancereports.management'), route('admin.performancereports.index'));
});

Breadcrumbs::register('admin.performancereports.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.performancereports.index');
    $breadcrumbs->push(trans('menus.backend.performancereports.create'), route('admin.performancereports.create'));
});

Breadcrumbs::register('admin.performancereports.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.performancereports.index');
    $breadcrumbs->push(trans('menus.backend.performancereports.edit'), route('admin.performancereports.edit', $id));
});
