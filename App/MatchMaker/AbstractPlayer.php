<?php
require_once('App/MatchMaker/AbstractPlayer.php');
require_once('App/MatchMaker/BlitzPlayer.php');
require_once('App/MatchMaker/lobby.php');
require_once('App/MatchMaker/Player.php');
require_once('App/MatchMaker/QueuingPlayer.php');

abstract class AbstractPlayer
{
    public function __construct(public string $name = 'anonymous', public float $ratio = 400.0)
    {
    }

    abstract public function getName(): string;

    abstract public function getRatio(): float;

    abstract protected function probabilityAgainst(self $player): float;

    abstract public function updateRatioAgainst(self $player, int $result): void;
}