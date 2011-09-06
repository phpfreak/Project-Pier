<?php

  return array(
  
    // source: actions.php

    // Bug Trac
    'open tickets' => 'Opnir miðar',  
    'closed tickets' => 'Lokaðir miðar',
    'add ticket' => 'Nýr miði',  
    'edit ticket' => 'Breyta miða',  
    'view ticket' => 'Skoða miða',  
    'open ticket' => 'Opna miða', 
    'close ticket' => 'Loka miða',  
    'delete ticket' => 'Eyða miða',  
    'add ticket category' => 'Bæta við flokki',
    'add default ticket categories' => 'Bæta við sjálfgefnum flokkum',
    'edit ticket category' => 'Breyta flokki',
    'ticket categories' => 'Miða flokkar',
    'update ticket options' => 'Uppfæra valkosti',

    // source: administration.php

    'config category name tickets' => 'Miðar',  
    'config category desc tickets' => 'Notið þessar stillingar til að breyta valkostum fyrir miða. Í augnablikinu er aðeins hægt að velja um sjálfgefna flokka.',
    'config option name tickets_types' => 'Tegundir miða',
    'config option name tickets_default_categories' => 'Sjálfgefnir flokkar fyrir miða í verkefni',

    // source: emails.php

    'new ticket' => 'Nýr miði',

    'new ticket posted' => 'Nýjum miða "%s" hefur verið bætt við verkefnið "%s"',
    'ticket edited' => 'Miða "%s" hefur verið breytt í verkefninu "%s"',
    'ticket closed' => 'Miða "%s" hefur verið lokað í verkefninu "%s"',
    'ticket opened' => 'Miði "%s" hefur verið opnaður í verkefninu "%s"',
    'attached files to ticket' => 'Skrár hafa verið hengdar við miðann "%s" í verkefninu "%s"',
    'view new ticket' => 'Skoða þennan miða',


    // source: errors.php

    // Add category
    'category name required' => 'Skrá verður nafn á flokki',
    
    // Add ticket
    'ticket summary required' => 'Skrá verður samantekt',
    'ticket description required' => 'Skrá verður lýsingu',

    // source: messages.php
    // Empty, dnx etc
    'no ticket subscribers' => 'Það eru engir notendur áskrifendur að þessum miða',

    'ticket dnx' => 'Þessi miði er ekki til',
    'no tickets in project' => 'Það eru engir miðar í verkefninu',
    'no my tickets' => 'Það hefur engum miðum verið úthlutað á þig',
    'no changes in ticket' => 'Það hafa engar breytingar verið gerðar á þessum miða',
    'category dnx' => 'Flokkurinn er ekki til',
    'no categories in project' => 'Það eru engir flokkar í þessu verkefni',

    // Success
    'success add ticket' => 'Miðanum \'%s\' hefur verið bætt við',
    'success edit ticket' => 'Miðinn \'%s\' hefur verið uppfærður',
    'success deleted ticket' => 'Miðanum \'%s\' og öllum athugasemdum hefur verið eytt',
    'success close ticket' => 'Völdum miða hefur verið lokað',
    'success open ticket' => 'Valinn miði hefur verið enduropnaður',
    'success add category' => 'Flokknum \'%s\' hefur verið bætt við',
    'success edit category' => 'Flokknum \'%s\' hefur verið breytt',
    'success deleted category' => 'Flokknum \'%s\' og öllum athugasemdum hefur verið eytt',
    
    'success subscribe to ticket' => 'Þú ert nú áskrifandi að þessum miða',
    'success unsubscribe to ticket' => 'Þú ert ekki lengur áskrifandi að þessum miða',

    // Failures
    'error update ticket options' => 'Ekki tókst að uppfæra valkosti miða',
    'error close ticket' => 'Ekki tókst að loka miðanum',
    'error open ticket' => 'Ekki tókst að enduropna miðann',
    'error subscribe to ticket' => 'Ekki tókst að gerast áskrifandi að miðanum',
    'error unsubscribe to ticket' => 'Ekki tókst að segja upp áskrift að miðanum',
    'error delete ticket' => 'Ekki tókst að eyða miðanum',

    // Confirmation
    'confirm delete ticket' => 'Á örugglega að eyða þessum miða?',
    'confirm unsubscribe' => 'Viltu örugglega segja upp áskriftinni?',
    'confirm subscribe ticket' => 'Viltu örugglega gerast áskrifandi að þessum miða? Þú munt fá tölvupóst í hvert sem einhver (annar en þú) gerir breytingar eða skráir athugasemdir við miðann',

    // Log
    'log add projectcategories' => '\'%s\' bætt við',
    'log edit projectcategories' => '\'%s\' uppfærður',
    'log delete projectcategories' => '\'%s\' eytt',
    'log add projecttickets' => '\'%s\' bætt við',
    'log edit projecttickets' => '\'%s\' uppfærður',
    'log delete projecttickets' => '\'%s\' eytt',
    'log close projecttickets' => '\'%s\' lokað',
    'log open projecttickets' => '\'%s\' opnað',
  
    // source: general.php


    // source: objects.php

    'ticket' => 'Miði',
    'tickets' => 'Miðar',
    'private ticket' => 'Einka miði',

    // source: project_interface.php

    'email notification ticket desc' => 'Tilkynna völdu fólki um þennan miða með tölvupósti',
    'subscribers ticket desc' => 'Áskrifendur fá tölvupóst í hvert sem einhver (annar en þeir sjálfir) gera breytingar eða skrá athugasemdir við miðann',
    
    // Tickets
    'summary' => 'Samantekt',
    'category' => 'Flokkur',
    'priority' => 'Forgangur',
    'state' => 'Staða',
    'assigned to' => 'Úthlutað til',
    'reported by' => 'Tilkynnt af',
    'closed' => 'Lokaður',
    'open' => 'Opinn',
    'critical' => 'Nauðsynlegt',
    'major' => 'Meiriháttar',
    'minor' => 'Minniháttar',
    'trivial' => 'Aukaatriði',
    'opened' => 'Opnaður',
    'confirmed' => 'Staðfestur',
    'not reproducable' => 'Ekki hægt að framkalla',
    'test and confirm' => 'Prófað og staðfest',
    'fixed' => 'Lagað',
    'defect' => 'Galli',
    'enhancement' => 'Endurbót',
    'feature request' => 'Viðbót/breyting',
    'legend' => 'Áritun',
    'ticket #' => 'Miði #%s',
    'updated on by' => '%s | <a href="%s">%s</a> | %s',
    'history' => 'Breytingarsaga',
    'field' => 'Svæði',
    'old value' => 'Gamalt gildi',
    'new value' => 'Nýtt gildi',
    'change date' => 'Dagsetning breytingar',

    'private ticket desc' => 'Einka miðar eru eingöngu sýnilegir notendum sem tengjast fyrirtæki sem á verkefnið. Notendur fyrirtækja sem eru viðskiptavinir sjá þá ekki.',

    // source: site_interface.php
    
    // Tickets
    'my tickets' => 'Miðarnir mínir',

  ); // array

?>    
