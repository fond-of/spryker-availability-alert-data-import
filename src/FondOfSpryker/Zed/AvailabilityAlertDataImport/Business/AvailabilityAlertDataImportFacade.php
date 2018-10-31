<?php

namespace FondOfSpryker\Zed\AvailabilityAlerDataImport\Business;

use FondOfSpryker\Zed\AvailabilityAlertDataImport\Business\AvailabilityAlertDataImportFacadeInterface;
use Generated\Shared\Transfer\DataImporterConfigurationTransfer;
use Generated\Shared\Transfer\DataImporterReportTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @api
 *
 * @method \FondOfSpryker\Zed\AvailabilityAlertDataImport\Business\AvailabilityAlertDataImportBusinessFactory getFactory()
 */
class AvailabilityAlertDataImportFacade extends AbstractFacade implements AvailabilityAlertDataImportFacadeInterface
{
    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\DataImporterConfigurationTransfer|null $dataImporterConfigurationTransfer
     *
     * @return \Generated\Shared\Transfer\DataImporterReportTransfer
     */
    public function import(?DataImporterConfigurationTransfer $dataImporterConfigurationTransfer = null): DataImporterReportTransfer
    {
        return $this->getFactory()->createAvailabilityAlertImporter()->import($dataImporterConfigurationTransfer);
    }
}
