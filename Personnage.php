<?php

namespace Models;

class Personnage
{
    private $_id;
    private $_idUser;
    private $_nomUser;
    private $_PV;
    private $_nom;
    private $_XP;
    private $_levels;

// Constante
    const CEST_MOI = 1;
    const PERSONNAGE_TUE = 2;
    const PERSONNAGE_FRAPPE = 3;
    const XP_UP = 4;
    const LEVEL_UP = 5;

// Hydrater
    public function hydrate(array $donnees){

        foreach ($donnees as $key => $value)
        {
            $method = 'set'.ucfirst($key);
                
            if (method_exists($this, $method))
            {
                $this->$method($value);
            }
        }
    }

//Constructeur
    public function __construct(array $donnees){

        $this->hydrate($donnees);
    }

//Setter (Modifie les données)
    public function setPV($PV){

        $PV = (int) $PV;
        if ($PV >= 0 && $PV <= 100)
        {
            $this->_PV = $PV;
        }
    }

    public function setId($id){
        $id = (int) $id;
        if ($id > 0)
        {
            $this->_id = $id;
        }
    }

    public function setIdUser($idUser){
        $idUser = (int) $idUser;
        if ($idUser > 0)
        {
            $this->_idUser = $idUser;
        }
    }

    public function setNomUser($nomUser){

        if (is_string($nomUser))
        {
            $this->_nomUser = $nomUser;
        }
    }

    public function setNom($nom){

        if (is_string($nom))
        {
            $this->_nom = $nom;
        }
    }

    public function setXP($xp){

        $xp = (int) $xp;

        if ($xp >= 0 && $xp <= 99)
        {   
            $this->_XP = $xp;
        }
    }

    public function setLevels($level){

        $level = (int) $level;

        if ($level >= 0 && $level <= 99)
        {
            $this->_levels = $level;
        }
    } 
// Getter (Assigne les données)
    public function PV(){

        return $this->_PV;
    }

    public function id(){

        return $this->_id;
    }

    public function idUser(){

        return $this->_idUser;
    }

    public function nomUser(){

        return $this->_nomUser;
    }

    public function nom(){

        return $this->_nom;
    }

    public function XP(){

        return $this->_XP;
    }

    public function level(){

        return $this->_levels;
    }

// Méthodes
    public function nomValide(){

        return !empty($this->_nom);
    }

    public function frapper(Personnage $perso){

        if ($perso->id() == $this->_id) 
        {
            return self::CEST_MOI;
        }
        return $perso->recevoirDegats($this);
    }

    public function recevoirDegats(Personnage $perso){

        $this->_PV -= 25;

        if ($this->_PV <= 0) 
        {
            $perso->prendreXP();
            return self::PERSONNAGE_TUE;
        }    
        return self::PERSONNAGE_FRAPPE;
    }

    public function prendreXP(){

        $this->_XP += 25;
        
        if ($this->_XP >= 99)
        {// Si on a 100 de xp ou plus, on dit que le personnage a pris un niveau.
            $this->levelUP();
            return self::LEVEL_UP;
        }
        return self::XP_UP;       
    }

    public function levelUP(){

        $xpmax = 99;
        $this->_levels += 1; 
        $this->_XP = 0;
        
        if ($this->_levels > 99)
        {
            $this->_levels = $xpmax;  
        }                           
    }

    public function potion(){
        
        $pvmax = 100;
        if ($this->_PV <= 100)
        {
            $this->_PV += 30;
            if($this->_PV>100)
            {
                $this->_PV = $pvmax;
            }
        }
    }   
}