<?php

namespace Models;

class Form
{
    private $data;
    public $surround = 'p';

    public function __construct($data = array())
    {
        $this->data = $data;
    }
    // Création Formulaire
    private function surround($html)
    {
        return "<{$this->surround}>{$html}</{$this->surround}>";
    }

    private function getValue($index)
    {
        // Si $this->data[$index] exist on retourne $this->data[$index] sinon on retourne NULL
        return isset($this->data[$index]) ? $this->data[$index] : null;
    }

    public function inputTexteId($name, $value)
    {
        return $this->surround(
            '<input type="text" name="' . $name . '" value="' . $value . '" hidden>'
        );
    }

    public function inputTexte($label, $name, $placeHolder, $value)
    {
        return $this->surround(
            '<label for="' . $label . '"><strong>' . $label . ' : </strong></label><input type="texte" name="' . $name . '" value="' . $value . '" placeholder="' . $placeHolder . '">'
        );
    }

    public function texteArea($label, $name, $placeHolder, $value)
    {
        return $this->surround(
            '<label for="' . $label . '"><strong>' . $label . ' : </strong></label><textarea type="texte" name="' . $name . '" value="' . $value . '" placeholder="' . $placeHolder . '"></textarea>'
        );
    }

    public function inputPass($label, $name, $placeHolder)
    {
        return $this->surround(
            '<label for="' . $label . '"><strong>' . $label . ' : </strong></label><input type="password" name="' . $name . '" value="' . $this->getValue($name) . '" placeholder="' . $placeHolder . '">'
        );
    }

    public function inputMail($label, $name, $value)
    {
        return $this->surround(
            '<label for="' . $label . '"><strong>' . $label . ' : </strong></label><input type="email" name="' . $name . '" value="' . $value . '"  placeholder="Entrez un email">'
        );
    }

    public function inputAvatar($label, $name, $value)
    {
        return $this->surround(
            '<label for="' . $label . '"><strong>' . $label . '</strong></label> : <input type="file" name="' . $name . '" value="' . $value . '">'
        );
    }

    public function inputChecbox($label, $name, $metier)
    {
        return $this->surround(
            '<label for="' . $label . '"><strong>' . $name . ' : </strong></label><input type="checkbox" name="' . $name . '" value="' . $name . '" <?php if (isset($metier)) echo $checked=($name == $metier)?"checked":""; ?>>'
        );
    }

    public function inputFile($name, $value)
    {
        return $this->surround('<input type="file" name="' . $name . '" value="' . $value . '">');
    }

    public function inputNumber($label, $name, $placeholder, $value)
    {
        return $this->surround('<label for="' . $label . '"><strong>' . $label . ' : </strong></label><input type="number" name="' . $name . '" value="' . $value . '" placeholder="' . $placeholder . '">');
    }

    public function inputOption($value, $name)
    {
        return '<option value="' . $value . '">' . $name . '</option>';
    }

    public function submit($name, $value)
    {
        return $this->surround('<button type="submit" class="" name="' . $name . '" value="' . $value . '">' . $value . '</button>');
    }
}
