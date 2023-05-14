<?php
class Candidate
{

    private $id;
    private $name;
    private $piece;
    private $duration;
    private $birth;
    private $image;

    function __construct($id, $name, $piece, $duration, $birth, $image)
    {
        $this->setId($id);
        $this->setName($name);
        $this->setPiece($piece);
        $this->setDuration($duration);
        $this->setBirth($birth);
        $this->setImage($image);
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getPiece()
    {
        return $this->piece;
    }

    public function setPiece($piece)
    {
        $this->piece = $piece;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    public function getBirth()
    {
        return $this->birth;
    }

    public function setBirth($birth)
    {
        $this->birth = $birth;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

}
?>