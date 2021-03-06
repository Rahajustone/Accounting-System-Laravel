<?php

namespace AccountSystem\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Alert;

use AccountSystem\Model\Income;

class KlientyController extends Controller
{
    //
    public function __construct() {
        $this->middleware('admin.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $income = Income::orderBy('created_at', 'desc')->limit('50')->get();

        //
        return view('klienty.index', [
            'fa'                => 'fa fa-users fa-fw',
            'title'             => 'Клиенты',
            'addurl'            => 'income.create',
            'savedata'          => '',
            'print'             => 'income.printpdf',
            'goback'            => '',
            'incomes'            => $income
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return response()->route('home');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        return response()->route('home');
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
        return response()->route('home');
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
        return response()->route('home');
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
        return response()->route('home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        return response()->route('home');
    }

    public function deleteAjax(Request $request) {
        if ($request->ajax()) {
            // get request ID
            $income = $request->id;
            if ($income) {
                // Search it from database
                try {
                    $income_data = Income::find($income);
                    if ($income_data) {

                        $tocarbon = new Carbon($income_data->created_at);

                        $incomestosum = IncomesOutgos::where('daily', '=', $tocarbon)->first();
                    
                        $incomestosum->incomes_sum_daily = $incomestosum->incomes_sum_daily - $income_data->obshiye_summa;

                        $incomestosum->update();

                        $result  = $income_data->delete();

                        if ($result) {
                            return response()->json(['success', $income]);
                        } else {
                            return response()->json('error');
                        }
                    } else {
                        return response()->json('error');
                    }
                } catch (Exception $e) {
                    return response()->json('error', $e);
                }
            }
        } else {
            return redirect()->route('income.index');
        }
    }
}
