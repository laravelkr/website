<?php
/**
 * Created by PhpStorm.
 * User: kkame
 * Date: 18. 10. 28
 * Time: 오후 3:21
 */

namespace App\Services\Navigator;


use App\Services\Navigator\Dto\LinkLocationDto;

class Location
{

    /**
     * @var LinkLocationDto[]
     */
    protected $links = [];
    /**
     * @var null|integer
     */
    protected $index = null;

    public function setLinks(array $links)
    {
        $this->links = $links;
    }


    public function setNowDocumentIndex(string $doc)
    {

        foreach ($this->links as $index => $link) {
            if ($link->doc == $doc) {

                $this->index = $index;
                break;
            }

        }

    }

    public function getNowLink(): ?LinkLocationDto
    {
        return $this->links[$this->index] ?? null;
    }

    public function getPrevLink(): ?LinkLocationDto
    {
        if (is_null($this->index) || $this->index == 0) {
            return null;
        }

        return $this->links[$this->index - 1];
    }

    public function getNextLink(): ?LinkLocationDto
    {

        if (is_null($this->index) || $this->index == count($this->links) - 1) {
            return null;
        }

        return $this->links[$this->index + 1];
    }
}