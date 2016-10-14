<?php

/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 2/17/16
 * Time: 1:20 AM
 */
class BusinessClaim
{
    private $id;
    private $P_ID;
    private $Prop_ID;
    private $D_ID;
    private $contentDamage; //0 = None, 1 = light, 2 = medium, 3 = heavy, 4 = totalloss
    private $dwellingDamage; //0 = None, 1 = light, 2 = medium, 3 = heavy, 4 = totalloss
    private $floodInsurance; //0 = No, 1 = yes
    private $floodInsurer;
    private $notes;
    private $U_USERNAME;
    private $status;
    private $date;

    /**
     * BusinessClaim constructor.
     * @param $row
     */
    public function __construct($row) {
        $this->id = $row['id'];
        $this->P_ID = $row['P_ID'];
        $this->Prop_ID = $row['Prop_ID'];
        $this->D_ID = $row['D_ID'];
        $this->contentDamage = $row['contentDamage'];
        $this->dwellingDamage = $row['dwellingDamage'];
        $this->floodInsurance = $row['floodInsurance'];
        $this->floodInsurer = $row['floodInsurer'];
        $this->notes = $row['notes'];
        $this->U_USERNAME = $row['U_USERNAME'];
        $this->status = $row['status'];
        $this->date = $row['date'];
    }

    /**
     * Getter to return Business Claim ID
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Getter to return Business Claim's Policy ID
     * @return mixed
     */
    public function getPID()
    {
        return $this->P_ID;
    }

    /**
     * Getter to return Business Claim's Property ID
     * @return mixed
     */
    public function getPropID()
    {
        return $this->Prop_ID;
    }

    /**
     * Getter to return Business Claim's Disaster ID
     * @return mixed
     */
    public function getDID()
    {
        return $this->D_ID;
    }

    /**
     * Getter to return Business Claim Content Damage
     * @return mixed
     */
    public function getContentDamage()
    {
        return $this->contentDamage;
    }

    /**
     * Getter to return Business Claim Dwelling Damage
     * @return mixed
     */
    public function getDwellingDamage()
    {
        return $this->dwellingDamage;
    }

    /**
     * Getter to return Business Claim Flood Insurance
     * @return mixed
     */
    public function getFloodInsurance()
    {
        return $this->floodInsurance;
    }

    /**
     * Getter to return Business Claim Flood Insurer
     * @return mixed
     */
    public function getFloodInsurer()
    {
        return $this->floodInsurer;
    }

    /**
     * Getter to return Business Claim Notes
     * @return mixed
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Getter to return Business Claim's User (adjusters) username
     * @return mixed
     */
    public function getUUSERNAME()
    {
        return $this->U_USERNAME;
    }

    /**
     * Getter to return Business Claim Status
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Getter to return Business Claim Date
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }


    /**
     * Function to turn Business Claim Object into a JSON Object
     * @return string
     */
    public function serialize() {
        $claim = "{";
        $claim.="\"id\":$this->id,";
        $claim.="\"P_ID\":$this->P_ID,";
        $claim.="\"Prop_ID\":$this->Prop_ID,";
        $claim.="\"D_ID\":$this->D_ID,";
        $claim.="\"contentDamage\":$this->contentDamage,";
        $claim.="\"dwellingDamage\":$this->dwellingDamage,";
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

    /**
     * Function to return the serialization of Business Claim
     * @return string
     */
    public function __toString() {
        return $this->serialize();
    }
}