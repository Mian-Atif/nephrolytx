<?php

Breadcrumbs::register('admin.upload-reports-data.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.uploadreportsdata.management'), route('admin.uploadreportsdata.index'));
});

Breadcrumbs::register('admin.upload-reports-data.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.uploadreportsdata.index');
    $breadcrumbs->push(trans('menus.backend.uploadreportsdata.create'), route('admin.uploadreportsdata.create'));
});

Breadcrumbs::register('admin.uploadreportsdata.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.uploadreportsdata.index');
    $breadcrumbs->push(trans('menus.backend.uploadreportsdata.edit'), route('admin.uploadreportsdata.edit', $id));
});
