How to sätta upp phpunit.

Installera PHPUnit
Fyll i nästa gång det görs.

Så här ställer du in inställningarna
Gå till Settings - PHP - PHPUnit
Klicka i "Use custom loader" och ange på raden under path to script som är:
/din/sökväg/till/Rentatool/vendor/autoload.php
Apply och spara.
Det här behövs för att testerna ska kunna ladda klasserna utan att använda require_once eller include.

Gå ut ur settings igen
I menyn längst upp till vänster om play-knappen och debug-knappen finns en rullgardinsknapp för att konfigurera testerna.
Tryck på den.
Tryck "Edit Configurations.." i listan som visas.

När ett nytt fönster öppnats tryck i fönstrets vänsta meny på Defaults - PHPUnit.

I det nya fönstret som öppnas tryck i "Directory" som testscope och ange katalogen
"/din/sökväg/till/Rentatool/application/Tests"
Det är det som anger var phpunit kan hitta testfallen.

Kryssa i "use alternative configuration file" och ange /din/sökväg/till/Rentatool/application/Tests/phpunit.xml
Det behövs för att i phpunit anges bootstrap.php som är den fil som körs innan alla tester. Atm laddar den in
configuration.php som sätter den upp vissa miljövariabler.