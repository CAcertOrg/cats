<?php
define("accept_Login_01","Sie sind noch nicht im System angemeldet. <br /> Bitte �berpr�fen Sie die Informationen Ihres Zertifikats und best�tigen Sie die Registrierung.");
define("accept_Login_02","Informationen Ihres Zertifikats");
define("accept_Login_03","Herausgegeben f�r:");
define("accept_Login_04","Allgemeiner Name(CN)");
define("accept_Login_05","Seriennummer ");
define("accept_Login_06","Email-Adresse  ");
define("accept_Login_07","Herausgegeben von:");
define("accept_Login_08","Organisation");
define("accept_Login_09","Organisationseinheit");
define("accept_Login_10","herausgegeben am");
define("accept_Login_11","l�uft ab am");
define("accept_Login_12","Mit diesen Informationen Registrieren?<br /><br />".
                         "Nur die Seriennummer ihres Zertifikats wird in der Datenbank gespeichert, aber wenn Sie nach einem bestandenen Test eine gedruckte Best�tigung anfordern wollen, muss diese Best�tigung auf den im Zertifikat enthaltenen Allgemeinen Namen ausgestellt werden!<br />".
                         "F�r anonyme Zertifikate (Allgemeiner Name \"CAcert WoT User\") kann keine Best�tigung ausgestellt werden.");
define("accept_Login_13","G�ltigkeit:");
define("Button_01","Neues Thema erstellen");
define("Button_02","Zur�ck zu den Themen");
define("Button_03","Zur�ck zu den Fragen");
define("Button_04","Fragen erstellen");
define("Button_05","Tabellarisch anzeigen");
define("Button_06","als Graph anzeigen");
define("Button_07","als Balken anzeigen");
define("Button_08","beste Beantwortung");
define("Button_09","schlechteste Beantwortung");
define("Button_10","Sie haben sich erfolgreich eingeloggt");
define("Button_11","speichern");
define("Button_12","�nderungen speichern");
define("Button_13","Antworten editieren");
define("Button_14","Antwort hinzuf�gen");
define("Button_15","Antwort entfernen");
define("Button_16","Test auswerten");
define("Button_17","Statistik Info");
define("Button_18","Benutzer Info");
define("Button_19","Test Statistik");
define("Check_Cert_01","Wenn Sie eine Best�tigung per Email oder Post erhalten m�chten, muss Ihr Name im Zertifikat enthalten sein! <br /> Sie k�nnen entweder mit der Registrieung fortfahren, allerdings haben Sie dann nicht die M�glichkeit die Best�tigung per E-Mail oder �ber den Postweg zu erhalten. <br />Sie k�nnen aber auch die Registrierung mit diesem Zertifikat abbrechen und sich mir einem anderen  Zertifikat anmelden, indem Ihr Name enthalten ist. ");
define("certificateDocu_01","Wenn Sie m�chten senden wir Ihnen ein Best�tigung zu, dass Sie den Assurer Test erfolgreich abgeschlossen haben. Im Dokument wird Ihr Name, der im Zertifikat enthalten ist verwendet.");
define("certificateDocu_02","Nein, ich ben�tige keine Best�tigung");
define("certificateDocu_03","Ja, bitte senden Sie mir die Best�tigung als PDF-Attachement via eMail  (Wir verwenden die Email-Adresse, die in Ihrem Zertifikat enthalten ist.)");
define("certificateDocu_04","Ja, bitte senden sie mir die Best�tigung auf dem Postweg zu");
define("certificateDocu_05","Vorname");
define("certificateDocu_06","Nachname");
define("certificateDocu_07","Stra�e");
define("certificateDocu_08","PLZ");
define("certificateDocu_09","Stadt");
define("certificateDocu_10","Bundesland");
define("certificateDocu_11","Land");
define("certificateDocu_12","Alle Felder m�ssen ausgef�llt sein, wenn sie �ber den Postweg Ihre Beglaubigung erhalten m�chten.S");
define("Class_Answer_01","Details der Antworten");
define("Class_Answer_02","Antworten");
define("Class_Answer_03","Antwort");
define("Class_Answer_04","In zu wenigen Antworten befindet sich Inhalt, es m�ssen immer mindestens 2 Antworten  ausgef�llt sein.");
define("Class_Answer_05","Mindestens eine Frage muss als 'Korrekt' markiert sein und in mindestens 2 Antworten muss sich Inhalt befinden.");
define("Class_Answer_06","Mindestens eine Frage muss als 'Korrekt' markiert sein.");
define("Class_Answer_07","Bei L�ckentext d�rfen die falschen Antworten nicht wie die richtigen lauten");
define("Class_Answer_08","Mindestens eine Antwort muss falsch bzw richtig sein");
define("Class_Answer_09","richtig");
define("Class_Answer_10","falsch");
define("Class_Progress_01","Anzahl der Fragen");
define("Class_Progress_02","Es sind zu viele Daten zu diesem Thema in der Datenbank enthalten.  "); // geh�rt zu Lernfortschritte_angezeigt
define("Class_Progress_03","Darstellung der letzten");
define("Class_Progress_04","Lernfortschritte");
define("Class_Progress_05","Keine Daten vorhanden");
define("Class_Progress_06","Keine weiteren Infos zu:");/*Bsp: Keine weiteren Infos zu : 5 Fragen */
define("Class_Progress_07","Frage(n)");
define("Class_Progress_08","falsch beantwortete Fragen");
define("Class_Question_01","Klicken Sie hier um n�here Informationen �ber diese Frage zu erhalten");
define("Class_Question_02","Setzen Sie die Frage inaktiv");
define("Class_Question_03","Setzen Sie die Frage aktiv");
define("Class_Question_04","L�schen Sie die Frage");
define("Class_Question_05","Keine Fragen in der Datenbank vorhanden");
define("Class_Question_06","Details der Frage");
define("Class_Quiz_01","Es gibt nicht genug Fragen zu diesem Thema bitte w�hlen sie ein anderes Thema aus");
define("Class_Quiz_02","Test");
define("Class_Quiz_03","Auswertung des Tests");
define("Class_Quiz_04","Ihr Gesamtergebnis ist:");
define("Class_Quiz_05","Minimum ist ein Ziel von :");
define("Class_Quiz_06","Sie haben folgende Pozentzahl erreicht:"); /*Bsp: You have reached 0 %  .... */
define("Class_Quiz_07","und somit");/* You have reached 0 %  and so you did not pass   */
define("Class_Quiz_08","bestanden");
define("Class_Quiz_09","nicht bestanden");/*Bsp:You have reached 0 %  and so you did not pass  */
define("Class_Quiz_10_AnonymousCert", "Sie haben ein anonymes Zertifikat zum Anmelden verwendet, deshalb k�nnen Sie keine Best�tigung beantragen.<br>");
define("Class_Quiz_11_RequestCert", "Best�tigung beantragen");
/*
define("Class_Quiz_12_ExplainCert", "Aus Datenschutzgr�nden d�rfen wir hier keine pers�nlichen Daten von Ihnen abfragen.<br /><br />".
                                    "Um eine Best�tigung ausgedruckt oder als PDF zu beantragen schicken Sie bitte eine EMail an <a class=\"http\" href=\"mailto:education@cacert.org?subject=Certificate for AssurerChallenge\">education@cacert.org</a> in der Sie uns sagen, ob Sie eine gedrucktes oder eine elektronische (PDF-)Best�tigung beantragen. Falls Sie eine gedruckte Best�tigung w�nschen geben Sie bitte auch Ihre Postanschrift an.<br />".
                                    "Die Mail kann <a class=\"http\" href=\"education.txt\">verschl�sselt</a> und <b>muss mit dem Zertifikat signiert sein, dass Sie zum Login f�r diesen Test verwendet haben</b>, damit wir anhand der Seriennummer pr�fen k�nnen, ob Sie den Test tats�chlich bestanden haben. ".
                                    "Ein Blick auf den \"eingelogged als:\" Kasten an der oberen rechten Ecke gibt Ihnen Informationen �ber das Zertifikat, das Sie gerade benutzen.<br />".
                                    "<br /><em>F�r eine gedruckte Best�tigung bitten wir Sie um eine Spende in H�he von etwa 5 EUR f�r Versand innerhalb Europas und 10 EUR f�r weltweiten Versand um die Kosten f�r Herstellung und Versand zu abzudecken.<br />".
                                    "Um �ber PayPal zu spenden k�nnen Sie den Button unten verwenden, <a class=\"http\" href=\"https://www.cacert.org/index.php?id=13\">https://www.cacert.org/index.php?id=13</a> zeigt Ihnen alle M�glichkeiten, wie Sie CAcert Spenden zukommen lassen k�nnen.</em><br />".
                                    "<br />Wir bitten Sie, die Unannehmlichkeiten zu entschuldigen.<br />");*/
define("Class_Quiz_12_ExplainCert", "Aus Datenschutzgr�nden d�rfen wir hier keine pers�nlichen Daten von Ihnen abfragen.<br /><br />".
                                    "Wir k�nnen momentan keine Anfragen nach Urkunden bearbeiten. Sie k�nnen trotzdem eines beantragen indem Sie eine Mail an <a class=\"http\" href=\"mailto:education@cacert.org?subject=Certificate for AssurerChallenge\">education@cacert.org</a> schicken, aber Sie sollten davon ausgehen dass die Bearbeitung <b>sehr</b> lange dauern wird!<br />".
                                    "<br />Wir bitten Sie, die Unannehmlichkeiten zu entschuldigen.<br />");
define("Class_Quiz_13_Donate5", "5 EUR f�r Versand innerhalb Europas");
define("Class_Quiz_14_Donate10", "10 EUR f�r Versand au�erhalb Europas");
define("Class_Topic_01","Name");
define("Class_Topic_02","Anzahl Fragen");
define("Class_Topic_03","Fragen pro Test");
define("Class_Topic_04","mind. Prozent");
define("Class_Topic_05","Thema bearbeiten");
define("Class_Topic_06","Setzen Sie das Thema aktiv");
define("Class_Topic_07","Setzen Sie das Thema inakiv, alle Fragen in diesem Thema werden ebenfalls inaktiv gesetzt.");
define("Class_Topic_08","L�schen Sie das Thema und alle dazugeh�rien Fragen und Antworten");
define("Class_Topic_09","min. Prozentzahl muss eine Zahl sein und darf nicht gr��er als 100 sein");
define("Class_Topic_10","Dieses Thema existiert bereits");
define("Class_Topic_11","Anzahl der Fragen muss eine Zahl sein und darf nicht negativ sein");
define("Class_Topic_12","min. Prozentzahl");
define("Collect_Question_01","Diese Frage existiert bereits ");
define("Collect_Question_02","Mindestens eine L�cke muss definiert sein. L�cken werden mittels [ ] erstellt. In der L�cken muss sich die richtige Antwort befinden. Alle L�cken m�ssen wieder geschlossen werden. ");
define("Collect_Question_03","enter question");
define("Function_getContent_01","Willkommen");
define("Function_getContent_02_Intro",'<div class="centered">Eine kurze Einf�hrung gibts <a href="http://wiki.cacert.org/wiki/AssurerChallenge" rel="external">im WiKi</a></div><br />');
define("Function_getTopic_01","Fortschritt anzeigen");
define("Function_getTopic_02","Statistik anzeigen");
define("Function_getTopic_03","Test erstellen");
define("Function_reallyDel_01","L�schvorgang");
define("Function_reallyDel_02","M�chten Sie das Thema wirklich l�schen?");
define("Function_reallyDel_03","Alle Fragen und Antworten werden ebenfalls gel�scht, wenn Sie best�tigen.");
define("Function_reallyDel_04","M�chten Sie die Frage wirklich l�schen?");
define("Get_Content_01","Registrierung wurde abgebrochen! ");
define("Global_01","Sie m�ssen eingeloggt sein um diese Funktionen nutzen zu k�nnen");
define("Global_02","zur�ck");
define("Global_03","korrekt");
define("Global_04","Datum");
define("Global_05","Ergebnis");
define("Global_06","ID");
define("Global_07",'<h4 class="centered">Keine Daten vorhanden</h4>');
define("Global_08","Frage");
define("Global_09","Thema");
define("Global_10","Pos.");
define("Global_11","H�ufigkeit");
define("Global_12","Fragetyp");
define("Global_13","Ja");
define("Global_14","Nein");
define("Global_15","korrekt beantwortet in %");
define("Global_16","Sie sind momentan nicht eingeloggt.");
define("Global_17","Loginvorgang fehlgeschlagen ! Es wird ein g�ltiges Zertifikat von CAcert ben�tigt.");
define("Global_18","ID der Frage");
define("Global_19","Loginvorgang fehlgeschlagen");
define("Global_20","Beschreibung");
define("Index_01","eingeloggt als :");
define("Login_01","Ihr Zertifikat konnte nicht �berpr�ft werden");
define("Login_02","Ihr Zertifikat wurde wiederrufen");
define("Login_03_No_Org_Certs","Organisations-Zertifikate werden von CATS nicht akzeptiert, da sie sich nicht einfach einem Benutzerkonto zuordnen lassen.");
define("Login_04_No_Server_Certs","Ihr Zertifikat enth�lt kein Email-Feld, vermutlich handelt es sich um ein Server-Zertifikat.<br />".
                                  "Server-Zertifikate werden von CATS nicht akzeptiert, da sie keine Person identifizieren.");
define("Menue_01","Hilfe");
define("Menue_02","Login");
define("Menue_03","Logout");
define("Menue_04","Lernfortschritt");
define("Menue_05","Statistiken");
define("Menue_06","Test");
define("Menue_07","Themen");
define("Menue_08","switch to EN");
define("Menue_09","wechseln zu DE");
define("Statistic_01","beste Beantwortung zum Thema : ");
define("Statistic_02","schlechteste Beantwortung zum Thema: ");
define("Statistic_03","Fragen zum Thema:");
define("Statistic_04","bestanden");
define("Statistic_05","fehlgeschlagen");
define("Statistic_06","Benutzer Informationen");
define("Statistic_07","Benutzer");
define("Statistic_08","registrierte Benutzer");
define("Statistic_09","davon Administratoren");
define("Statistic_10","Root Zertifikate");
define("Statistic_11","Benutzer Class I Zertifkat");
define("Statistic_12","Benutzer Class III Zertifkat");
define("Statistic_13","Spracheinstellung");
define("Statistic_14","Deutsch");
define("Statistic_15","Englisch");
define("Statistic_16","Versandoption der Zertifikate");
define("Statistic_17","Post");
define("Statistic_18","Email");
define("Statistic_19","keine");
define("Statistic_20","Info �ber Tests");
define("Statistic_21","Datum");
define("Statistic_22","durchgef�hrte Tests");
define("Statistic_23","davon bestanden");
define("Statistic_24","Franz�sisch");
define("Title_01","CATS Themen");
define("Title_02","CATS Fragen erstellen");
define("Title_03","CATS Statistik");
define("Title_04","CATS Test starten");
define("Title_05","CATS Lernfortschritt");
define("Title_06","CATS Zertifikatsinformationen");
define("Topic_01","Achtung:Sie k�nnen keine Antworten als richtig deklarieren, die unten als falsch deklariert wurden");
define("Topic_02","Themen �bersicht");
define("Topic_03","Fragen zum Thema:");


?>
