<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\RespondsWithJson;
use App\Http\Resources\ClothingItemResource;
use App\Models\ClothingItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ClothingItemController extends Controller
{
    use RespondsWithJson;

    private const CATEGORIES = [
        'tops',
        'bottoms',
        'dresses',
        'shoes',
        'accessories',
        'outerwear',
    ];

    public function index(Request $request)
    {
        $query = $request->user()->clothingItems()->latest();

        if ($request->filled('category')) {
            $request->validate([
                'category' => ['required', Rule::in(self::CATEGORIES)],
            ]);

            $query->where('category', $request->category);
        }

        $items = $query->get();

        return $this->success([
            'items' => ClothingItemResource::collection($items),
        ]);
    }

    public function store(Request $request)
    {
        $this->decodeJsonArrayFields($request, ['colors', 'season', 'occasion']);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', Rule::in(self::CATEGORIES)],
            'colors' => ['required', 'array'],
            'colors.*' => ['string'],
            'season' => ['required', 'array'],
            'season.*' => ['string'],
            'occasion' => ['required', 'array'],
            'occasion.*' => ['string'],
            'notes' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:5120'],
        ]);

        $user = $request->user();

        $item = new ClothingItem([
            'name' => $validated['name'],
            'category' => $validated['category'],
            'colors' => $validated['colors'],
            'season' => $validated['season'],
            'occasion' => $validated['occasion'],
            'notes' => $validated['notes'] ?? null,
        ]);

        if ($request->hasFile('image')) {
            $item->image_path = $request->file('image')->store("wardrobe/{$user->id}", 'public');
        }

        $user->clothingItems()->save($item);

        return $this->success(
            ['item' => new ClothingItemResource($item)],
            'Clothing item created.',
            201
        );
    }

    public function destroy(Request $request, int $id)
    {
        $item = ClothingItem::findOrFail($id);

        if ($item->user_id !== $request->user()->id) {
            return $this->error('Forbidden.', null, 403);
        }

        if ($item->image_path) {
            Storage::disk('public')->delete($item->image_path);
        }

        $item->delete();

        return $this->success(null, 'Item deleted.');
    }

    private function decodeJsonArrayFields(Request $request, array $fields): void
    {
        foreach ($fields as $field) {
            $value = $request->input($field);

            if (is_string($value)) {
                $decoded = json_decode($value, true);

                if (json_last_error() === JSON_ERROR_NONE) {
                    $request->merge([$field => $decoded]);
                }
            }
        }
    }
}
