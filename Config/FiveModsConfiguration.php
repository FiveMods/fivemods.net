<?php
namespace Config;

class FiveModsConfiguration
{
    /**
     * Gets the active configuration
     * @return array[]
     */
    public static function get() {
        return [
            'mysql' => [
                'host' => $_ENV['MYSQL_HOST'],
                'database' => $_ENV['MYSQL_DATABASE'],
                'username' => $_ENV['MYSQL_USERNAME'],
                'password' => $_ENV['MYSQL_PASSWORD']
            ],
            'discord' => [
                'client_id' => $_ENV['DISCORD_CID'],
                'client_secret' => $_ENV['DISCORD_SEC']
            ],
            'google' => [
                'client_id' => $_ENV['GOOGLE_CID'],
                'client_secret' => $_ENV['GOOGLE_SEC']
            ]
        ];
    }
}