<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;

class TestController extends Controller
{
    public function display(Request $request) {
        $test = Test::all();
        return response([
            $test,
            "message"=>  "showing" . " ". $test
        ]);

    }

    public function create(Request $request) {
        $test = Test::create($request->all());
         return response([
            $test,
            "message"=>  "created" . " ". $test
        ]);

    }

    public function upDate(Request $request, $id) {
        $test = Test::find($id);
        $test->update($request->all());
        $newTest = Test::find($id);
        return response([
            $newTest,
            "message"=> $newTest. " " . "updated"
        ]);
    }

    public function destroy(Request $request, $id) {
        $test = Test::find($id);
        $test->delete($request->all());
        return response([
            $test,
            "message"=> $test." "."deletedet"
        ]);
    }
}
