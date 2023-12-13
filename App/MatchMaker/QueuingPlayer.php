<?php
require_once('App/MatchMaker/AbstractPlayer.php');
require_once('App/MatchMaker/BlitzPlayer.php');
require_once('App/MatchMaker/lobby.php');
require_once('App/MatchMaker/Player.php');
require_once('App/MatchMaker/QueuingPlayer.php');

class QueuingPlayer extends Player
{
    public function __construct(AbstractPlayer $player, protected int $range = 1)
    {
        parent::__construct($player->getName(), $player->getRatio());
    }

    public function getRange(): int
    {
        return $this->range;
    }

    public function upgradeRange(): void
    {
        $this->range = min($this->range + 1, 40);
    }
}