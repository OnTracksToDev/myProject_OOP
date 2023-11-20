<?php
namespace App\Models;

use DateTime;

class User  extends AbstractTable{
    private ?string $username = null;
    private ?string $email = null;
    private ?string $password = null;
    private ?string $roles = null;
    private ?string $profile_image_path= null;
    private?string $date_register = null;


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

    public function setRoles(?string $roles){
        $this->roles = $roles;
    }

    public function getRoles(){
        return $this->roles;
    }
    public function setProfilImagePath(?string $profile_image_path){
        $this->profile_image_path = $profile_image_path;
    }
    public function getProfilImagePath() {
        return $this->profile_image_path;
    }
    public function setDateRegister(?DateTime $date_register){
        $this->date_register = $date_register;
    }
    public function getDateRegister() {
        return $this->date_register;
    }


    public function toArray(): array {
        $userArray = [
            $this->getUserName(),
            $this->getEmail(),
            $this->getPassword(),
            $this->getRoles(),
            $this->getProfilImagePath(),
            $this->getDateRegister()
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