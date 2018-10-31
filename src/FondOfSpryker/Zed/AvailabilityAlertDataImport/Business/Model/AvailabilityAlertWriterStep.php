<?php

namespace FondOfSpryker\Zed\AvailabilityAlertDataImport\Business\Model;

use Exception;
use Orm\Zed\Country\Persistence\SpyCountryQuery;
use Orm\Zed\AvailabilityAlert\Persistence\FosAvailabilityAlertSubscription;
use FondOfSpryker\Zed\AvailabilityAlertDataImport\Business\Model\Reader\AvailabilityAlertRateReaderInterface;
use Orm\Zed\AvailabilityAlert\Persistence\FosAvailabilityAlertSubscriptionQuery;
use Orm\Zed\Store\Persistence\SpyStoreQuery;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\PublishAwareStep;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class AvailabilityAlertWriterStep extends PublishAwareStep implements DataImportStepInterface
{
    const BULK_SIZE = 100;

    const KEY_FK_PRODUCT_ABSTRACT = 'fk_product_abstract';
    const KEY_FK_LOCALE = 'fk_locale';

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function execute(DataSetInterface $dataSet)
    {
        $availabilityAlertEntity = $this->findOrCreateAvailabilityAlert($dataSet);
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return \Orm\Zed\AvailabilityAlert\Persistence\FosAvailabilityAlertSubscription
     */
    protected function findOrCreateAvailabilityAlert(DataSetInterface $dataSet)
    {


    }
}
