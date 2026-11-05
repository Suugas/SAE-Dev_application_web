<?php

namespace touiteur\class\outils;
use PDO;

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

    public function getTouites(int $page): array
    {
        $query = "Select text, date_publication, email, cheminfichier
            from touite
            Order by date_publication
            limit 50 offset 50*:page;";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['page' => $page]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //recuprer touite utilisateur
    public function getTouitesUtilisateur(int $page, string $email): array
    {
        $query = "Select text, date_publication, email, cheminfichier
            from touite
            where email = :email
            Order by date_publication
            limit 50 offset 50*:page;";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['page' => $page, 'email'=>$email]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        $query = "Select * from utilisateur where email = :email";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function countAbonnement(string $email):array{
        $query = "Select count(email_suivi) from suivre where email_suiveur = :email";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['email'=>$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function follow(string $follower, string $followed):void{
        $stmt = $this->pdo->prepare("Select email_suiveur from suivre where email_suiveur = :follower and email_suivi = :followed;");
        $stmt->execute(['follower'=>$follower, 'followed'=>$followed]);
        if(count($stmt->fetchAll(PDO::FETCH_ASSOC))>0){
            $stmt = $this->pdo->prepare("Delete from suivre where email_suiveur = :follower and email_suivi = :followed;");
            $stmt->execute(['follower'=>$follower, 'followed'=>$followed]);
        }
        else{
            $stmt = $this->pdo->prepare("Insert into suivre(email_suiveur, email_suivi)
                values(:follower, :followed)");
                $stmt->execute(['follower'=>$follower, 'followed'=>$followed]);
        }
    }    public function addTouit(string $texte, string $email, ?string $cheminFichier)
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

    public function getTag(int $idTag):array{
        $query = "SELECT idTag from tag where idTag like ':idTag'";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(["idTag"=>$idTag]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addTag(int $idTag, string $libelle) : void{
        $description = "";
        $query = "INSERT into tag(idTag, libelle, description) values(:idTag, :libelle, :description);";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['idTag'=>$idTag, 'libelle'=>$libelle, 'description'=>$description]);
    }

    public function editTag(int $idTag, string $description) : void{
        $query = "UPDATE tag SET description = :description WHERE idTag = :idTag;";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(["idTag"=>$idTag, "description"=>$description]);
    }

    public function getTouitesDuTag(int $idTag, int $page) : array {
        $query = "SELECT idMessage
            from touite_tag
            where idTag like ':idTag'
            Order by date_publication
            limit 50 offset 50*:page;";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['page' => $page, 'idTag'=>$idTag]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // recuperer tag follow
    // Recuperer 1 touite
    //

}
