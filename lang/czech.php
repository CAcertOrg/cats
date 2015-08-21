<?php
define("accept_Login_01","Nejste zaregistrován(a). <br /> Zkontrolujte údaje svého certifikátu a potvrďte registraci.");
define("accept_Login_02","údaje certifikátu");
define("accept_Login_03","Vydán komu:");
define("accept_Login_04","Běžné jméno (CN)");
define("accept_Login_05","Pořadové číslo");
define("accept_Login_06","e-mailová adresa  ");
define("accept_Login_07","Vydán kým:");
define("accept_Login_08","Organizace");
define("accept_Login_09","Organizační jednotka");
define("accept_Login_10","Vydán kdy");
define("accept_Login_11","Platnost do");
define("accept_Login_12","Registrovat tímto certifikátem?<br /><br />".
                         "Bude uloženo pouze pořadové číslo certifikátu, ale požádáte-li po složení zkoušky o písemné osvědčení, bude muset být vydáno na Vaše Běžné jméno (Common Name) uložené v certifikátu!<br />".
                         "Tištěná osvědčení nemohou být vydána pro anonymní certifikáty (kde Běžné jméno je \"CAcert WoT User\").");
define("accept_Login_13","Platnost:");
define("Button_01","vytvořit nové téma");
define("Button_02","zpět na správu témat");
define("Button_03","zpět na správu dotazů");
define("Button_04","nový dotaz");
define("Button_05","zobrazit jako seznam");
define("Button_06","zobrazit jako čárový graf");
define("Button_07","zobrazit jako sloupcový graf");
define("Button_08","nejlepší odpověď");
define("Button_09","nejhorší odpověď");
define("Button_10","úspěšné přihlášení");
define("Button_11","uložit");
define("Button_12","uložit změny");
define("Button_13","upravit odpovědi");
define("Button_14","přidat odpověď");
define("Button_15","smazat odpověď");
define("Button_16","vyhodnotit test");
define("Button_17","statistické údaje");
define("Button_18","uživatelské údaje");
define("Button_19","statistika testu");
define("Check_Cert_01","Přejete-li si dostat dokument klasickou poštou nebo e-mailem, musí být v certifikátu uloženo Vaše jméno!<br /> Můžete pokračovat v registraci, ale nemůžete zvolit <i>poslat klasickou poštou</i> nebo <i>poslat e-mailem</i>.<br /> Můžete také zrušit tuto registraci a registrovat se jiným certifikátem, v němž je Vaše jméno uloženo.");
define("certificateDocu_01","Pokud chcete, můžeme engross dokument dokládající, že jste úspěšně složil zkoušku zaručovatele. Dokument bude vydán na Vaše jméno, jak je uvedeno ve Vašem digitálním certifikátu.");
define("certificateDocu_02","Ne, nepotřebuji takový dokument.");
define("certificateDocu_03","Ano, prosím pošlete mi dokument jako přílohu PDF e-mailem  (použijte e-mailovou adresu a jméno uložené v certifikátu).");
define("certificateDocu_04","Ano, prosím pošlete mi dokument klasickou poštou na tuto adresu:");
define("certificateDocu_05","první (rodné, křestní) jméno");
define("certificateDocu_06","příjmení");
define("certificateDocu_07","ulice");
define("certificateDocu_08","poštovní směrovací číslo");
define("certificateDocu_09","město, obec");
define("certificateDocu_10","kraj, stát");
define("certificateDocu_11","země");
define("certificateDocu_12","Chcete-li obdržet dokument klasickou poštou, musíte vyplnit všechna pole.");
define("Class_Answer_01","odpovědi podrobně");
define("Class_Answer_02","odpovědi");
define("Class_Answer_03","odpověď");
define("Class_Answer_04","Je třeba označit alespoň dvě odpovědi.");
define("Class_Answer_05","Alespoň jedna odpověď musí být označena jako 'správná' a celkem musí být označeny alespoň dvě.");
define("Class_Answer_06","Alespoň jedna odpověď musí být označena jako 'správná'");
define("Class_Answer_07","V doplňovacích odpovědích se musí lišit správná odpověď od nesprávné!");
define("Class_Answer_08","Alespoň jedna odpověď musí být označena jako správná a jedna jako nesprávná!");
define("Class_Answer_09","správně");
define("Class_Answer_10","chybně");
define("Class_Progress_01","počet otázek");
define("Class_Progress_02","Příliš mnoho údajů uložených v databázi. "); // gehört zu Lernfortschritte_angezeigt
define("Class_Progress_03","Zobrazení poslední");
define("Class_Progress_04","pokrok ve výuce");
define("Class_Progress_05","Další údaje nejsou dostupné"); /*Bsp: Keine weiteren Infos zu : 5 Fragen */
define("Class_Progress_06","Další údaje nedostupné pro:");
define("Class_Progress_07","otázka (otázky)");
define("Class_Progress_08","nesprávně zodpovězené otázky");
define("Class_Question_01","Klikněte pro zobrazení více informací");
define("Class_Question_02","inaktivovat otázku");
define("Class_Question_03","aktivovat otázku ");
define("Class_Question_04","odstranit otázku");
define("Class_Question_05","V databázi nejsou dostupné otázky");
define("Class_Question_06","podrobnosti otázky");
define("Class_Quiz_01","K tomuto tématu není dostatek otázek. Prosím, zvolte jiné téma.");
define("Class_Quiz_02","test");
define("Class_Quiz_03","Vyhodnocení testu");
define("Class_Quiz_04","Vaše celkové skóre:");
define("Class_Quiz_05","Minimální požadavky pro test:");
define("Class_Quiz_06","Dosáhl(a) jste: "); /*Bsp: You have reached 0 %  .... */
define("Class_Quiz_07","a proto jste");/* You have reached 0 %  and so you did not pass   */
define("Class_Quiz_08","zkoušku složil(a).");
define("Class_Quiz_09","zkoušku nesložil(a).");/*Bsp:You have reached 0 %  and so you did not pass  */
define("Class_Quiz_10_AnonymousCert", "Skládal(a) jste zkoušku za použití anonymního certifikátu, takže si nemůžete vyžádat tištěné ani PDF osvědčení o složení zkoušky.<br />");
define("Class_Quiz_11_RequestCert", "Vyžádat osvědčení");
/* Původní text 
define("Class_Quiz_12_ExplainCert", "Z důvodu ochrany soukromí zde nemůžeme přijímat Vaše osobní údaje.<br /><br />".
                                    "Pro vyžádání tištěného nebo PDF osvědčení pošlete e-mail na <a class=\"http\" href=\"mailto:education@cacert.org?subject=Certificate ve věci AssurerChallenge\">education@cacert.org</a> a sdělte, zda žádáte verzi tištěnou nebo PDF. Chcete-li tištěné osvědčení, připojte prosím svoji poštovní adresu (klasické pošty).<br />".
                                    "Pošta může být <a class=\"http\" href=\"education.txt\">zašifrovaná</a> a <b>musí být podepsána certifikátem, který jste použil(a) při testu</b> kontrolou jeho pořadového čísla můžeme ověřit, že jste složil(a) zkoušku. ".
                                    "Rámeček v pravém horním rohu \"Přihlášen jako:\" obsahuje údaje o Vámi použitém certifikátu.<br />".
                                    "<br /><em>Za tištěné osvědčení Vás požádáme o dar asi 5 EUR za poštovné v rámci Evropy a 10 EUR za poštovné v rámci světa a za zpracování.<br />".
                                    "Pro darování použijte PayPal tlačítko dole, <a class=\"http\" href=\"https://www.cacert.org/index.php?id=13\">https://www.cacert.org/index.php?id=13</a> ukže všechny metody darování CAcert.</em><br />".
                                    "<br />Omlouváme se za případné obtíže.<br />");*/
/* Náhrada za čas, kdy nemůžeme zpracovávat žádosti o osvědčení */
define("Class_Quiz_12_ExplainCert", "Z důvodu ochrany osobnosti zde neukládáme Vaše osobní údaje.<br /><br />".
                                    "V současnosti můžeme zpracovávat žádosti o osvědčení o složení zkoušky. Přesto o ně můžete žádat e-mailem na <a class=\"http\" href=\"mailto:education@cacert.org?subject=Certificate for AssurerChallenge\">education@cacert.org</a> zpracování žádosti však může trvat <b>velmi</b> dlouho!<br />".
                                    "<br />Omlouváme se za případné problémy.<br />");
define("Class_Quiz_13_Donate5", "5 EUR za poštovné v rámci Evropy");
define("Class_Quiz_14_Donate10", "10 EUR za poštovné mimo Evropu");
define("Class_Topic_01","jméno");
define("Class_Topic_02","počet otázek");
define("Class_Topic_03","počet otázek v testu");
define("Class_Topic_04","požadavek");
define("Class_Topic_05","upravit téma");
define("Class_Topic_06","aktivovat téma");
define("Class_Topic_07","Inaktivovat téma: Všechny otázky tohoto tématu budou také inaktivovány.");
define("Class_Topic_08","Smazat téma se všemi přiřazenými otázkami a odpověďmi");
define("Class_Topic_09","min. procento musí být číslo nejvýše 100");
define("Class_Topic_10","Téma již existuje.");
define("Class_Topic_11","Počet otázek musí být celé kladné číslo.");
define("Class_Topic_12","požadavek");
define("Collect_Question_01","Tato otázka již existuje.");
define("Collect_Question_02","Musí být definována alespoň jedna mezera k doplnění, vytvořená pomocí [ ]. Správná odpověď musí být umístěna do hranatých závorek. Všechny závorky musí být uzavřeny. ");
define("Collect_Question_03","zadejte otázku");
define("Function_getContent_01","Vítáme Vás");
define("Function_getContent_02_Intro",'<div class="centered">Krátký úvod najdete na <a href="http://wiki.cacert.org/wiki/AssurerChallenge/CZ" rel="external">WiKi</a></div><br />');
define("Function_getTopic_01","ukázat pokrok");
define("Function_getTopic_02","zobrazit statistiku");
define("Function_getTopic_03","zahájit test");
define("Function_reallyDel_01","smazat");
define("Function_reallyDel_02","Určitě chcete smazat toto téma?");
define("Function_reallyDel_03","Potvrzením smažete také všechny otázky a odpovědi.");
define("Function_reallyDel_04","Určitě chcete smazat tuto otázku?");
define("Get_Content_01","Registrace zrušena!");
define("Global_01","Pro použití této funkce se musíte přihlásit!");
define("Global_02","zpět");
define("Global_03","správně");
define("Global_04","datum");
define("Global_05","Výsledek");
define("Global_06","ID");
define("Global_07",'<h4 class="centered">Údaje nejsou dostupné.</h4>');
define("Global_08","otázka");
define("Global_09","téma");
define("Global_10","poz.");
define("Global_11","četnost");
define("Global_12","typ otázky");
define("Global_13","Ano");
define("Global_14","Ne");
define("Global_15","% správných odpovědí");
define("Global_16","Nyní nejste přihlášen(a)!");
define("Global_17","Chyba přihlášení! Je nutný platný klientský certifikát CAcert.");
define("Global_18","ID otázky");
define("Global_19","Chyba přihlášení");
define("Global_20","popis");
define("Index_01","přihlášen:");
define("Login_01","Váš certifikát nelze ověřit.");
define("Login_02","Váš certifikát byl odvolán.");
define("Login_03_No_Org_Certs","Certifikáty organizací nejsou pro CATS přípustné, neboť je nelze snadno sledovat k účtu uživatele.");
define("Menue_01","Nápověda");
define("Menue_02","Přihlášení");
define("Menue_03","Odhlášení");
define("Menue_04","Pokrok");
define("Menue_05","Statistika");
define("Menue_06","Testy");
define("Menue_07","Témata");
define("Menue_08","EN");
define("Menue_09","DE");
define("Statistic_01","Nejlepší výsledek tématu: ");
define("Statistic_02","nejhorší výsledek tématu: ");
define("Statistic_03","otázky pro toto téma:");
define("Statistic_04","uspěl(a)");
define("Statistic_05","neuspěl(a)");
define("Statistic_06","uživatelské údaje");
define("Statistic_07","Uživatel");
define("Statistic_08","registrovaní uživatelé");
define("Statistic_09","správci");
define("Statistic_10","kořenové certifikáty");
define("Statistic_11","uživatelský certifikát třídy 1");
define("Statistic_12","uživatelský certifikát třídy 3");
define("Statistic_13","jazyková nastavení");
define("Statistic_14","němčina");
define("Statistic_15","angličtina");
define("Statistic_16","zaslat osvědčení:");
define("Statistic_17","klasickou poštou");
define("Statistic_18","e-mailem");
define("Statistic_19","žádné");
define("Statistic_20","údaje o testu");
define("Statistic_21","datum");
define("Statistic_22","testy dokončeny");
define("Statistic_23","úspěšný test");
define("Statistic_24","francouzsky");
define("Title_01","témata CATS");
define("Title_02","otázky CATS");
define("Title_03","statistika CATS");
define("Title_04","Zahájit test CATS");
define("Title_05","postup výuky CATS");
define("Title_06","údaje certifikátu CATS");
define("Topic_01","POZOR: Zde nelze označit odpovědi za správné, když byly níže označeny za nesprávné.");
define("Topic_02","Přehled témat");
define("Topic_03","otázky v tomto tématu:");
?>
