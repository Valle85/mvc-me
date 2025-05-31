![Projektbild](public/img/proj.png)

# Femkortspoker - Projekt i MVC-kursen

Detta är ett skolprojekt där man spelar traditionell femkortspoker mot datorn. Projektet är en del av kursen "Objektorienterade webbreknologier".

## Funktioner

- Spelaren får 5 kort och kan byta upp till 3 gånger
- En datorhand skapas automatiskt
- Resultatet utvärderas efter sista bytet
- Spelaren kan satsa pengar varje runda
- Spelet avslutas när pengarna tar slut

## Kom igång

git clone https://github.com/Valle85/mvc-me.git
cd mvc/me/report
composer install
npm install
npm run build
symfony server:start


## Dokumentation & Analys

- [PHPDoc (lokalt)](docs/api/index.html)
- [PhpMetrics (lokalt)](metrics/index.html)  
- [Scrutinizer](https://scrutinizer-ci.com/g/Valle85/mvc-me/)

[![Build Status](https://scrutinizer-ci.com/g/Valle85/mvc-me/badges/build.png?b=main)](https://scrutinizer-ci.com/g/Valle85/mvc-me/)  
[![Code Coverage](https://scrutinizer-ci.com/g/Valle85/mvc-me/badges/coverage.png?b=main)](https://scrutinizer-ci.com/g/Valle85/mvc-me/)  
[![Quality Score](https://scrutinizer-ci.com/g/Valle85/mvc-me/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/Valle85/mvc-me/)

---

## Om me-sidan

![me-sida](public/img/screenshot.png)
Min me-sida finns på `/`, med presentation, kursbeskrivning och redovisningar för varje kmom. Sidan är byggd i Symfony med layout, navbar, footer och JSON API.


## Navigering

- / – Presentation av mig själv  
- /about – Kursbeskrivning + länkar  
- /report – Redovisningstexter  
- /lucky – Slumpmässigt värde  
- /game – Startsida för kortspelet 21  
- /game/play – Spelets spelplan  
- /api – Översikt över JSON API  
- /api/quote – JSON med dagens citat  
- /api/game – JSON-status för kortspelet  
- /card – Meny för kortlek  
- /card/deck – Visar hela kortleken  
- /card/deck/shuffle – Blandar kortleken  
- /card/deck/draw – Drar ett kort  
- /card/deck/draw/:number – Drar valfritt antal kort  

# Kodkvalitet med PhpMetrics och Scrutinizer

Projektet innehåller en analys av kodkvalitet med hjälp av PhpMetrics och Scrutinizer. Fullständig rapport och analys finns på sidan /metrics.

[![Build Status](https://scrutinizer-ci.com/g/Valle85/mvc-me/badges/build.png?b=main)](https://scrutinizer-ci.com/g/Valle85/mvc-me/)
[![Code Coverage](https://scrutinizer-ci.com/g/Valle85/mvc-me/badges/coverage.png?b=main)](https://scrutinizer-ci.com/g/Valle85/mvc-me/)
[![Quality Score](https://scrutinizer-ci.com/g/Valle85/mvc-me/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/Valle85/mvc-me/)

Efter analys med PhpMetrics och Scrutinizer identifierades bland annat duplicerad kod och lågt Cohesion-värde i vissa klasser. Genom att bryta ut logik till mindre metoder och flytta kod till rätt plats förbättrades Quality Score från 7.2 till 8.4.

# Före och efter analys 
Jag genomförde förbättringar i kodtäckning baserat på analyser från PhpMetrics och Scrutinizer:

- Lade till tester för PokerHandEvaluator 
- Täckte klassen till 90% kodtäckning

![Alt-text](public/img/before.png)
![Alt-text](public/img/after.png)

## Verktyg 

- Scrutinizer
- PhpMetrics
- PHP
- Symfony

## Kommandon 

- composer phpunit
- composer phpmetrics
- composer lint
- composer phpdoc 