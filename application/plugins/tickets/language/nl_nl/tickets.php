<?php
 /**
 * @author Engelbert Mercelis
 * @licence Gnu Affero General Public License
 */
  return array(
  
    // source: actions.php

    // Bug Trac
    'open tickets' => 'Open tickets',  
    'closed tickets' => 'Gesloten tickets',
    'add ticket' => 'Ticket toevoegen',  
    'edit ticket' => 'Ticket bewerken',  
    'view ticket' => 'Ticket bekijken',  
    'open ticket' => 'Ticket openen', 
    'close ticket' => 'Ticket sluiten',  
    'delete ticket' => 'Ticket verwijderen',  
    'add ticket category' => 'Categorie toevoegen',
    'add default ticket categories' => 'Standaard categorieën toevoegen',
    'edit ticket category' => 'categorie bewerken',
    'ticket categories' => 'Ticket categorieën',
    'update ticket options' => 'Update opties',

    // source: administration.php

    'config category name tickets' => 'Tickets',  
    'config category desc tickets' => 'Gebruik deze instellingen om ticket opties in te stellen. Op dit moment alleen standaard categorieën.',
    'config option name tickets_types' => 'Toegestane ticket types',
    'config option name tickets_default_categories' => 'Standaard ticket categorieën voor een project',

    // source: emails.php

    'new ticket' => 'Nieuw ticket',

    'new ticket posted' => 'Nieuw ticket "%s" is gemaakt in het "%s" project',
    'ticket edited' => 'Ticket "%s" is bijgewerkt in het "%s" project',
    'ticket closed' => 'Ticket "%s" is gesloten in het "%s" project',
    'ticket opened' => 'Ticket "%s" is geopend in het "%s" project',
    'attached files to ticket' => 'Enkele bestanden zijn toegevoegd aan ticket "%s" in het "%s" project',
    'view new ticket' => 'Bekijk dat ticket',


    // source: errors.php

    // Add category
    'category name required' => 'Categorienaam is verplicht',
    
    // Add ticket
    'ticket summary required' => 'Samenvatting is verplicht',
    'ticket description required' => 'Beschrijving is verplicht',

    // source: messages.php
    // Empty, dnx etc
    'no ticket subscribers' => 'Er zijn geen gebruikers geabonneerd op dit ticket',

    'ticket dnx' => 'Gevraagde ticket bestaat niet',
    'no tickets in project' => 'Er zijn geen tickets in dit project',
    'no my tickets' => 'Er zijn geen tickets aan u toegewezen',
    'no changes in ticket' => 'Er zijn geen veranderingen in dit ticket',
    'category dnx' => 'Gevraagde categorie bestaat niet',
    'no categories in project' => 'Er zijn geen categorieën in dit project',

    // Success
    'success add ticket' => 'Ticket \'%s\' is succesvol toegevoegd',
    'success edit ticket' => 'Ticket \'%s\' is succesvol bijgewerkt',
    'success deleted ticket' => 'Ticket \'%s\' en alle bijbehorende reacties zijn succesvol verwijderd',
    'success close ticket' => 'Geselecteerde ticket is gesloten',
    'success open ticket' => 'Geselecteerde ticket is heropend',
    'success add category' => 'Categorie \'%s\' is succesvol toegevoegd',
    'success edit category' => 'Categorie \'%s\' is succesvol bijgewerkt',
    'success deleted category' => 'Categorie \'%s\' aen alle bijbehorende reacties zijn succesvol verwijderd',
    
    'success subscribe to ticket' => 'U bent succesvol geabonneerd op dit ticket',
    'success unsubscribe to ticket' => 'U bent succesvol uitgeschreven uit dit ticket',

    // Failures
    'error update ticket options' => 'Ticket opties updaten is mislukt',
    'error close ticket' => 'Geselecteerde ticket sluiten is mislukt',
    'error open ticket' => 'Geselecteerde ticket heropenen is mislukt',
    'error subscribe to ticket' => 'Abonneren op geselecteerde ticket is mislukt',
    'error unsubscribe to ticket' => 'Mislukt uit te schrijven uit geselecteerde ticket',
    'error delete ticket' => 'Geselecteerde ticket verwijderen is mislukt',

    // Confirmation
    'confirm delete ticket' => 'Weet u zeker dat u dit ticket wilt verwijderen?',
    'confirm unsubscribe' => 'Weet u zeker dat u zich wilt uitschrijven?',
    'confirm subscribe ticket' => 'Weet u zeker dat u zich wilt abonneren op dit ticket? U ontvangt een e-mail iedere keer dat iemand (behalve uzelf) een verandering maakt of een reactie plaatst op dit ticket',

    // Log
    'log add projectcategories' => '\'%s\' toegevoegd',
    'log edit projectcategories' => '\'%s\' bijgewerkt',
    'log delete projectcategories' => '\'%s\' verwijderd',
    'log add projecttickets' => '\'%s\' toegevoegd',
    'log edit projecttickets' => '\'%s\' bijgewerkt',
    'log delete projecttickets' => '\'%s\' verwijderd',
    'log close projecttickets' => '\'%s\' gesloten',
    'log open projecttickets' => '\'%s\' geopend',
  
    // source: general.php


    // source: objects.php

    'ticket' => 'Ticket',
    'tickets' => 'Tickets',
    'private ticket' => 'Prive ticket',

    // source: project_interface.php

    'email notification ticket desc' => 'Geselecteerde mensen op de hoogte houden over dit ticket via e-mail',
    'subscribers ticket desc' => 'Abonnees ontvangen een e-mail notificatie wanneer iemand (behalve zijzelf) een verandering maakt of een reactie plaatst op dit ticket',
    
    // Tickets
    'summary' => 'Samenvatting',
    'category' => 'Categorie',
    'priority' => 'Prioritijd',
    'state' => 'Status',
    'assigned to' => 'Toegewezen aan',
    'reported by' => 'Gerapporteerd door',
    'closed' => 'Gesloten',
    'open' => 'Open',
    'critical' => 'Kritiek',
    'major' => 'Belangrijk',
    'minor' => 'Minder belangrijk',
    'trivial' => 'Triviaal',
    'opened' => 'Nieuw',
    'confirmed' => 'bevestigd',
    'not reproducable' => 'niet reproduceerbaar',
    'test and confirm' => 'Test en bevestig',
    'fixed' => 'Gerepareerd',
    'defect' => 'Defect',
    'enhancement' => 'Verbetering',
    'feature request' => 'Functie',
    'legend' => 'Legende',
    'ticket #' => 'Ticket #%s',
    'updated on by' => '%s | <a href="%s">%s</a> | %s',
    'history' => 'Wijzigingsgeschiedenis',
    'field' => 'Veld',
    'old value' => 'Oude waarde',
    'new value' => 'Nieuwe waarde',
    'change date' => 'wijzigingsdatum',

    'private ticket desc' => 'Prive-tickets zijn alleen zichtbaar voor de eigenaarbedrijf leden. De leden van klantbedrijven zullen niet in staat om ze te zien.',

    // source: site_interface.php
    
    // Tickets
    'my tickets' => 'Mijn tickets',

    'filters' => 'Filters',  
    'new' => 'Nieuw',  
    'pending' => 'Hangende',  
    'updated on' => 'Bijgewerkt op',  

  ); // array

?>