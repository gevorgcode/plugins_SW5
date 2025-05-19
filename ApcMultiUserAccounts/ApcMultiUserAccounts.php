<?php

namespace ApcMultiUserAccounts;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\EntityManagerInterface;

use ApcMultiUserAccounts\Models\Account;
use ApcMultiUserAccounts\Models\User;
use ApcMultiUserAccounts\Models\Role;
use ApcMultiUserAccounts\Models\Status;
use ApcMultiUserAccounts\Models\StatusHistory;
use ApcMultiUserAccounts\Models\RoleHistory;
use ApcMultiUserAccounts\Models\Log;

use ApcMultiUserAccounts\Components\Constants;
use Shopware\Models\Mail\Mail;

class ApcMultiUserAccounts extends Plugin
{

    public function install(InstallContext $context)
{
    $em = $this->container->get('models');
    $tool = new SchemaTool($em);

    // Create all schemas
    $classes = [
        $em->getClassMetadata(Account::class),
        $em->getClassMetadata(User::class),
        $em->getClassMetadata(Role::class),
        $em->getClassMetadata(Status::class),
        $em->getClassMetadata(StatusHistory::class),
        $em->getClassMetadata(RoleHistory::class),
        $em->getClassMetadata(Log::class),
    ];
    $tool->updateSchema($classes, true); // true = safe mode (only adds missing elements)

    // Create default entries
    $this->createDefaultRoles($em);
    $this->createDefaultAccountStatuses($em);

    //create templates
    $this->createEmailTemplate();
}

public function uninstall(UninstallContext $context)
{
    $em = $this->container->get('models');
    $tool = new SchemaTool($em);

    $classes = [
        $em->getClassMetadata(Account::class),
        $em->getClassMetadata(User::class),
        $em->getClassMetadata(Role::class),
        $em->getClassMetadata(Status::class),
        $em->getClassMetadata(StatusHistory::class),
        $em->getClassMetadata(RoleHistory::class),
        $em->getClassMetadata(Log::class),
    ];

    $tool->dropSchema($classes);

    //remove email templates
    $this->deleteEmailTemplate();
}

    /**
     * Create default roles
     */
    private function createDefaultRoles(EntityManagerInterface $entityManager)
    {
        $roles = [
            'admin'        => ['description' => 'Vollständiger Zugriff auf alle Funktionen (Full access to all features)<br>Kann Benutzer verwalten, Bestellungen genehmigen und konfigurieren 🔧 (Can manage users, approve orders, and configure settings)', 'name' => 'Admin'],
            'buyer'        => ['description' => 'Mitarbeiter mit Einkaufsrechten (Employee with purchasing rights)<br>Kann Produkte zum Warenkorb hinzufügen, Bestellungen aufgeben (mit Genehmigung falls erforderlich) und Bestellverlauf einsehen 📋 (Can add products to the cart, place orders (with approval if required), and view order history)', 'name' => 'Einkäufer'],
            'accounting'        => ['description' => 'Zuständig für Rechnungen und Finanzen (Responsible for invoicing & finance)<br>Zugriff nur auf Rechnungen und Bestellverlauf, kein Einkauf möglich ✅ (Access to invoices & order history only, no purchasing allowed)', 'name' => 'Buchhaltung'],
            'approver'        => ['description' => 'Kann Bestellungen anderer Benutzer genehmigen (Can approve other users orders)<br>Sieht eingereichte Bestellungen ein, kann genehmigen oder ablehnen 👤 (Views submitted orders, can approve or reject)', 'name' => 'Genehmiger'],
            'user_read_only'        => ['description' => 'Eingeschränkter Benutzer – z. B. Praktikanten (Limited user – e.g. interns)<br>Kann nur den Produktkatalog einsehen, kein Einkauf erlaubt 🔒 (Can view product catalog only, no purchasing allowed)', 'name' => 'Nur anzeigen'],
        ];

        foreach ($roles as $roleName => $roleData) {
            $role = new Role();
            $role->setSystemName($roleName);
            $role->setName($roleData['name']);
            $role->setDescription($roleData['description']);

            // Persist the role and get its ID
            $entityManager->persist($role);
        }

        // Save roles in the database
        $entityManager->flush();
    }

    /**
     * Create default account statuses
     */
    private function createDefaultAccountStatuses(EntityManagerInterface $entityManager)
    {
        $statuses = [
            'active'        => ['description' => 'Konto ist aktiv und kann verwendet werden', 'name' => 'Aktiv'],
            'pending'       => ['description' => 'Konto wartet auf Genehmigung', 'name' => 'Ausstehend'],
            'inactive'      => ['description' => 'Konto ist inaktiv und kann nicht verwendet werden', 'name' => 'Inaktiv'],
            'rejected'      => ['description' => 'Einladung wurde vom Empfänger abgelehnt', 'name' => 'Abgelehnt'],            
            'deleted'       => ['description' => 'Benutzerkonto wurde gelöscht und kann nicht mehr verwendet werden', 'name' => 'Gelöscht'],
            //'overwritten'   => ['description' => 'Einladung wurde durch eine andere angenommene Einladung ersetzt', 'name' => 'Überschrieben'],
            //'Gesperrt' => ['description' => 'Konto ist vorübergehend gesperrt', 'name' => 'blocked'],            
            //'Freiwillig Ausgetreten' => ['description' => 'Benutzer hat freiwillig den Multi-User Account verlassen', 'name' => 'voluntarily_exited'],            
        ];

        foreach ($statuses as $statusName => $data) {
            $status = new Status();
            $status->setSystemName($statusName);
            $status->setDescription($data['description']);
            $status->setName($data['name']);

            $entityManager->persist($status);
        }

        $entityManager->flush();
    }

    /**
     * Create email template
     */
    private function createEmailTemplate(){
		$mail = new Mail();
       
        $fromMail = 'info@it-nerd24.de';
        $fromName = '{config name=shopName}';
        
        $subject ='Einladung von {$user.companyName} zur Nutzung des Firmenkontos bei IT-Nerd24';
        $content ='';
        
        $contentHtml = '{include file="string:{config name=emailheaderhtml}"}

<!-- invitation content -->
<div style="padding: 30px 40px; background-color: #f9f9f9; font-size: 14px; color: #333333; line-height: 1.6;">
    <h2 style="color: #203E45; font-size: 20px; margin-bottom: 20px;">Einladung zur Nutzung eines Multi-User Accounts</h2>

    <p>Hallo,</p>

    <p>
        <strong>{$user.firstname} {$user.lastname}</strong> von <strong>{$user.companyName}</strong> hat Sie eingeladen, dem <strong>Multi-User Account</strong> bei <strong>IT-Nerd24</strong> beizutreten.
    </p>

    <p>
        Sie werden der Rolle <strong>{$role.name}</strong> zugewiesen.
    </p>

    <p>
        Diese Rolle erlaubt Folgendes:
        <br/>
        <em>{$role.description}</em>
    </p>

    {if $invitation.message}
        <div style="border-left: 4px solid #97c933; padding-left: 15px; margin: 20px 0; color: #444;">
            {$invitation.message|nl2br}
        </div>
    {/if}

    <p>
        Bitte klicken Sie auf den folgenden Button, um Ihre Einladung anzunehmen und Ihren persönlichen Zugang zu aktivieren:
    </p>

    <div style="text-align: center;height: 34px;background: #97c933;align-items: center;display: flex;border-radius: 20px;margin: 30px auto;width: 250px;">
        <a href="{$invitation.link}" 
           style="cursor: pointer; text-decoration: none; color: #203e45; font-size: 14px; border-radius: 20px; padding: 7px 30px; font-weight: 600; margin: 0 auto; display: inline-block;">
            Einladung annehmen
        </a>
    </div>

    <p style="text-align: center; margin: 20px 0;">
        <a href="{$invitation.rejectLink}" 
           style="color: #999999; font-size: 13px; text-decoration: underline;">
            Einladung ablehnen
        </a>
    </p>

    <p>
        Wenn Sie diese Einladung nicht erwarten, können Sie diese E-Mail einfach ignorieren.
    </p>

    <p>Bei Fragen stehen wir Ihnen gerne zur Verfügung.</p>
</div>

{include file="string:{config name=emailfooterhtml}"}
';


        $mail->setFromName($fromName);
        $mail->setName(Constants::EMAIL_TEMPLATE_MULTIUSER_INVITE);
        $mail->setSubject($subject);
        $mail->setContent($content);
        $mail->setContentHtml($contentHtml);
        $mail->setIsHtml(true);
        $mail->setFromMail($fromMail);
        
        Shopware()->Models()->persist($mail);
        Shopware()->Models()->flush();
	}

    /**
     * Delete email template
     */
    private function deleteEmailTemplate(){
        $mailRepo = Shopware()->Models()->getRepository(Mail::class);
        
        $mail = $mailRepo->findOneByName(Constants::EMAIL_TEMPLATE_MULTIUSER_INVITE);
        
        if(empty($mail)) {
            return;
        }
        
        Shopware()->Models()->remove($mail);        
        Shopware()->Models()->flush();
    }
}