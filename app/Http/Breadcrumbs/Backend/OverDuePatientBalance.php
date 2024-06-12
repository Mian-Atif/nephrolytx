<?php

Breadcrumbs::register('admin.overduepatientbalances.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.overduepatientbalances.management'), route('admin.overduepatientbalances.index'));
});

Breadcrumbs::register('admin.overduepatientbalances.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.overduepatientbalances.index');
    $breadcrumbs->push(trans('menus.backend.overduepatientbalances.create'), route('admin.overduepatientbalances.create'));
});

Breadcrumbs::register('admin.overduepatientbalances.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.overduepatientbalances.index');
    $breadcrumbs->push(trans('menus.backend.overduepatientbalances.edit'), route('admin.overduepatientbalances.edit', $id));
});
