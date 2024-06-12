<?php

Breadcrumbs::register('admin.totalactivepatientbalances.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.totalactivepatientbalances.management'), route('admin.totalactivepatientbalances.index'));
});

Breadcrumbs::register('admin.totalactivepatientbalances.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.totalactivepatientbalances.index');
    $breadcrumbs->push(trans('menus.backend.totalactivepatientbalances.create'), route('admin.totalactivepatientbalances.create'));
});

Breadcrumbs::register('admin.totalactivepatientbalances.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.totalactivepatientbalances.index');
    $breadcrumbs->push(trans('menus.backend.totalactivepatientbalances.edit'), route('admin.totalactivepatientbalances.edit', $id));
});
