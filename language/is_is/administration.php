<?php

  return array(
  
    // ---------------------------------------------------
    //  Administration tools
    // ---------------------------------------------------
    
    'administration tool name test_mail_settings' => 'Prófa tölvupóst stillingar',
    'administration tool desc test_mail_settings' => 'Notið þetta einfalda verkfæri til að prófa hvort ProjectPier póstkerfið er rétt stillt',
    'administration tool name mass_mailer' => 'Fjölpóstur',
    'administration tool desc mass_mailer' => 'Einfalt verkfæri sem er hægt að nota til að senda einföld textaskilaboð til valins hóps notanda sem skráðir eru í kerfið',

    // ---------------------------------------------------
    //  Configuration categories and options
    // ---------------------------------------------------
  
    'configuration' => 'Stillingar',
    
    'mail transport mail()' => 'Sjálfgefnar PHP stillingar',
    'mail transport smtp' => 'SMTP póstþjónn',
    
    'secure smtp connection no'  => 'Nei',
    'secure smtp connection ssl' => 'Já, nota SSL',
    'secure smtp connection tls' => 'Já, nota TLS',
    
    'file storage file system' => 'Skráakerfi',
    'file storage mysql' => 'Gagnagrunnur (MySQL)',
    
    // Categories
    'config category name general' => 'Almennt',
    'config category desc general' => 'Almennar stillingar ProjectPier',
    'config category name mailing' => 'Tölvupóstur',
    'config category desc mailing' => 'Notið þessa möguleika til að stilla hvernig ProjectPier á að meðhöndla sendingu tölvupósts. Þú getur notað sjálfgefnar stillingar sem eru í php.ini skránni eða stillt þær þannig að notaður sé einhver annar SMTP póstþjónn',
    'config category name features' => 'Valkostir',
    'config category desc features' => 'Notið þessar stillingar til að virkja eða gera óvirka ýmsa valkosti og velja á milli mismunandi aðferða við að birta gögn verkefnis',
    'config category name database' => 'Gagnagrunnur',
    'config category desc database' => 'Notið þessar möguleika til að stilla valkosti fyrir gagnagrunn',
    
    // ---------------------------------------------------
    //  Options
    // ---------------------------------------------------
    
    // General
    'config option name site_name' => 'Heiti vefs',
    'config option desc site_name' => 'Þessi texti birtist sem heiti vefs á stjórnborðs síðunni',
    'config option name file_storage_adapter' => 'Skráa vistun',
    'config option desc file_storage_adapter' => 'Veljið hvar á að vista viðhengi, smámyndir, merki og allar aðrar skrár sem hlaðið er upp. <strong>Mælt er með vistun í gagnagrunni</strong>.',
    'config option name default_project_folders' => 'Sjálfgefnar möppur',
    'config option desc default_project_folders' => 'Heiti á möppum sem eru myndaðar þegar verkefni er búið til. Skráið heiti hverrar möppu í nýja línu. Tómar línur og tvífölduð heiti birtast ekki.',
    'config option name theme' => 'Sniðmát fyrir útlit',
    'config option desc theme' => 'Hægt er að breyta útliti og virkni ProjectPier með því að nota sniðmát',
    'config option name calendar_first_day_of_week' => 'Fyrsti dagur vikunnar',
    'config option name check_email_unique' => 'Netfang verður að vera einstakt',
    'config option name remember_login_lifetime' => 'Sekúndur sem á að vera innskráður',
    'config option name installation_root' => 'Slóð á vefinn',
    'config option name installation_welcome_logo' => 'Merki á innskráningar síðu',
    'config option name installation_welcome_text' => 'Texti á innskráningar síðu',
    'config option name installation_base_language' => 'Sjálfgefið tungumál (líka fyrir innskráningar síðu)',

    // LDAP authentication support
    'config option name ldap_domain' => 'LDAP lén',
    'config option desc ldap_domain' => 'Lén fyrir active directory',
    'config option name ldap_host' => 'LDAP vél',
    'config option desc ldap_host' => 'Nafn tölvu sem hýsir active directory nafn eða IP tala',
    'secure ldap connection no' => 'Nei',
    'secure ldap connection tls' => 'Já, nota TLS',
    'config option name ldap_secure_connection' => 'Nota örugga LDAP tengingu',
    
    // ProjectPier
    'config option name upgrade_check_enabled' => 'Virkja sjálfvirka uppfærslu athugun',
    'config option desc upgrade_check_enabled' => 'Ef já mun kerfið athuga daglega hvort ný útgáfa af ProjectPier sé í boði',
    'config option name logout_redirect_page' => 'Fara á aðra síðu við útskráningu',
    'config option desc logout_redirect_page' => 'Stillið hvaða síðu kerfið sendir notendur á þegar þeir skrá sig út.  Veljið sjálfgefið til að nota sjálfgefna stillingu',
    // Mailing
    'config option name exchange_compatible' => 'Microsoft Exchange samhæfni',
    'config option desc exchange_compatible' => 'Merkið við ef notaður er Microsoft Exchange póstmiðlari til að koma í veg fyrir þekkt vandamál við tölvupóstsendingar.',
    'config option name mail_transport' => 'Póst sendingar',
    'config option desc mail_transport' => 'Hægt er að nota sjálfgefnar PHP stillingar til að senda tölvupóst eða nota SMTP póstþjón',
    'config option name mail_from' => 'Frá: netfang',
    'config option name mail_use_reply_to' => 'Nota Svara-til: fyrir Frá',
    'config option name smtp_server' => 'SMTP póstþjónn',
    'config option name smtp_port' => 'SMTP gátt',
    'config option name smtp_authenticate' => 'Nota SMTP auðkenningu',
    'config option name smtp_username' => 'SMTP notendanafn',
    'config option name smtp_password' => 'SMTP aðgangsorð',
    'config option name smtp_secure_connection' => 'Nota örugga SMTP tengingu',

    'config option name per_project_activity_logs' => 'Sér viðburðaskrá fyrir hvert verkefni',
    'config option name categories_per_page' => 'Fjöldi flokka á síðu',

    'config option name character_set' => 'Stafasett sem á að nota',
    'config option name collation' => 'Stafasett fyrir röðun',

    'config option name session_lifetime' => 'Líftími setu',
    'config option name default_controller' => 'Sjálfgefin aðalsíða',
    'config option name default_action' => 'Sjálfgefin undirsíða',

    'config option name logs_show_icons' => 'Birta táknmyndir í viðburðaskrá',
    'config option name default_private' => 'Sjálfgefin stilling fyrir "einka" valkost',
  ); // array

?>
