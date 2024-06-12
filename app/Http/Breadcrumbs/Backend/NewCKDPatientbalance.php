<?php

Breadcrumbs::register('admin.newckdpatientbalances.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.newckdpatientbalances.management'), route('admin.newckdpatientbalances.index'));
});

Breadcrumbs::register('admin.newckdpatientbalances.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.newckdpatientbalances.index');
    $breadcrumbs->push(trans('menus.backend.newckdpatientbalances.create'), route('admin.newckdpatientbalances.create'));
});

Breadcrumbs::register('admin.newckdpatientbalances.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.newckdpatientbalances.index');
    $breadcrumbs->push(trans('menus.backend.newckdpatientbalances.edit'), route('admin.newckdpatientbalances.edit', $id));
});
