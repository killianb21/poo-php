<?php

declare(strict_types=1);
namespace App\Domain\MatchMaker\Player;

abstract class AbstractPlayer
{
    public function __construct(string $name = 'anonymous', float $ratio = 400.0)
    {
    }

    abstract public function getName(): string;

    abstract public function getRatio(): float;

    abstract protected function probabilityAgainst(self $player): float;

    abstract public function updateRatioAgainst(self $player, int $result): void;
}