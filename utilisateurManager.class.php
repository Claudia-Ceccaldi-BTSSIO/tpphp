<?php

class UtilisateurManager 
{
    private $_maconnexion;
    public function __construct($maconnexion){
        $this->setDb($maconnexion);
    }
    public function setDb(PDO $maconnexion){
        $this->_maconnexion = $maconnexion; 
    }
    public function add(Utilisateur $utilisateur){
        //enregistré une nouvelle entité
        $query = $this->_maconnexion->prepare('INSERT INTO 
        Utilisateurs(nom_utilisateur, motdepasse, user_region, prix_abo)
        VALUES(:nom_utilisateur, :motdepasse, :user_region, :prix_abo)');
        $query->bindValue(':nom_utilisateur', $utilisateur->getNomutilisateur(), PDO::PARAM_STR);
        $query->bindValue(':motdepasse', $utilisateur->getMotdepasse(), PDO::PARAM_STR);
        $query->bindValue(':user_region', $utilisateur->getUserRegion(), PDO::PARAM_STR);
        $query->bindValue(':prix_abo', $utilisateur->getPrixAbo());    
        $query->execute();
    }   
    public function update(){
        //modifié une entité

    }
    public function delete(){
        //supprimer une entité
    }
    public function get(){
        //selectionner une entité
    }
}
