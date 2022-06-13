<?php

namespace App\Http\Controllers;

use App\Exceptions\InvariantException;
use App\Http\Requests\TableAddRequest;
use App\Models\Table;
use App\Services\TableService;
use Illuminate\Http\Request;

class TableController extends Controller
{
    private TableService $tableService;

    public function __construct(TableService $tableService)
    {
        $this->tableService = $tableService;
    }


    public function index()
    {
        $title = 'Meja';
        $tables = Table::all();
        return view('tables.index', compact('title', 'tables'));
    }

    public function store(TableAddRequest $request)
    {
        try {
            $this->tableService->addTable($request);
            return redirect()->back()->with('success', 'Berhasil menambah meja');
        }catch (InvariantException $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        try {
            Table::where('id',$id)->delete();
            return redirect()->back()->with('success', 'Meja berhasil dihapus');
        }catch (\Exception $exception) {
            return redirect()->back()->with('error', 'Meja gagal dihapus');
        }
    }
}
