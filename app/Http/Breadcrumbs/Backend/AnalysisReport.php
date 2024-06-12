<?php

Breadcrumbs::register('admin.analysisreports.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.analysisreports.management'), route('admin.analysisreports.index'));
});

Breadcrumbs::register('admin.analysisreports.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.analysisreports.index');
    $breadcrumbs->push(trans('menus.backend.analysisreports.create'), route('admin.analysisreports.create'));
});

Breadcrumbs::register('admin.analysisreports.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.analysisreports.index');
    $breadcrumbs->push(trans('menus.backend.analysisreports.edit'), route('admin.analysisreports.edit', $id));
});
