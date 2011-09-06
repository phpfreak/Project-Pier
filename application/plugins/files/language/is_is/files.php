<?php

  return array(

    // source: actions.php

    // Files
    'add file' => 'Bæta við skrá',
    'edit file' => 'Breyta skrá',
    'delete file' => 'Eyða skrá',
    
    'add folder' => 'Bæta við möppu',
    'edit folder' => 'Breyta möppu',
    'delete folder' => 'Eyða möppu',
    
    'files add revision' => 'Bæta við útgáfu',
    'files edit revision' => 'Breyta útgáfu %s',
    'delete file revision' => 'Eyða útgáfu %s',
    
    'attach file' => 'Bæta við viðhengi',
    'attach files' => 'Bæta við viðhengjum',
    'attach more files' => 'Bæta við fleiri viðhengjum',
    'detach file' => 'Fjarlægja skrá',
    'detach files' => 'Fjarlægja skrár',

    // source: administration.php

    'config option name files_show_icons' => 'Birta táknmynd skráa',
    'config option name files_show_thumbnails' => 'Birta smámynd skráar þegar það er hægt',

    // source: errors.php

    // Validate project folder
    'folder name required' => 'Skrá þarf heiti á möppu',
    'folder name unique' => 'Heiti á möppum í verkefninu þurfa að vera einstök',
    
    // Validate add / edit file form
    'folder id required' => 'Veldu möppu',
    'filename required' => 'Skrá þarf skráarheiti',
    
    // File revisions (internal)
    'file revision file_id required' => 'Útgáfa þarf að vera tengd skrá',
    'file revision filename required' => 'Skrá þarf skráarheiti',
    'file revision type_string required' => 'Óþekkt skráartegund',

    // source: messages.php

    // Empty, dnx etc
    'no files on the page' => 'Það eru engar skrár á þessari síðu',
    'folder dnx' => 'Mappan sem þú baðst um er ekki til í gagnagrunninum',
    'define project folders' => 'Það eru engar möppur í þessu verkefni. Vinsamlega búið til möppu áður en haldið er áfram',
    'file dnx' => 'Þessi skrá er ekki til í gagnagrunninum',
    'file revision dnx' => 'Þessi útgáfa er ekki til í gagnagrunninum',
    'no file revisions in file' => 'Ógild skrá - það eru engar útgáfur tengdar þessari skrá',
    'cant delete only revision' => 'Þú getur ekki eytt þessari útgáfu. Skrár hafa í það minnsta eina útgáfu',

    'no attached files' => 'engar',
    'file not attached to object' => 'Valin skrá er ekki viðhengd völdum hlut',
    'no files to attach' => 'Vinsamlega veljið skrár sem á að hengja við',

    // Success
    'success add folder' => 'Möppunni \'%s\' hefur verið bætt við',
    'success edit folder' => 'Mappan \'%s\' hefur verið uppfærð',
    'success delete folder' => 'Möppunni \'%s\' hefur verið eytt',
    
    'success add file' => 'Skránni \'%s\' hefur verið bætt við',
    'success edit file' => 'Skráin \'%s\' hefur verið uppfærð',
    'success delete file' => 'Skránni \'%s\' hefur verið eytt',
    
    'success add revision' => 'Útgáfu %s hefur verið bætt við',
    'success edit file revision' => 'Útgáfa hefur verið uppfærð',
    'success delete file revision' => 'Útgáfu af skránni hefur verið eytt',
    
    'success attach files' => '%s skrár hafa verið viðhengdar',
    'success detach file' => 'Skrá(m) hefur verið eytt',

    // Failures
    'error upload file' => 'Tókst ekki að hlaða upp skránni',
    'error file download' => 'Tókst ekki að sækja valda skrá',
    'error attach file' => 'Tókst ekki að viðhengja',

    'error delete folder' => 'Tókst ekki að eyða valinni möppu',
    'error delete file' => 'Tókst ekki að eyða valinni skrá',
    'error delete file revision' => 'Tókst ekki að eyða útgáfu af skránni',
    'error attach file' => 'Tókst ekki að viðhengja skrá(r)',
    'error detach file' => 'Tókst ekki að fjarlækja skrá(r)',
    'error attach files max controls' => 'Þú getur ekki bætt við fleiri viðhengjum. Hámarkið er %s',

    // Confirmation
    'confirm delete folder' => 'Ertu viss um að þú viljir eyða þessari möppu?',
    'confirm delete file' => 'Ertu viss um að þú viljir eyða þessari skrá?',
    'confirm delete revision' => 'Ertu viss um að þú viljir eyða þessari útgáfu?',
    'confirm detach file' => 'Ertu viss um að þú viljir fjarlækja þessa skrá?',

    // Log
    'log add projectfolders' => '\'%s\' bætt við',
    'log edit projectfolders' => '\'%s\' uppfærð',
    'log delete projectfolders' => '\'%s\' eytt',
    
    'log add projectfiles' => '\'%s\' hlaðið upp',
    'log edit projectfiles' => '\'%s\' uppfærðar',
    'log delete projectfiles' => '\'%s\' eytt',
    
    'log edit projectfilerevisions' => '%s uppfærðar',
    'log delete projectfilerevisions' => '%s eytt',

    // source: objects.php

    'file' => 'Skrá',
    'files' => 'Skrár',
    'file revision' => 'Útgáfa af skrá',
    'file revisions' => 'Útgáfur af skrá',
    'revision' => 'Útgáfa',
    'revisions' => 'Útgáfur',
    'folder' => 'Mappa',
    'folders' => 'Möppur',
    'attached file' => 'Viðhengd skrá',
    'attached files' => 'Viðhengdar skrár',
    'important file'     => 'Mikilvæg skrá',
    'important files'    => 'Mikilvægar skrár',
    'private file' => 'Einka skrár',
    'attachment' => 'Viðhengi',
    'attachments' => 'Viðhengi',

    // source: project_interface.php

    'attach existing file' => 'Viðhengja skrá úr skjalasafni (undir Skrár)',
    'upload and attach' => 'Hlaða upp nýrri skrá og hengja hana við skilaboðin',

    'new file' => 'Ný skrá',
    'existing file' => 'Skrá úr safni',
    'replace file description' => 'Þú getur skipt út núverandi skrá með því að velja nýja. Skildu reitinn eftir tóman ef þú vilt ekki skipta henni út.',
    'download history' => 'Notkunar saga',
    'download history for' => 'Notkunarsaga fyrir <a href="%s">%s</a>',
    'downloaded by' => 'Sótt af',
    'downloaded on' => 'Sótt þann',

    'revisions on file' => '%s útgáfu(m)',
    'order by filename' => 'skráarheiti (a-ö)',
    'order by posttime' => 'dagsetningu og tíma',
    'all files' => 'Allar skrár',
    'upload file desc' => 'Þú getur hlaðið upp hvaða skráartegund sem er. Mesta stærð skráa sem þú getur hlaðið upp er %s',
    'file revision info short' => 'Útgáfa #%s <span>(mynduð %s)</span>',
    'file revision info long' => 'Útgáfa #%s <span>(af <a href="%s">%s</a> þann %s)</span>',
    'file revision title short' => '<a href="%s">Útgáfa #%s</a> <span>(mynduð %s)</span>',
    'file revision title long' => '<a href="%s">Útgáfa #%s</a> <span>(af <a href="%s">%s</a> þann %s)</span>',
    'update file' => 'Uppfæra skrá',
    'version file change' => 'Muna þessa breytingu (gamla skráin verður geymd til samanburðar)',
    'last revision' => 'Nýjasta útgáfa',
    'revision comment' => 'Athugasemdir útgáfu',
    'initial versions' => '-- Upprunaleg útgáfa --',
    'file details' => 'Upplýsingar um skrá',
    'view file details' => 'Skoða upplýsingar um skrá',
    
    'add attach file control' => 'Bæta við skrá',
    'remove attach file control' => 'Fjarlægja',
    'attach files to object desc' => 'Hengdu skrár við <strong><a href="%s">%s</a></strong>. Þú getur viðhengt eina eða fleiri skrár. Þú getur valið skrár sem eru til í skráasafninu eða sótt nýjar. <strong>Nýjar skrár verða einnig tiltækar í skráasafninu eftir að þeim hefur verið hlaðið upp</strong>.',
    'select file' => 'Veldu skrá',

    'important file desc' => 'Mikilvægar skrár birtast til hliðar í skráasafninu undir "Mikilvægar skrár"',
    'private file desc' => 'Einka skrár eru eingöngu sýnilegar notendum tengdum fyrirtæki sem á verkefnið. Notendur fyrirtækis viðskiptavinar sjá ekki skrárnar',
    
  ); // array

?>