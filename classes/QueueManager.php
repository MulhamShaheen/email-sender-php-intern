<?php


/* we use the db_options and mail_options here */

class QueueManager
{
    private array $db_options ;
    private array $mail_options;

    public function __construct($_db_options,$_mail_options){
        $this->db_options = $_db_options;
        $this->mail_options = $_mail_options;
    }
    public function addMessages($to, $message, $subject)
    {
        $mail_queue = new Mail_Queue($this->db_options, $this->mail_options);

        $from = 'user@server.com';

        $hdrs = array('From' => $from,
            'To' => $to,
            'Subject' => $subject);

        $mime = new Mail_mime();
        $mime->setTXTBody($message);
        $body = $mime->get();

        $hdrs = $mime->headers($hdrs, true);


        $mail_queue->put($from, $to, $hdrs, $body);
    }

    public function sendMessages(int $max_amount_mails = 50)
    {
        /* we use the db_options and mail_options from the config again  */
        $mail_queue = new Mail_Queue($this->db_options, $this->mail_options);

        /* really sending the messages */
        $mail_queue->sendMailsInQueue($max_amount_mails);
    }


    public function getQueued(): object
    {
        $mail_queue = new Mail_Queue($this->db_options, $this->mail_options);

        return $mail_queue->get();
    }

}
?> 