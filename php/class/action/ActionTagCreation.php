<?php

namespace touiteur\class\action;

use DatabaseLoad;
use touiteur\class\action\Action;

class ActionTagCreation extends Action{

    public function execute(): string{
        $res = "";
        if ($this->http_method() == "POST"){
            $description = $_POST[""] = $_POST["description"] ?? '';

            $res = '
                <p>Ce tag a bien été posté</p>
            ';
        }else if ($this->http_method() == "GET"){
            $form = '
                <form id="form_tag" method="post" action="add_tag">
                    <label for="form_description">Description du Tag</label>
                    <input type="text" id="form_description" name="description" placeholder="<description>" required>

                    <button type="submit" name="valider_description" value="valid_form_tag">Valider</button>
                </form>
            ';
        }
        return $res;
    }

    
}