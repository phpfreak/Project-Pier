<?php

  /**
  * Array of messages file (error, success message, status...)
  *
  * @http://www.projectpier.org/
  */

  return array(
  
    // Empty, dnx etc
    'project dnx' => 'Gevraagde project bestaat niet in database',
    'message dnx' => 'Gevraagde bericht bestaat niet',
    'no comments in message' => 'Er zijn nog geen reacties op dit bericht',
    'no comments associated with object' => 'Er zijn nog geen reacties geplaatst voor dit object',
    'no status updates associated with object' => 'Er zijn geen status updates geplaatst voor dit object',
    'no messages in project' => 'Er zijn geen berichten in dit project',
    'no subscribers' => 'Er zijn geen gebruikers geabonneerd op dit bericht',
    'no contacts in company' => 'Er zijn geen contactpersonen in dit bedrijf',

    'no activities in project' => 'Er zijn geen activiteiten geregistreerd voor dit project',
    'comment dnx' => 'Gevraagde reactie bestaat niet',
    'milestone dnx' => 'Gevraagde mijlpaal bestaat niet',
    'time dnx' => 'Gevraagd time record bestaat niet',
    'task list dnx' => 'Gevraagd takenlijst bestaat niet',
    'task dnx' => 'Gevraagde taak bestaat niet',
    'no milestones in project' => 'Er zijn geen mijlpalen in dit project',
    'no active milestones in project' => 'Er zijn geen actieve mijlpalen in dit project',
    'empty milestone' => 'Deze mijlpaal is leeg. U kunt een <a href="%s"> bericht </ a> of een <a href="%s"> takenlijst </ a> toevoegen op elk gewenst moment',
    'no logs for project' => 'Er zijn geen logboekvermeldingen in verband met dit project',
    'no recent activities' => 'Er zijn geen recente activiteiten gelogged in de database',
    'no open task lists in project' => 'Er zijn geen open takenlijsten in dit project',
    'no completed task lists in project' => 'Er zijn geen voltooide takenlijsten in dit project',
    'no open task in task list' => 'Er zijn geen taken in deze lijst',
    'no projects in db' => 'Er zijn geen gedefinieerde projecten',
    'no projects owned by company' => 'Er zijn geen projecten in handen van dit bedrijf',
    'no projects started' => 'Er zijn geen projecten die gestart zijn',
    'no active projects in db' => 'Er zijn geen actieve projecten',
    'no new objects in project since last visit' => 'Er zijn geen nieuwe objecten in dit project sinds uw laatste bezoek',
    'no clients in company' => 'Uw bedrijf heeft geen geregistreerde klanten',
    'no contacts in company' => 'Er zijn geen contactpersonen in dit bedrijf',
    'no users in company' => 'Er zijn geen gebruikers in dit bedrijf',
    'client dnx' => 'Geselecteerde klantbedrijf bestaat niet',
    'company dnx' => 'Geselecteerde bedrijf bestaat niet',
    'contact dnx' => 'Geselecteerde contactpersoon bestaat niet',
    'user dnx' => 'Gevraagde gebruiker bestaat niet in de database',
    'avatar dnx' => 'Avatar bestaat niet',
    'no current avatar' => 'Geen avatar geupload',
    'no current logo' => 'Geen logo geupload',
    'user not on project' => 'Geselecteerde gebruiker is niet betrokken bij geselecteerde project',
    'company not on project' => 'Geselecteerde bedrijf is niet betrokken bij geselecteerde project',
    'user cant be removed from project' => 'Geselecteerde gebruiker kan niet worden verwijderd uit het project',
    'tag dnx' => 'Gevraagde tag bestaat niet',
    'no tags used on projects' => 'Er zijn geen tags gebruikt in dit project',
    'no forms in project' => 'Er zijn geen formulieren in dit project',
    'project form dnx' => 'Gevraagde project formulier bestaat niet in de database',
    'related project form object dnx' => 'Aanverwant formulier object bestaat niet in de database',
    'no my tasks' => 'Er zijn geen taken aan u toegewezen',
    'no search result for' => 'Er zijn geen objecten die overeenkomen met "<strong>%s</ strong>"',
    'config category dnx' => 'De configuratie categorie die u heeft opgevraagd bestaat niet',
    'config category is empty' => 'Gekozen configuratie categorie is leeg',
    'email address not in use' => '%s is niet in gebruik',
    'no administration tools' => 'Er zijn geen geregistreerde beheerprogramma\'s in de database',
    'administration tool dnx' => 'Beheerprogramma "%s" bestaat niet',
    'about to delete' => 'U staat op het punt om te verwijderen',
    'about to move' => 'U staat op het punt om te verplaatsen',
    'no image functions' => 'Geen afbeelding functies (installeer GD library)',
    'no ldap functions' => 'Geen LDAP functies (installeer ldap extensie)',

    
    // Success
    'success add project' => 'Project %s is met succes toegevoegd',
    'success copy project' => 'Project %s is gekopieerd naar %s',
    'success edit project' => 'Project %s is bijgewerkt',
    'success delete project' => 'Project %s is verwijderd',
    'success complete project' => 'Project %s is voltooid',
    'success open project' => 'Project %s is heropend',
    'success edit project logo' => 'Project logo is bijgewerkt',
    'success delete project logo' => 'Project logo is verwijderd',
    'success edit logo' => 'Logo is bijgewerkt',
    'success delete logo' => 'Logo is verwijderd',
    
    'success add milestone' => 'Mijlpaal \'%s\' is succesvol aangemaakt',
    'success edit milestone' => 'Mijlpaal \'%s\' is succesvol bijgewerkt',
    'success deleted milestone' => 'Mijlpaal \'%s\' is succesvol verwijderd',

    'success add time' => 'Tijd \'% s\' is succesvol aangemaakt',
    'success edit time' => 'Tijd \'% s\' is succesvol bijgewerkt',
    'success deleted time' => 'Tijd \'% s\' is succesvol verwijderd',
    
    'success add message' => 'Bericht \'%s\' is succesvol toegevoegd',
    'success edit message' => 'Bericht \'%s\' is succesvol bijgewerkt',
    'success move message' => 'Bericht \'%s\' is verplaatst van project \'%s\' naar project \'%s\'',
    'success deleted message' => 'Bericht \'%s\' en alle reacties zijn met succes verwijderd',
    
    'success add comment' => 'Reactie is succesvol geplaatst',
    'success edit comment' => 'Reactie is succesvol bijgewerkt',
    'success delete comment' => 'Reactie is succesvol verwijderd',
    
    'success add task list' => 'Takenlijst \'%s\' is toegevoegd',
    'success edit task list' => 'Takenlijst \'%s\' is bijgewerkt',
    'success copy task list' => 'Takenlijst \'%s\' is gekopieerd naar \'%s\' met %s taken',
    'success move task list' => 'Takenlijst \'%s\' is verplaatst van project \'%s\' naar project \'%s\'',
    'success delete task list' => 'Takenlijst \'%s\' is verwijderd',
    
    'success add task' => 'Geselecteerde taak is toegevoegd',
    'success edit task' => 'Geselecteerde taak is bijgewerkt',
    'success delete task' => 'Geselecteerde taak is verwijderd',
    'success complete task' => 'Geselecteerde taak is afgerond',
    'success open task' => 'Geselecteerde taak is heropend',
    'success n tasks updated' => '%s taken bijgewerkt',
     
    'success add client' => 'Klant bedrijf %s is toegevoegd',
    'success edit client' => 'Klant bedrijf %s is bijgewerkt',
    'success delete client' => 'Klant bedrijf %s is verwijderd',
    
    'success edit company' => 'Bedrijfsgegevens zijn bijgewerkt',
    'success edit company logo' => 'Bedrijfslogo is bijgewerkt',
    'success delete company logo' => 'Bedrijfslogo is verwijderd',
    
    'success add user' => 'Gebruiker %s is met succes toegevoegd',
    'success edit user' => 'Gebruiker %s is met succes bijgewerkt',
    'success delete user' => 'Gebruiker %s is met succes verwijderd',
    
    'success add contact' => 'Contactpersoon %s is met succes toegevoegd',
    'success edit contact' => 'Contactpersoon %s is met succes bijgewerkt',
    'success delete contact' => 'Contactpersoon %s is met succes verwijderd',
    
    'success update project permissions' => 'Project machtigingen zijn succesvol bijgewerkt',
    'success remove user from project' => 'Gebruiker is succesvol verwijderd uit het project',
    'success remove company from project' => 'Bedrijf is succesvol verwijderd uit het project',
    
    'success update profile' => 'Profiel is bijgewerkt',
    'success edit avatar' => 'Avatar is succesvol bijgewerkt',
    'success delete avatar' => 'Avatar is met succes verwijderd',
    
    'success hide welcome info' => 'Welkom info box is met succes verborgen',
    
    'success complete milestone' => 'Mijlpaal \'%s\' is afgerond',
    'success open milestone' => 'Mijlpaal \'%s\' is heropend',
    
    'success subscribe to message' => 'U bent succesvol geabonneerd op dit bericht',
    'success unsubscribe to message' => 'U bent succesvol uitgeschreven op dit bericht',
   
    'success add project form' => 'Formulier \'%s\' is toegevoegd',
    'success edit project form' => 'Formulier \'%s\' is bijgewerkt',
    'success delete project form' => 'Formulier \'%s\' is verwijderd',
    
    'success update config category' => '%s configuratie waarden zijn bijgewerkt',
    'success forgot password' => 'Uw wachtwoord werd per e-mail naar u verzonden',
    
    'success test mail settings' => 'Test mail is succesvol verzonden',
    'success massmail' => 'Test mail is verzonden',
	
    'success update company permissions' => 'Bedrijf rechten succesvol bijgewerkt. %s records bijgewerkt',
    'success user permissions updated' => 'Gebruikersrechten zijn bijgewerkt',
    
    // Failures
    'error form validation' => 'object opslaan is mislukt, omdat sommige van de eigenschappen niet geldig zijn',
    'error delete owner company' => 'Eigenaar bedrijf kan niet worden verwijderd',
    'error delete message' => 'Geselecteerd bericht verwijderen is mislukt',
    'error update message options' => 'Berichtopties updaten is mislukt',
    'error delete comment' => 'Geselecteerde opmerking verwijderen is mislukt',
    'error delete milestone' => 'Geselecteerde mijlpaal verwijderen is mislukt',
    'error delete time' => 'Geselecteerde tijd verwijderen is mislukt',
    'error complete task' => 'Geselecteerd taak volbrengen is mislukt',
    'error open task' => 'Geselecteerd taak heropenen is mislukt',
    'error delete project' => 'Geselecteerd project verwijderen is mislukt',
    'error complete project' => 'Geselecteerd project volbrengen is mislukt',
    'error open project' => 'Geselecteerd project heropenen is mislukt',
    'error edit project logo' => 'Project logo updaten is mislukt',
    'error delete project logo' => 'Project logo verwijderen is mislukt',
    'error edit logo' => 'logo %s updaten is mislukt',
    'error delete logo' => 'logo %s verwijderen is mislukt',
    'error delete client' => 'Geselecteerd klant bedrijf verwijderen is mislukt',
    'error delete user' => 'Geselecteerd gebruiker verwijderen is mislukt',
    'error delete contact' => 'Geselecteerd Contactpersoon verwijderen is mislukt',
    'error update project permissions' => 'Project rechten updaten is mislukt',
    'error remove user from project' => 'Gebruiker verwijderen uit project is mislukt',
    'error remove company from project' => 'Bedrijf verwijderen uit project is mislukt',
    'error edit avatar' => 'Avatar bewerken is milukt',
    'error delete avatar' => 'Avatar verwijderen is milukt',
    'error hide welcome info' => 'Welkomstinfo verbergen is mislukt',
    'error complete milestone' => 'Geselecteerd mijlpaal voltooien is mislukt',
    'error open milestone' => 'Geselecteerd mijlpaal heropenen is mislukt',
    'error edit company logo' => 'Bedrijfslogo updaten is mislukt',
    'error delete company logo' => 'Bedrijfslogo verwijderen is mislukt',
    'error subscribe to message' => 'Abonnement op geselecteerd bericht nemen is niet gelukt',
    'error unsubscribe to message' => 'Abonnement op geselecteerd bericht opzeggen is niet gelukt',

    'error move message' => 'Geselecteerde bericht %s verplaatsen is mislukt',
    'error move task list' => 'Geselecteerde takenlijst %s verplaatsen is mislukt',
    'error delete task list' => 'Geselecteerde takenlijst %s verwijderen is mislukt',
    'error delete task' => 'Geselecteerde taak verwijderen is mislukt',
    'error delete category' => 'Geselecteerde categorie verwijderen is mislukt',
    'error check for upgrade' => 'Controleren op een nieuwere versie is mislukt',
    'error test mail settings' => 'verzenden van testmail is mislukt',
    'error massmail' => 'verzenden van mail is mislukt',
    'error owner company has all permissions' => 'Eigenaar bedrijf heeft alle machtigingen',
    
    // Access or data errors
    'no access permissions' => 'Je hebt geen toestemming om de gevraagde pagina te bekijken',
    'invalid request' => 'Ongeldige aanvraag!',
    
    // Confirmation
    'confirm delete message' => 'Weet u zeker dat u dit bericht wilt verwijderen?',
    'confirm delete milestone' => 'Weet u zeker dat u deze mijlpaal wilt verwijderen?',
    'confirm delete task list' => 'Weet u zeker dat u deze takenlijst en al zijn taken wilt verwijderen?',
    'confirm delete task' => 'Weet u zeker dat u deze taak wilt verwijderen?',
    'confirm delete comment' => 'Weet u zeker dat u deze reactie wilt verwijderen?',
    'confirm delete category' => 'Weet u zeker dat u deze categorie wilt verwijderen?',
    'confirm delete project' => 'Weet u zeker dat u dit project wilt verwijderen samen met alle relatieve data (berichten, taken, mijlpalen, bestanden, ...)?',
    'confirm delete project logo' => 'AWeet u zeker dat u dit project logo wilt verwijderen?',
    'confirm delete logo' => 'Weet u zeker dat u dit logo wilt verwijderen?',
    'confirm complete project' => 'Weet u zeker dat u dit project wilt markeren als voltooid? Alle project acties zullen worden vergrendeld',
    'confirm open project' => 'Weet u zeker dat u dit project wilt markeren als open? Dit zal alle projectactiviteiten ontgrendelen',
    'confirm delete client' => 'Weet u zeker dat u het geselecteerde klantbedrijf en alle gebruikers wilt verwijderen?',
    'confirm delete user' => 'Weet u zeker dat u deze gebruikers account wilt verwijderen?',
    'confirm delete contact' => 'Weet u zeker dat u deze contactpersoon wilt verwijderen?',
    'confirm reset people form' => 'Weet u zeker dat u dit formulier opnieuw wenst in te stellen? Alle wijzigingen die u hebt gemaakt zullen verloren gaan!',
    'confirm remove user from project' => 'Weet u zeker dat u deze gebruiker wilt verwijderen uit het project?',
    'confirm remove company from project' => 'Weet u zeker dat u dit bedrijf uit het project wilt?',
    'confirm logout' => 'Weet u zeker dat u wilt afmelden?',
    'confirm delete current avatar' => 'Weet u zeker dat u deze avatar wilt verwijderen?',
    'confirm delete company logo' => 'Weet u zeker dat u dit logo wilt verwijderen?',
    'confirm subscribe' => 'Weet u zeker dat u zich wilt abonneren op dit bericht? U ontvangt een e-mail iedere keer dat iemand (behalve uzelf een reactieplaatst bij dit bericht.',
    'confirm reset form' => 'Weet u zeker dat u dit formulier opnieuw wenst in te stellen?',
    
    // Errors...
    'system error message' => 'Het spijt ons, maar een fatale fout verhinderd ProjectPier van het uitvoeren van uw verzoek. Er is een fout rapport verzonden naar de beheerder.',
    'execute action error message' => 'Het spijt ons, maar ProjectPier is momenteel niet in staat om uw verzoek uit te voeren. Er is een fout rapport verzonden naar de beheerder.',
    
    // Log
    'log add projectmessages' => '\'%s\' toegevoegd',
    'log edit projectmessages' => '\'%s\' bijgewerkt',
    'log delete projectmessages' => '\'%s\' verwijderd',
    
    'log add comments' => '%s toegevoegd',
    'log edit comments' => '%s bijgewerkt',
    'log delete comments' => '%s verwijderd',
    
    'log add projectmilestones' => '\'%s\' toegevoegd',
    'log edit projectmilestones' => '\'%s\' bijgewerkt',
    'log delete projectmilestones' => '\'%s\' verwijderd',
    'log close projectmilestones' => '\'%s\' afgerond',
    'log open projectmilestones' => '\'%s\' reopened',

    'log add projecttimes' => '\'%s\' toegevoegd', 
    'log edit projecttimes' => '\'%s\' bijgewerkt',
    'log delete projecttimes' => '\'%s\' verwijderd',
    
    'log add projecttasklists' => '\'%s\' toegevoegd',
    'log edit projecttasklists' => '\'%s\' bijgewerkt',
    'log delete projecttasklists' => '\'%s\' verwijderd',
    'log close projecttasklists' => '\'%s\' gesloten',
    'log open projecttasklists' => '\'%s\' geopend',
    
    'log add projecttasks' => '\'%s\' toegevoegd',
    'log edit projecttasks' => '\'%s\' bijgewerkt',
    'log delete projecttasks' => '\'%s\' verwijderd',
    'log close projecttasks' => '\'%s\' gesloten',
    'log open projecttasks' => '\'%s\' geopend',
  
    'log add projectforms' => '\'%s\' toegevoegd',
    'log edit projectforms' => '\'%s\' bijgewerkt',
    'log delete projectforms' => '\'%s\' verwijderd',
  
    'log add projects' => '%s toegevoegd',
    'log edit projects' => '%s bijgewerkt',
    'log open projects' => '%s geopend',
    'log close projects' => '%s gesloten',
    'log delete projects' => '%s verwijderd',

    'log add users' => '%s toegevoegd',
    'log edit users' => '%s bijgewerkt',
    'log delete users' => '%s verwijderd',

    'log add companies' => '%s toegevoegd',
    'log edit companies' => '%s bijgewerkt',
    'log delete companies' => '%s verwijderd',

    'log add contacts' => '%s toegevoegd',
    'log edit contacts' => '%s bijgewerkt',
    'log delete contacts' => '%s verwijderd',

    'log add i18nlocales' => 'Locale \'%s\' toegevoegd',
    'log edit i18nlocales' => 'Locale \'%s\' bijgewerkt',
    'log delete i18nlocales' => 'Locale \'%s\' verwijderd',

    'log add i18localevalues' => 'Locale waarde \'%s\' toegevoegd',
    'log edit i18nlocalevalues' => 'Locale waarde \'%s\' bijgewerkt',
    'log delete i18nlocalevalues' => 'Locale waarde \'%s\' verwijderd',
  ); // array

?>