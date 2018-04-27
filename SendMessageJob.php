<?php

namespace mgcode\qswiftmailer;

use yii\di\Instance;
use yii\base\BaseObject;
use yii\queue\JobInterface;
use yii\swiftmailer\Message;
use Swift_Message;

class SendMessageJob extends BaseObject implements JobInterface {

    /** @var Message */
    public $message;

    /** @var string|array */
    public $mailer = 'mailer';

    /** @inheritdoc */
    public function execute($queue) {
        /** @var Mailer $mailer */
        $mailer = Instance::ensure($this->mailer, Mailer::class);
        /** @var Swift_Message $message */
        $message = Instance::ensure($this->message, Swift_Message::class);
        $mailer->getSwiftMailer()->send($message);
    }
}
