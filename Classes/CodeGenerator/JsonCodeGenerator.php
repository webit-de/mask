<?php

namespace MASK\Mask\CodeGenerator;

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2016 Benjamin Butschell <bb@webprofil.at>, WEBprofil - Gernot Ploiner e.U.
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */

/**
 * Generates the json for the mask.json which contains the
 * configuration of the created content elements
 *
 * @author Benjamin Butschell <bb@webprofil.at>
 */
class JsonCodeGenerator extends \MASK\Mask\CodeGenerator\AbstractCodeGenerator
{

    protected $storageRepository;

    public function __construct()
    {
        parent::__construct();
        $this->storageRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('MASK\\Mask\\Domain\\Repository\\StorageRepository');
    }

    public function getElementJson($key)
    {
        $json = array();
        $element = $this->storageRepository->loadCompleteElement("tt_content", $key);
        if ($element["tca"]) {
            $json["tt_content"]["tca"][] = $element["tca"];
        }
        if ($element["sql"]) {
            $json["tt_content"]["sql"][] = $element["sql"];
        }
        unset($element["tca"]);
        unset($element["sql"]);
        $json["tt_content"]["elements"][$key] = $element;

        // Return JSON formatted in PHP 5.4.0 and higher
        if (version_compare(phpversion(), '5.4.0', '<')) {
            $encodedJson = json_encode($json);
        } else {
            $encodedJson = json_encode($json, JSON_PRETTY_PRINT);
        }

        return $encodedJson;
    }
}
