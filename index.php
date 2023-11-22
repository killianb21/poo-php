<?php

/*
 * This file is part of the OpenClassRoom PHP Object Course.
 *
 * (c) Grégoire Hébert <contact@gheb.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

class User
{
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    function __construct(
        string $username,
        string $status = self::STATUS_ACTIVE
    ) {
    }

    function setStatus(string $status): void
    {
        if (!in_array($status, [self::STATUS_ACTIVE, self::STATUS_INACTIVE])) {
            trigger_error(sprintf(
                'Le status %s n\'est pas valide. Les status possibles sont : %s',
                $status,
                implode(', ', [self::STATUS_ACTIVE, self::STATUS_INACTIVE])
            ), E_USER_ERROR);
        };
        $this->status = $status;
    }

    function getStatus(): string
    {
        return $this->status;
    }
}

class Admin extends User
{
    const STATUS_LOCKED = 'locked';

    // la méthode est entièrement réécrite ici
    // seule la signature reste inchangée
    public function setStatus(string $status): void
    {
        if (!in_array($status, [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_LOCKED])) {
            trigger_error(sprintf(
                'Le status %s n\'est pas valide. Les status possibles sont : %s',
                $status,
                implode(', ', [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_LOCKED])
            ), E_USER_ERROR);
        }
        $this->status = $status;
    }

    // utilise la méthode de la classe parente et ajoute un comportement
    function getStatus(): string
    {
        return strtoupper(parent::getStatus());
    }
}

$admin = new Admin('Paddington');
$admin->setStatus(Admin::STATUS_LOCKED);
echo $admin->getStatus();

class Lobby
{
    /** @var array<QueuingPlayer> */
    public $queuingPlayers = [];

    function findOponents(QueuingPlayer $player): array
    {
        $minLevel = round($player->getRatio() / 100);
        $maxLevel = $minLevel + $player->getRange();

        return array_filter($this->queuingPlayers, static function (QueuingPlayer $potentialOponent) use ($minLevel, $maxLevel, $player) {
            $playerLevel = round($potentialOponent->getRatio() / 100);

            return $player !== $potentialOponent && ($minLevel <= $playerLevel) && ($playerLevel <= $maxLevel);
        });
    }

    function addPlayer(Player $player): void
    {
        $this->queuingPlayers[] = new QueuingPlayer($player);
    }

    function addPlayers(Player ...$players): void
    {
        foreach ($players as $player) {
            $this->addPlayer($player);
        }
    }
}

class Player
{
    function __construct(string $name, float $ratio = 400.0)
    {
    }

    function getName(): string
    {
        return $this->name;
    }

    function probabilityAgainst(self $player): float
    {
        return 1 / (1 + (10 ** (($player->getRatio() - $this->getRatio()) / 400)));
    }

    function updateRatioAgainst(self $player, int $result): void
    {
        $this->ratio += 32 * ($result - $this->probabilityAgainst($player));
    }

    function getRatio(): float
    {
        return $this->ratio;
    }
}

class QueuingPlayer extends Player
{
    public $range;

    function __construct(Player $player)
    {   
        parent::__construct($player->getName(), $player->getRatio());
        $this->range = 1;
    }

    function getRange(): int
    {
        return $this->range;
    }
}

$greg = new Player('greg', 400);
$jade = new Player('jade', 476);

$lobby = new Lobby();
$lobby->addPlayers($greg, $jade);

var_dump($lobby->findOponents($lobby->queuingPlayers[0]));

exit(0);