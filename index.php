<?php

/*
 * This file is part of the OpenClassRoom PHP Object Course.
 *
 * (c) Grégoire Hébert <contact@gheb.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once('App/MatchMaker/AbstractPlayer.php');
require_once('App/MatchMaker/BlitzPlayer.php');
require_once('App/MatchMaker/lobby.php');
require_once('App/MatchMaker/Player.php');
require_once('App/MatchMaker/QueuingPlayer.php');

declare(strict_types=1);

$greg = new BlitzPlayer('greg');
$jade = new BlitzPlayer('jade');

$lobby = new Lobby();
$lobby->addPlayers($greg, $jade);

var_dump($lobby->findOponents($lobby->queuingPlayers[0]));

exit(0);
