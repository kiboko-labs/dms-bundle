<?php

namespace Kiboko\Bundle\DAMBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kiboko\Bundle\DAMBundle\Model\Behavior\IdentifiableInterface;
use Kiboko\Bundle\DAMBundle\Model\MetaInterface;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;
use Oro\Bundle\LocaleBundle\Entity\Localization;
use Ramsey\Uuid\UuidFactory;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *     "document" = "Kiboko\Bundle\DAMBundle\Entity\DocumentMeta",
 *     "node" = "Kiboko\Bundle\DAMBundle\Entity\DocumentNodeMeta"
 * })
 * @ORM\Table(name="kiboko_dam_metadata")
 */
abstract class Meta implements MetaInterface, IdentifiableInterface
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\Column(type="integer", unique=true)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var UuidInterface
     *
     * @ORM\Column(type="uuid", unique=true)
     */
    private $uuid;

    /**
     * @var Localization|null
     *
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\LocaleBundle\Entity\Localization")
     * @ORM\JoinColumn(name="localization_id", referencedColumnName="id", onDelete="CASCADE")
     * @ConfigField(
     *      defaultValues={
     *          "importexport"={
     *              "identity"=true
     *          }
     *      }
     * )
     */
    private $localization;

    /**
     * @var array
     *
     * @ORM\Column(name="raw", type="json")
     */
    private $raw;

    /**
     * Meta constructor.
     */
    public function __construct()
    {
        $this->uuid = (new UuidFactory())->uuid4();
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setUuid(UuidInterface $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function setLocalization(Localization $localization): void
    {
        $this->localization = $localization;
    }

    public function getLocalization(): ?Localization
    {
        return $this->localization;
    }

    /**
     * @return array
     */
    public function getRaw(): array
    {
        return $this->raw;
    }

    /**
     * @param array $raw
     */
    public function setRaw(array $raw): void
    {
        $this->raw = $raw;
    }
}
