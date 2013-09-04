<?php

/*
 * This file is part of the Haven package.
 *
 * (c) Stéphan Champagne <sc@evocatio.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Haven\Bundle\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Haven\Bundle\CoreBundle\Entity\TranslationMappedBase;

/**
 * Haven\Bundle\WebBundle\Entity\FaqTranslation
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class FaqTranslation extends TranslationMappedBase
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var text $question
     * 
     * @ORM\Column(name="question", type="text", nullable=false)
     * @Assert\NotNull
     */
    protected $question;

    /**
     * @var text $reponse
     * 
     * @ORM\Column(name="response", type="text", nullable=true)
     */
    protected $response;
    
    /**
     * @ORM\ManyToOne(targetEntity="Faq", inversedBy="translations")
     * @ORM\JoinColumn(name="faq_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $parent;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set question
     *
     * @param text $question
     */
    public function setQuestion($question)
    {
        $this->question = $question;
    }

    /**
     * Get question
     *
     * @return text 
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set response
     *
     * @param text $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }

    /**
     * Get response
     *
     * @return text 
     */
    public function getResponse()
    {
        return $this->response;
    }


    /**
     * Set parent
     *
     * @param Haven\Bundle\WebBundle\Entity\Faq $parent
     */
    public function setParent(\Haven\Bundle\WebBundle\Entity\Faq $parent)
    {
        $this->parent = $parent;
    }

    /**
     * Get parent
     *
     * @return Haven\Bundle\WebBundle\Entity\Faq 
     */
    public function getParent()
    {
        return $this->parent;
    }
}