<?php

namespace touiteur\class\outils;

use PDO;

class DatabaseLoad
{

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

    public function getTouites(int $page): array
    {
        $query = "Select text, date_publication, email, cheminfichier
            from touite
            Order by date_publication
            limit 50 offset 50*:page;";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['page' => $page]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //recuprer touite utilisateur
    public function getTouitesUtilisateur(int $page, string $email): array
    {
        $query = "Select text, date_publication, email, cheminfichier
            from touite
            where email like ':email'
            Order by date_publication
            limit 50 offset 50*:page;";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['page' => $page, 'email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addUser(string $email, string $nom, string $prenom): void
    {
        $query = "Insert into utilisateur(email, nom, prenom)
            values(:email, :nom, :prenom);";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['email' => $email, 'nom' => $nom, 'prenom' => $prenom]);
    }

    //getUtilisateur
    public function getUser(string $email): array
    {
        $query = "Select email from utilisateur where email like ':email'";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addTouit(string $texte, string $email, ?string $cheminFichier)
    {
        $query = "INSERT INTO touite (texte, date_publication, email, cheminFichier)
        VALUES (:texte, NOW(), :email, :cheminFichier);";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            'texte' => $texte,
            'email' => $email,
            'cheminFichier' => $cheminFichier,
        ]);
    }

    // Renvoie true si le touit est maintenant liké, false s'il vient d'être unliké
    public function btnLike(string $email, int $idMessage): bool
    {
        $params = ['email' => $email, 'id' => $idMessage];

        $stmt = $this->pdo->prepare(
            "DELETE FROM liker WHERE email = :email AND idMessage = :id"
        );
        $stmt->execute($params);

        if ($stmt->rowCount() > 0) {
            return false;
        }

        $stmt = $this->pdo->prepare(
            "INSERT INTO liker (email, idMessage) VALUES (:email, :id)"
        );
        $stmt->execute($params);
        return true;
    }












    // Recuperer followers et followed


    // recuperer tag follow
    // Recuperer 1 touite
    //

}
