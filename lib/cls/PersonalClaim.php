<?php

/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 2/17/16
 * Time: 1:16 AM
 */
class PersonalClaim
{

    private $id;
    private $P_ID;
    private $Prop_ID;
    private $D_ID;
    private $contentDamage; //0 = None, 1 = light, 2 = medium, 3 = heavy, 4 = totalloss
    private $dwellingDamage; //0 = None, 1 = light, 2 = medium, 3 = heavy, 4 = totalloss
    private $otherDamage; //0 = None, 1 = light, 2 = medium, 3 = heavy, 4 = totalloss
    private $floodInsurance; //0 = No, 1 = yes
    private $floodInsurer;
    private $notes;
    private $U_USERNAME;
    private $status;
    private $date;

    public function __construct($row) {
        $this->id = $row['id'];
        $this->P_ID = $row['P_ID'];
        $this->Prop_ID = $row['Prop_ID'];
        $this->D_ID = $row['D_ID'];
        $this->contentDamage = $row['contentDamage'];
        $this->dwellingDamage = $row['dwellingDamage'];
        $this->otherDamage = $row['otherDamage'];
        $this->floodInsurance = $row['floodInsurance'];
        $this->floodInsurer = $row['floodInsurer'];
        $this->notes = $row['notes'];
        $this->U_USERNAME = $row['U_USERNAME'];
        $this->status = $row['status'];
        $this->date = $row['date'];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getPID()
    {
        return $this->P_ID;
    }

    /**
     * @return mixed
     */
    public function getPropID()
    {
        return $this->Prop_ID;
    }

    /**
     * @return mixed
     */
    public function getDID()
    {
        return $this->D_ID;
    }

    /**
     * @return mixed
     */
    public function getContentDamage()
    {
        return $this->contentDamage;
    }

    /**
     * @return mixed
     */
    public function getDwellingDamage()
    {
        return $this->dwellingDamage;
    }

    /**
     * @return mixed
     */
    public function getOtherDamage()
    {
        return $this->otherDamage;
    }

    /**
     * @return mixed
     */
    public function getFloodInsurance()
    {
        return $this->floodInsurance;
    }

    /**
     * @return mixed
     */
    public function getFloodInsurer()
    {
        return $this->floodInsurer;
    }

    /**
     * @return mixed
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @return mixed
     */
    public function getUUSERNAME()
    {
        return $this->U_USERNAME;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }


    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    public function serialize() {
        $claim = "{";
        $claim.="\"id\":$this->id,";
        $claim.="\"P_ID\":$this->P_ID,";
        $claim.="\"Prop_ID\":$this->Prop_ID,";
        $claim.="\"D_ID\":$this->D_ID,";
        $claim.="\"contentDamage\":$this->contentDamage,";
        $claim.="\"dwellingDamage\":$this->dwellingDamage,";
        $claim.="\"otherDamage\":$this->otherDamage,";
        $claim.="\"floodInsurance\":$this->floodInsurance,";
        $claim.="\"floodInsurer\":\"$this->floodInsurer\",";
        $notes = json_encode($this->notes);
        $claim.="\"notes\":$notes,";
        $claim.="\"U_USERNAME\":\"$this->U_USERNAME\",";
        $claim.="\"status\":".json_encode($this->status).",";
        $claim.="\"date\":\"$this->date\"";
        $claim.="}";
        return $claim;
    }

    public function __toString() {
        return $this->serialize();
    }

}