<?php

namespace App\Repositories;
use App\Entities\User;
use App\Entities\Compte;
use App\Repositories\CompteRepository;
use App\Core\Abstract\AbstractRepository;
use App\Core\Abstract\AbstractEntity;
use App\Core\DataBase;
use App\Core\App;
use PDO;
use PDOException;

class UserRepository extends AbstractRepository
{
    private static ?UserRepository $userRepository = null;
    private CompteRepository $compteRepository;
    
    private function __construct()
    {
       parent::__construct();
       $this->compteRepository = App::getDependencie('CompteRepository');
    }

    public static function getInstance(): UserRepository
    {
        if (is_null(self::$userRepository)) {
            self::$userRepository = new UserRepository();
        }
        return self::$userRepository;
    }

    public function selectAll()
    {
        // Implementation for selecting all users
    }

    public function insert(User $utilisateur): int
    {
        if (!$utilisateur instanceof User) {
            throw new \InvalidArgumentException('User attendu');
        }
        $sql = "INSERT INTO utilisateur 
                (nom, numero_cni, photo_recto_cni, photo_verso_cni, profil_id, prenom, password) 
                VALUES (:nom, :cni, :recto_cni, :verso_cni, :profil_id, :prenom, :password)";
    
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':nom' => $utilisateur->getNom(),
            ':cni' => $utilisateur->getNumeroCni(),
            ':recto_cni' => $utilisateur->getPhotorecto(),
            ':verso_cni' => $utilisateur->getPhotoverso(),
            ':profil_id' => 1,
            ':prenom' => $utilisateur->getPrenom(),
            ':password' => $utilisateur->getPassword()
        ]);
        return $this->db->lastInsertId();
    }

    public function update()
    {
        // Implementation for updating an existing user
    }

    public function delete()
    {
        // Implementation for deleting a user
    }

    public function selectById($id)
    {
        // Implementation for selecting a user by ID
    }

    public function findUser(string $telephone): ?array 
    {
        try {
            $sql = "SELECT u.*, c.telephone, c.solde, c.type as compte_type 
                    FROM utilisateur u 
                    INNER JOIN compte c ON u.id = c.client_id 
                    WHERE c.telephone = ? AND c.type = 'Principal'";
                    
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$telephone]);
            
            $data = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if ($data) {
                error_log("Données utilisateur trouvées: " . print_r($data, true));
                
                $user = new User();
                $user->setId($data['id']);
                $user->setNom($data['nom']);
                $user->setPrenom($data['prenom']); 
                $user->setPassword($data['password']);
                
                $compte = new Compte(
                    $data['id'],
                    $data['solde'],
                    $data['compte_type'],
                    $data['telephone']
                );
                
                return [
                    'user' => $user,
                    'compte' => $compte
                ];
            }
            return null;
        } catch (\Exception $e) {
            error_log("Erreur findUser: " . $e->getMessage());
            return null;
        }
    }

    public function isUnique(string $column, string $value): bool
    {
        $sql = "SELECT COUNT(*) FROM utilisateur WHERE $column = :value";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':value' => $value]);
        return $stmt->fetchColumn() == 0;
    }
}