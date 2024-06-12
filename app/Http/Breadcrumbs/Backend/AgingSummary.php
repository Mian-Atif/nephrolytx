<?php

Breadcrumbs::register('admin.agingsummaries.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.agingsummaries.management'), route('admin.agingsummaries.index'));
});

Breadcrumbs::register('admin.agingsummaries.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.agingsummaries.index');
    $breadcrumbs->push(trans('menus.backend.agingsummaries.create'), route('admin.agingsummaries.create'));
});

Breadcrumbs::register('admin.agingsummaries.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.agingsummaries.index');
    $breadcrumbs->push(trans('menus.backend.agingsummaries.edit'), route('admin.agingsummaries.edit', $id));
});
