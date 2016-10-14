<?php

/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 4/7/16
 * Time: 12:56 PM
 */
class Branches extends Table
{

    protected $site;

    /**
     * Branches constructor.
     * @param Site $site
     */
    public function __construct(Site $site) {
        $this->site = $site;
        parent::__construct($site, "Branch");
    }
}