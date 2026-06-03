<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\RespondsWithJson;
use App\Http\Resources\ClothingItemResource;
use App\Services\RecommendationService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RecommendationController extends Controller
{
    use RespondsWithJson;

    public function __construct(
        private readonly RecommendationService $recommendationService
    ) {}

    public function index(Request $request)
    {
        $validated = $request->validate([
            'occasion' => ['required', Rule::in(['casual', 'work', 'formal', 'party'])],
        ]);

        $combinations = $this->recommendationService->generate(
            $request->user(),
            $validated['occasion']
        );

        $formatted = collect($combinations)->map(fn (array $combo) => [
            'items' => ClothingItemResource::collection($combo['items']),
            'weather' => $combo['weather'],
            'occasion' => $combo['occasion'],
        ]);

        return $this->success(['combinations' => $formatted]);
    }
}
