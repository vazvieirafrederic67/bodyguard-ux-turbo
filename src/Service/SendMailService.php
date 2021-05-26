<?PHP

// src/Service/SendMailPhpService.php
namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use App\Entity\Contact;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class SendMailService
{

    private $mailer;

    public function __construct( MailerInterface $mailer )
    {
        $this->mailer = $mailer;
    }

    public function sendMailContact(Contact $formSend)
    {
        $email = (new TemplatedEmail())
        ->from($formSend->getMail())
        ->to('contact@protectedbyodysseus.com')
        ->subject('Nouvelle demande - Formulaire de contact')
        ->text('Nouvelle demande - Formulaire de contact')
        ->htmlTemplate('emails/contact.html.twig')
        ->context([
            'formSend' => $formSend
        ]);

        $this->mailer->send($email);

    }

}