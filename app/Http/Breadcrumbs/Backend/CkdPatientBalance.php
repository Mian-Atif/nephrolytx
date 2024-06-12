<?php

Breadcrumbs::register('admin.ckdpatientbalances.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.ckdpatientbalances.management'), route('admin.ckdpatientbalances.index'));
});

Breadcrumbs::register('admin.ckdpatientbalances.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.ckdpatientbalances.index');
    $breadcrumbs->push(trans('menus.backend.ckdpatientbalances.create'), route('admin.ckdpatientbalances.create'));
});

Breadcrumbs::register('admin.ckdpatientbalances.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.ckdpatientbalances.index');
    $breadcrumbs->push(trans('menus.backend.ckdpatientbalances.edit'), route('admin.ckdpatientbalances.edit', $id));
});
