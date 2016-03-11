<?php

require_once __DIR__ . '/../vendor/autoload.php';

use euclid1990\PhpIosEmoji\Emoji;

$config = ['emoji' => require __DIR__.'/../config/emoji.php'];
$emoji = new Emoji(new Illuminate\Config\Repository($config));

echo $emoji->parse('Parse the emotions: :smiley: :smile: :baby: in this string.');