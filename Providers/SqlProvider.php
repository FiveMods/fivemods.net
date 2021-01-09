<?php
namespace Providers;

use Config\FiveModsConfiguration;

/**
 * An SQL provider.
 */
class SqlProvider
{
    private static $instance;
    private $pdo;
    private function __construct() {
        $conf = FiveModsConfiguration::get();
        $this->pdo = new PDO('mysql:dbname=' . $conf['mysql']['database'] . ';host=' . $conf['mysql']['host'], $conf['mysql']['username'], $conf['mysql']['password']);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Gets the PDO Connection
     * @return \PDO
     */
    public function getConnection() {
        return $this->pdo;
    }

    /**
     * Begins preparing an SQL statement
     * @param string $sql The SQL to be executed
     * @param array $options Options to pass
     * @return false|\PDOStatement
     */
    public function prepare($sql, $options = array()) {
        return $this->pdo->prepare($sql, $options);
    }

    /**
     * Gets the current SQLProvider instance
     * @return SqlProvider
     */
    public static function getInstance() {
        if(self::$instance == null) {
            self::$instance = new SqlProvider();
        }
        return self::$instance;
    }
}