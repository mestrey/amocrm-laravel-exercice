<?php

namespace App\Http\Controllers;

use AmoCRM\Exceptions\AmoCRMApiNoContentException;
use App\Services\AmoApiServiceInterface;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function __construct(
        private AmoApiServiceInterface $amoApiService
    ) {
    }

    public function index(Request $request)
    {
        $page = $request->has('page') ? $request->get('page') : 1;

        try {
            $leads = $this->amoApiService->getLeadsByPage(intval($page));

            return response()->json([
                'leads' => $leads
            ]);
        } catch (AmoCRMApiNoContentException $e) {
            return response()->json(['leads' => []]);
        } catch (\Exception $e) {
            return response()->json(['Error' => $e->getMessage()]);
        }
    }
}
