<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel = "stylesheet" href="stilus/stilus.css">
    <link rel = "stylesheet" href="stilus/statisztikak_stilus.css">
    <link rel="icon" href="img/icon.png">
    <title>Statisztikák</title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li>
                    <a href="index.php">Bemutatkozás</a>
                </li>
                <li>
                    <a href="filmek.php">Filmek</a>
                </li>
                <li>
                    <a href="karakterek.php">Karakterek</a>
                </li>
                <li>
                    <a aria-current="page" href="statisztikak.html">Statisztikák</a>
                </li>
                <li>
                    <a href="forum.php">Fórum</a>
                </li>
            </ul>
        </nav>
        <div id="alap">
            <div id="baloszlop">
                <p class="animate-charcter">A számok mesélnek.</p>
            </div>
            <div id="focimkep"> 
                <p><img class="nyomtat" src="img/shrek-banner.png" alt="jobb kint mint bent" width="1020"></p>
            </div>
        </div>
    </header>
    <hr>
    <main>
        <div class="leiras">
            <p class="cim">Az adatok magukért beszélnek</p>
            <p class="leiras">Az alábbi táblázatban jól látszik, hogy milyen népszerűek a filmek.</p>
    
            <table>
                <thead>
                    <tr>
                        <th id="film">Filmek</th>
                        <th id="budget">Költségek</th>
                        <th id="income">Globális bevétel </th>
                        <th id="relase">Megjelenés ideje Magyarországon</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td id="green" headers="film">Shrek 1</td>
                        <td headers="budget">60,000,000$</td>
                        <td headers="income">488,441,368$</td>
                        <td headers="relase">2001. jún. 21.</td>
                    </tr>
                    <tr>
                        <td id="green" headers="film">Shrek 2</td>
                        <td headers="budget">150,000,000$</td>
                        <td id="red" headers="income">928,760,770$</td>
                        <td headers="relase">2004. júl. 01.</td>
                    </tr>
                    <tr>
                        <td id="green" headers="film">Harmadik Shrek</td>
                        <td headers="budget">160,000,000$</td>
                        <td headers="income">813,367,380$</td>
                        <td headers="relase">2007. júl. 14.</td>
                    </tr>
                    <tr>
                        <td id="green" headers="film">Shrek a vége, fuss el véle</td>
                        <td id="red" headers="budget">165,000,000$</td>
                        <td headers="income">752,600,867$</td>
                        <td headers="relase">2010. júl. 08.</td>
                    </tr>
                </tbody>
            </table>
            <p class="cim">Nézzünk meg pár véleményt is a filmekről</p>
            <p class="filmcimek"><a id="lightgreen">Shrek -</a> IMDB: 7.9/10 | Rotten Tomatoes: 88%</p>
            <blockquote cite="https://www.mafab.hu/movies/shrek-44088.html&tab=1"><q>Többször nézős mese, már csak a zenék miatt is. A története egész izgalmas és ami a kulcs benne, hogy rengeteg szereplővel dogolzik, akiket mindenki ismer innen-onnan.</q></blockquote>
            <blockquote cite="https://www.mafab.hu/movies/shrek-44088.html&tab=1"><q>Az egyik legmulattatóbb animációs film, tele kedves és mulatságos szereplőkkel, egyszerűen nem lehet nem szeretni. Felidézi a gyermekkori mesék főbb karaktereit, kiparodizálva azokat.</q></blockquote>
            <p class="filmcimek"><a id="lightgreen">Shrek 2 -</a> IMDB: 7.3/10 | Rotten Tomatoes: 89%</p>
            <blockquote cite="https://www.mafab.hu/movies/shrek-2-44089.html"><q>Semmiben sem maradt el az elsőtől, újabb helyes karaktereket hoztak be a mesébe. A története teljesen más, mint az előző. Nagyon jó humora van és Shrek a régi.</q></blockquote>
            <blockquote cite="https://www.mafab.hu/movies/shrek-2-44089.html"><q>Sikerült az első rész szintjét elérni, bár ez szerintem itt már nem csak Szamárnak köszönhető, hanem a Csizmáskandúr behozása a csapatba nagyszerű húzás volt. Ezen kívül újabb látványos helyszínek, a grafika továbbra is első osztályú, ez az alkotás is nagyszerű kikapcsolódás a családnak.</q></blockquote>
            <p class="filmcimek"><a id="lightgreen">Harmadik Shrek -</a> IMDB: 6.1/10 | Rotten Tomatoes: 41%</p>
            <blockquote cite="https://www.mafab.hu/movies/harmadik-shrek-3750.html"><q>Olyan igazi Shrek-es történet, ahol valóban nem a külső alapján ítélik meg a figurákat. Nekem nagyon tetszett.</q></blockquote>
            <blockquote cite="https://www.mafab.hu/movies/harmadik-shrek-3750.html&tab=1#tabs"><q>Klasszikus shrekes mese egy kis csavarral. Jó a gonosz ellen... Azért ennyi rész után többet vártam volna, de ettől függetlenül egész jó lett. Bár több ütős poén azért jólesett volna. A zenéjét ennek is nagyon szerttem. Igazi klasszikus.</q></blockquote>
            <p class="filmcimek"><a id="lightgreen">Shrek a vége, fuss el véle -</a> IMDB: 6.3/10 | Rotten Tomatoes: 57%</p>
            <blockquote cite="https://www.mafab.hu/movies/shrek-a-vege-fuss-el-vele-45798.html"><q>Picit talán már sok a zöld Ogréből, de nekem ez is tetszett csak picit marad el az előzőektől. Ugye már mindent láttunk, most új szereplőként jött a manó.</q></blockquote>
            <blockquote cite="https://www.mafab.hu/movies/shrek-a-vege-fuss-el-vele-45798.html"><q>Egy kicsivel jobb lett mint a harmadik rész, és ez talán az új ogréknak köszönhető. Itt is sok karakter van, ugyan úgy mint az előző részben, de valahogy itt jobban tudták kezelni a számtalan szereplőt. Ismét sok érzelem van benne, de nem a humor rovására.</q></blockquote>
        </div>
    </main>
    

</body>
</html>