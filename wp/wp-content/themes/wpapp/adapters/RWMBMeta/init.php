<?php

require_once __DIR__ . '/adapter.php'; 

$rwmbMeta = [];

$rwmbMeta[] = FormContactModel::getRWMBMetaFields();
$rwmbMeta[] = FormLeadModel::getRWMBMetaFields();

RWMBMetaBoxAdapter::run($rwmbMeta);