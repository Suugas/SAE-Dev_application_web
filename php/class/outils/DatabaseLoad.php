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
        $limite = 50;
        $offset = max(0, $page) * $limite;

        $query = "SELECT idMessage, texte,date_publication, email, cheminFichier, Likes, Note
                  FROM touite
                  ORDER BY date_publication DESC
                  LIMIT :limite OFFSET :offset";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':limite', $limite, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    //recuprer touite utilisateur
    public function getTouitesUtilisateur(int $page, string $email): array
    {
        $offset = 50* $page;
        $query = "Select *
            from touite
            where email like :email
            Order by date_publication
            limit 50 offset :offset;";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
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
    public function getUser(string $email): array|false
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
    public function rechercherTouit(string $texte): array
{
    $query = "SELECT t.idMessage, t.texte, t.date_publication, t.email, u.nom, u.prenom, t.cheminFichier, t.Likes, t.Note
              FROM touite AS t
              JOIN utilisateur AS u
              ON u.email = t.email
              LEFT JOIN touite_tag as tg
              ON tg.idMessage = t.idMessage
              LEFT JOIN tag
              ON tag.idTag = tg.idTag
              WHERE t.texte LIKE :texte
              OR u.nom LIKE :texte
              OR u.prenom LIKE :texte
              OR t.email LIKE :texte
              OR tag.libelle LIKE :texte
              ORDER BY t.date_publication DESC
              LIMIT 20;";
    $stmt = $this->pdo->prepare($query);
    $like = '%' . $texte . '%';
    $stmt->execute(['texte' => $like]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function rechercherUtilisateur(string $texte): array
{
    $query = "SELECT email, nom, prenom, nombre_touites
              FROM utilisateur
              WHERE nom LIKE :texte OR prenom LIKE :texte
              LIMIT 10";
    $stmt = $this->pdo->prepare($query);
    $like = '%' . $texte . '%';
    $stmt->execute(['texte' => $like]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function rechercherTag(string $texte): array{
        $query = "SELECT idTag, libelle, description
                    FROM tag
                    WHERE libelle like :texte or description like :texte
                    limit 10;";
        $stmt = $this->pdo->prepare($query);
        $like = '%' . $texte . '%';
        $stmt->execute(['texte'=>$like]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addImage(string $lien, string $description){
        $query = 'INSERT INTO image VALUE(:lien, :description);';
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['lien'=> $lien,'description'=> $description]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getImage(string $lien): array{
        $query = "SELECT *
            FROM image 
            WHERE cheminFichier like :lien;";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(["lien"=> $lien]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMurUser(string $email, int $page): array{
        $offset = 50* $page;
        $query = "SELECT t.idMessage, t.texte, t.date_publication, t.email, t.cheminFichier, t.Likes, t.Note
            FROM touite as t
            WHERE t.email IN (SELECT email_suivi FROM suivre WHERE email_suiveur = :email)
                 OR t.idMessage IN (SELECT tt.idMessage
                                    FROM touite_tag AS tt
                                    JOIN utilisateur_tag AS ut ON ut.idTag = tt.idTag
                                    WHERE ut.email = :email)
            ORDER BY t.date_publication DESC
            limit 10 offset :offset;
            ";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function isFollowed(string $emailFollower, string $emailFollow): bool{
        $query = 'SELECT *
                FROM suivre
                WHERE email_suiveur = :emailFollower
                AND email_suivi = :emailFollow;
                ';
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['emailFollower'=> $emailFollower,'emailFollow'=> $emailFollow]);
        return count($stmt->fetchAll(PDO::FETCH_ASSOC)) == 1;
    }









    // Recuperer followers et followed
    public function getTag(string $libelleTag):array|false{
        $query = "SELECT idTag, libelle from tag where libelle = :libelle";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(["libelle"=>$libelleTag]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addTag(string $libelle) : void{
        $description = "";
        $query = "INSERT into tag(libelle, description) values(:libelle, :description);";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['libelle'=>$libelle, 'description'=>$description]);
    }

    public function editTag(int $idTag, string $description) : void{
        $query = "UPDATE tag SET description = :description WHERE idTag = :idTag;";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(["idTag"=>$idTag, "description"=>$description]);
    }

    public function getTouitesDuTag(string $libelle, int $page) : array {
        $offset = 50* $page;
        $query = "SELECT t.idMessage, t.texte, t.date_publication, t.email, t.cheminFichier, t.Likes, t.Note
            FROM touite as t
            JOIN touite_tag as tg
            ON t.idMessage = tg.idMessage
            JOIN tag
            on tag.idTag = tg.idTag
            where tag.libelle like :libelle
            Order by t.date_publication
            limit 50 offset :offset;";
        $stmt = $this->pdo->prepare($query);

        $stmt->bindValue(':libelle', $libelle, PDO::PARAM_STR);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addTagMessage($idMessage, $idTag): void{
        $query = "Insert into touite_tag(idMessage, idTag)
            values(:idMessage, :idTag);";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['idMessage'=>$idMessage, 'idTag'=>$idTag]);
    }

    public function getLastTouite():int{
        $query = "Select Max(IdMessage) as max from touite;";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return (int)$stmt->fetch(PDO::FETCH_ASSOC)['max'];
    }

    public function followTag(string $email, int $idTag) : void{
        $query = '';
        if ($this->isTagFollowed($email, $idTag)) {
            $query = 'DELETE from utilisateur_tag 
                        where email = :email 
                        and idTag = :idTag;';
        } else {
            $query = "INSERT INTO utilisateur_tag 
                    VALUE(:email, :idTag);
                    ";
        }
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['email'=>$email, 'idTag'=>$idTag]);
    }

    public function isTagFollowed(string $emailFollower, int $idTag): bool{
        $query = 'SELECT *
                FROM utilisateur_tag
                WHERE email = :emailFollower
                AND idTag = :idTag;
                ';
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['emailFollower'=> $emailFollower,'idTag'=> $idTag]);
        return count($stmt->fetchAll(PDO::FETCH_ASSOC)) == 1;
    }

}
