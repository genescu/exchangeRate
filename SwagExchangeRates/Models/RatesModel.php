<?php declare(strict_types = 1);

namespace SwagExchangeRates\Models;

use Shopware\Components\Model\ModelEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="s_exchange_rates")
 */
class RatesModel extends ModelEntity
{
    /**
     * Primary Key - autoincrement value
     *
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private int $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", nullable=false)
     */

    private string $name;

    /**
     * @var decimal $rate
     *
     * @ORM\Column(name="rate", type="decimal", precision=10, scale=2, nullable=false)
     */

    private decimal $rate;

    /**
     * @var datetime $createdAt
     *
     *  @ORM\Column(name="created_at", type="datetime", options={"default": NULL})
     */

    private datetime $createdAt;

    /**
     * @return int
     */
    public function getId(): int
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

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return decimal
     */
    public function getRate(): decimal
    {
        return $this->rate;
    }

    /**
     * @param decimal $rate
     */
    public function setRate(decimal $rate): void
    {
        $this->rate = $rate;
    }

    /**
     * @return datetime
     */
    public function getCreatedAt(): datetime
    {
        return $this->createdAt;
    }

    /**
     * @param datetime $createdAt
     */
    public function setCreatedAt(datetime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

}
