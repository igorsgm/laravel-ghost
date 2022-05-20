<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Igorsgm\Ghost\Facades\Ghost;

it('generates adminToken correctly', function () {
    $ghost = Ghost::admin();
    $adminKey = '1234:56789';

    $jwtToken = invokeMethod($ghost, 'adminToken', [$adminKey]);
    $decodedJWT = JWT::decode($jwtToken, new Key(pack('H*', '56789'), 'HS256'));

    expect($decodedJWT->exp)->toBeLessThanOrEqual(strtotime('+10 minutes'));
    expect($decodedJWT->iat)->toBeLessThanOrEqual(time());
    expect($decodedJWT->aud)->toBe("/v{$this->config->get('ghost.ghost_api_version')}/admin/");
});
