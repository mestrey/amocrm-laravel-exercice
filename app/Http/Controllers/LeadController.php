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

    public function index(int $id = null)
    {
        if ($id == null) {
            return response()->json(['error' => 'id is null']);
        }

        try {
            $lead = $this->amoApiService->getLeadById($id);
            $elements = $lead->getCatalogElementsLinks();

            $sum = 0;
            $res = ['success' => true, 'products' => $elements->count(), 'data' => []];

            foreach ($elements as $el) {
                $product = $this->amoApiService->getCatalogElementById($el->getCatalogId(), $el->id);

                foreach ($product->getCustomFieldsValues() as $customField) {
                    if ($customField->fieldCode == "PRICE") {
                        $sum += intval($customField->values[0]->getValue());
                    } else if ($customField->fieldCode == "SPECIAL_PRICE_1") {
                        $priceOne = intval($customField->values[0]->value);
                        $res['data'][] = [
                            'priceOne' => $priceOne
                        ];
                    }
                }
            }

            $res['sum'] = $sum;

            return response()->json($res);
        } catch (AmoCRMApiNoContentException $e) {
            return response()->json(['error' => 'id not found']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
