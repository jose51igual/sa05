<?php
namespace Joc4enRatlla\Models;

interface JocInterface {
    public function getBoard(): Board;
    public function getPlayers(): array;
    public function getWinner(): ?Player;
    public function getScores(): array;
    public function getNextPlayer(): int;
    public function reset(): void;
    public function play(int $columna): array;
    public function playAutomatic(): void;
    public function save(): void;
    public static function restore(): Game;
}