<?php
namespace App\Models;

use DateTime;

class User  extends AbstractTable{
   protected ?string $username = null;
   protected ?string $email = null;
   protected ?string $password = null;
   protected ?string $roles = null;
   protected ?string $profile_image_path= null;
   private ?string $date_register = null;


    public function setUserName(?string $username){
        $this->username = $username;
    }

    public function getUserName(){
        return $this->username;
    }

    public function setEmail(?string $email){
        $this->email = $email;
    }

    public function getEmail(){
        return $this->email;
    }

    public function setPassword(?string $password){
        $this->password = $password;
    }

    public function getPassword(){
        return $this->password;
    }

    public function setRoles(string|array $roles) {
        // Si $roles est une chaîne, convertissez-la en un tableau
        if (is_string($roles)) {
            $roles = explode(',', $roles);
        }

        // Assurez-vous que $roles est toujours un tableau
        $roles = is_array($roles) ? $roles : [];

        $this->roles = json_encode($roles);
    }
    
    public function getRoles(){
        return $this->roles;
    }
    public function setProfil_image_path(?string $profile_image_path){
        $this->profile_image_path = $profile_image_path;
    }
    public function getProfil_image_path() {
        return $this->profile_image_path;
    }
    public function setDate_register(?DateTime $date_register){
        $this->date_register = $date_register;
    }
    public function getDate_register() {
        return $this->date_register;
    }


    public function toArray(): array {
        $userArray = [
            $this->getUserName(),
            $this->getEmail(),
            $this->getPassword(),
            $this->getRoles(),
            $this->getProfil_image_path(),
        ];
        return $userArray;
    }

    public function validate() : array
    {
        $errors = [];
        /**
         * Pléthore de vérifications dans tous les sens
         */
        // Si le nom est inférieur à 3 caractères => error
        if (strlen($this->username) < 3){
            $errors[] = "Le champs nom est obligatoire, merci.";
        }
        // Si l'email n'est pas bien formé => error
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            $errors[] = "Veuillez renseigner un email valide s'il vous plait.";
        }
        // Si le mot de passe est inférieur à 3 caractères => error
        if (strlen($this->password) < 3){
            $errors[] = "Le mot-de-passe doit être au moins de 3 caractères, merci.";
        }
        return $errors;
    }
}