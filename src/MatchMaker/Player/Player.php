<?php

declare(strict_types=1);
namespace App\Domain\MatchMaker\Player;


class Player extends AbstractPlayer
{
    public function __construct(string $name, float $ratio = 400.0)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    protected function probabilityAgainst(AbstractPlayer $player): float
    {
        return 1 / (1 + (10 ** (($player->getRatio() - $this->getRatio()) / 400)));
    }

    public function updateRatioAgainst(AbstractPlayer $player, int $result): void
    {
        $this->ratio += 32 * ($result - $this->probabilityAgainst($player));
    }

    public function getRatio(): float
    {
        return $this->ratio;
    }
}