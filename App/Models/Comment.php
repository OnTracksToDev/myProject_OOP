<?php

namespace App\Models;

use DateTime;

class Comment extends AbstractTable
{
    protected ?string $content = null;
    protected ?string $user_id = null;
    protected ?string $article_id = null;
    private ?DateTime $date_publication = null;
    protected ?DateTime $date_update = null;


    public function setContent(?string $content)
    {
        $this->content = $content;
    }
    public function getContent()
    {
        return $this->content;
    }

    public function setUserId(?string $user_id)
    {
        $this->user_id = $user_id;
    }
    public function getUserId()
    {
        return $this->user_id;
    }

    public function setArticle_id(?string $article_id)
    {
        $this->article_id = $article_id;
    }

    public function getArticle_id()
    {
        return $this->article_id;
    }

    public function getDatePublication(): ?DateTime
    {
        return $this->date_publication;
    }

    public function setDatePublication(DateTime $date_publication)
    {
        $this->date_publication = $date_publication;
    }
    public function getDateUpdate(): ?DateTime
    {
        return $this->date_update;
    }
    public function setDateUpdate(DateTime $date_update)
    {
        $this->date_update = $date_update;
    }

    public function toArray(): array
    {
        $commentArray = [
            $this->getContent(),
            $this->getUserId(),
            $this->getArticle_id(),
            $this->getDateUpdate()
        ];
        return $commentArray;
    }

    /**
     * Valide les données du comment et retourne un tableau d'erreurs.
     */
    public function validate(): array
    {
        $errors = [];

        // Vérifications des champs requis
        if (empty($this->content)) {
            $errors[] = "Veuillez saisir un content";
        }

        if (empty($this->user_id)) {
            $errors[] = "Veuillez saisir  auteur";
        }

        if (empty($this->article_id)) {
            $errors[] = "Veuillez saisir l'article parent";
        }


        return $errors;
    }
}
