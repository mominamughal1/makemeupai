<?php

namespace App\Services;

class FaceAnalysisService
{
    private const FACE_SHAPES = ['oval', 'round', 'heart', 'square'];

    private const SKIN_TONES = ['warm-light', 'warm-medium', 'cool-light', 'cool-medium', 'deep'];

    private const HAIR_LENGTHS = ['short', 'medium', 'long'];

    public function analyze(int $userId, string $imageContents): array
    {
        $seed = crc32($userId.'|'.hash('sha256', $imageContents));

        return [
            'faceShape' => self::FACE_SHAPES[$seed % count(self::FACE_SHAPES)],
            'skinTone' => self::SKIN_TONES[intdiv($seed, 7) % count(self::SKIN_TONES)],
            'hairLength' => self::HAIR_LENGTHS[intdiv($seed, 49) % count(self::HAIR_LENGTHS)],
            'analyzed_at' => now()->toIso8601String(),
        ];
    }
}
