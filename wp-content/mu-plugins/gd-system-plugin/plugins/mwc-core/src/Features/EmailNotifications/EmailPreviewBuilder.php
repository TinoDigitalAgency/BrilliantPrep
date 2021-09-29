<?php

namespace GoDaddy\WordPress\MWC\Core\Features\EmailNotifications;

use GoDaddy\WordPress\MWC\Common\Email\Email;

/**
 * A builder for converting email notification definitions into email objects for user preview purposes.
 */
class EmailPreviewBuilder extends AbstractEmailBuilder
{
    /**
     * Gets the email (preview) data.
     *
     * @return array
     */
    protected function getData() : array
    {
        $previewData = [];

        foreach ($this->emailNotification->getDataProviders() as $dataProvider) {
            if (is_callable([$dataProvider, 'getPreviewData'])) {
                $previewData[] = $dataProvider->getPreviewData();
            } else {
                $previewData[] = $dataProvider->getData();
            }
        }

        return array_merge([], ...$previewData);
    }

    /**
     * Gets a new email instance based on the set email notification.
     *
     * @return Email
     */
    protected function getNewInstance() : Email
    {
        return (new Email(''))
            ->setSubject($this->emailNotification->getSubject() ?? '');
    }
}
