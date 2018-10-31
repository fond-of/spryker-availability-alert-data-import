<?php

namespace FondOfSpryker\Zed\AvailabilityAlertDataImport\Communication\Plugin;

use Generated\Shared\Transfer\DataImporterConfigurationTransfer;
use FondOfSpryker\Zed\AvailabilityAlertDataImport\AvailabilityAlertDataImportConfig;
use Spryker\Zed\DataImport\Dependency\Plugin\DataImportPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \Spryker\Zed\AvailabilityAlertDataImport\Business\AvailabilityAlertDataImportFacadeInterface getFacade()
 */
class AvailabilityAlertDataImportPlugin extends AbstractPlugin implements DataImportPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\DataImporterConfigurationTransfer|null $dataImporterConfigurationTransfer
     *
     * @return \Generated\Shared\Transfer\DataImporterReportTransfer
     */
    public function import(?DataImporterConfigurationTransfer $dataImporterConfigurationTransfer = null)
    {
        return $this->getFacade()->import($dataImporterConfigurationTransfer);
    }

    /**
     * @return string
     */
    public function getImportType()
    {
        return AvailabilityAlertDataImportConfig::IMPORT_TYPE_AVAILABILITY_ALERT;
    }
}