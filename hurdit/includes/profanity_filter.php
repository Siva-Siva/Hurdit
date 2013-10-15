<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="style.css" />
        <link rel="shortcut icon" href="favicon.ico">
        <title></title>
    </head>
    <body>
        <table class="background">
            <tr>
                <td>
                    <?php
                    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
                    session_start();
                    $profanity = "(ahole|anus|ash0le|ash0les|asholes|ass|assface|assh0le|assh0lez|asshole|assholes|assholz|asswipe|azzhole|bassterds|bastard|bastards|bastardz|biatch|bitch|blowjob|boffing|butthole|buttwipe|c0ck|c0cks|c0k|cawk|cawks|clit|cnts|cntz|cock|cockhead|cocks|cocksucker|cock-sucker|cum|cunt|cunts|cuntz|dick|dild0|dild0s|dildo|dilld0|dilld0s|dominatricks|dominatrics|dominatrix|dyke|fag|fag1t|faget|fagg1t|faggit|faggot|fagit|fags|fagz|faig|faigs|fart|fuck|fucker|fuckin|fucking|fucks|fuk|fukah|fuken|fucker|fukin|fukk|fukkah|fukken|fukker|fukkin|g00k|gayz|god-damned|h00r|h0ar|h0re|hoar|hoor|hoore|jackoff|jerk-off|jisim|jiss|jizm|jizz|kunt|kunts|kuntz|lezzian|lipshits|lipshitz|masokist|massterbait|masstrbait|masstrbate|masterbaiter|masterbate|masterbates|motherfucker|mother-fucker|n1gr|nasst|nigger|nigur|niiger|niigr|orafis|orgasim|orgasm|orgasum|oriface|orifice|orifiss|packi|packie|packy|pakie|paky|pecker|peeenus|peeenusss|peenus|peinus|pen1us|penas|penis|penis-breath|penus|penuus|phuc|phuck|phuck|phuker|phukker|polac|polack|polak|poonani|pusse|pussee|pussy|puuke|puuker|queerz|qweerz|qweir|recktum|rectrum|scank|schlong|semen|sh!t|sh1t|sh1ter|sh1ts|sh1tter|sh1tz|shit|shits|shitter|shitty|shity|shitz|shyt|shyte|shytty|shyty|skanck|skank|skankee|skanky|slut|sluts|slutty|slutz|son-of-a-bitch|tit|turd|va1jina|vaj1na|vagina|vullva|vulva|wh00r|wh0re|whore|xrated|xxx|b1+ch|bitch|blowjob|clit|arschloch|fuck|shit|ass|asshole|b1tch|b17ch|b1tch|bastard|bi+ch|boiolas|buceta|c0ck|cawk|chink|cipa|clits|cock|cum|cunt|dildo|dirsa|ejakulate|fatass|fcuk|fuk|fux0r|hoer|hore|jism|kawk|l3itch|l3i+ch|masterbat3|motherfucker|s.o.b|mofo|nigga|nigger|nutsack|phuck|pimpis|pusse|pussy|scrotum|shemale|shi+|sh!+|smut|teets|tits|boobs|b00bs|teez|titt|w00se|jackoff|wank|whoar|dyck|fuck|amcik|andskota|arse|assrammer|ayir|bi7ch|bitch|butt-pirate|cabron|cazzo|chraa|chuj|cock|cunt|d4mn|daygo|dego|dick|dike|dupe|dziwka|ejackulate|ekrem|ekto|enculer|faen|fag|fanculo|fanny|faces|feg|felcher|ficken|fitt|flikker|fotze|futkretzn|gook|guiena|h0r|jizz|kanker|kike|klootzk|knuile|kuk|kuksuger|lesbo|queef|shiz|suka|titt|twat|wetback)";
                    $comment = preg_replace($profanity, "hurdit", $comment);
                    if (preg_match($profanity, $username)) {
                        die ("Username incldues illegal string.");
                    }
                    ?>
                </td>
            </tr>
        </table>
    </body>
</html>
