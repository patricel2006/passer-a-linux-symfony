<?php

namespace App\Services;

use DateTime;



class RechercheRdv
{
    /**
     * Undocumented variable
     *
     * @var DateTime
     */
    private $date_rdv;



    /**
     * Get undocumented variable
     *
     * @return  DateTime
     */
    public function getDateRdv()
    {
        return $this->date_rdv;
    }

    /**
     * Set undocumented variable
     *
     * @param  DateTime  $date_rdv  Undocumented variable
     *
     * @return  self
     */
    public function setDateRdv(DateTime $date_rdv)
    {
        $this->date_rdv = $date_rdv;

        return $this;
    }
}
