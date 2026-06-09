<?php

namespace App\Services;

use App\Models\ClothingItem;
use App\Models\User;
use Illuminate\Support\Collection;

class RecommendationService
{
    public function __construct(
        private readonly WeatherService $weatherService
    ) {}

    public function generate(User $user, string $occasion): array
    {
        $weather = $this->weatherService->getWeather($user->city ?? 'Lahore');
        $items = $user->clothingItems()->get();

        $filtered = $items->filter(
            fn (ClothingItem $item) => in_array($occasion, $item->occasion ?? [], true)
        );

        $filtered = $this->applyWeatherFilter($filtered, $weather['temp']);

        $pools = $this->groupByCategory($filtered);

        return $this->buildCombinations($pools, $weather, $occasion);
    }

    private function applyWeatherFilter(Collection $items, int $temp): Collection
    {
        if ($temp > 30) {
            return $items->filter(function (ClothingItem $item) {
                if ($item->category === 'outerwear') {
                    return false;
                }

                return ! in_array('winter', $item->season ?? [], true);
            });
        }

        return $items;
    }

    private function groupByCategory(Collection $items): array
    {
        $categories = ['tops', 'bottoms', 'dresses', 'shoes', 'outerwear'];
        $pools = [];

        foreach ($categories as $category) {
            $pools[$category] = $items->where('category', $category)->values();
        }

        return $pools;
    }

    private function buildCombinations(array $pools, array $weather, string $occasion): array
    {
        $combinations = [];
        $seenKeys = [];
        $requiresOuterwear = $weather['temp'] < 15;
        $maxAttempts = 10;

        for ($attempt = 0; $attempt < $maxAttempts && count($combinations) < 3; $attempt++) {
            $combo = $this->buildSingleCombination($pools, $requiresOuterwear);

            if ($combo === null) {
                continue;
            }

            $key = collect($combo)->pluck('id')->sort()->implode('-');

            if (isset($seenKeys[$key])) {
                continue;
            }

            $seenKeys[$key] = true;
            $combinations[] = [
                'items' => collect($combo),
                'weather' => $weather,
                'occasion' => $occasion,
            ];
        }

        return $combinations;
    }

    private function buildSingleCombination(array $pools, bool $requiresOuterwear): ?array
    {
        $combo = [];

        $dresses = $pools['dresses']->shuffle();
        $tops = $pools['tops']->shuffle();
        $bottoms = $pools['bottoms']->shuffle();

        $useDress = $dresses->isNotEmpty() && ($tops->isEmpty() || random_int(0, 1) === 1);

        if ($useDress) {
            $combo[] = $dresses->first();
        } else {
            if ($tops->isEmpty()) {
                return null;
            }

            $combo[] = $tops->first();

            if ($bottoms->isNotEmpty()) {
                $combo[] = $bottoms->first();
            }
        }

        $shoes = $pools['shoes']->shuffle();
        if ($shoes->isNotEmpty()) {
            $combo[] = $shoes->first();
        }

        if ($requiresOuterwear) {
            $outerwear = $pools['outerwear']->shuffle();
            if ($outerwear->isEmpty()) {
                return null;
            }

            $combo[] = $outerwear->first();
        }

        return count($combo) > 0 ? $combo : null;
    }
}
