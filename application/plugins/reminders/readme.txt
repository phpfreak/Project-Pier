Installation Instructions

Extract the contents into the plugins folder.
Enable the Reports plugin in your ProjectPier installation
Setup a cron job script to retrieve %PROJECT_PIER_URL%/index.php?c=reports&a=send_emails, where the %PROJECT_PIER_URL% is your base URL.
Note: The URL retrieved is used in the email, so if you set your URL to http://localhost/, your users may not be able to use the links in the email.
Each user must set their own Reports and Reminders preferences. These settings can be found via the My Profile page.