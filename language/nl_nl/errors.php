<?php

  /** 
  * Error messages
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */

  // Return langs
  return array(
  
    // General
    'invalid email address' => 'E-mailadres is niet goed',
    'id missing' => 'Verplichte ID waarde is niet opgegeven',
   
    // Company validation errors
    // Company validation errors
    'company name required' => 'Bedrijf / organizatie naam is verplicht',
    'company homepage invalid' => 'Homepage waarde is geen geldige URL (http://www.example.com)',

    // Contact validation errors
    'name value required' => 'Naam is verplicht',
    'existing contact required' => 'U moet een bestaande contactpersoon selecteren',
    
    // Add user to contact form
    'contact already has user' => 'Deze contactpersoon heeft reeds een gebruikersaccount die eraan verbonden is.',
    // User validation errors
    'username value required' => 'Gebruikersnaam is verplicht',
    'username must be unique' => 'Sorry, de gevraagde gebruikersnaam is al in gebruik',
    'email value is required' => 'Email adres is verplicht',
    'email address must be unique' => 'Sorry, het gevraagde mail adres is al in gebruik',
    'company value required' => 'Gebruiker moet deel uitmaken van het bedrijf / organizatie',
    'password value required' => 'Paswoord is verplicht',
    'passwords dont match' => 'Paswoorden komen niet overeen',
    'old password required' => 'Oud paswoord is verplicht',
    'invalid old password' => 'Oud paswoord is geen geldige waarde',
    'user homepage invalid' => 'Dit is geen geldige URL (http://www.example.com)',
    
    // Avatar
    'invalid upload type' => 'Ongeldig bestandstype. Toegestane types zijn %s',	
    'invalid upload dimensions' => 'Ongeldige afmetingen van de afbeelding. Maximum grootte is %sx%s pixels',
    'invalid upload size' => 'Ongeldige afmetingen van de afbeelding. Maximum grootte is %s',
    'invalid upload failed to move' => 'Geupload bestand verplaatsen is gefaald',
    
    // Registration form
    'terms of services not accepted' => 'Om een account aan te maken moet u onze voorwaarden van dienstverlening lezen en ermee akkoord gaan',
    
    // Init company website
    'failed to load company website' => 'Website laden faalde. Eigenaars bedrijf niet gevonden',
    'failed to load project' => 'Het actieve project laden faalde',
    
    // Login form
    'username value missing' => 'Vul je gebruikersnaam alstublieft in',
    'password value missing' => 'Vul je paswoord alstublieft in',
    'invalid login data' => 'Inloggen is gefaald. Controleer je login gegevens alstublief, en probeer opnieuw.',
    'invalid password' => 'Fout paswoord. Controleer alstublieft je paswoord, en probeer het dan nog eens',
    
    // Add project form
    'project name required' => 'Projectnaam is verplicht',
    'project name unique' => 'Projectnaam moet uniek zijn',
    
    // Add message form
    'message title required' => 'Titelwaarde is verplicht',
    'message title unique' => 'Titelwaarde moet uniek zijn in dit project',
    'message text required' => 'Tekstwaarde is verplicht',
    
    // Add comment form
    'comment text required' => 'Tekst in de comentaar is verplicht',
    
    // Add milestone form
    'milestone name required' => 'Mijlpaal naam is verplicht',
    'milestone due date required' => 'Mijlpaal \'tegen dan\' datum waarde is verplicht',

    // Add task list
    'task list name required' => 'Takenlijst naam is verplicht',
    'task list name unique' => 'Takenlijst naam must be unique in project',
    
    // Add task
    'task text required' => 'Taak tekst is verplicht',

    // Test mail settings
    'test mail recipient required' => 'Ontvangstadres is verplicht',
    'test mail recipient invalid format' => 'Fout ontvangstadres formaat',
    'test mail message required' => 'Mail bericht is verplicht',
    
    // Mass mailer
    'massmailer subject required' => 'Een onderwerp voor je bericht is verplicht.',
    'massmailer message required' => 'Een hoofdtekst voor je bericht is verplicht.',
    'massmailer select recipients' => 'Alstublieft, selecteer de gebruikers die dit bericht per mail aan mogen krijgen.',
    
  ); // array

?>