<!DOCTYPE html>
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{$nazov_projektu." (ID: ".$id_projekt.")"}}</title>

    <link rel="stylesheet" href="{{asset('css/reportFonts.css')}}" media="all" />

</head>
<style>

    table.owntable, th.owntable, td.owntable {
        border: 1px dashed black;
        border-collapse: collapse;
        padding-left: 3px;
    }

    .headline-1
    {
        background-color: #eeeeee;
        color: #e46054;
        font-family: InterBold,sans-serif;
    }

    .headline-2
    {
        background-color: #eeeeee;
        font-family: InterSemiBold,sans-serif;
    }

    .headline-3
    {
        background-color: #eeeeee;
        font-family: InterRegular,sans-serif;
        text-align: left;
    }

    .text-normal
    {
        font-family: InterRegular,sans-serif;
    }

    .halfwidth
    {
        width: 50%;
    }

    .table_list_height{
        line-height: 12px;
    }

    .table_list_height_gant{
        line-height: 13px;
    }

    .green_cell{
        background-color: #bfda89;
    }

    .orange_cell{
        background-color: #f2b92b;
    }

    .red_cell{
        background-color: #e66054;
    }

    .triangle-up {
        width: 0;
        height: 0;
        border-left: 8px solid transparent;
        border-right: 8px solid transparent;
        border-bottom: 15px solid #d6d6d6;
    }

    .today_cell::before{
        content: '\a0';
        display: flex;
        width: 4px;
        background: #082864;
        transform: scaleY(1.7) translateX(-3px)  ;
    }

</style>

<body>
<div style="background-color: #e46054;
            position: fixed; top: -50px;right: -50px;left: -45px; bottom: -50px">

    <p style="color: white; font-family: InterRegular,sans-serif; font-size: 25px;
              position: fixed; top: -10px;right: 0px;left: 15px; bottom: 0px">
        #Moderný magistrát
    </p>
    <p style="color: white; font-family: InterRegular,sans-serif; font-size: 23px;
              position: fixed; top: -10px;right: 0px;left: 600px; bottom: 0px">
        #Pre Bratislavčanky a Bratislavčanov
    </p>

    <table style="color: white; font-family: InterBold,sans-serif; font-size: 50px;
              position: fixed; top: 95px;right: 0px;left: 15px; bottom: 0px;
               vertical-align: bottom; width: 900px" >
        <tr >
            <td style="vertical-align: top;width: 23%">
                Projekt:
            </td>
            <td style="vertical-align: top;line-height: 90%; padding-top: 18px; text-align: left">
                {{$nazov_projektu}} <br> {{"ID: ".$id_projekt}}
            </td>
        </tr>
    </table>

    <p style="color: white; font-family: InterRegular,sans-serif; font-size: 30px;
              position: fixed; top: 550px;right: 0px;left: 15px; bottom: 0px">
        Aktuálny stav projektu <br> k {{date('d.m.Y')}}
    </p>

    <img style="
              position: fixed; top: 380px;right: 0px;left: 640px; bottom: 0px"
         src="{{public_path('images/300ppi/PrimacPalac.png')}}" width="380px"
    >
    <img style="
              position: fixed; top: 680px;right: 0px;left: 980px; bottom: 0px"
         src="{{public_path('images/300ppi/whiteLogo.png')}}" width="40px"
    >
</div>

<div style="page-break-after: always"></div>

//////////////PAGE 2 /////////////PAGE 2//////////////PAGE 2///////////////PAGE 2/////////

@if((count($zrealizovane_aktivity)+count($planovane_aktivity))>8)

    <div style="margin: 0 auto;display: block; background-color: white; color: black;
            position: fixed; top: -50px;right: -50px;left: -45px; bottom: -50px">

        <table style="color: black; font-family: InterBold,sans-serif; font-size: 30px;
              position: fixed; top: -35px;right: 0px;left: 15px; bottom: 0px;
               vertical-align: bottom; width: 900px" >
            <tr >
                <td style="vertical-align: top;width: 125px">
                    Projekt:
                </td>
                <td style="vertical-align: top;line-height: 90%; padding-top: 12px;text-align: left">
                    {{$nazov_projektu}}<span style="font-family: InterRegular,sans-serif;">{{" (ID: ".$id_projekt.")"}}</span>
                </td>
            </tr>
            <tr>
                <td colspan="2" style=" font-family: InterRegular,sans-serif;line-height: 90%; font-size: 27px">
                    Aktuálny stav projektu k {{date('d.m.Y')}}
                </td>
                <td></td>
            </tr>
        </table>

        @if($mtl=="red")
            <img style="position: fixed; top: -20px;right: 0px;left: 1000px; bottom: 0px"
                 src="{{public_path('images/300ppi/redTL.png')}}" width="22px">
        @elseif($mtl=="orange")
            <img style="position: fixed; top: -20px;right: 0px;left: 1000px; bottom: 0px"
                 src="{{public_path('images/300ppi/orangeTL.png')}}" width="22px">
        @elseif($mtl=="green")
            <img style="position: fixed; top: -20px;right: 0px;left: 1000px; bottom: 0px"
                 src="{{public_path('images/300ppi/greenTL.png')}}" width="22px">
        @endif

        @if($mtl!==null)
        <p style="color: #d6d6d6; font-family: InterRegular,sans-serif; font-size: 15px;
              position: fixed; top: -30px;right: 0px;left: 918px; bottom: 0px; line-height: 80%">
            Termínový <br> semafór
        </p>
        @endif

        <table class="owntable" style="font-family: InterBold,sans-serif; font-size: 14px;
              position: fixed; top: 93px;right: 0px;left: 15px; bottom: 0px;
               vertical-align: bottom; width: 1000px; " >
            <tr class="owntable">
                <td class="owntable headline-2 table_list_height" style="width: 20%; vertical-align: top">Zrealizované aktivity za posledný týždeň</td>
                <td class="owntable text-normal">
                    <table>
                        @foreach($zrealizovane_aktivity as $zrealizovane_aktivity_item)
                            <tr>
                                <td class="table_list_height" style="vertical-align: top">-</td>
                                <td class="table_list_height">{{$zrealizovane_aktivity_item}}</td>
                            </tr>
                        @endforeach
                    </table>
                </td>
            </tr>

            <tr class="owntable">
                <td class="owntable headline-2 table_list_height" style="vertical-align: top" >Plánované aktivity na najbližší týždeň</td>
                <td class="owntable text-normal">
                    <table>
                        @foreach($planovane_aktivity as $planovane_aktivity_item)
                            <tr>
                                <td class="table_list_height" style="vertical-align: top">-</td>
                                <td class="table_list_height" >{{$planovane_aktivity_item}} </td>
                            </tr>
                        @endforeach
                    </table>
                </td>
            </tr>
        </table>

        <p class="text-normal"
           style="position: fixed; top: 630px;right: 0px;left: 15px; bottom: 0px;
        font-size: 10px; color: darkgrey; width: 740px; font-family: InterRegular,sans-serif;">
            <span style="font-family: InterSemiBold,sans-serif;">Vysvetlivka k projektovému semaforu:</span>
            <span style="color: #bfda89;">Zelená:</span> projekt beží <span style="text-decoration: underline">podľa plánu</span>
            | <span style="color: #f2b92b;"> Žltá:</span> projekt má odchýlky termínov, rozpočtu a cieľov <span style="text-decoration: underline">do cca. 10% oproti plánu </span> |
            <span style="color: #e66054"> Červená:</span> projekt má odchýlky termínov, rozpočtu a cieľov výrazne <span style="text-decoration: underline"> viac ako 10% oproti plánu </span>
        </p>
        <p class="text-normal"
           style="position: fixed; top: 690px;right: 0px;left: 15px; bottom: 0px;
        font-size: 14px;color: black" >
            {{date('d.m.Y')}}
        </p>
        <p class="text-normal"
           style="position: fixed; top: 690px;right: 0px;left: 160px; bottom: 0px;
        font-size: 14px;color: black" >
            {{$projekt_manazer}}
        </p>
        <img style="
              position: fixed; top: 670px;right: 0px;left: 960px; bottom: 0px"
             src="{{public_path('images/300ppi/BA_logo_black.png')}}" width="60px"
        >

    </div>

    <div style="page-break-after: always"></div>

    <div style="margin: 0 auto;display: block; background-color: white; color: black;
            position: fixed; top: -50px;right: -50px;left: -45px; bottom: -50px">

        <table style="color: black; font-family: InterBold,sans-serif; font-size: 30px;
              position: fixed; top: -35px;right: 0px;left: 15px; bottom: 0px;
               vertical-align: bottom; width: 900px" >
            <tr >
                <td style="vertical-align: top;width: 125px">
                    Projekt:
                </td>
                <td style="vertical-align: top;line-height: 90%; padding-top: 12px;text-align: left">
                    {{$nazov_projektu}}<span style="font-family: InterRegular,sans-serif;">{{" (ID: ".$id_projekt.")"}}</span>
                </td>
            </tr>
            <tr>
                <td colspan="2" style=" font-family: InterRegular,sans-serif;line-height: 90%; font-size: 27px">
                    Aktuálny stav projektu k {{date('d.m.Y')}}
                </td>
                <td></td>
            </tr>
        </table>

        @if($mtl=="red")
            <img style="position: fixed; top: -20px;right: 0px;left: 1000px; bottom: 0px"
                 src="{{public_path('images/300ppi/redTL.png')}}" width="22px">
        @elseif($mtl=="orange")
            <img style="position: fixed; top: -20px;right: 0px;left: 1000px; bottom: 0px"
                 src="{{public_path('images/300ppi/orangeTL.png')}}" width="22px">
        @elseif($mtl=="green")
            <img style="position: fixed; top: -20px;right: 0px;left: 1000px; bottom: 0px"
                 src="{{public_path('images/300ppi/greenTL.png')}}" width="22px">
        @endif

        @if($mtl!=null)
        <p style="color: #d6d6d6; font-family: InterRegular,sans-serif; font-size: 15px;
              position: fixed; top: -30px;right: 0px;left: 918px; bottom: 0px; line-height: 80%">
            Projektový <br> semafór
        </p>
        @endif

        <table class="owntable" style="font-family: InterBold,sans-serif; font-size: 14px;
              position: fixed; top: 93px;right: 0px;left: 15px; bottom: 0px;
               vertical-align: bottom; width: 1000px; " >
            <tr class="owntable">
                <td class="owntable headline-2 table_list_height" style="vertical-align: top"> Riziká projektu a ich manažment</td>
                <td class="owntable text-normal">
                    <table>
                        @foreach($rizika_projektu as $rizika_projektu_item)
                            <tr>
                                <td class="table_list_height" style="vertical-align: top">-</td>
                                <td class="table_list_height">{{$rizika_projektu_item}} </td>
                            </tr>
                        @endforeach
                    </table>
                </td>
            </tr>
            <tr class="owntable">
                <td class="owntable headline-2 table_list_height" style="vertical-align: top">Komentár k semafóru</td>
                <td class="owntable text-normal">
                    <table>
                        @foreach($komentarMTL as $komentarMTL_item)
                            <tr>
                                <td class="table_list_height" style="vertical-align: top">-</td>
                                <td class="table_list_height">{{$komentarMTL_item}} </td>
                            </tr>
                        @endforeach

                    </table>
                </td>
            </tr>

        </table>


        <p class="text-normal"
           style="position: fixed; top: 630px;right: 0px;left: 15px; bottom: 0px;
        font-size: 10px; color: darkgrey; width: 740px; font-family: InterRegular,sans-serif;">
            <span style="font-family: InterSemiBold,sans-serif;">Vysvetlivka k projektovému semaforu:</span>
            <span style="color: #bfda89;">Zelená:</span> projekt beží <span style="text-decoration: underline">podľa plánu</span>
            | <span style="color: #f2b92b;"> Žltá:</span> projekt má odchýlky termínov, rozpočtu a cieľov <span style="text-decoration: underline">do cca. 10% oproti plánu </span> |
            <span style="color: #e66054"> Červená:</span> projekt má odchýlky termínov, rozpočtu a cieľov výrazne <span style="text-decoration: underline"> viac ako 10% oproti plánu </span>
        </p>
        <p class="text-normal"
           style="position: fixed; top: 690px;right: 0px;left: 15px; bottom: 0px;
        font-size: 14px;color: black" >
            {{date('d.m.Y')}}
        </p>
        <p class="text-normal"
           style="position: fixed; top: 690px;right: 0px;left: 160px; bottom: 0px;
        font-size: 14px;color: black" >
            {{$projekt_manazer}}

        </p>
        <img style="
              position: fixed; top: 670px;right: 0px;left: 960px; bottom: 0px"
             src="{{public_path('images/300ppi/BA_logo_black.png')}}" width="60px"
        >

    </div>

    <div style="page-break-after: always"></div>

@else
    <div style="margin: 0 auto;display: block; background-color: white; color: black;
            position: fixed; top: -50px;right: -50px;left: -45px; bottom: -50px">

        <table style="color: black; font-family: InterBold,sans-serif; font-size: 30px;
              position: fixed; top: -35px;right: 0px;left: 15px; bottom: 0px;
               vertical-align: bottom; width: 900px" >
            <tr >
                <td style="vertical-align: top;width: 125px">
                    Projekt:
                </td>
                <td style="vertical-align: top;line-height: 90%; padding-top: 12px;text-align: left">
                    {{$nazov_projektu}}<span style="font-family: InterRegular,sans-serif;">{{" (ID: ".$id_projekt.")"}}</span>
                </td>
            </tr>
            <tr>
                <td colspan="2" style=" font-family: InterRegular,sans-serif;line-height: 90%; font-size: 27px">
                    Aktuálny stav projektu k {{date('d.m.Y')}}
                </td>
                <td></td>
            </tr>
        </table>

        @if($mtl=="red")
            <img style="position: fixed; top: -20px;right: 0px;left: 1000px; bottom: 0px"
                 src="{{public_path('images/300ppi/redTL.png')}}" width="22px">
        @elseif($mtl=="orange")
            <img style="position: fixed; top: -20px;right: 0px;left: 1000px; bottom: 0px"
                 src="{{public_path('images/300ppi/orangeTL.png')}}" width="22px">
        @elseif($mtl=="green")
            <img style="position: fixed; top: -20px;right: 0px;left: 1000px; bottom: 0px"
                 src="{{public_path('images/300ppi/greenTL.png')}}" width="22px">
        @endif

        @if($mtl!=null)
        <p style="color: #d6d6d6; font-family: InterRegular,sans-serif; font-size: 15px;
              position: fixed; top: -30px;right: 0px;left: 918px; bottom: 0px; line-height: 80%">
             Projektový <br> semafór
        </p>
        @endif


        <table class="owntable" style="font-family: InterBold,sans-serif; font-size: 14px;
              position: fixed; top: 93px;right: 0px;left: 15px; bottom: 0px;
               vertical-align: bottom; width: 1000px; " >
            <tr class="owntable">
                <td class="owntable headline-2 table_list_height" style="width: 20%; vertical-align: top">Zrealizované aktivity za posledný týždeň</td>
                <td class="owntable text-normal">
                    <table>
                        @foreach($zrealizovane_aktivity as $zrealizovane_aktivity_item)
                            <tr>
                                <td class="table_list_height" style="vertical-align: top">-</td>
                                <td class="table_list_height">{{$zrealizovane_aktivity_item}}</td>
                            </tr>
                        @endforeach
                    </table>
                </td>
            </tr>

            <tr class="owntable">
                <td class="owntable headline-2 table_list_height" style="vertical-align: top" >Plánované aktivity na najbližší týždeň</td>
                <td class="owntable text-normal">
                    <table>
                        @foreach($planovane_aktivity as $planovane_aktivity_item)
                            <tr>
                                <td class="table_list_height" style="vertical-align: top">-</td>
                                <td class="table_list_height" >{{$planovane_aktivity_item}} </td>
                            </tr>
                        @endforeach
                    </table>
                </td>
            </tr>

            <tr class="owntable">
                <td class="owntable headline-2 table_list_height" style="vertical-align: top"> Riziká projektu a ich manažment</td>
                <td class="owntable text-normal">
                    <table>
                        @foreach($rizika_projektu as $rizika_projektu_item)
                            <tr>
                                <td class="table_list_height" style="vertical-align: top">-</td>
                                <td class="table_list_height">{{$rizika_projektu_item}} </td>
                            </tr>
                        @endforeach
                    </table>
                </td>
            </tr>
            <tr class="owntable">
                <td class="owntable headline-2 table_list_height" style="vertical-align: top">Komentár k semafóru</td>
                <td class="owntable text-normal">
                    <table>
                        @foreach($komentarMTL as $komentarMTL_item)
                            <tr>
                                <td class="table_list_height" style="vertical-align: top">-</td>
                                <td class="table_list_height">{{$komentarMTL_item}} </td>
                            </tr>
                        @endforeach
                    </table>
                </td>
            </tr>
        </table>

        <p class="text-normal"
           style="position: fixed; top: 630px;right: 0px;left: 15px; bottom: 0px;
        font-size: 10px; color: darkgrey; width: 740px; font-family: InterRegular,sans-serif;">
            <span style="font-family: InterSemiBold,sans-serif;">Vysvetlivka k projektovému semaforu:</span>
            <span style="color: #bfda89;">Zelená:</span> projekt beží <span style="text-decoration: underline">podľa plánu</span>
            | <span style="color: #f2b92b;"> Žltá:</span> projekt má odchýlky termínov, rozpočtu a cieľov <span style="text-decoration: underline">do cca. 10% oproti plánu </span> |
            <span style="color: #e66054"> Červená:</span> projekt má odchýlky termínov, rozpočtu a cieľov výrazne <span style="text-decoration: underline"> viac ako 10% oproti plánu </span>
        </p>
        <p class="text-normal"
           style="position: fixed; top: 690px;right: 0px;left: 15px; bottom: 0px;
        font-size: 14px;color: black" >
            {{date('d.m.Y')}}
        </p>
        <p class="text-normal"
           style="position: fixed; top: 690px;right: 0px;left: 160px; bottom: 0px;
        font-size: 14px;color: black" >

            {{$projekt_manazer}}

        </p>
        <img style="
              position: fixed; top: 670px;right: 0px;left: 960px; bottom: 0px"
             src="{{public_path('images/300ppi/BA_logo_black.png')}}" width="60px"
        >

    </div>

    <div style="page-break-after: always"></div>


@endif

//////////////PAGE 3 /////////////PAGE 3//////////////PAGE 3///////////////PAGE 3/////////

@if(isset($aktivity->page))
    @foreach($aktivity->page as $aktivity_page_item)

        <div style="margin: 0 auto;display: block; background-color: white; color: black;
            position: fixed; top: -50px;right: -50px;left: -45px; bottom: -50px">
            <table style="color: black; font-family: InterBold,sans-serif; font-size: 30px;
              position: fixed; top: -35px;right: 0px;left: 15px; bottom: 0px;
               vertical-align: bottom; width: 900px" >
                <tr >
                    <td style="vertical-align: top;width: 125px">
                        Projekt:
                    </td>
                    <td style="vertical-align: top;line-height: 90%; padding-top: 12px;text-align: left">
                        {{$nazov_projektu}}<span style="font-family: InterRegular,sans-serif;">{{" (ID: ".$id_projekt.")"}}</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style=" font-family: InterRegular,sans-serif;line-height: 90%; font-size: 27px">
                        Aktuálny stav projektu k {{date('d.m.Y')}}
                    </td>
                    <td></td>
                </tr>
            </table>
            @if($atl=="red")
                <img style="position: fixed; top: -20px;right: 0px;left: 1000px; bottom: 0px"
                     src="{{public_path('images/300ppi/redTL.png')}}" width="22px">
            @elseif($atl=="orange")
                <img style="position: fixed; top: -20px;right: 0px;left: 1000px; bottom: 0px"
                     src="{{public_path('images/300ppi/orangeTL.png')}}" width="22px">
            @elseif($atl=="green")
                <img style="position: fixed; top: -20px;right: 0px;left: 1000px; bottom: 0px"
                     src="{{public_path('images/300ppi/greenTL.png')}}" width="22px">
            @endif

            @if($atl!=null)
            <p style="color: #d6d6d6; font-family: InterRegular,sans-serif; font-size: 15px;
              position: fixed; top: -30px;right: 0px;left: 918px; bottom: 0px; line-height: 80%">
                Termínový <br> semafór
            </p>
            @endif

            <table class="owntable" style="font-family: InterBold,sans-serif; font-size: 14px;
              position: fixed; top: 93px;right: 0px;left: 15px; bottom: 0px;
               vertical-align: bottom; width: 1010px; " >
                <tr class="owntable" >
                    <td class="owntable headline-1" style="vertical-align: top; width: 350px"  rowspan="2">
                        Aktivita projektu
                    </td>
                    <td class="owntable  headline-1" colspan="6">
                        2022
                    </td>
                    <td class="owntable headline-1" colspan="12">
                        2023
                    </td>
                    <td class="owntable headline-1" colspan="12">
                        2024
                    </td>
                    <td class="owntable headline-1" colspan="12">
                        2025
                    </td>
                    <td class="owntable headline-1" colspan="12">
                        2026
                    </td>
                    <td class="owntable headline-1" colspan="12">
                        2027
                    </td>
                    <td class="owntable headline-1" colspan="12">
                        2028
                    </td>
                    <td class="owntable headline-1" colspan="12">
                        2029
                    </td>
                    <td class="owntable headline-1" colspan="12">
                        2030
                    </td>
                </tr>
                <tr class="owntable">
                    <td class="owntable headline-3" style="font-size: 8px" colspan="3">Q3</td>
                    <td class="owntable headline-3" style="font-size: 8px" colspan="3">Q4</td>
                    <td class="owntable headline-3" style="font-size: 8px"colspan="3">Q1</td>
                    <td class="owntable headline-3" style="font-size: 8px" colspan="3">Q2</td>
                    <td class="owntable headline-3" style="font-size: 8px" colspan="3">Q3</td>
                    <td class="owntable headline-3" style="font-size: 8px" colspan="3">Q4</td>
                    <td class="owntable headline-3" style="font-size: 8px" colspan="3">Q1</td>
                    <td class="owntable headline-3" style="font-size: 8px" colspan="3">Q2</td>
                    <td class="owntable headline-3" style="font-size: 8px" colspan="3">Q3</td>
                    <td class="owntable headline-3" style="font-size: 8px" colspan="3">Q4</td>
                    <td class="owntable headline-3" style="font-size: 8px" colspan="3">Q1</td>
                    <td class="owntable headline-3" style="font-size: 8px" colspan="3">Q2</td>
                    <td class="owntable headline-3" style="font-size: 8px" colspan="3">Q3</td>
                    <td class="owntable headline-3" style="font-size: 8px" colspan="3">Q4</td>
                    <td class="owntable headline-3" style="font-size: 8px" colspan="3">Q1</td>
                    <td class="owntable headline-3" style="font-size: 8px" colspan="3">Q2</td>
                    <td class="owntable headline-3" style="font-size: 8px" colspan="3">Q3</td>
                    <td class="owntable headline-3" style="font-size: 8px" colspan="3">Q4</td>
                    <td class="owntable headline-3" style="font-size: 8px" colspan="3">Q1</td>
                    <td class="owntable headline-3" style="font-size: 8px" colspan="3">Q2</td>
                    <td class="owntable headline-3" style="font-size: 8px" colspan="3">Q3</td>
                    <td class="owntable headline-3" style="font-size: 8px" colspan="3">Q4</td>
                    <td class="owntable headline-3" style="font-size: 8px" colspan="3">Q1</td>
                    <td class="owntable headline-3" style="font-size: 8px" colspan="3">Q2</td>
                    <td class="owntable headline-3" style="font-size: 8px" colspan="3">Q3</td>
                    <td class="owntable headline-3" style="font-size: 8px" colspan="3">Q4</td>
                    <td class="owntable headline-3" style="font-size: 8px" colspan="3">Q1</td>
                    <td class="owntable headline-3" style="font-size: 8px" colspan="3">Q2</td>
                    <td class="owntable headline-3" style="font-size: 8px" colspan="3">Q3</td>
                    <td class="owntable headline-3" style="font-size: 8px" colspan="3">Q4</td>
                    <td class="owntable headline-3" style="font-size: 8px" colspan="3">Q1</td>
                    <td class="owntable headline-3" style="font-size: 8px" colspan="3">Q2</td>
                    <td class="owntable headline-3" style="font-size: 8px" colspan="3">Q3</td>
                    <td class="owntable headline-3" style="font-size: 8px" colspan="3">Q4</td>
                </tr>

                @foreach($aktivity_page_item as $aktivity_item)

                    <tr>
                        @php
                            $j=0;
                        @endphp

                        <td class="owntable text-normal table_list_height_gant"
                            @if(strlen($aktivity_item->name)>100) style="font-size: 11px" @endif >{{$aktivity_item->name}} @if(isset($aktivity_item->finished))
                                &#10003; {{$aktivity_item->date}}
                            @endif</td>
                        @for($i=0;$i<$aktivity_item->partOne;$i++)
                            <td class="owntable @if($aktivity->current_month_line==$j) today_cell @endif"></td>
                            @php
                                $j=$j+1;
                            @endphp
                        @endfor
                        @for($i=0;$i<$aktivity_item->partTwo;$i++)
                            <td class="owntable {{$aktivity_item->color}} @if($aktivity->current_month_line==$j) today_cell @endif"></td>
                            @php
                                $j=$j+1;
                            @endphp
                        @endfor

                        @for($i=0;$i<$aktivity_item->partThree;$i++)
                            <td class="owntable @if($aktivity->current_month_line==$j) today_cell @endif"></td>
                            @php
                                $j=$j+1;
                            @endphp
                        @endfor



                    </tr>
                @endforeach

            </table>
            <p class="text-normal"
               style="position: fixed; top: 630px;right: 0px;left: 15px; bottom: 0px;
        font-size: 10px; color: darkgrey; width: 740px; font-family: InterRegular,sans-serif;">
                <span style="font-family: InterSemiBold,sans-serif;">Vysvetlivka k harmonogramu:</span>
                <span style="color: #bfda89;">Zelená:</span> aktivita dokončená
                | <span style="color: #f2b92b;"> Žltá:</span> aktivita začatá |
                <span style="color: #e66054"> Červená:</span> aktivita ešte nezačatá
                |
                <span style="color: #082864"> Línia: </span> aktuálny mesiac
            </p>
            <p class="text-normal"
               style="position: fixed; top: 690px;right: 0px;left: 15px; bottom: 0px;
        font-size: 14px;color: black" >
                {{date('d.m.Y')}}
            </p>
            <p class="text-normal"
               style="position: fixed; top: 690px;right: 0px;left: 160px; bottom: 0px;
        font-size: 14px;color: black" >
                {{$projekt_manazer}}
            </p>
            <img style="
              position: fixed; top: 670px;right: 0px;left: 960px; bottom: 0px"
                 src="{{public_path('images/300ppi/BA_logo_black.png')}}" width="60px"
            >
        </div>
        <div style="page-break-after: always"></div>
    @endforeach
@endif
//////////////PAGE 4 /////////////PAGE 4//////////////PAGE 4///////////////PAGE 4/////////
<div style="margin: 0 auto;display: block; background-color: white; color: black;
            position: fixed; top: -50px;right: -50px;left: -45px; bottom: -50px">


    <table style="color: black; font-family: InterBold,sans-serif; font-size: 30px;
              position: fixed; top: -35px;right: 0px;left: 15px; bottom: 0px;
               vertical-align: bottom; width: 900px" >
        <tr >
            <td style="vertical-align: top;width: 125px">
                Projekt:
            </td>
            <td style="vertical-align: top;line-height: 90%; padding-top: 12px;text-align: left">
                {{$nazov_projektu}}<span style="font-family: InterRegular,sans-serif;">{{" (ID: ".$id_projekt.")"}}</span>
            </td>
        </tr>
        <tr>
            <td colspan="2" style=" font-family: InterRegular,sans-serif;line-height: 90%; font-size: 27px">
                Aktuálny stav projektu k {{date('d.m.Y')}}
            </td>
            <td></td>
        </tr>
    </table>
    <table class="owntable" style="font-family: InterBold,sans-serif; font-size: 14px;
              position: fixed; top: 93px;right: 0px;left: 15px; bottom: 0px;
               vertical-align: bottom; width: 1000px; " >
        <tr class="owntable">
            <td class="owntable headline-2" style="width: 20%;">Projektový manažér</td>
            <td class="owntable text-normal">{{$projekt_manazer}}</td>
            <td class="owntable headline-2" style="width: 20%">Začiatok a koniec projektu</td>
            <td class="owntable text-normal" >{{$zaciatok_projektu}} @if($koniec_projektu=="" or $zaciatok_projektu=="") @else {{"-"}}
                @endif {{$koniec_projektu}}</td>
        </tr>
        <tr class="owntable">
            <td class="owntable headline-2" >ID, kategória, typ projektu</td>
            <td class="owntable text-normal" colspan="3" > {{$id_projekt.", ".$kategoria.", ".$typ_projektu}}</td>
        </tr>
        <tr class="owntable">
            <td class="owntable headline-1" colspan="4" > Aktuálne platný rámec projektu</td>
        </tr>
        <tr class="owntable">
            <td class="owntable headline-2"> Celkové výdavky projektu* <br> (s DPH)</td>
            <td class="owntable text-normal" colspan="3" >
                <table style="width: 100%">
                    <tr>
                        <td class="table_list_height">2023: {{number_format($financovanie[2]->value,0,","," ")}} €</td>
                        <td class="table_list_height">2025: {{number_format($financovanie[4]->value,0,","," ")}} € </td>
                        <td class="table_list_height">2027: {{number_format($financovanie[6]->value,0,","," ")}} €</td>
                        <td class="table_list_height">2029: {{number_format($financovanie[8]->value,0,","," ")}} €</td>
                    </tr>
                    <tr>
                        <td class="table_list_height">2024: {{number_format($financovanie[3]->value,0,","," ")}} €</td>
                        <td class="table_list_height">2026: {{number_format($financovanie[5]->value,0,","," ")}} €</td>
                        <td class="table_list_height">2028: {{number_format($financovanie[7]->value,0,","," ")}} €</td>
                        <td class="table_list_height">2030: {{number_format($financovanie[9]->value,0,","," ")}} €</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class="owntable">
            <td class="owntable headline-1" colspan="4" > Projektová organizácia</td>
        </tr>
        <tr class="owntable">
            <td class="owntable headline-2 " style="vertical-align: top" > Projektový tím</td>
            <td class="owntable text-normal" colspan="3">
                <table style="width: 100%">
                    {{--                    <tr style="font-size: 12px">--}}
                    @if($projektovy_tim!=null)
                        @foreach($projektovy_tim as $projekt_tim_item)
                            @if($loop->iteration%3==1)
                                <tr>
                                    <td class="halfwidth table_list_height">{{$projekt_tim_item->sn." ".$projekt_tim_item->givenName." ".$projekt_tim_item->ou}}</td>
                                    @endif

                                    @if($loop->iteration%3==2)
                                        <td class="halfwidth table_list_height">{{$projekt_tim_item->sn." ".$projekt_tim_item->givenName." ".$projekt_tim_item->ou}}</td>
                                    @endif

                                    @if($loop->iteration%3==0)
                                        <td class="halfwidth table_list_height">{{$projekt_tim_item->sn." ".$projekt_tim_item->givenName." ".$projekt_tim_item->ou}}</td>
                                </tr>
                            @endif
                        @endforeach
                    @endif

                </table>
            </td>

        </tr>
        <tr class="owntable">
            <td class="owntable headline-2" style="vertical-align: top"> Riadiace grémium projektu
            <td class="owntable text-normal" colspan="3">
                <table style="width: 100%">
                    @if($riadiace_gremium!=null)
                        @foreach($riadiace_gremium as $riadiace_gremium_item)
                            @if($loop->iteration%3==1)
                                <tr>
                                    <td class="halfwidth table_list_height">{{$riadiace_gremium_item->sn." ".$riadiace_gremium_item->givenName." ".$riadiace_gremium_item->ou}}</td>
                                    @endif

                                    @if($loop->iteration%3==2)
                                        <td class="halfwidth table_list_height">{{$riadiace_gremium_item->sn." ".$riadiace_gremium_item->givenName." ".$riadiace_gremium_item->ou}}</td>
                                    @endif

                                    @if($loop->iteration%3==0)
                                        <td class="halfwidth table_list_height">{{$riadiace_gremium_item->sn." ".$riadiace_gremium_item->givenName." ".$riadiace_gremium_item->ou}}</td>
                                </tr>
                            @endif
                        @endforeach
                    @endif
                </table>
            </td>

        </tr>
        {{--        <tr class="owntable">--}}
        {{--            <td class="owntable headline-2" style="vertical-align: top" > Zúčastnené strany projektu--}}
        {{--            <td class="owntable text-normal" colspan="3">--}}
        {{--                <table style="width: 100%">--}}
        {{--                    <tr>--}}
        {{--                        <td class="halfwidth table_list_height">Meno Priezvisko / Názov organizácie</td>--}}
        {{--                        <td class="halfwidth table_list_height">Meno Priezvisko / Názov organizácie</td>--}}
        {{--                    </tr>--}}
        {{--                    <tr>--}}
        {{--                        <td class="halfwidth table_list_height">Meno Priezvisko / Názov organizácie</td>--}}
        {{--                        <td class="halfwidth table_list_height">Meno Priezvisko / Názov organizácie</td>--}}
        {{--                    </tr>--}}
        {{--                </table>--}}
        {{--            </td>--}}
        {{--        </tr>--}}
    </table>

    <p class="text-normal"
       style="position: fixed; top: 650px;right: 0px;left: 15px; bottom: 0px;
        font-size: 10px; color: darkgrey">
        * Roky 2023 až 2025 zodpovedajú rozpočtu hlavného mesta, v ďalších rokoch sa jedná o údaje z projektového zámeru
    </p>
    <p class="text-normal"
       style="position: fixed; top: 690px;right: 0px;left: 15px; bottom: 0px;
        font-size: 14px;color: black" >
        {{date('d.m.Y')}}
    </p>
    <p class="text-normal"
       style="position: fixed; top: 690px;right: 0px;left: 160px; bottom: 0px;
        font-size: 14px;color: black" >
        {{$projekt_manazer}}
    </p>
    <img style="
              position: fixed; top: 670px;right: 0px;left: 960px; bottom: 0px"
         src="{{public_path('images/300ppi/BA_logo_black.png')}}" width="60px"
    >

</div>
</body>
</html>
