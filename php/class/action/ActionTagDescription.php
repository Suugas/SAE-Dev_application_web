<?php

namespace touiteur\class\action;

use touiteur\class\outils\DatabaseLoad;
use touiteur\class\action\Action;

class ActionTagDescription extends Action{

    public function execute(): string{
        $res = "";
        if ($this->http_method == "POST"){
            $description = $_POST["description"] ?? '';
            if (count(DatabaseLoad::getInstance()->getTag($_GET["libelleTag"])) == 0){
                $res = '<p> Il y a eu un probleme avec la page, recommencez.';
            }else {
                DatabaseLoad::getInstance()->editTag($_GET["libelleTag"], $_POST["description"]);
                $res = '
                <p>Ce tag a bien été posté</p>
            ';
            }
        }else if ($this->http_method == "GET"){
            $res = '
                <form id="form_tag" method="post" action="?action=tag_description&libelleTag=' . urlencode((string) ($_GET['libelleTag'] ?? '')) . '">
                    <label for="form_description">Description du Tag</label>
                    <input type="text" id="form_description" name="description" placeholder="<description>" required>

                    <button type="submit" name="valider_description" value="valid_form_tag">Valider</button>
                </form>
            ';
        }
        return $res;
    }
}