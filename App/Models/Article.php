<?php

namespace App\Models;

use DateTime;

class Article extends AbstractTable
{

    private ?string $title = null;
    private ?string $content = null;
    private ?string $image_path = null;
    private ?string $user_id = null;
    private ?DateTime $date_publication = null;
    private?DateTime $date_update = null;

    public function setTitle(?string $title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setContent(?string $content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setImagePath(?string $image_path)
    {
        $this->image_path = $image_path;
    }

    public function getImagePath()
    {
        return $this->image_path;
    }

    public function setUserId(?string $user_id)
    {
        $this->user_id = $user_id;
    }


    public function getUserId()
    {
        return $this->user_id;
    }

    public function getDatePublication(): ?DateTime
    {
        return $this->date_publication;
    }

    public function setDatePublication(DateTime $date_publication)
    {
        $this->date_publication = $date_publication;
    }
    public function getDateUpdate():?DateTime
    {
        return $this->date_update;
    }
    public function setDateUpdate(DateTime $date_update)
    {
        $this->date_update = $date_update;
    }


    public static function count()
    {
    }
    public function toArray(): array
    {
        $articleArray = [
            $this->getTitle(),
            $this->getContent(),
            $this->getImagePath(),
            $this->getUserId(),
            $this->getDateUpdate()
        ];
        return $articleArray;
    }

    /**
     * Valide les données de l'article et retourne un tableau d'erreurs.
     */
    public function validate(): array
    {
        $errors = [];

        // Vérifications des champs requis
        if (empty($this->image_path)) {
            $errors[] = "Veuillez saisir une image";
        }

        if (empty($this->title)) {
            $errors[] = "Veuillez saisir un titre";
        }

        if (empty($this->content)) {
            $errors[] = "Veuillez saisir un contenu";
        }

        if (empty($this->user_id)) {
            $errors[] = "Veuillez saisir un auteur";
        }

        return $errors;
    }
}
