<?php

Breadcrumbs::register('admin.billingmanagers.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.billingmanagers.management'), route('admin.billingmanagers.index'));
});

Breadcrumbs::register('admin.billingmanagers.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.billingmanagers.index');
    $breadcrumbs->push(trans('menus.backend.billingmanagers.create'), route('admin.billingmanagers.create'));
});

Breadcrumbs::register('admin.billingmanagers.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.billingmanagers.index');
    $breadcrumbs->push(trans('menus.backend.billingmanagers.edit'), route('admin.billingmanagers.edit', $id));
});
