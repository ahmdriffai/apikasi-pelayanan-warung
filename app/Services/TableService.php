<?php

namespace App\Services;

use App\Http\Requests\TableAddRequest;
use App\Models\Table;

interface TableService
{
    function addTable(TableAddRequest $request): Table;
}
