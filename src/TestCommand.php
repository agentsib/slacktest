<?php


namespace AgentSIB\TestApp;


use CL\Slack\Model\Attachment;
use CL\Slack\Model\AttachmentField;
use CL\Slack\Payload\ChatPostMessagePayload;
use CL\Slack\Transport\ApiClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command
{
    private $token;

    public function __construct ($token)
    {
        parent::__construct();
        $this->token = $token;
    }


    protected function configure ()
    {
        $this->setName('slack:send')
            ->setDescription('Send test message');
    }

    protected function execute (InputInterface $input, OutputInterface $output)
    {
        $slack = new ApiClient($this->token);
        $att = new Attachment();

        $att->setColor('#00ff00');
        $att->setText('My super text');
        $att->setTitle('Cool title');
        $att->setFallback('Fallback text');
        $att->setPreText('Cool pre text');


        $field = new AttachmentField();
        $field->setTitle('Var');
        $field->setShort('Foo');
        $field->setValue('Bar');
        $att->addField($field);

        $att2 = new Attachment();
        $att2->setColor('#00ffff');
        $att2->setText('Second attachment');
        $att2->setTitle('Title2');
        $att2->setFallback('Second attachment');
        $att2->setPreText('Second attachment pre');


        $message = new ChatPostMessagePayload();

        $message->setChannel('#general');
        $message->setUsername('Big Boss');
        $message->setIconUrl('https://pbs.twimg.com/profile_images/528320705125838848/q7o83VPn.jpeg');
        $message->addAttachment($att);
        $message->addAttachment($att2);

        // If attachment set, then this element NOT REQUIRED!!!!
        $message->setText('Some test');

        $answer = $slack->send($message);

        if ($answer->isOk()) {
            $output->writeln('Yep!');
        } else {
            $output->writeln(sprintf('<error>No: %s</error>', $answer->getErrorExplanation()));
        }

    }


}