<?php
require_once('App/MatchMaker/AbstractPlayer.php');
require_once('App/MatchMaker/BlitzPlayer.php');
require_once('App/MatchMaker/lobby.php');
require_once('App/MatchMaker/Player.php');
require_once('App/MatchMaker/QueuingPlayer.php');

class Player extends AbstractPlayer
{
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