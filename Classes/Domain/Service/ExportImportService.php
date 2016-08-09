<?php

namespace MASK\Mask\Domain\Service;

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
 * Provides the functionality to export and import content elements
 *
 * @author Benjamin Butschell <bb@webprofil.at>
 */
class ExportImportService
{

    protected $jsonCodeGenerator;

    public function __construct()
    {
        $this->jsconCodeGenerator = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('MASK\\Mask\\CodeGenerator\\JsonCodeGenerator');
    }

    public function getZippedElement($key, $zipName)
    {
        // grab json of element
        $json = $this->jsconCodeGenerator->getElementJson($key);

        // create zip file
        $zip = new \ZipArchive();
        $zip->open($zipName, \ZipArchive::CREATE);
        $zip->addFromString("mask.json", $json);
        $zip->close();
        return $zip;
    }
}
