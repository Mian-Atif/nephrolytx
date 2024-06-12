<?php

Breadcrumbs::register('admin.chargeandcollectionsummaries.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.chargeandcollectionsummaries.management'), route('admin.chargeandcollectionsummaries.index'));
});

Breadcrumbs::register('admin.chargeandcollectionsummaries.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.chargeandcollectionsummaries.index');
    $breadcrumbs->push(trans('menus.backend.chargeandcollectionsummaries.create'), route('admin.chargeandcollectionsummaries.create'));
});

Breadcrumbs::register('admin.chargeandcollectionsummaries.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.chargeandcollectionsummaries.index');
    $breadcrumbs->push(trans('menus.backend.chargeandcollectionsummaries.edit'), route('admin.chargeandcollectionsummaries.edit', $id));
});
