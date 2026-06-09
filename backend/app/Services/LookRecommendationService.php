<?php

namespace App\Services;

class LookRecommendationService
{
    public function recommend(array $traits, string $eventType, string $styleMood): array
    {
        $faceShape = $traits['faceShape'] ?? 'oval';
        $skinTone = $traits['skinTone'] ?? 'warm-medium';
        $hairLength = $traits['hairLength'] ?? 'medium';

        $makeup = $this->makeupSuggestions($faceShape, $skinTone, $eventType, $styleMood);
        $hairstyle = $this->hairstyleSuggestions($faceShape, $hairLength, $eventType, $styleMood);
        $mehndi = $this->mehndiSuggestions($eventType, $styleMood);

        return [
            'makeup' => $makeup,
            'hairstyle' => $hairstyle,
            'mehndi' => $mehndi,
        ];
    }

    private function makeupSuggestions(
        string $faceShape,
        string $skinTone,
        string $eventType,
        string $styleMood
    ): array {
        $warm = str_contains($skinTone, 'warm');
        $base = $warm
            ? ['Soft Glam Warm', 'Peach Glow Base', 'Golden Hour Highlight']
            : ['Cool Rose Base', 'Porcelain Finish', 'Berry Soft Contour'];

        if ($eventType === 'wedding' || $eventType === 'formal') {
            $base = array_merge(['Classic Bridal Glow', 'Elegant Dewy Finish'], $base);
        }

        if ($styleMood === 'bold') {
            $base[] = 'Defined Wing Liner';
        }

        if ($faceShape === 'round') {
            $base[] = 'Vertical Contour Lift';
        }

        return array_values(array_unique(array_slice($base, 0, 3)));
    }

    private function hairstyleSuggestions(
        string $faceShape,
        string $hairLength,
        string $eventType,
        string $styleMood
    ): array {
        $options = match ($hairLength) {
            'short' => ['Textured Pixie', 'Sleek Side Part', 'Soft Curls Crop'],
            'long' => ['Loose Waves', 'Half-Up Curls', 'Braided Low Bun'],
            default => ['Textured Low Bun', 'Soft Blowout', 'Half-Up Twist'],
        };

        if ($faceShape === 'heart') {
            $options[] = 'Face-Framing Layers';
        }

        if ($eventType === 'party') {
            $options[] = 'Voluminous Party Curls';
        }

        if ($styleMood === 'natural') {
            $options[] = 'Effortless Air-Dried Look';
        }

        return array_values(array_unique(array_slice($options, 0, 3)));
    }

    private function mehndiSuggestions(string $eventType, string $styleMood): array
    {
        if ($eventType === 'wedding' || $eventType === 'formal') {
            return $styleMood === 'bold'
                ? ['Traditional Bridal Full', 'Intricate Paisley', 'Mandala Palm Design']
                : ['Minimal Arabic', 'Floral Traditional', 'Delicate Finger Trails'];
        }

        if ($eventType === 'party') {
            return ['Glitter Accent Mehndi', 'Modern Geometric', 'Minimal Arabic'];
        }

        return ['Single Line Accent', 'Tiny Floral Motif', 'Skip or Light Henna Stain'];
    }
}
