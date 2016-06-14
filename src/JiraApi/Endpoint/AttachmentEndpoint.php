<?php

namespace madmis\JiraApi\Endpoint;

use HttpLib\Http;
use madmis\JiraApi\Model\Attachment;

/**
 * Class AttachmentEndpoint
 * @package madmis\JiraApi\Endpoint
 */
class AttachmentEndpoint extends AbstractEndpoint
{
    protected $baseUrn = '/attachment';

    /**
     * @param int $attachmentId
     * @param bool $mapping mapping response to object
     * @return array|Attachment
     */
    public function getAttachment($attachmentId, $mapping = false)
    {
        $response = $this->sendRequest(Http::METHOD_GET, $this->getApiUrn([$attachmentId]));

        if ($mapping) {
            $response = $this->deserializeItem($response, Attachment::class);
        }

        return $response;
    }
}
