<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <title>Jazzman's World</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, inital-scale=0.9" />
    <link rel="stylesheet" href="index.css" />
</head>

<body>
    
    <div id="wrapper">
        <header>
            <a href="/"><h1>Jazzman's World</h1></a>
        </header>

        <div id="left">
            <div id="content">

                <section>
                    <div class="ramkaArticle" style="flex: 3;">
                        <article>
                            <?php if(isset($errMsg)):?>
                                <h3 style="color:green"><?=$errMsg?></h3>
                            <?php endif ?>
                            <h3>Twój ulubony portal o gitarze jazzowej</h3><br/>
                            <p>Jazz powstał na drodze złożonego, wielofazowego procesu, w którym można wyróżnić etap rozwoju afrykańskiej muzyki ludowej i inkorporacji do niej elementów muzyki amerykańsko-europejskiej, wyodrębniania się gatunków muzycznych stanowiących źródła jazzu (negro spirituals, plantation songs, blues, ragtime) oraz krystalizowanie się nowego nurtu muzycznego w końcu wieku XIX.</p>

                            <p>Ludność czarnoskóra była sprowadzona do Ameryki Północnej już w wieku XVI i XVII – jej muzyka towarzyszyła ekstatycznym obrzędom, tańcom, zajęciom codziennym. Ze względu na warunki życia i korzenie instrumentarium tej muzyki było proste, miała ona przede wszystkim charakter wokalny (często posługująca się falsetem), o nieskomplikowanej melodyce. Powszechnie stosowana w niej była heterofonia. Forma wykonawcza to często tzw. call-and-response – zawołanie lub pytanie głosu solowego i odpowiedź chóru.</p>

                            <p> Na pieśni czarnych osób tego okresu wywierała też duży wpływ hymnodia protestancka, a w niektórych rejonach muzyka francuska i hiszpańska. Wpływy muzyki protestanckiej to przede wszystkim hymny i psalmy, zawarte w śpiewnikach tekstowych lub zawierających też melodie opracowane na wiele głosów, np. The Bay Psalm Book (Cambridge, Mass., 1640) czy XVIII-wieczne hymny T. Buttsa, J. Cennika, J. Newtona, I. Wattsa, G. Whitefielda i J. i Ch. Wesleyów.</p><br />
                            <div style="text-align: center; width: 100%;"><a href="#tutaj"><h4>Przejdź na dół strony</h4></a></div>
                        </article>
                    </div>
                </section>
            </div>

        </div>

            <div class="aside">
                <nav>
                    <div class="menu">
                        <p class="menuTitle"><b>Menu</b></p>
                        <a href="instrumenty">
                            <div class="navMenuPos">
                                Typy instrumentów
                            </div>
                        </a>

                        <hr />

                        <a href="albumy">
                            <div class="navMenuPos">
                                Albumy, których powinien posłuchać każdy
                            </div>
                        </a>

                        <hr />

                        <a href="kontakt">
                            <div class="navMenuPos">
                                Napisz do mnie
                            </div>
                        </a>

                        <hr />

                        <a href="galeria">
                            <div class="navMenuPos">
                                Galeria
                            </div>
                        </a>

                        <hr />
                        
                        <a href="own_gallery">
                            <div class="navMenuPos">
                                Zapamiętane obrazy
                            </div>
                        </a>

<hr />

<a href="search">
    <div class="navMenuPos">
        Przeszukaj galerię
    </div>
</a>
                        
                        <hr />

                        <?php if(isset($_SESSION['userID'])):?>
                        <a href="logout">
                            <div class="navMenuPos">
                                Wyloguj się
                            </div>
                        </a>
                        <?php else:?>
                            <a href="login">
                            <div class="navMenuPos">
                                Zaloguj się
                            </div>
                        </a>
                        <?php endif?>

                        <div id="menuOnPhone">
                            <hr />

                            <button id="phoneDDButton">
                                Legendy gitary jazzowej
                            </button>

                            <div id="phoneDDContent">
                                <hr />
                                <a href="pass">
                                    <div class="navMenuPos">
                                        Joe Pass
                                    </div>
                                </a>

                                <hr />

                                <a href="hall">
                                    <div class="navMenuPos">
                                        Jim Hall
                                    </div>
                                </a>

                                <hr />

                                <a href="wes">
                                    <div class="navMenuPos">
                                        Wes Montgomery
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </nav>

                <nav>
                    <div class="container">

                        <div class="navMenuPosDD">
                            <div class="navMenuPos">
                                Legendy gitary jazzowej
                            </div>
                        </div>

                        <div id="slide">
                            <a href="pass">
                                <img class="menuPic" src="img/pass.jpg" alt="Joe Pass"/>
                            </a>

                            <a href="hall">
                                <img class="menuPic" src="img/hall.jpg" alt="Jim Hall"/>
                            </a>

                            <a href="wes">
                                <img class="menuPic" src="img/wes.jpg" alt="Wes Montgomery"/>
                            </a>
                        </div>

                        <div class="gridSpace">
                            <div class="gallery">
                                <p class="menuTitle"><b>Standardy tygodnia</b></p>

                                <div>
                                    <a href="img/s1.jpg" target="_blank"><img src="img/s1.jpg" alt="Music Notes" /></a>
                                    When Sunny Gets Blue
                                </div>
                                <div>
                                    <a href="img/s2.jpg" target="_blank"><img src="img/s2.jpg" alt="Music Notes" /></a>
                                    <br />Autumn Leaves
                                </div>
                                <div>
                                    <a href="img/s3.jpg" target="_blank"><img src="img/s3.jpg" alt="Music Notes" /></a>
                                    <br />Invitation
                                </div>
                                <div>
                                    <a href="img/s4.png" target="_blank"><img src="img/s4.png" alt="Music Notes" /></a>
                                    <br />Alone Together
                                </div>
                                <div>
                                    <a href="img/s5.png" target="_blank"><img src="img/s5.png" alt="Music Notes" /></a>
                                    <br />The Girl From Ipanema
                                </div>
                                <div>
                                    <a href="img/s6.jpg" target="_blank"><img src="img/s6.jpg" alt="Music Notes" /></a>
                                    <br />Misty
                                </div>
                                <div>
                                    <a href="img/s7.png" target="_blank"><img src="img/s7.png" alt="Music Notes" /></a>
                                    <br />Have You Met Miss Jones
                                </div>
                                <div>
                                    <a href="img/s8.png" target="_blank"><img src="img/s8.png" alt="Music Notes" /></a>
                                    <br />On The Sunny Side Of The Street
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>

            <section id="mobileGallery">
                <p class="menuTitle"><b>Standardy tygodnia</b></p>
                <div id="pics">
                    <div>
                        <a href="img/s1.jpg" target="_blank"><img src="img/s1.jpg" alt="Music Notes" /></a>
                        <br />When Sunny Gets Blue
                    </div>
                    <div>
                        <a href="img/s2.jpg" target="_blank"><img src="img/s2.jpg" alt="Music Notes" /></a>
                        <br />Autumn Leaves
                    </div>
                    <div>
                        <a href="img/s3.jpg" target="_blank"><img src="img/s3.jpg" alt="Music Notes" /></a>
                        <br />Invitation
                    </div>
                    <div>
                        <a href="img/s4.png" target="_blank"><img src="img/s4.png" alt="Music Notes" /></a>
                        <br />Alone Together
                    </div>
                    <div>
                        <a href="img/s5.png" target="_blank"><img src="img/s5.png" alt="Music Notes" /></a>
                        <br />The Girl From Ipanema
                    </div>
                    <div>
                        <a href="img/s6.jpg" target="_blank"><img src="img/s6.jpg" alt="Music Notes" /></a>
                        <br />Misty
                    </div>
                    <div>
                        <a href="img/s7.png" target="_blank"><img src="img/s7.png" alt="Music Notes" /></a>
                        <br />Have You Mey Miss Jones
                    </div>
                    <div>
                        <a href="img/s8.png" target="_blank"><img src="img/s8.png" alt="Music Notes" /></a>
                        <br />On The Sunny Side Of The Street
                    </div>
                </div>
            </section>
            <footer>
                <svg style="width: 21px; height: 21px ; position: relative; top: 3px;">
                    <polygon points="10,1 4,19.8 19,7.8 1,7.8 16,19.8" style="fill:white; stroke: white; stroke-width: 1;" />
                </svg>

                <span id="tutaj"></span><b>
                    Jan Kaczerski, grupa 1

                    <svg style="width: 21px; height: 21px; position: relative; top: 3px;">
                        <polygon points="10,1 4,19.8 19,7.8 1,7.8 16,19.8" style="fill:white; stroke: white; stroke-width: 1;" />
                    </svg>

                    <br /><a href="#">Wróć na górę</a>
                </b>

            </footer>
    </div>
</body>

</html>