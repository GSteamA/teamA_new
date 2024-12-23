<?php

namespace App\Services\Game;

interface GameServiceInterface
{
    public function initializeGame(array $params): ?array;
    public function processGameAction(array $params): array;
    public function finalizeGame(array $gameState): array;
}