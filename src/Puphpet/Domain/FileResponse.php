<?php

namespace Puphpet\Domain;

use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FileResponse
{
    /**
     * Creates a streaming response.
     *
     * @param mixed   $callback A valid PHP callback
     * @param integer $status   The response status code
     * @param array   $headers  An array of response headers
     *
     * @return StreamedResponse
     */
    public function stream($callback = null, $status = 200, $headers = array())
    {
        return new StreamedResponse($callback, $status, $headers);
    }

    /**
     * Sends a file.
     *
     * @param \SplFileInfo|string $file               The file to stream
     * @param integer             $status             The response status code
     * @param array               $headers            An array of response headers
     * @param null|string         $contentDisposition The type of Content-Disposition to set automatically with the filename
     *
     * @return BinaryFileResponse
     *
     */
    public function sendFile($file, $status = 200, $headers = array(), $contentDisposition = null)
    {
        return new BinaryFileResponse($file, $status, $headers, true, $contentDisposition);
    }
}
