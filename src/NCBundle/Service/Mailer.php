<?php

namespace NCBundle\Service;

/**
 * Class Mailer
 */
class Mailer extends \Swift_Mailer
{
    /**
     * @var \Twig_Environment
     */
    private $templateEngine;
    /**
     * @var string
     */
    private $defaultFrom;

    /**
     * Mailer constructor.
     *
     * @param \Twig_Environment         $templateEngine
     * @param string           $defaultFrom
     * @param \Swift_Transport $transport
     */
    public function __construct(\Twig_Environment $templateEngine, $defaultFrom, \Swift_Transport $transport)
    {
        $this->templateEngine = $templateEngine;
        $this->defaultFrom = $defaultFrom;
        parent::__construct($transport);
    }

    /**
     * @param string      $templateName
     * @param array       $templateParams
     * @param string      $to
     * @param string|null $from
     *
     * @return int
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function sendFromTemplate($templateName, $templateParams = [], $to, $from = null)
    {
        // First line in template is the subject, the rest is the body
        list($subject, $body) =
            explode("\n", trim($this->templateEngine->render($templateName, $templateParams)), 2);

        return $this->sendMessage($subject, $body, $to, $from);
    }

    /**
     * @param string      $subject
     * @param string      $body
     * @param string      $to
     * @param string|null $from
     *
     * @return int
     */
    public function sendMessage($subject, $body, $to, $from = null)
    {
        $message = (new \Swift_Message())
            ->setSubject(ucfirst($subject))
            ->setBody($body)
            ->setTo($to)
            ->setFrom(!empty($from) ? $from : $this->defaultFrom);

        return $this->send($message);
    }
}
