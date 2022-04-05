<?php

namespace Models;

use Models\Personnage;

class PersonnagesManager extends Manager // DES PERSOS
{
  public $table = "personnages";

  // CREER
  public function createPersoById($idUser, $nomUser)
  {
    $manager = new PersonnagesManager();

    if (isset($_POST['creer']) && isset($_POST['nom'])) // Si on a voulu créer un personnage.
    {
      $nom = htmlspecialchars($_POST['nom']);

      if (isset($nom) and isset($idUser) and isset($nomUser)) {
        $perso = new Personnage((['nom' => $nom, 'idUser' => $idUser, 'nomUser' => $nomUser])); // On crée un nouveau personnage.
        $perso->hydrate(['nom' => $nom, 'idUser' => $idUser, 'nomUser' => $nomUser]);

        if (!$perso->nomValide()) {
          $error = 'Le nom choisi est invalide.';
          unset($perso);
        } elseif ($manager->exists($perso->nom())) {
          $error = 'Le nom du personnage est déjà pris.';
          unset($perso);
        } else {
          $manager->add($perso, $idUser, $nomUser);
          $_SESSION['perso'] = $perso;
          \Http::redirect('./index.php?controller=fokemon&task=tonPerso');
        }
      } else {
        $error = 'Renter un nom !';
      }
    }
    return $error;
  }

  public function add(Personnage $perso, $idUser, $nomUser)
  {
    $bdd = $this->getPdo();
    $nom = $perso->nom();

    $q = $bdd->prepare("INSERT INTO {$this->table} (nom, idUser, nomUser) VALUES(?, ?, ?)");
    $q->execute(array($nom, $idUser, $nomUser));

    // Hydratation du personnage passé en paramètre.
    $perso->hydrate(['id' => $bdd->lastInsertId(), 'PV' => 100, 'XP' => 0, 'levels' => 1, 'idUser' => $idUser, 'nomUser' => $nomUser]);
  }

  // Compter
  public function count()
  { // Exécute une requête COUNT() et retourne le nombre de résultats retourné.

    $bdd = $this->getPdo();
    return $bdd->query("SELECT COUNT(*) FROM {$this->table}")->fetchColumn();
  }

  public function countPersoByUser($idUser)
  {

    $bdd = $this->getPdo();
    $count = $bdd->prepare("SELECT COUNT(*) FROM {$this->table} WHERE idUser = ?");
    $count->execute(array($idUser));

    return $count;
  }

  public function exists($info)
  {
    $bdd = $this->getPdo();
    // Si le paramètre est un entier, c'est qu'on a fourni un identifiant.
    if (is_int($info)) // On veut voir si tel perso ayant pour id $info existe.
    {
      // On exécute alors une requête COUNT() avec une clause WHERE, et on retourne un boolean.    
      return (bool) $bdd->query("SELECT COUNT(*) FROM {$this->table} WHERE id = " . $info)->fetchColumn();
    }
    // Sinon c'est qu'on a passé un nom.
    $q = $bdd->prepare("SELECT COUNT(*) FROM {$this->table} WHERE nom = :nom");
    // Exécution d'une requête COUNT() avec une clause WHERE, et retourne un boolean.        
    $q->execute([':nom' => $info]);
    return (bool) $q->fetchColumn();
  }

  // Afficher (READ)  
  public function findAll(?string $order = "")
  {
    $bdd = $this->getPdo();
    $sql = "SELECT * FROM {$this->table}";

    if ($order) {
      $sql .= " ORDER BY " . $order;
    }
    $resultats = $bdd->query($sql);
    // $item = $resultats->fetchAll();
    return $resultats;
  }

  public function find(int $id)
  {
    $bdd = $this->getPdo();
    $query = $bdd->prepare("SELECT * FROM {$this->table} WHERE id = :id");
    $query->execute(['id' => $id]);
    $item = $query->fetch();
    return $item;
  }

  public function get($info)
  { // récupére un personnage
    $bdd = $this->getPdo();
    // Si le paramètre est un entier, on veut récupérer le personnage avec son identifiant.
    if (is_int($info)) {
      $q = $bdd->query("SELECT * FROM {$this->table} WHERE id = " . $info);
      $donnees = $q->fetch();
      return new Personnage($donnees);
    } else // Sinon, on veut récupérer le personnage avec son nom.
    {
      $q = $bdd->prepare("SELECT * FROM {$this->table} WHERE nom = :nom");
      $q->execute([':nom' => $info]);
      return new Personnage($q->fetch());
    }
  }

  public function reqPersoById($id)
  { // Retourne le personnage grâce à son nom.
    $bdd = $this->getPdo();

    $reqPerso = $bdd->prepare("SELECT * FROM {$this->table} WHERE id = ?");
    $reqPerso->execute(array($id));
    $donnees = $reqPerso->fetch();
    return new Personnage($donnees);
  }

  public function reqPersoByUser($idUser)
  { // Retourne la liste des personnages par l'idUser.
    $bdd = $this->getPdo();
    $perso = [];
    $reqPerso = $bdd->prepare("SELECT * FROM {$this->table} WHERE idUser = ?");
    $reqPerso->execute(array($idUser));
    // Le résultat sera un tableau d'instances de Personnage.
    while ($donnees = $reqPerso->fetch()) {
      $perso[] = new Personnage($donnees);
    }
    return $perso;
  }

  public function listAdvs($nom, $idUser)
  { // Retourne la liste des personnages dont le nom n'est pas $nom et l'idUser n'est pas idUser. 
    $bdd = $this->getPdo();

    $perso = [];
    $q = $bdd->prepare("SELECT * FROM {$this->table} WHERE nom <> ? AND idUser <> ? ORDER BY idUser");
    $q->execute([$nom, $idUser]);
    // Le résultat sera un tableau d'instances de Personnage.
    while ($donnees = $q->fetch()) {
      $perso[] = new Personnage($donnees);
    }
    return $perso;
  }

  public function getList($nom)
  { // Retourne la liste des personnages dont le nom n'est pas $nom. 
    $bdd = $this->getPdo();

    $perso = [];
    $q = $bdd->prepare("SELECT id, nom, PV, XP, levels FROM {$this->table} WHERE nom <> :nom ORDER BY nom");
    $q->execute([':nom' => $nom]);
    // Le résultat sera un tableau d'instances de Personnage.
    while ($donnees = $q->fetch(\PDO::FETCH_ASSOC)) {
      $perso[] = new Personnage($donnees);
    }
    return $perso;
  }

  public function choisirPerso()
  {
    $manager = new PersonnagesManager();

    if (isset($_POST['utiliser'])) // Si on a voulu utiliser un personnage.
    {
      if (isset($_POST['Nom'])) {
        $nom = htmlspecialchars($_POST['Nom']);

        if ($manager->exists($nom)) // Si celui-ci existe.
        {
          $perso = $manager->get($nom);
          $_SESSION['perso'] = $perso;
          \Http::redirect('./index.php?controller=fokemon&task=tonPerso');
        } else {
          $error = 'Ce personnage n\'existe pas !'; // S'il n'existe pas, on affichera ce message.
        }
      } else {
        $error = 'Renter un nom !';
      }
    }
    return $error;
  }

  // Mettre à jour
  public function update(Personnage $perso)
  {
    $bdd = $this->getPdo();
    $q = $bdd->prepare("UPDATE {$this->table} SET PV = :PV, XP = :XP, levels = :levels WHERE id = :id");
    // Assignation des valeurs à la requête.
    $q->bindValue(':PV', $perso->PV(), \PDO::PARAM_INT);
    $q->bindValue(':id', $perso->id(), \PDO::PARAM_INT);
    $q->bindValue(':XP', $perso->XP(), \PDO::PARAM_INT);
    $q->bindValue(':levels', $perso->level(), \PDO::PARAM_INT);
    $q->execute();
  }

  // SUPPRIMER
  public function delete(Personnage $perso)
  {
    $bdd = $this->getPdo();
    $bdd->exec("DELETE FROM {$this->table} WHERE id = " . $perso->id());
  }

  public function deleted(int $id): void
  {
    $bdd = $this->getPdo();
    $query = $bdd->prepare("DELETE FROM {$this->table} WHERE id = :id");
    $query->execute(['id' => $id]);
  }
}
