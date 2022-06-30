<?php

namespace App\Services\Eloquent;

use App\Exceptions\InvariantException;
use App\Http\Requests\TableAddRequest;
use App\Models\Table;
use App\Services\TableService;
use Illuminate\Support\Facades\DB;

class TableServiceImpl implements TableService
{

    function addTable(TableAddRequest $request): Table
    {
        $number = $request->input('number');

        try {
            DB::beginTransaction();
            $table = new Table([
                'number' => $number,
            ]);
            $table->save();

            DB::commit();
        }catch (\Exception $exception) {
            DB::rollBack();
            throw new InvariantException($exception->getMessage());
        }

        return $table;
    }

}
