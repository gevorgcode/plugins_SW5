#1. //MultiUsers page-um ete companyn active chi, cuyc tal message dimeq supportin
#2. sarqel email template installi jamanak, vor uxarkvi hraver
    #2.1 maili mej avelacnel merjel button (poxel status@ merjac)
    #2.2. stexcel nor status, merjac

#3. inviteAction logika mail uxarkelu
    #3.1. ete s_userum ka, asum neq hajox - NO
    #3.2. ete s_userum chka uxarkum neq - mail
    #3.2.1 ete s_userum chka, u et masteri koxmic der hraver chka uxarkum neq - mail

#4. admini ejum tal editi hnaravorutyun hyureri role u active 
#5. mailic het stanalu link, tokenov (inch vor mi dzev pahel token u tokeni jamket)
#6. maili linkov galu ej, vortex klracvi partasir vorosh dashter u parol u ksarqvi user,multiuser heto redirect klni accounti ej
7. porcel gtenl lav lucum amen type-i hamar vonc hide anel vorosh infoner, u tal hamapatasxan hnaravorutyunner
#8. jnjel angleren texter@
#9. sarqel role history status historyi nman (kirarel 1. editi jamank ev ayl texer ete kan)
#10. add log info (status changes, role changes, naev mutq u elq logic (amen tesak log@ arandznacvac)) masteri koxmic useri spiski mej
#11. email changi pah@ accounti indexum hashvi arnel
#12. send mail avelacnel logerum
#13. resend mail aveacnel logerum
#14. resend success-i success mesag@ texapoxel verev
15. topbarum cuyc tal info usernerin vor iranq user en, iranc role, iranc companyn. popupov bace info iranc roli u hnaravorutyunneri masin
16. activate page-um cuyc tal info iranc role-i u hnaravorutyunneri masin 
#17. admin koxmic delete talu jamanak userin s_userum sarqel inactive
18. multiuseri hamar sarqel ej, grel vorosh infoner ira masin, ev tal inqn iran jnjelu hnaravorutyun
19. multiuser subscriberi L85 mej avelacnel sax accountneri orderneri u ayl infoner karavarman hamar


///aragtodo
#invite aneluc stugel ete et email@ arden invite exaca u rejecta arel, mtacel logika
#jnjel status overriten
#bolor statusner@ unenan iranc guyn@ kam bg
#usernerin tal editi hnaravorutyun masteri ejum
#userediti ejum tal zgushacum, vor pending->reject@ aylevs hnaravorutyun chi ta et userin kanchel, active u inactive -> deleted@ anveradarc a
#sarqel reject logikan
#sarqel confirm logikan (/sarqel nor user, active anel, tal random pass u dzebn asel poxelu, usernerum sax pendingner@ myus masteri koxmic ete ka reject anel )
#resend pendingi pah@ mtacel u poxel



$roles = [
    'admin'        => ['description' => 'Vollständiger Zugriff auf alle Funktionen (Full access to all features)<br>Kann Benutzer verwalten, Bestellungen genehmigen und konfigurieren 🔧 (Can manage users, approve orders, and configure settings)', 'name' => 'Admin'],
    'buyer'        => ['description' => 'Mitarbeiter mit Einkaufsrechten (Employee with purchasing rights)<br>Kann Produkte zum Warenkorb hinzufügen, Bestellungen aufgeben (mit Genehmigung falls erforderlich) und Bestellverlauf einsehen 📋 (Can add products to the cart, place orders (with approval if required), and view order history)', 'name' => 'Einkäufer'],
    'accounting'        => ['description' => 'Zuständig für Rechnungen und Finanzen (Responsible for invoicing & finance)<br>Zugriff nur auf Rechnungen und Bestellverlauf, kein Einkauf möglich ✅ (Access to invoices & order history only, no purchasing allowed)', 'name' => 'Buchhaltung'],
    'approver'        => ['description' => 'Kann Bestellungen anderer Benutzer genehmigen (Can approve other users orders)<br>Sieht eingereichte Bestellungen ein, kann genehmigen oder ablehnen 👤 (Views submitted orders, can approve or reject)', 'name' => 'Genehmiger'],
    'user_read_only'        => ['description' => 'Eingeschränkter Benutzer – z. B. Praktikanten (Limited user – e.g. interns)<br>Kann nur den Produktkatalog einsehen, kein Einkauf erlaubt 🔒 (Can view product catalog only, no purchasing allowed)', 'name' => 'Nur anzeigen'],
];
