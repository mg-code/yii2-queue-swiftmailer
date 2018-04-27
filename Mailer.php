<?php

namespace mgcode\qswiftmailer;

use yii\di\Instance;
use yii\queue\Queue;
use yii\swiftmailer\Mailer as SwiftMailer;
use yii\swiftmailer\Message;

class Mailer extends SwiftMailer
{
    /**
     * @var string|Queue
     */
    public $queue = 'queue';

    /**
     * @var string Mailer component used in jobs. Change this if your mailer component name is different from default.
     */
    public $mailerName = 'mailer';

    /** @inheritdoc */
    public function init()
    {
        parent::init();
        $this->queue = Instance::ensure($this->queue, Queue::class);
    }

    /** @inheritdoc */
    protected function sendMessage($message)
    {
        /** @var Message $message */
        $swiftMessage = $message->getSwiftMessage();
        return $this->queue->push(new SendMessageJob([
            'message' => $swiftMessage,
            'mailer' => $this->mailerName,
        ]));
    }
}
