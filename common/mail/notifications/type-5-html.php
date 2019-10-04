<?php
use yii\helpers\Url;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?= Yii::t('main', 'Новое уведомление') ?></title>
    <!--


    COLORE INTENSE  #9C010F
    COLORE LIGHT #EDE8DA

    TESTO LIGHT #3F3D33
    TESTO INTENSE #ffffff


     -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">

    <style type="text/css">

        #ko_compactarticleBlock_4 .articletextintenseStyle a, #ko_compactarticleBlock_4 .articletextintenseStyle a:link, #ko_compactarticleBlock_4 .articletextintenseStyle a:visited, #ko_compactarticleBlock_4 .articletextintenseStyle a:hover {
            color: #ffffff;
            color: #a5a5a5;

            text-decoration: none;
            font-weight: bold;
            text-decoration: none
        }

        #ko_compactarticleBlock_4 .articletextlightStyle a, #ko_compactarticleBlock_4 .articletextlightStyle a:link, #ko_compactarticleBlock_4 .articletextlightStyle a:visited, #ko_compactarticleBlock_4 .articletextlightStyle a:hover {
            color: #3F3D33;
            color: #a5a5a5;
            text-decoration: none;
            font-weight: bold;
            text-decoration: none
        }
    </style>


    <style type="text/css">
        /* CLIENT-SPECIFIC STYLES */
        #outlook a {
            padding: 0;
        }

        /* Force Outlook to provide a "view in browser" message */
        .ReadMsgBody {
            width: 100%;
        }

        .ExternalClass {
            width: 100%;
        }

        /* Force Hotmail to display emails at full width */
        .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {
            line-height: 100%;
        }

        /* Force Hotmail to display normal line spacing */
        body, table, td, a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        /* Prevent WebKit and Windows mobile changing default text sizes */
        table, td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        /* Remove spacing between tables in Outlook 2007 and up */
        img {
            -ms-interpolation-mode: bicubic;
        }

        /* Allow smoother rendering of resized image in Internet Explorer */

        /* RESET STYLES */
        body {
            margin: 0;
            padding: 0;
        }

        img {
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }

        table {
            border-collapse: collapse !important;
        }

        body {
            height: 100% !important;
            margin: 0;
            padding: 0;
            width: 100% !important;
        }

        /* iOS BLUE LINKS */
        .appleBody a {
            color: #68440a;
            text-decoration: none;
        }

        .appleFooter a {
            color: #999999;
            text-decoration: none;
        }

        /* MOBILE STYLES */
        @media screen and (max-width: 525px) {

            /* ALLOWS FOR FLUID TABLES */
            table[class="wrapper"] {
                width: 100% !important;
                min-width: 0px !important;
            }

            /* USE THESE CLASSES TO HIDE CONTENT ON MOBILE */
            td[class="mobile-hide"] {
                display: none;
            }

            img[class="mobile-hide"] {
                display: none !important;
            }

            img[class="img-max"] {
                width: 100% !important;
                max-width: 100% !important;
                height: auto !important;
            }

            /* FULL-WIDTH TABLES */
            table[class="responsive-table"] {
                width: 100% !important;
            }

            /* UTILITY CLASSES FOR ADJUSTING PADDING ON MOBILE */
            td[class="padding"] {
                padding: 10px 5% 15px 5% !important;
            }

            td[class="padding-copy"] {
                padding: 10px 5% 10px 5% !important;
                text-align: center;
            }

            td[class="padding-meta"] {
                padding: 30px 5% 0px 5% !important;
                text-align: center;
            }

            td[class="no-pad"] {
                padding: 0 0 0px 0 !important;
            }

            td[class="no-padding"] {
                padding: 0 !important;
            }

            td[class="section-padding"] {
                padding: 10px 15px 10px 15px !important;
            }

            td[class="section-padding-bottom-image"] {
                padding: 10px 15px 0 15px !important;
            }

            /* ADJUST BUTTONS ON MOBILE */
            td[class="mobile-wrapper"] {
                padding: 10px 5% 15px 5% !important;
            }

            table[class="mobile-button-container"] {
                margin: 0 auto;
                width: 100% !important;
            }

            a[class="mobile-button"] {
                width: 80% !important;
                padding: 15px !important;
                border: 0 !important;
                font-size: 16px !important;
            }

        }
    </style>
</head>
<body style="margin: 0; padding: 0;" bgcolor="#ffffff" align="center">

<!-- PREHEADER -->


<table border="0" cellpadding="0" cellspacing="0" width="100%" id="ko_titleBlock_3">
    <tbody>
    <tr class="row-a">
        <td bgcolor="#7460ee" align="center" class="section-padding" style="padding: 30px 15px 0px 15px;">
            <table border="0" cellpadding="0" cellspacing="0" width="500" style="padding: 0 0 20px 0;"
                   class="responsive-table">
                <!-- TITLE -->
                <tbody>
                <tr>
                    <td align="center" class="padding-copy" colspan="2"
                        style="padding: 0 0 10px 0px; font-size: 25px; font-family: Helvetica, Arial, sans-serif; font-weight: normal; color: #f5f5f5;">
                        <strong>Новое уведомление Servers.Fun</strong></td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>

    </tbody>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" id="ko_compactarticleBlock_4">
    <tbody>
    <tr class="row-a">
        <td bgcolor="#f5f5f5" align="center" class="section-padding" style="padding: 0px 15px 0px 15px;">
            <table border="0" cellpadding="0" cellspacing="0" width="500" style="padding: 0 0 20px 0;"
                   class="responsive-table">

                <tbody>
                <tr>
                    <td valign="top" style="padding: 40px 0 0 0;" class="mobile-hide"><img alt="User <?= $username ?> avatar" width="105" border="0"
                                                                                           style="display: block; font-family: Arial; color: #3F3D33; font-size: 14px; width: 105px;"
                                                                                           src="<?= $avatar_link ?>">
                    </td>
                    <td style="padding: 40px 0 0 0;" class="no-padding">
                        <!-- ARTICLE -->
                        <table border="0" cellspacing="0" cellpadding="0" width="100%">
                            <tbody>
                            <tr>
                                <td align="left" class="padding-copy"
                                    style="padding: 0 0 5px 25px; font-size: 22px; font-family: Helvetica, Arial, sans-serif; font-weight: normal; color: #a5a5a5;">
                                    Здравствуйте, <?= $username ?>!
                                </td>
                            </tr>
                            <tr>
                                <td align="left" class="padding-copy articletextintenseStyle"
                                    style="padding: 10px 0 15px 25px; font-size: 16px; line-height: 24px; font-family: Helvetica, Arial, sans-serif; color: #a5a5a5;">
                                    <p>Уведомляем Вас, что срок аренды ссылки <i><?= $link_title ?></i>
                                        закончился. За время аренды по ней кликнули <?= $link_clicks ?> раз (дней
                                        аренды: <?= $link_days ?>). Если Вы желаете продлить аренду, перейдите по ниже
                                        указанной ссылке:</p></td>
                            </tr>
                            <tr>
                                <td style="padding: 0 0 45px 25px;" align="left" class="padding">
                                    <table border="0" cellspacing="0" cellpadding="0" class="mobile-button-container">
                                        <tbody>
                                        <tr>
                                            <td align="center">
                                                <!-- BULLETPROOF BUTTON -->
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0"
                                                       class="mobile-button-container">
                                                    <tbody>
                                                    <tr>
                                                        <td align="center" style="padding: 0;" class="padding-copy">
                                                            <table border="0" cellspacing="0" cellpadding="0"
                                                                   class="responsive-table">
                                                                <tbody>
                                                                <tr>
                                                                    <td align="center">
                                                                        <a target="_new" class="mobile-button"
                                                                           style="display: inline-block; font-size: 15px; font-family: Helvetica, Arial, sans-serif; font-weight: normal; color: #FFF; text-decoration: none; background-color: #7460ee; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px; border-radius: 3px; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-bottom: 3px solid #4429e8;"
                                                                           href="<?= Yii::$app->urlManager->createAbsoluteUrl(['/advertising/link/buy']) ?>">Купить еще&nbsp;→</a>

                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>

    </tbody>
</table>
<!-- FOOTER -->
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width: 500px;" id="ko_footerBlock_2">
    <tbody>
    <tr>
        <td bgcolor="#7460ee" align="center">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                <tbody>
                <tr>
                    <td style="padding: 20px 0px 20px 0px;">
                        <!-- UNSUBSCRIBE COPY -->
                        <table width="500" border="0" cellspacing="0" cellpadding="0" align="center"
                               class="responsive-table">
                            <tbody>
                            <tr>
                                <td align="center" valign="middle"
                                    style="font-size: 12px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #d8d8d8;">
                                    <span class="appleFooter" style="color: #d8d8d8;"><?= Yii::t('main', 'Если у Вас есть вопросы - Вы можете отправить их ответным письмом.')?></span><br>
                                    <a class="original-only"
                                       href="<?= Yii::$app->urlManager->createAbsoluteUrl(['/user/profile', 'type' => 'settings']) ?>"
                                       style="color: #f2f2f2; text-decoration: none;"
                                       target="_new"><?= Yii::t('main', 'Отписаться') ?></a><span class="original-only"
                                                                                                  style="font-family: Arial, sans-serif; font-size: 12px; color: #444444;">&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;</span><a
                                            href="https://servers.fun" style="color: #d8d8d8; text-decoration: none;"
                                            target="_new"><?= Yii::t('main', 'Перейти на') ?> Servers.Fun</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>


</body>
</html>