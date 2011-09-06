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
    'invalid email address' => 'Snið netfangs er ekki gilt',
    'id missing' => 'ID númer vantar',
   
    // Company validation errors
    'company name required' => 'Skrá verður fyrirtæki / stofnun',
    'company homepage invalid' => 'Slóðin á vefinn er ekki rétt (http://www.example.com)',
    
    // User validation errors
    'username value required' => 'Nauðsynlegt er að skrá notendanafn',
    'username must be unique' => 'Notendanafn er þegar skráð',
    'email value is required' => 'Skrá verður netfang',
    'email address must be unique' => 'Netfang er þegar skráð',
    'company value required' => 'Notandi verður að vera tengdur fyrirtæki/stofnun',
    'password value required' => 'Skrá verður aðgangsorð',
    'passwords dont match' => 'Aðgangsorðin eru ekki eins',
    'old password required' => 'Skrá verður gamla lykilorðið',
    'invalid old password' => 'Gamla lykilorðið er ekki rétt',
    'user homepage invalid' => 'Slóðin á vefinn er ekki rétt (http://www.example.com)',
    
    // Avatar
    'invalid upload type' => 'Ógild skráartegund. Leyfðar tegundir eru %s',
    'invalid upload dimensions' => 'Myndin er of stór. Mesta stærð er %sx%s punktar',
    'invalid upload size' => 'Myndin er of stór. Mesta stærð er %s',
    'invalid upload failed to move' => 'Tókst ekki að flytja skrána',
    
    // Registration form
    'terms of services not accepted' => 'Til að búa til aðgang verður þú að lesa og samþykkja skilyrði þjónustunnar',
    
    // Init company website
    'failed to load company website' => 'Gat ekki sótt vefinn. Fyrirtæki eiganda fannst ekki',
    'failed to load project' => 'Tókst ekki að hlaða virku verkefni',
    
    // Login form
    'username value missing' => 'Skráðu lykilorð',
    'password value missing' => 'Skráðu lykilorð',
    'invalid login data' => 'Ekki tókst að skrá þig inn. Athugaðu hvort notandanafn og lykilorð hafi verið rétt skráð og reyndu aftur',
    
    // Add project form
    'project name required' => 'Heiti verkefnis verður að vera skráð',
    'project name unique' => 'Heiti verkefnis verður að vera einstakt',
    
    // Add message form
    'message title required' => 'Skrá verður heiti',
    'message title unique' => 'Heitið verður að vera einstakt í verkefninu',
    'message text required' => 'Skrá verður texta',
    
    // Add comment form
    'comment text required' => 'Skrá verður texta athugasemdar',
    
    // Add milestone form
    'milestone name required' => 'Skrá verður heiti áfanga',
    'milestone due date required' => 'Skrá verður lokadagsetningu áfanga',

    // Add task list
    'task list name required' => 'Skrá verður heiti verkþáttalista',
    'task list name unique' => 'Heiti verkþáttalista verður að vera einstakt í verkefninu',
    
    // Add task
    'task text required' => 'Skrá verður texta fyrir verkþátt',

    // Test mail settings
    'test mail recipient required' => 'Skrá verður netfang viðtakanda',
    'test mail recipient invalid format' => 'Netfang viðtakanda ógilt',
    'test mail message required' => 'Skrá verður skilaboðin',
    
    // Mass mailer
    'massmailer subject required' => 'Skrá verður varðandi',
    'massmailer message required' => 'Skrá verður texta skilaboðanna',
    'massmailer select recipients' => 'Vinsamlega veljið notendur sem eiga að fá þennan tölvupóst',
    
  ); // array

?>
