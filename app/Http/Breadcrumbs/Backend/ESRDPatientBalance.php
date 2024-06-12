<?php

Breadcrumbs::register('admin.esrdpatientbalances.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.esrdpatientbalances.management'), route('admin.esrdpatientbalances.index'));
});

Breadcrumbs::register('admin.esrdpatientbalances.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.esrdpatientbalances.index');
    $breadcrumbs->push(trans('menus.backend.esrdpatientbalances.create'), route('admin.esrdpatientbalances.create'));
});

Breadcrumbs::register('admin.esrdpatientbalances.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.esrdpatientbalances.index');
    $breadcrumbs->push(trans('menus.backend.esrdpatientbalances.edit'), route('admin.esrdpatientbalances.edit', $id));
});
