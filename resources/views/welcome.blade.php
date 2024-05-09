<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
          href="{{asset('welcome/css/libs.min.css')}}">
    <link rel="stylesheet"
          href="{{asset('welcome/css/style.min.css')}}">
    <title>{{ env('APP_NAME') }}</title>
</head>
<body>
<!--header-->
<header>
    <div class="lg-1:rounded-b-none rounded-b-2xl bg-white py-2 lg-1:py-0 shadow lg-1:shadow-none">

        <div class="title-info py-3 hidden lg-1:block">
            <div
                class="flex justify-between items-center container mx-auto font-roboto-regular text-white leading-none text-xs">
                <span>РЕМОНТ БЫТОВОЙ ТЕХНИКИ И ТЕХНИЧЕСКОГО ОБОРУДОВАНИЯ</span>
            </div>
        </div>

        <div class="container mx-auto flex items-center justify-between">
            <div class="flex flex-grow lg-1:pt-5 lg-1:pb-3 items-center lg-1:items-start">
                <div class="w-66 mr-2 md:mr-0 lg-1:w-auto logo flex-none"><a href="{{route('welcome')}}"><img
                            src="{{ asset('welcome/img/logo.svg') }}" style="width: 66px; height: auto;" alt=""></a>
                </div>
                <div class="flex flex-row lg-1:flex-col w-full pl-0 lg-1:pl-5 md:justify-evenly">
                    <div class="w-full md:w-auto flex lg-1:flex-1 justify-between self-center lg-1:self-stretch">
                        <div
                            class="title self-start lg-1:pt-4 lg-1:pr-0 pr-3 lg-1:text-2xl text-sm font-roboto-bold text-dark-blue">
                            <p>{{ env('APP_NAME') }}</p></div>
                        <div class="contacts hidden lg-1:block">
                            <div class="work-time pt-2">
                                <div class="days flex justify-between">
                                    <span>Режим работы:</span>
                                    <span class="px-1.5">Пн.-пт. с 9.00 до 19.00 </span>
                                    <span class="px-1.5">Суббота с 10.00 до 16.00</span>
                                    <span class="px-1.5">Воскресенье - выходной</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="block py-5">
                        <ul class="flex justify-between uppercase items-center">
                            <li class="py-1 cursor-pointer hover:lavand-color flex-grow text-center">
                                <a class="home" href="{{ route('welcome') }}">главная</a>
                            </li>
                            <li class="py-1 cursor-pointer hover:lavand-color flex-grow text-center">
                                <a href="{{ route('login') }}">авторизации</a>
                            </li>
                            <li class="py-1 cursor-pointer hover:lavand-color flex-grow text-center">
                                <a href="{{ route('register') }}">регистрация</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!--main banner-->
<!--main banner-->
<section class="main-banner">
    <div class="container-fluid main-banner-bg pb-4">
        <div class="container main-banner-title mx-auto flex">
            <div
                class="flex flex-col md:justify-start md:pt-12 lg-1:justify-center  items-start relative h-full lg-1:self-center self-start lg-1:w-1/3 md:w-2/3 w-3/4 pt-3 lg-1:pt-0">
                <p class="font-roboto-bold lg-1:text-28 lg:leading-8 md:leading-normal leading-snug md:text-2xl text-sm uppercase lg-1:text-dark-blue text-white">
                    Ремонт
                    бытовой техники и технологического оборудования</p>
            </div>
        </div>
    </div>
    <div
        class="font-roboto-regular hidden md:block container mx-auto my-10 pl-5 lg-1:border-l-10 border-l-7 border-purple-cstm md:text-sm text-xs">
        <p>Эксплуатация электроники – уже давно неотъемлемая часть в повседневной жизни человека. Техника с высокими
            характеристиками и производительностью тоже может стать неисправной, даже если она изготовлена из прочного
            материала и
            лучшим производителем в мире. К сожалению, ремонт бытовой техники вряд ли можно выполнить самостоятельно,
            так как такие
            ремонтные работы – это трудный процесс, требующий определенных знаний и опыта.</p>

    </div>

    <div
        class="font-roboto-regular relative md:hidden container mx-auto pl-5 border-custom border-l-7-custom border-purple-cstm text-xs">
        <p>Эксплуатация электроники – уже давно неотъемлемая часть в повседневной жизни человека. Техника с высокими
            характеристиками и производительностью тоже может стать неисправной, даже если она изготовлена из
            прочного<span id="dots">...</span> <span id="more">материала и
            лучшим производителем в мире. К сожалению, ремонт бытовой техники вряд ли можно выполнить самостоятельно,
            так как такие
            ремонтные работы – это трудный процесс, требующий определенных знаний и опыта.</span></p>
    </div>
</section>
<!--section repair-->
<div class="repair container mx-auto">
    <span class="pl-7 text-white py-1 rounded text-sm md:text-lg lg-1:text-22 leading-7">Ремонты нашего сервиса</span>
    <div class="py-10 grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-5">
        <!--Card 1-->
        <div class="cards rounded overflow-hidden flex flex-col">
            <div class="h-full self-center flex">
                <img class="self-center" src="{{ asset('welcome/img/tv.png') }}" alt="tv">
            </div>
            <div class="py-1 cursor-pointer hover:lavand-color flex-grow text-center">
                <a class="uppercase" href="#">телевизоры</a>
            </div>
        </div>
        <!--Card 2-->
        <div class="cards rounded overflow-hidden flex flex-col">
            <div class="h-full self-center flex">
                <img class="self-center" src="{{ asset('welcome/img/wash-machine.png') }}" alt="wash">
            </div>
            <div class="py-1 cursor-pointer hover:lavand-color flex-grow text-center">
                <a class="uppercase" href="#">стиральные машины</a>
            </div>
        </div>
        <!--Card 3-->
        <div class="cards rounded overflow-hidden flex flex-col">
            <div class="h-full self-center flex">
                <img class="self-center" src="{{ asset('welcome/img/vacuum-cleaner.png') }}" alt="vac">
            </div>
            <div class="py-1 cursor-pointer hover:lavand-color flex-grow text-center">
                <a class="uppercase" href="#">пылесосы</a>
            </div>
        </div>
        <!--Card 4-->
        <div class="cards rounded overflow-hidden flex flex-col">
            <div class="h-full self-center flex">
                <img class="self-center" src="{{ asset('welcome/img/freeze.png') }}" alt="freeze">
            </div>
            <div class="py-1 cursor-pointer hover:lavand-color flex-grow text-center">
                <a class="uppercase" href="#">холодильники</a>
            </div>
        </div>
        <!--Card 5-->
        <div class="cards rounded overflow-hidden flex flex-col">
            <div class="h-full self-center flex">
                <img class="self-center" src="{{ asset('welcome/img/dish-wash.png') }}" alt="dish-wash">
            </div>
            <div class="py-1 cursor-pointer hover:lavand-color flex-grow text-center">
                <a class="uppercase" href="#">посудомоечные машины</a>
            </div>
        </div>
        <!--Card 6-->
        <div class="cards rounded overflow-hidden flex flex-col">
            <div class="h-full self-center flex">
                <img class="self-center" src="{{ asset('welcome/img/vents.png') }}" alt="vents">
            </div>
            <div class="py-1 cursor-pointer hover:lavand-color flex-grow text-center">
                <a class="uppercase" href="#">вытяжки</a>
            </div>
        </div>
        <!--Card 7-->
        <div class="cards rounded overflow-hidden flex flex-col">
            <div class="h-full self-center flex">
                <img class="self-center" src="{{ asset('welcome/img/coffee.png') }}" alt="cofe">
            </div>
            <div class="py-1 cursor-pointer hover:lavand-color flex-grow text-center">
                <a class="uppercase" href="#">кофе машины</a>
            </div>
        </div>
        <!--Card 8-->
        <div class="cards rounded overflow-hidden flex flex-col">
            <div class="h-full self-center flex">
                <img class="self-center" src="{{ asset('welcome/img/boiler.png') }}" alt="boiler">
            </div>
            <div class="py-1 cursor-pointer hover:lavand-color flex-grow text-center">
                <a class="uppercase" href="#">электрические чайники</a>
            </div>
        </div>
    </div>
</div>
<!--section repair-text-block-->
<div class="repair container mx-auto mb-10">

    <div class="my-10 pl-5 lg:border-l-10 border-l-7 border-purple-cstm">
        <span class="title my-3 text-sm md:text-base lg-1:text-22">{{ env('APP_NAME') }}</span>
        <p class="text-xs md:text-sm">Эксплуатация электроники – уже давно неотъемлемая часть в повседневной жизни
            человека. Техника с высокими
            характеристиками и производительностью тоже может стать неисправной, даже если она изготовлена из прочного
            материала и
            лучшим производителем в мире. К сожалению, ремонт бытовой техники вряд ли можно выполнить самостоятельно,
            так как такие
            ремонтные работы – это трудный процесс, требующий определенных знаний и опыта.</p>
    </div>

</div>

<footer class="footer bg-blue-footer relative pt-1">
    <div class="container mx-auto">
        <div class="sm:flex sm:mt-8 mb-5">
            <div class="mt-8 sm:mt-0 sm:w-full flex flex-col sm:flex-row justify-between">
                <div class="flex-col services hidden sm:block">
                    <span class="title mb-2 mt-4 md:mt-0 border-b-1">{{ env('APP_NAME') }}</span>
                    <p class="py-3">Если вам необходима диагностикаи
                        ремонт бытовой техники, обращайтесь к нам,
                        не задумываясь, мы всегда рады
                        вам помочь!</p>
                </div>
                <div class="flex-col menu-title hidden lg:block">
                    <div class="flex-col mx-auto">
                        <span class="title border-b-1 block">Меню</span>
                        <span class="py-4 border-b-1 block"><a href="{{ route('login') }}" class="uppercase hover:text-blue-500">авторизация</a></span>
                        <span class="py-4 border-b-1 block"><a href="{{ route('register') }}"
                                                               class="uppercase hover:text-blue-500">регистрация</a></span>
                    </div>
                </div>
                <div class="flex-col times hidden sm:block">
                    <span class="title mb-2 mt-4 md:mt-0 border-b-1 block">Режим работы</span>
                    <span class="my-2">Пн.-пт. с 9.00 до 19.00 <br>Суббота с 10.00 до 16.00 <br> Воскресенье - выходной</span>
                </div>
            </div>
        </div>
    </div>
</footer>
<!--footer components-->
<script src="{{ asset('welcome/js/libs.min.js') }}"></script>
<script src="{{ asset('welcome/js/main.min.js') }}"></script>
</body>
</html>
