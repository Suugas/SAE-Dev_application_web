<?php

class DatabaseLoad {

    protected static ?array $config = null;
    protected static ?DatabaseLoad $instance = null;
    protected ?PDO $pdo = null;


    protected function __construct()
    {
        if (!self::$config) {
            throw new \Exception("Configuration non définie. Appeler setConfig() d'abord.");
        }
        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=utf8',
            self::$config['host'],
            self::$config['database']
        );
        $this->pdo = new PDO($dsn, self::$config['user'], self::$config['password']);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance(): DatabaseLoad
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function setConfig(string $file): void
    {
        self::$config = parse_ini_file($file);
    }

    public function getTouites(int $page):array{
        $query = "Select *
            from touite
            Order by date_publication
            limit 50 offset 50*:page;";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['page' => $page]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //recuprer touite utilisateur
    public function getTouitesUtilisateur(int $page, string $email):array{
        $query = "Select *
            from touite
            where email like ':email'
            Order by date_publication
            limit 50 offset 50*:page;"
    }

    // Recuperer followers et followed
    // recuperer tag follow
    // Recuperer 1 touite
    //
}
