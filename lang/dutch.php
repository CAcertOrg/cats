<?php
define("accept_Login_01","U bent niet geregistreerd. <br />Controleer a.u.b. uw certificaat informatie en bevestig uw registratie.");
define("accept_Login_02","certificaat informatie");
define("accept_Login_03","Uitgegeven aan:");
define("accept_Login_04","Common Name (CN)");
define("accept_Login_05","Serie Nummer");
define("accept_Login_06","Email adres");
define("accept_Login_07","Uitgegeven door :");
define("accept_Login_08","Organisatie (O)");
define("accept_Login_09","Organisatie afdeling (OU)");
define("accept_Login_10","Uitgegeven op");
define("accept_Login_11","Vervalt op");
define("accept_Login_12","Uzelf registreren met dit certificaat?<br /><br />".
                         "Enkel het serienummer van het certificaat zal opgeslagen worden. Als u echter een gedrukt attest wil aanvragen na succesvol afleggen van de toets kan het attest alleen uitgegeven worden met de Common Name van het certificaat!<br />".
                         "Gedrukte attesten kunnen niet worden uitgegeven voor anonieme certificaten (Common Name \"CAcert WoT User\").");
define("accept_Login_13","Geldigheid:");
define("Button_01","cre&#235;er een nieuw onderwerp");
define("Button_02","terug naar onderwerp management");
define("Button_03","terug naar vragen-management");
define("Button_04","nieuwe vraag");
define("Button_05","toon als lijst");
define("Button_06","toon als lijngrafiek");
define("Button_07","toon als staafgrafiek");
define("Button_08","beste antwoord");
define("Button_09","slechste antwoord");
define("Button_10","aanmelden gelukt");
define("Button_11","opslaan");
define("Button_12","wijzigingen opslaan");
define("Button_13","antwoorden wijzigen");
define("Button_14","antwoord toevoegen");
define("Button_15","antwoord verwijderen");
define("Button_16","evalueer toets");
define("Button_17","statistische informatie");
define("Button_18","gebruikers informatie"); /**/
define("Button_19","toets statistieken");
define("Check_Cert_01","Indien u een document per post of per email wenst te ontvangen, dan moet uw naam in het certificaat opgenomen zijn!<br />".
                       "U kan verder gaan met de registratie, maar u zal de optie <i>verstuur per post</i> of <i>verstuur per email</i> niet kunnen kiezen.<br />Indien u wenst kunt u deze registratie annuleren en uzelk opnieuw registreren met een ander certificaat, waarin uw naam opgenomen is.");
define("certificateDocu_01","Indien u wenst kunnen we een document opmaken waarin wordt bevestigd dat u geslaagd bent voor de Assurer test. Het document zal opgemaakt worden op uw naam, zoals aanwezig in uw digitaal certificaat.");
define("certificateDocu_02","Nee, ik heb dit document niet nodig.");
define("certificateDocu_03","Ja, stuur me a.u.b. het document als een pdf bijlage per email (we gebruiken het email adres en uw naam zoals opgenomen in het certificaat.)");
define("certificateDocu_04","Ja, stuur me a.u.b. het document per post naar het volgende adres:");
define("certificateDocu_05","voornaam");
define("certificateDocu_06","achternaam");
define("certificateDocu_07","straat");
define("certificateDocu_08","postcode");
define("certificateDocu_09","plaatsnaam");
define("certificateDocu_10","provincie");
define("certificateDocu_11","land");
define("certificateDocu_12","Alle velden moeten ingevuld zijn als u het per post wilt ontvangen.");
define("Class_Answer_01","details van de antwoorden");
define("Class_Answer_02","antwoorden");
define("Class_Answer_03","antwoord");
define("Class_Answer_04","Er moeten minimaal 2 antwoorden opgegeven worden.");
define("Class_Answer_05","Tenminste 1 antwoord moet als 'correct' gemarkeerd worden en er moeten minimaal 2 antwoorden opgegeven worden.");
define("Class_Answer_06","Tenminste 1 antwoord moet als 'correct' gemarkeerd worden.");
define("Class_Answer_07","In a cloze correct and incorrect answers must be different"); // ToDo: Cloze = fill in the blanks, german "Lückentext"
define("Class_Answer_08","Er moet tenminste 1 correct en 1 incorrect antwoord zijn.");
define("Class_Answer_09","waar");
define("Class_Answer_10","niet waar");
define("Class_Progress_01","aantal vragen");
define("Class_Progress_02","Te veel informatie opgeslagen in de database."); /* gehört zu Lernfortschritte_angezeigt */
define("Class_Progress_03","Beeld van de laatste");
define("Class_Progress_04","toetsen.");
define("Class_Progress_05","Geen verdere informatie beschikbaar"); /*Bsp: Keine weiteren Infos zu : 5 Fragen */
define("Class_Progress_06","Geen verdere informatie beschikbaar voor:");
define("Class_Progress_07","vraag/vragen");
define("Class_Progress_08","fout beantwoorde vragen");
define("Class_Question_01","Klik voor meer informatie over dit onderwerp");
define("Class_Question_02","deactiveer vraag");
define("Class_Question_03","activeer vraag ");
define("Class_Question_04","verwijder vraag");
define("Class_Question_05","Geen vragen beschikbaar in de database");
define("Class_Question_06","details van de vraag");
define("Class_Quiz_01","Er zijn niet voldoende vragen over dit onderwerp. Kies a.u.b. een ander onderwerp.");
define("Class_Quiz_02","toets");
define("Class_Quiz_03","Evaluatie van de toets");
define("Class_Quiz_04","Uw totaal score is :");
define("Class_Quiz_05","Minimum vereist resultaat voor deze toets :");
define("Class_Quiz_06","U heeft gehaald: "); /*Bsp: You have reached 0 %  .... */
define("Class_Quiz_07","en daarmee bent u"); /* You have reached 0 %  and so you did not pass   */
define("Class_Quiz_08","geslaagd.");
define("Class_Quiz_09","gezakt.");/*Bsp:You have reached 0 %  and so you did not pass  */
define("Class_Quiz_10_AnonymousCert", "U maakte de toets m.b.v. een anoniem certificaat. U kunt dus geen gedrukt of PDF attest aanvragen.<br />");
define("Class_Quiz_11_RequestCert", "Attest aanvragen");
define("Class_Quiz_12_ExplainCert", "In verband met privacy richtlijnen mogen we hier geen persoonlijke gegevens verzamelen of bewaren.<br /><br />".
                                    "Om een gedrukt of PDF attest aan te vragen kunt u een email sturen naar <a class=\"http\" href=\"mailto:education@cacert.org?subject=Certificate for AssurerChallenge\">education@cacert.org</a> waarin u schrijft of u een gedrukte versie of een PDF versie wilt. Indien u een gedrukt attest wilt, voeg dan uw post adres toe.<br />".
                                    "De email mag <a class=\"http\" href=\"education.txt\">versleuteld</a> worden, en <b>moet ondertekend worden met het certificaat dat gebruikt is tijdens het maken van de toets</b>. D.m.v. het serienummer kan gecontroleerd worden dat u de toets gehaald heeft.".
                                    "<br />Kijk bij het \"Aangemeld als:\" vak in de rechter bovenhoek om te zien welk certificaat u momenteel gebruikt.<br />".
                                    "<br /><em>Voor gedrukte attesten vragen wij een donatie van 5 EUR voor verzending binnnen Europa, en 10 EUR voor verzending buiten Europa, i.v.m. de handelings en verzendkosten.<br />". /**/
                                    "Om te doneren kunt u een van onderstaande Paypal knoppen gebruiken, <a class=\"http\" href=\"https://www.cacert.org/index.php?id=13\">https://www.cacert.org/index.php?id=13</a> toont alle methoden om te doneren aan CAcert.</em><br />".
                                    "<br />Excuses voor eventueel ongemak.<br />");
define("Class_Quiz_13_Donate5", "5 EUR voor verzending binnen Europa");
define("Class_Quiz_14_Donate10", "10 EUR voor verzending buiten Europa");
define("Class_Topic_01","naam");
define("Class_Topic_02","aantal vragen");
define("Class_Topic_03","vragen per toets");
define("Class_Topic_04","minimum resultaat");
define("Class_Topic_05","bewerk onderwerp");
define("Class_Topic_06","activeer onderwerp");
define("Class_Topic_07","Deactiveer onderwerp: alle vragen over dit onderwerp zullen ook gede&#228;ctiveerd worden.");
define("Class_Topic_08","Verwijder dit onderwerp, met alle gerelateerde vragen en antwoorden");
define("Class_Topic_09","Min. percentage moet een nummer zijn, en mag niet groter dan 100 zijn");
define("Class_Topic_10","Onderwerp bestaat al.");
define("Class_Topic_11","Aantal vragen moet een positieve integer zijn.");
define("Class_Topic_12","minimum resultaat");
define("Collect_Question_01","Deze vraag bestaat al.");
define("Collect_Question_02","Ten minste 1 'gat' moet gedefineerd zijn. Gaten worden gedefineerd met [ ]. Het goede antwoord moet tussen de haken staan. Alle haken moeten gesloten worden.");
define("Collect_Question_03","vraag invullen");
define("Function_getContent_01","Welkom");
define("Function_getContent_02_Intro",'<div class="centered">Voor een korte introductie kijk a.u.b. even op de <a href="http://wiki.cacert.org/wiki/AssurerChallenge" rel="external">WiKi</a>.</div><br />');
define("Function_getTopic_01","Toon vorderingen");
define("Function_getTopic_02","Toon statistieken");
define("Function_getTopic_03","start toets");
define("Function_reallyDel_01","Zeker weten?");
define("Function_reallyDel_02","Bent u heel zeker dat u dit onderwerp wil verwijderen?");
define("Function_reallyDel_03","Als u ja antwoord zullen ook alle vragen en antwoorden verwijderd worden.");
define("Function_reallyDel_04","Bent u zeker dat u deze vraag wil verwijderen?");
define("Get_Content_01","Registratie geannuleerd!");
define("Global_01","U moet aangemeld zijn voor deze functie");
define("Global_02","terug");
define("Global_03","correct");
define("Global_04","datum");
define("Global_05","Resultaat");
define("Global_06","ID");
define("Global_07",'<h4 class="centered">Geen gegevens beschikbaar</h4>');
define("Global_08","vraag");
define("Global_09","onderwerp");
define("Global_10","rang"); /* translation to be finished */
define("Global_11","frequentie");
define("Global_12","type vraag");
define("Global_13","Ja");
define("Global_14","Nee");
define("Global_15","correcte antwoorden in %");
define("Global_16","U bent momenteel niet aangemeld");
define("Global_17","Login mislukt! Een geldig CAcert client certificaat is vereist.");
define("Global_18","Vraag ID");
define("Global_19","Login mislukt");
define("Global_20","omschrijving");
define("Index_01","aangemeld als :");
define("Login_01","Uw certificaat kon niet gecontroleerd worden.");
define("Login_02","Uw certificaat is ingetrokken.");
define("Login_03_No_Org_Certs","Organisatie (OA) certificaten worden niet aanvaard door CATS omdat deze niet eenvoudig naar een gebruikersaccount te herleiden zijn.");
define("Menue_01","Help");
define("Menue_02","Aanmelden");
define("Menue_03","Afmelden");
define("Menue_04","Voortgang");
define("Menue_05","Statistieken");
define("Menue_06","Toetsen");
define("Menue_07","Onderwerpen");
define("Menue_08","EN");
define("Menue_09","DE");
define("Menue_10","FR"); /* ?? a rajouté certainement has certainly added */
define("Statistic_01","beste antwoorden voor het onderwerp: ");
define("Statistic_02","slechtste antwoorden voor het onderwerp: ");
define("Statistic_03","vragen over dit onderwerp:");
define("Statistic_04","geslaagd");
define("Statistic_05","gezakt");
define("Statistic_06","gebruiker informatie");
define("Statistic_07","Gebruiker");
define("Statistic_08","geregistreerde gebruikers");
define("Statistic_09","beheerders");
define("Statistic_10","root certificaten");
define("Statistic_11","gebruikers met Class I certificaten");
define("Statistic_12","gebruikers met Class III certificaten");
define("Statistic_13","taalinstellingen");
define("Statistic_14","duits");
define("Statistic_15","engels");
define("Statistic_16","oorkonde verstuurd per "); /**/
define("Statistic_17","post");
define("Statistic_18","email");
define("Statistic_19","n.v.t.");
define("Statistic_20","toets informatie"); /**/
define("Statistic_21","datum");
define("Statistic_22","toetsen voltooid"); /**/
define("Statistic_23","toetsen gehaald");
define("Statistic_24","français"); /* ligne rajouté numérotation décaler a corrigé lors de l'intégration Line numbering added offset corrected during the integration */
define("Title_01","CATS onderwerpen");
define("Title_02","CATS vragen invoeren");
define("Title_03","CATS statistieken");
define("Title_04","CATS start toets");
define("Title_05","CATS vorderingen");
define("Title_06","CATS certificaat informatie");
define("Topic_01","Nota: u kan hier geen antwoorden als correct markeren die hieronder als foutief gemarkeerd zijn.");
define("Topic_02","Onderwerpen Overzicht");
define("Topic_03","vragen over dit onderwerp:");
?>
