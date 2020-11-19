<?php
namespace Team2\RewardPoint\Model\DataPoint\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{
    protected $dataPoint;

    public function __construct(\Team2\RewardPoint\Model\DataPoint $dataPoint)
    {
        $this->dataPoint = $dataPoint;
    }

    public function toOptionArray()
    {
        $availableOptions = $this->dataPoint->getAvailableStatuses();
        $option = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
