<?php

Breadcrumbs::register('admin.activepatientbalances.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.activepatientbalances.management'), route('admin.activepatientbalances.index'));
});

Breadcrumbs::register('admin.activepatientbalances.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.activepatientbalances.index');
    $breadcrumbs->push(trans('menus.backend.activepatientbalances.create'), route('admin.activepatientbalances.create'));
});

Breadcrumbs::register('admin.activepatientbalances.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.activepatientbalances.index');
    $breadcrumbs->push(trans('menus.backend.activepatientbalances.edit'), route('admin.activepatientbalances.edit', $id));
});
