<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\TestResource;
use App\Models\Test;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;

class TestCatalogController extends Controller
{
    use ApiResponses;

    public function index(Request $request)
    {
        $tests = Test::with('type', 'sections', 'questions')->get();

        return $this->successResponse(
            TestResource::collection($tests),
            'Test catalog retrieved.'
        );
    }

    public function show(int $id)
    {
        $test = Test::with('type', 'sections', 'questions')->find($id);

        if (!$test) {
            return $this->notFoundResponse('Test not found.');
        }

        return $this->successResponse(
            new TestResource($test),
            'Test details retrieved.'
        );
    }
}
