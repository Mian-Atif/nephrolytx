<?php

Breadcrumbs::register('admin.cptcodeinsuranceprices.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.cptcodeinsuranceprices.management'), route('admin.cptcodeinsuranceprices.index'));
});

Breadcrumbs::register('admin.cptcodeinsuranceprices.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.cptcodeinsuranceprices.index');
    $breadcrumbs->push(trans('menus.backend.cptcodeinsuranceprices.create'), route('admin.cptcodeinsuranceprices.create'));
});

Breadcrumbs::register('admin.cptcodeinsuranceprices.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.cptcodeinsuranceprices.index');
    $breadcrumbs->push(trans('menus.backend.cptcodeinsuranceprices.edit'), route('admin.cptcodeinsuranceprices.edit', $id));
});
