<?php
 /**
 * @author Engelbert Mercelis
 * @licence Gnu Affero General Public License
 */
  return array(

    // source: actions.php

    // Files
    'add file' => 'Bestand toevoegen',
    'edit file' => 'Bestand bewerken',
    'move file' => 'Bestand verplaatsen',
    'delete file' => 'Bestand verwijderern',
    
    'add folder' => 'Folder toevoegen',
    'edit folder' => 'Folder bewerken',
    'delete folder' => 'Folder verwijderern',
    
    'files add revision' => 'Herziening toevoegen',
    'files edit revision' => 'Herziening %s bewerken',
    'delete file revision' => 'Herziening %s verwijderern',
    
    'attach' => 'Koppel',
    'attach file' => 'Koppel een bestand',
    'attach files' => 'Koppel bestanden',
    'attach more files' => 'Koppel meer bestanden',
    'detach file' => 'Koppel bestand los',
    'detach files' => 'Koppel bestanden los',

    // source: administration.php

    'config option name files_show_icons' => 'Toon bestands iconen',
    'config option name files_show_thumbnails' => 'Toon bestand miniaturen waar mogelijk',

    // source: errors.php

    // Validate project folder
    'folder name required' => 'Folder naam is verplicht',
    'folder name unique' => 'Naam van de folder moet uniek zijn in dit project',
    
    // Validate add / edit file form
    'folder id required' => 'Selecteer aub een folder',
    'filename required' => 'Bestandsnaam is verplicht',
    
    // File revisions (internal)
    'file revision file_id required' => 'Herziening dien gekoppeld te zijn met een bestand',
    'file revision filename required' => 'Bestandsnaam is verplicht',
    'file revision type_string required' => 'Onbekend bestandstype',

    // source: messages.php

    // Empty, dnx etc
    'no files on the page' => 'Er zijn geen bestanden op deze pagina',
    'folder dnx' => 'De folder die u hebt aangevraagd bestaat niet in de database',
    'define project folders' => 'Er zijn geen folders in dit project. Gelieve folders te definiëren om verder te gaan',
    'file dnx' => 'Gevraagde bestand bestaat niet in de database',
    'file revision dnx' => 'Gevraagde herziening bestaat niet in de database',
    'no file revisions in file' => 'Ongeldig bestand - er zijn geen herzieningen gekoppeld met dit bestand',
    'cant delete only revision' => 'U kunt deze herziening niet verwijderen. Elk bestand dient te beschikken over ten minste een herziening',

    'no attached files' => 'Er zijn geen bestanden gekoppeld aan dit object',
    'file not attached to object' => 'Geselecteerde bestand is niet gekoppeld aan geselecteerde object',
    'no files to attach' => 'Selecteer aub bestanden die moeten worden gekoppeld',

    // Success
    'success add folder' => 'Folder \'%s\' is toegevoegd',
    'success edit folder' => 'Folder \'%s\' is bijgewerkt',
    'success delete folder' => 'Folder \'%s\' is verwijderd',
    
    'success add file' => 'Bestand \'%s\' is toegevoegd',
    'success edit file' => 'Bestand \'%s\' is bijgewerkt',
    'success move file' => 'Bestand \'%s\' is verplaatst van project %s naar project %s',
    'success delete file' => 'Bestand \'%s\' is verwijderd',
    
    'success add revision' => 'Herziening %s is toegevoegd',
    'success edit file revision' => 'Herziening is bijgewerkt',
    'success delete file revision' => 'Herziening is verwijderd',
    
    'success attach files' => '%s bestand(en) is(zijn) met succes gekoppeld',
    'success detach file' => 'Bestand(en) zijn succesvol losgekoppeld',

    // Failures
    'error upload file' => 'Bestand uploaden is mislukt',
    'error file download' => 'Opgegeven bestand downloaden is mislukt',
    'error attach file' => 'Bestand koppelen is mislukt',

    'error delete folder' => 'Geselecteerde map verwijderen is mislukt',
    'error move file' => 'geselecteerde bestand %s verplaatsen is mislukt',
    'error delete file' => 'geselecteerde bestand verwijderen is mislukt',
    'error delete file revision' => 'Herziening verwijderen is mislukt',
    'error attach file' => 'Bestand(en) koppelen is mislukt',
    'error detach file' => 'Bestand(en) ontkoppelen is mislukt',
    'error attach files max controls' => 'U kunt geen bestandsbijlagen meer toevoegen. De limiet is %s',

    // Confirmation
    'confirm delete folder' => 'Weet u zeker dat u deze folder wilt verwijderen?',
    'confirm delete file' => 'Weet u zeker dat u dit bestand wilt verwijderen?',
    'confirm delete revision' => 'Weet u zeker dat u deze herziening wilt verwijderen?',
    'confirm detach file' => 'Weet u zeker dat u dit bestand wilt loskoppelen?',

    // Log
    'log add projectfolders' => '\'%s\' toegevoegd',
    'log edit projectfolders' => '\'%s\' bijgewerkt',
    'log delete projectfolders' => '\'%s\' verwijderd',
    
    'log add projectfiles' => '\'%s\' toegevoegd',
    'log edit projectfiles' => '\'%s\' bijgewerkt',
    'log delete projectfiles' => '\'%s\' verwijderd',
    
    'log edit projectfilerevisions' => '%s bijgewerkt',
    'log delete projectfilerevisions' => '%s verwijderd',

    // source: objects.php

    'file' => 'Bestand',
    'files' => 'Bestanden',
    'file revision' => 'Bestandsherziening',
    'file revisions' => 'Bestandsherzieningen',
    'revision' => 'Herziening',
    'revisions' => 'Herzieningen',
    'folder' => 'Folder',
    'folders' => 'Folders',
    'no folder' => '(geen folder)',
    'attached file' => 'Gekoppeld bestand',
    'attached files' => 'Gekoppelde bestanden',
    'important file'     => 'Belangrijk bestand',
    'important files'    => 'Belangrijke bestanden',
    'private file' => 'Prive bestand',
    'attachment' => 'Bijlage',
    'attachments' => 'Bijlagen',
    'parent folder' => 'Bovenliggende Folder',

    // source: project_interface.php

    'attach existing file' => 'Koppel een bestaand bestand (van de Bestanden sectie)',
    'upload and attach' => 'Upload een nieuw bestand en koppel het aan het bericht',

    'new file' => 'Nieuw bestand',
    'existing file' => 'Bestaand bestand',
    'replace file description' => 'U kunt een bestaand bestand vervangen door het specificeren van een nieuw bestand. Als u het niet wilt vervangen laat dit veld dan leeg.',
    'download history' => 'Download geschiedenis',
    'download history for' => 'Download geschiedenis voor <a href="%s">%s</a>',
    'downloaded by' => 'Gedownload door',
    'downloaded on' => 'Gedownload op',

    'revisions on file' => '%s herziening(en)',
    'order by filename' => 'bestandsnaam (a-z)',
    'order by posttime' => 'datum en tijd',
    'order by folder' => 'folder',
    'all files' => 'Alle bestanden',
    'upload file desc' => 'U kunt bestanden uploaden van elk type. De maximum bestandsgrootte die u mag uploaden is %s',
    'file revision info short' => 'Herziening #%s <span>(gemaakt op %s)</span>',
    'file revision info long' => 'Herziening #%s <span>(door <a href="%s">%s</a> op %s)</span>',
    'file revision title short' => '<a href="%s">Herziening #%s</a> <span>(gemaakt op %s)</span>',
    'file revision title long' => '<a href="%s">Herziening #%s</a> <span>(door <a href="%s">%s</a> op %s)</span>',
    'update file' => 'Bestand bijwerken',
    'version file change' => 'Onthoud deze verandering (het oude bestand wordt opgeslagen als referentie)',
    'last revision' => 'Laatste herziening',
    'revision comment' => 'Herziening commentaar',
    'initial versions' => '-- Oorspronkelijke versie --',
    'file details' => 'Bestands details',
    'view file details' => 'Bekijk bestands details',
    
    'add attach file control' => 'Bestand toevoegen',
    'remove attach file control' => 'Verwijder',
    'attach files to object desc' => 'Gebruik dit formulier om bestanden te koppelen aan <strong> <a href="%s">%s</a></strong>. U kunt één of meer bestanden koppelen. U kunt bestaande bestanden uit de bestanden sectie gebruiken of nieuwe uploaden. <strong> Nieuwe bestanden zullen ook beschikbaar zijn via bestanden sectie wanneer u ze upload </strong>.',
    'select file' => 'Selecteer een bestand',

    'important file desc' => 'Belangrijke bestanden worden weergegeven in de zijbalk van de Bestanden sectie in de "Belangrijke bestanden" blok',
    'private file desc' => 'Prive-bestanden zijn alleen zichtbaar voor de leden van het eigenaar bedrijf. De leden van klantbedrijven zullen niet in staat om ze te zien',
  ); // array

?>